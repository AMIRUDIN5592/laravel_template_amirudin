@extends('layouts.admin')

@section('title', 'Tambah Role')
@section('page-title', 'Tambah Role')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Role Baru</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf

                        <x-admin.input
                            name="name"
                            label="Nama Role (slug)"
                            :value="old('name')"
                            placeholder="mis. editor"
                            required
                        />

                        <x-admin.input
                            name="label"
                            label="Label"
                            :value="old('label')"
                            placeholder="mis. Editor"
                            required
                        />

                        <div class="form-group mb-3">
                            <label class="form-label d-block">Permission</label>
                            @foreach ($permissions as $permission)
                                <div class="form-check">
                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        name="permissions[]"
                                        value="{{ $permission }}"
                                        id="perm-{{ $permission }}"
                                        {{ in_array($permission, old('permissions', []), true) ? 'checked' : '' }}
                                    >
                                    <label class="form-check-label" for="perm-{{ $permission }}">
                                        {{ $permission }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            <x-admin.button>Simpan</x-admin.button>
                            <a href="{{ route('roles.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
