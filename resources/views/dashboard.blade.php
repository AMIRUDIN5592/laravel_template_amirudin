@extends('layouts.admin')

@section('title', 'Halaman Utama Admin')
@section('page-title', 'Selamat Datang!')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Halo Dunia!</h3>
            </div>
            <div class="card-body">
                AdminLTE 4 berhasil dipasang secara manual di Laravel 13 tanpa NPM!
                <br>
                <div class="alert alert-info mt-2">
                    Jumlah Product: {{ $data['jumlah_product'] }}
                    <br>
                    <a href="{{ route('product.index') }}" class="btn btn-sm btn-primary mt-2">Lihat Product</a>    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection