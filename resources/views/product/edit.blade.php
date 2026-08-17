@extends('layouts.admin')

@section('title', 'Edit Product')
@section('page-title', 'Page Edit Product')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Product</h3>
                </div>
                <form action="{{ route('product.update', ['id' => $product->id]) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <x-admin.input name="name" label="Name" :value="$product->name" required />
                        <x-admin.input name="price" label="Price" type="number" step="0.01" :value="$product->price" required />
                    </div>
                    <div class="card-footer">
                        <x-admin.button>Update</x-admin.button>
                        <a href="{{ route('product.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
