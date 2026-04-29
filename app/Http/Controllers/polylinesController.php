<?php

namespace App\Http\Controllers;

use App\Models\polylinesModel;
use Illuminate\Http\Request;

class polylinesController extends Controller
{
    public function __construct()
    {
        $this->polylines = new polylinesModel();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validasi input
        $request->validate(
            [
                'geometry_polyline' => 'required',
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'geometry_polyline.required'=> 'Fielad geometry polyline harus diisi.',
                'name.required'=> 'Field nama harus diisi.',
                'name.string'=> 'Field nama harus berupa string.',
                'name.max'=> 'Field nama tidak boleh lebih dari 255 karakter.',
                'description.required'=> 'Field deskripsi harus diisi.',
                'description.string'=> 'Field deskripsi harus berupa string.',
                'image.image'=> 'File harus berupa file gambar.',
                'image.mimes'=> 'File gambar harus berupa file dengan ekstensi jpeg, png, atau jpg.',
                'image.max'=> 'Ukuran file gambar tidak boleh lebih dari 2MB.',
            ]
        );

        //membuat direktori image apabila belum tersedia
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
            }

        // simpan file image ke direktori storage/images dan menyimpan nama file ke database
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_polyline." . strtolower($image->getClientOriginalExtension());
            $image->move('storage/images', $name_image);
            } else {
                $name_image = null;
                }

        $data = [
            'geom' => $request->geometry_polyline,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
        ];

        // simpan data ke database dan akan menampilkan pesan error apabila gagal menyimpan data polyline
        if (!$this->polylines->create($data)) {
            return redirect()->route('peta')->with('error', 'Gagal menyimpan data polyline.');
        }

        // kembali ke halaman peta
        return redirect()->route('peta')->with('success', 'Data polyline berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
