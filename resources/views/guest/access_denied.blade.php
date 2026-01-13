@extends('layouts.guest')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-7 col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-danger">Akses Ditolak</h6>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-exclamation-triangle fa-4x text-danger mb-4"></i>
                    <h4 class="text-danger mb-3">Akses Ditolak</h4>
                    <p class="text-gray-600 mb-4">Anda tidak memiliki akses untuk masuk ke halaman tersebut.</p>
                    <a href="{{ route('guest.dashboard') }}" class="btn btn-primary">
                        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
