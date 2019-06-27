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
                                    <h4 class="ml-3 card-title">Proyek {{ $project->title }}</h4>
                                    <div>
                                        @if($project->payment_status > 1 && (Auth::id() === $project->user->id || Auth::user()->access === 1))
                                        <a href="{{ route('proyek.print', $project->id) }}" class="mr-4 au-btn au-btn-icon au-btn--blue au-btn--small">
                                                <i class="zmdi zmdi-print"></i>cetak</a>
                                        @endif
                                        @if(Auth::user()->access === 1 || (Auth::user()->access === 3 && $project->user->id === Auth::id()))
                                        <a href="{{ route('proyek.edit', $project->id) }}" class="mr-4 au-btn au-btn-icon au-btn--green au-btn--small">
                                                <i class="zmdi zmdi-edit"></i>ubah</a>
                                        @endif
                                        @if( $project->project_status < 3 && (Auth::user()->access === 1 || $project->user_id === Auth::id()) )
                                        <button class="mr-4 btn au-btn-icon btn-danger au-btn--small" data-toggle="modal" data-target="#modal-confirm">
                                            <i class="zmdi zmdi-delete"></i>HAPUS
                                        </button>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Judul</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$project->title}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Penangan</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$project->user->name}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Nama Klien</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$project->client_name}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">No. Ponsel Klien</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$project->client_phone}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Email Klien</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$project->client_email}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Nama Instansi</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$project->instance_name}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Tingkat Instansi</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$project->criterion->instance_level_name}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Tingkat Kerumitan Sistem</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$project->criterion->complexity_level_name}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Tgl Mulai</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Tgl Selesai</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{ $project->finish_date ? \Carbon\Carbon::parse($project->finish_date)->format('d/m/Y') : '-'}}</b></p>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="col-md-6">
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Fitur :</label>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="ml-4 col-12 col-md-11">
                                                <ol>
                                                    @foreach ($project->features as $feature)
                                                    <li>
                                                        <div class="row">
                                                            <div class="col-md-9">{{ $feature->name }}</div>
                                                            <div class="col-md-3"><b>{{ $feature->priority_name }}</b></div>
                                                        </div>
                                                        <hr>
                                                    </li>
                                                    @endforeach
                                                </ol>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Status</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Status Proyek</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$project->project_status_name}}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Jenis Pembayaran</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{ $project->payment_type_name }}</b></p>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col col-md-5">
                                                <label class=" form-control-label">Status Pembayaran</label>
                                            </div>
                                            <div class="col-12 col-md-7">
                                                <p class="form-control-static"><b>{{$project->payment_status_name}}</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>Informasi Keuangan</h4>
                            </div>

                            <div class="card-body">
                                <div class="col-md-12">
                                    @if($project->project_status > 2)
                                    <div class="row form-group">
                                        <div class="col col-md-5">
                                            <label class=" form-control-label">Hasil Perhitungan</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <p class="form-control-static"><b>{{$project->cost->calculation_result}}</b></p>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-5">
                                            <label class=" form-control-label">Biaya Alternatif</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <p class="form-control-static"><b>{{$project->cost->alternate_cost}}</b></p>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col col-md-5">
                                            <label class=" form-control-label">Biaya Akhir</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <p class="form-control-static"><b>{{$project->cost->final_cost}}</b></p>
                                        </div>
                                    </div>
                                    @if($project->payment_type === 1)
                                    <div class="row form-group">
                                        <div class="col col-md-5">
                                            <label class=" form-control-label">Uang Muka</label>
                                        </div>
                                        <div class="col-12 col-md-7">
                                            <p class="form-control-static"><b>{{$project->cost->down_payment}}</b></p>
                                        </div>
                                    </div>
                                    @endif
                                    @else
                                    <div class="row form-group">
                                        <div class="col col-md-12">
                                            <label class=" form-control-label">Proyek ini belum melakukan perhitungan dan konfirmasi</label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                Apakah Anda yakin akan menghapus proyek ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form action="{{ route('proyek.destroy', $project->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><p style="color: #fff">Hapus</p></button>
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