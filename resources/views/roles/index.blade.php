@extends('layouts.admin')

@section('title', 'Role & Permission')
@section('page-title', 'Role & Permission')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Kelola Hak Akses Role</h3>
                    <div class="card-tools">
                        <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary">Tambah Role</a>
                    </div>
                </div>
                <div class="card-body">
                    <x-admin.alert />

                    <form action="{{ route('roles.update') }}" method="POST">
                        @csrf

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th scope="col">Role</th>
                                        @foreach ($permissions as $permission)
                                            <th scope="col" class="text-center">{{ $permission }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        @php
                                            $granted = $role->permissionList();
                                            $locked = $role->name === \App\Models\User::ROLE_SUPER_ADMIN;
                                        @endphp
                                        <tr>
                                            <th scope="row">
                                                <strong>{{ $role->label }}</strong>
                                                <small class="d-block text-muted">{{ $role->name }}</small>
                                            </th>
                                            @foreach ($permissions as $permission)
                                                <td class="text-center">
                                                    @if ($locked)
                                                        <input type="checkbox" class="form-check-input" checked disabled>
                                                    @else
                                                        <input
                                                            type="checkbox"
                                                            class="form-check-input"
                                                            name="roles[{{ $role->name }}][]"
                                                            value="{{ $permission }}"
                                                            {{ in_array($permission, $granted, true) ? 'checked' : '' }}
                                                        >
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
