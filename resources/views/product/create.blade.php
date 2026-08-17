@extends('layouts.admin')

@section('title', 'Tambah Product')
@section('page-title', 'Tambah Product Baru')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Product</h3>
                </div>
                <form action="{{ route('product.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <x-admin.input name="name" label="Nama Product" :value="old('name')" placeholder="Masukkan nama product" required />
                        <x-admin.input name="price" label="Harga" type="number" step="0.01" :value="old('price')" placeholder="Masukkan harga" required />
                    </div>
                    <div class="card-footer">
                        <x-admin.button>
                            <i class="bi bi-save"></i> Simpan
                        </x-admin.button>
                        <a href="{{ route('product.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
