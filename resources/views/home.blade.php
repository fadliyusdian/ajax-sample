@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <a href="{{ route("mapel.index") }}" class="btn btn-lg btn-primary btn-block">Kelola Mata Pelajaran</a>
                        </div>
                        <div class="col-md-6 mb-2">
                            <a href="{{ route("jadwal-pelajaran.index") }}" class="btn btn-lg btn-warning btn-block">Kelola Jadwal Pelajaran</a>
                        </div>
                        <div class="col-md-12">
                            <a href="{{ route("jadwal.mapel") }}" class="btn btn-lg btn-info btn-block">Jadwal Pelajaran by Mata Pelajaran</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
