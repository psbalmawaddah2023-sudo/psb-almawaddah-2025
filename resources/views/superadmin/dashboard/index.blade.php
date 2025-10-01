@extends('superadmin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<h1>Dashboard Admin</h1>
<div class="row mt-4">
    <div class="col-md-3">
        <div class="card p-3 shadow-sm">
            Total Pendaftar: {{ $total }}
        </div>
    </div>
</div>
@endsection
