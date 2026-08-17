@extends('layouts.admin')

@section('title', 'Page Create Users')
@section('page-title', 'Page Create Users')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Halaman Create Users</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf

                        <x-admin.input name="name" label="Name" :value="old('name')" required />
                        <x-admin.input name="email" label="Email" type="email" :value="old('email')" required />

                        <x-admin.select
                            name="role"
                            label="Role"
                            :value="old('role')"
                            :options="['' => '-- Pilih Role --', 'admin' => 'Admin', 'superadmin' => 'Superadmin']"
                        />

                        <x-admin.input name="password" label="Password" type="password" required />

                        <div class="mt-3">
                            <x-admin.button>Submit</x-admin.button>
                            <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
