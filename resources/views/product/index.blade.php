@extends('layouts.admin')

@section('title', 'Halaman Product')
@section('page-title', 'Page Product')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Halaman Product</h3>
                    <div class="card-tools">
                        <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary">Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <x-admin.alert />

                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ number_format($product->price, 2) }}</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <a href="{{ route('product.edit', ['id' => $product->id]) }}" class="btn btn-sm btn-info">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </a>
                                            <form action="{{ route('product.delete', ['id' => $product->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="bi bi-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-center">
                                    {{ $products->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
