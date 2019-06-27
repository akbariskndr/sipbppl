@extends('layout.wrapper')
    @section('content')
        @component('layout.navigation')
        @endcomponent
        @component('layout.main')
            @slot('content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row justify-content-between">
                                    <h4 class="ml-3 card-title">Profil</h4>
                                    <div>
                                        @if(Auth::user()->access === 1 && Auth::user()->id !== $user->id)
                                        <button class="mr-4 btn au-btn-icon btn-info au-btn--small" data-toggle="modal" data-target="#modal-confirm-2">
                                            <i class="zmdi zmdi-edit"></i>RESET PASSWORD
                                        </button>
                                        @endif
                                        @if(Auth::user()->access === 1 || Auth::id() === $user->id)
                                        <a href="{{ route('pengguna.edit', $user->id) }}" class="mr-4 au-btn au-btn-icon au-btn--green au-btn--small">
                                                <i class="zmdi zmdi-edit"></i>ubah</a>
                                        @endif
                                        @if(!($user->id === Auth::id()) && Auth::user()->access === 1)
                                        <button class="mr-4 btn au-btn-icon btn-danger au-btn--small" data-toggle="modal" data-target="#modal-confirm">
                                            <i class="zmdi zmdi-delete"></i>HAPUS
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="mt-2 col-md-6">
                                        <img height="250px" width="250px" class="mx-auto d-block" src="{{ $user->photo }}" alt="{{ $user->name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Nama</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$user->name}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Akses</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$user->access_name}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">No. Ponsel</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$user->phone_number}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Username</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$user->username}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Status</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$user->status ? "Aktif" : "Tidak Aktif"}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Tgl Masuk</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if($user->access === 1 || $user->access === 3)
                    <div class="col-md-4">
                        <div class="statistic__item">
                            <h2 class="number">{{ $user->projects_count }}</h2>
                            <span class="desc">Projek Ditangani</span>
                            <div class="icon">
                                <i class="zmdi zmdi-calendar-note"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="statistic__item">
                            <h2 class="number">{{ number_format($sum, 0) }}</h2>
                            <span class="desc">Penghasilan</span>
                            <div class="icon">
                                <i class="zmdi zmdi-money"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($user->access === 1 || $user->access === 2)
                    <div class="col-md-4">
                        <div class="statistic__item">
                            <h2 class="number">{{$user->weights_count}} X</h2>
                            <span class="desc">Bobot Diubah</span>
                            <div class="icon">
                                <i class="zmdi zmdi-settings"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                @if(Auth::user()->access === 1 && $user->access !== 2)
                <div class="row mt-2">
                    <div class="col-md-12">
                        <h2 class="title-1 m-b-25">Proyek Yang Ditangani Pengguna Ini</h2>
                        @if($user->projects->count() > 0)
                        <div class="table-responsive table-responsive-data3">
                            <table class="table table-data3">
                                <thead>
                                    <tr>
                                        <th>no.</th>
                                        <th>judul</th>
                                        <th>nama instansi</th>
                                        <th>status proyek</th>
                                        <th>status pembayaran</th>
                                        <th>tanggal mulai</th>
                                        <th>tanggal selesai</th>
                                        <th>aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->projects as $project)
                                    <tr class="tr-shadow">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $project->title }}</td>
                                        <td>{{ $project->instance_name }}</td>
                                        <td>{{ $project->project_status_name }}</td>
                                        <td>{{ $project->payment_status_name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}</td>
                                        <td>{{ $project->finish_date ? \Carbon\Carbon::parse($project->finish_date)->format('d/m/Y') : '--/--/----' }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                @if(Auth::user()->access === 1 || Auth::id() === $project->user->id)
                                                <a href="{{ route('proyek.edit', ['id' => $project->id]) }}" class="item" data-toggle="tooltip" data-placement="top" title="Ubah">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                @endif
                                                <a href="{{ route('proyek.show', ['id' => $project->id]) }}" class="item" data-toggle="tooltip" data-placement="top" title="Lihat">
                                                    <i class="zmdi zmdi-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                        @else
                        <p>Pengguna ini belum menanangi proyek!</p>
                        @endif
                    </div>
                </div>
                <div class="row mt-5"></div>
                @endif
            @endslot
        @endcomponent
    @endsection

    @section('modal-script')
    <div class="modal fade" id="modal-confirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Perhatian!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin akan menghapus pengguna ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form action="{{ route('pengguna.destroy', $user->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><p style="color: #fff">Hapus</p></button>
                </form>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-confirm-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Perhatian!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin akan mengatur ulang password dari pengguna ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form action="{{ route('pengguna.reset', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-info"><p style="color: #fff">Reset</p></button>
                </form>
            </div>
            </div>
        </div>
    </div>

    @if(session()->has('success'))
    <div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sukses!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ session('success') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
            </div>
        </div>
    </div>
    <script>
        $('#modal-alert').modal('show');
    </script>
    @endif
    @endsection