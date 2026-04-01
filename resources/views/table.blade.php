@extends('layouts.template')

@section('styles')
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }
    </style>
@endsection

@section('content')
<div class="container mt-3">
    <div class="card">
    <div class="card-header">
        <h3>Tabel Data</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Deskripsi</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>Bundaran UGM</td>
                    <td>Jalan Pancasila</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Monumen Pancasila</td>
                    <td>Jl Ringroad Utara</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Stasiun Tugu</td>
                    <td>Jl Jendral Sudirman</td>
                </tr>
                <tr>
                    <td>4</td>
                    <td>Malioboro</td>
                    <td>Jl Malioboro</td>
                </tr>
            </thead>
            <tbody>
            </table>
    </div>
</div>
</div>
@endsection