@extends('layouts.admin')

@section('title', 'Halaman Users')
@section('page-title', 'Halaman Users')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Halaman Users</h3>
                    <div class="card-tools">
                        <a href="{{ route('users.add') }}" class="btn btn-sm btn-primary">Tambah</a>
                    </div>
                </div>
                <div class="card-body">
                    <x-admin.alert />

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <th scope="row">{{ $user->id }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('users.edit', ['id' => $user->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('users.delete', ['id' => $user->id]) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-center">
                                    {{ $users->links() }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
