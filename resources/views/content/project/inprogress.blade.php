@extends('layout.wrapper')
    @section('content')
        @component('layout.navigation')
        @endcomponent
        @component('layout.main')
            @slot('content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Proyek Yang Sedang Dikerjakan</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-5">
                    @if($projects->count() > 0)
                    
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
                                <div class="row">
                                    <div class="col-md-6"><p>Hasil Hitung</p></div>
                                    <div class="col-md-6"><p>: <b>Rp. {{ number_format($project->cost->calculation_result, 0) }}</b></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"><p>Biaya Akhir</p></div>
                                    <div class="col-md-6"><p>: <b>Rp. {{ number_format($project->cost->final_cost, 0) }}</b></p></div>
                                </div>
                                @if($project->payment_type === 1)
                                <div class="row">
                                    <div class="col-md-6"><p>Uang Muka</p></div>
                                    <div class="col-md-6"><p>: <b>Rp. {{ number_format($project->cost->down_payment, 0) }}</b></p></div>
                                </div>
                                @endif
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-end">
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <a href="{{ route('proyek.print', $project->id) }}" target="_blank" class="btn btn-info"">Cetak</a>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-success"
                                                    data-toggle="modal" data-target="#modal-confirm"
                                                    data-project-id="{{$project->id}}"
                                                    data-payment-type="{{$project->payment_type}}">
                                                Selesai</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <div class="col-md-12">
                        <p>Maaf, belum ada proyek disini</p>
                    </div>
                    @endif
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
                Apakah Anda yakin bahwa proyek ini sudah selesai?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-success"><p style="color: #fff">Selesai</p></button>
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
                <h5 class="modal-title" id="exampleModalLabel">Berhasil!</h5>
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

    <script>
        $('#modal-confirm').on('shown.bs.modal', function(e) {
            var projectId = Number($(e.relatedTarget).data('project-id'));

            var form = $(e.currentTarget).find('form')[0];
            form.action = '{{ URL::to('/') }}/proyek/' + projectId + '/selesai';
        });
    </script>
    @endsection
