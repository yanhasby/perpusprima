<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bukuDummy = [
        [
            'id' => 1,
            'judul' => 'Belajar Laravel',
            'penulis' => 'John Doe',
            'tahun_terbit' => 2022
        ],
        [
            'id' => 2,
            'judul' => 'Pemrograman PHP untuk Pemula',
            'penulis' => 'Jane Smith',
            'tahun_terbit' => 2021
        ],
        [
            'id' => 3,
            'judul' => 'JavaScript Essentials',
            'penulis' => 'Ali Mustafa',
            'tahun_terbit' => 2023
        ],
    ];
    public function index()
    {
        return response()->json($this->bukuDummy);
    }

    // Menampilkan detail buku berdasarkan ID
    public function show($id)
    {
        $buku = collect($this->bukuDummy)->firstWhere('id', $id);


        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json($buku);
    }

    public function store(Request $request)

    {

        $validated = $request->validate([

            'judul' => 'required|string|max:255',

            'penulis' => 'required|string|max:255',

            'tahun_terbit' => 'required|integer',

        ]);



        // Membuat data buku baru

        $newBuku = [

            'id' => count($this->bukuDummy) + 1,

            'judul' => $validated['judul'],

            'penulis' => $validated['penulis'],

            'tahun_terbit' => $validated['tahun_terbit'],

        ];



        // Menambahkan buku ke data dummy

        $this->bukuDummy[] = $newBuku;



        return response()->json($newBuku, 201);
    }



    // Mengupdate data buku berdasarkan ID

    public function update(Request $request, $id)

    {

        $bukuIndex = collect($this->bukuDummy)->search(fn($buku) => $buku['id'] == $id);



        if ($bukuIndex === false) {

            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }



        $validated = $request->validate([

            'judul' => 'required|string|max:255',

            'penulis' => 'required|string|max:255',

            'tahun_terbit' => 'required|integer',

        ]);



        $this->bukuDummy[$bukuIndex] = [

            'id' => $id,

            'judul' => $validated['judul'],

            'penulis' => $validated['penulis'],

            'tahun_terbit' => $validated['tahun_terbit'],

        ];



        return response()->json($this->bukuDummy[$bukuIndex]);
    }



    // Menghapus buku berdasarkan ID

    public function destroy($id)

    {

        $bukuIndex = collect($this->bukuDummy)->search(fn($buku) => $buku['id'] == $id);



        if ($bukuIndex === false) {

            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }



        array_splice($this->bukuDummy, $bukuIndex, 1);



        return response()->json(['message' => 'Buku berhasil dihapus']);
    }
}
