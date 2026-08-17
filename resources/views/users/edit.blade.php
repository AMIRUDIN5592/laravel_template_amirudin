@extends('layouts.admin')

@section('title', 'Page Edit Users')
@section('page-title', 'Page Edit Users')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Halaman Edit Users</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
                        @csrf

                        <x-admin.input name="name" label="Name" :value="$user->name" required />
                        <x-admin.input name="email" label="Email" type="email" :value="$user->email" required />

                        <x-admin.select
                            name="role"
                            label="Role"
                            :value="$user->role"
                            :options="['' => '-- Pilih Role --', 'admin' => 'Admin', 'superadmin' => 'Superadmin']"
                        />

                        <x-admin.input name="password" label="Password" type="password" placeholder="Kosongkan jika tidak diubah" />

                        <div class="mt-3">
                            <x-admin.button>Update</x-admin.button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
