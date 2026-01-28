<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guru;
use App\Models\Pengguna;
use Illuminate\Support\Facades\DB;

class GuruController extends Controller
{
    /**
     * Menampilkan daftar semua guru
     */
    public function index()
    {
        // Ambil semua data guru dengan relasi pengguna
        $gurus = Guru::with('pengguna')->get();
        
        // Return view dengan data guru
        return view('admin.guru.index', compact('gurus'));
    }

    /**
     * Menampilkan form untuk menambah guru baru
     */
    public function create()
    {
        return view('admin.guru.create');
    }

    /**
     * Menyimpan data guru baru ke database
     */
    public function store(Request $request)
{
    // Validasi
    $request->validate([
        'nama' => 'required|string|max:100',
        'nip' => 'nullable|string|max:20',
        'email' => 'nullable|email',
        'username' => 'required|string|unique:pengguna,username|min:3',
        'password' => 'required|string|min:3|confirmed',
    ]);

    DB::beginTransaction();

       try {
        // Simple create tanpa validation
        $pengguna = new Pengguna();
        $pengguna->username = $request->username;
        $pengguna->password = md5($request->password);
        $pengguna->peran = 'guru';
        $pengguna->save();
        
        $guru = new Guru();
        $guru->nama = $request->nama;
        $guru->nip = $request->nip;
        $guru->email = $request->email;
        $guru->pengguna_id = $pengguna->id;
        $guru->save();
        
        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil ditambahkan!');
            
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }

}
    public function edit($id)
    {
        // Cari data guru berdasarkan ID
        $guru = Guru::with('pengguna')->find($id);

        // Jika guru tidak ditemukan, redirect dengan pesan error
        if (!$guru) {
            return redirect()->route('guru.index')
                ->with('error', 'Data guru tidak ditemukan.');
        }

        // Tampilkan view edit dengan data guru
        return view('admin.guru.edit', compact('guru'));
    }

    /**
     * Mengupdate data guru di database
     */
    public function update(Request $request, $id)
    {
        // Cari data guru berdasarkan ID
        $guru = Guru::find($id);

        // Jika guru tidak ditemukan, redirect dengan pesan error
        if (!$guru) {
            return redirect()->route('guru.index')
                ->with('error', 'Data guru tidak ditemukan.');
        }

        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:100',
            'nip' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'password' => 'nullable|string|min:3|confirmed',
        ]);

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // 1. Update data guru
            $guru->update([
                'nama' => $request->nama,
                'nip' => $request->nip,
                'email' => $request->email,
            ]);

            // 2. Update password jika diisi (optional)
            if ($request->filled('password')) {
                $guru->pengguna->update([
                    'password' => md5($request->password)
                ]);
            }

            // Commit transaksi
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->route('guru.index')
                ->with('success', 'Data guru ' . $guru->nama . ' berhasil diperbarui!');

        } catch (\Exception $e) {
            // Rollback jika error
            DB::rollback();

            return back()
                ->with('error', 'Gagal memperbarui data guru: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menghapus data guru dari database
     */
    public function destroy($id)
    {
        // Cari data guru berdasarkan ID
        $guru = Guru::find($id);

        // Jika guru tidak ditemukan, redirect dengan pesan error
        if (!$guru) {
            return redirect()->route('guru.index')
                ->with('error', 'Data guru tidak ditemukan.');
        }

        // Mulai transaksi database
        DB::beginTransaction();

        try {
            // Simpan nama guru untuk pesan sukses
            $nama_guru = $guru->nama;

            // 1. Hapus data pengguna terkait (akan cascade ke guru)
            if ($guru->pengguna) {
                $guru->pengguna->delete();
            }

            // 2. Hapus data guru (jika belum terhapus cascade)
            $guru->delete();

            // Commit transaksi
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->route('guru.index')
                ->with('success', 'Data guru ' . $nama_guru . ' berhasil dihapus!');

        } catch (\Exception $e) {
            // Rollback jika error
            DB::rollback();

            return back()
                ->with('error', 'Gagal menghapus data guru: ' . $e->getMessage());
        }
    }

    /**
     * Method untuk testing/debugging
     */
    public function test()
    {
        // Test koneksi database
        try {
            $gurus = Guru::with('pengguna')->get();
            return response()->json([
                'status' => 'success',
                'total_guru' => $gurus->count(),
                'data' => $gurus
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}