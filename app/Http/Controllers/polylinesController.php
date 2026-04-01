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
            ],
            [
                'geometry_polyline.required'=> 'Fielad geometry polyline harus diisi.',
                'name.required'=> 'Field nama harus diisi.',
                'name.string'=> 'Field nama harus berupa string.',
                'name.max'=> 'Field nama tidak boleh lebih dari 255 karakter.',
                'description.required'=> 'Field deskripsi harus diisi.',
                'description.string'=> 'Field deskripsi harus berupa string.',
            ]
        );

        $data = [
            'geom' => $request->geometry_polyline,
            'name' => $request->name,
            'description' => $request->description,
        ];

        // simpan data ke database dan akan menampilkan pesan error apabila gagal menyimpan data point
        if (!$this->polylines->insert($data)) {
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
