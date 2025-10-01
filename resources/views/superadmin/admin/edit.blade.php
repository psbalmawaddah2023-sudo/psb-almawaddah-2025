@extends('superadmin.layouts.app')

@section('title', 'Edit Admin / Superadmin / Capel')

@section('content')
<div class="container">
    <h1>Edit User</h1>

    <form action="{{ route('admin.update', $admin->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" 
                   class="form-control @error('name') is-invalid @enderror" 
                   value="{{ old('name', $admin->name) }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email', $admin->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (biarkan kosong jika tidak diganti)</label>
            <input type="password" name="password" id="password" 
                   class="form-control @error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                   class="form-control @error('password_confirmation') is-invalid @enderror">
            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
    <label for="role_id" class="form-label">Role</label>
    <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror"
            {{ $admin->role_id == 1 ? 'disabled' : '' }}>
        <option value="">Pilih Role</option>
        <option value="2" {{ $admin->role_id == 2 ? 'selected' : '' }}>Admin</option>
        <option value="3" {{ $admin->role_id == 3 ? 'selected' : '' }}>Superadmin</option>
    </select>

    {{-- Hidden input untuk Capel supaya tetap terkirim --}}
    @if($admin->role_id == 1)
        <input type="hidden" name="role_id" value="1">
    @endif

    @error('role_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
