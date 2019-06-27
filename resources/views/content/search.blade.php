@extends('layout.wrapper')
    @section('content')
        @component('layout.navigation')
        @endcomponent
        @component('layout.main')
            @slot('content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Hasil Pencarian</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    @if(count($projects) > 0)
                    @foreach($projects as $project)
                    <div class="col-md-6">
                        <div class="card border border-secondary">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <div class="col-md-9">
                                        <strong class="card-title">{{ $project->title }}</strong>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('proyek.show', $project->id) }}" class="btn btn-primary">Lihat</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6"><p>Klien</p></div>
                                    <div class="col-md-6"><p>: <b>{{ $project->client_name }}</b></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"><p>Instansi</p></div>
                                    <div class="col-md-6"><p>: <b>{{ $project->instance_name }}</b></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"><p>No. Ponsel</p></div>
                                    <div class="col-md-6"><p>: <b>{{ $project->client_phone }}</b></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"><p>Email</p></div>
                                    <div class="col-md-6"><p>: <b>{{ $project->client_email }}</b></p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @elseif(count($users) > 0)
                    @foreach($users as $user)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="mx-auto d-block">
                                    <img class="rounded-circle mx-auto d-block" src="{{ $user->photo }}" alt="{{ $user->name }}" width="102px" height="120px">
                                    <h5 class="text-sm-center mt-2 mb-1">{{ $user->name }}</h5>
                                    <div class="location text-sm-center">
                                        {{ $user->access_name }}</div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-center">
                                    <div class="col-md-5">
                                        <a href="{{ route('pengguna.show', $user->id) }}" class="btn btn-info btn-block">Lihat</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @else
                    <div class="col-md-12">
                        <p>Tidak ditemukan hasil!</p>
                    </div>
                    @endif
                </div>
            @endslot
        @endcomponent
    @endsection