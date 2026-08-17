@extends('layouts.admin')

@section('title', 'Halaman Utama Admin')
@section('page-title', 'Page About')

@section('content')

    <div class="container py-4">
       

        <div class="card shadow-sm">
            <div class="row">
                <div class="col-4 bg-primary">
                    <img src="https://picsum.photos/200/300" class="rounded-circle">
                </div>
                <div class="col-8 bg-warning">
                    <div class="card-body">
                        <h1 class="h3 mb-3">{{ $data['aplikasi'] }}</h1>
                        <h2 class="mt-3">{{ $data['pembuat'] }}</h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptas, voluptate.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 bg-secondary text-white">
                    <div class="card-body">
                        <h3 class="h4 mb-3">Fitur Aplikasi</h3>
                        <ul>
                            <li>Fitur 1: Deskripsi fitur pertama.</li>
                            <li>Fitur 2: Deskripsi fitur kedua.</li>
                            <li>Fitur 3: Deskripsi fitur ketiga.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection