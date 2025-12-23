@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Pengguna</h1>
        <div>
            <a href="{{ route('admin.users.edit', $user) }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit
            </a>
            <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
    </div>

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Pengguna</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $user->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Informasi Pengguna</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0"><strong>Nama:</strong></p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $user->name }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0"><strong>Email:</strong></p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $user->email }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0"><strong>Role:</strong></p>
                        </div>
                        <div class="col-sm-9">
                            <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'staff' ? 'warning' : 'info') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0"><strong>Dibuat:</strong></p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $user->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3">
                            <p class="mb-0"><strong>Diupdate:</strong></p>
                        </div>
                        <div class="col-sm-9">
                            <p class="text-muted mb-0">{{ $user->updated_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
