@extends('layout.wrapper')
    @section('content')
        @component('layout.navigation')
        @endcomponent
        @component('layout.main')
            @slot('content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Proyek Yang Belum Dikonfirmasi</h2>
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
                                    <div class="col-md-6"><p>Pembayaran</p></div>
                                    <div class="col-md-6"><p>: <b>{{ $project->payment_type_name }}</b></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"><p>Tanggal Mulai</p></div>
                                    <div class="col-md-6"><p>: <b>{{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}</b></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"><p>Hasil Hitung</p></div>
                                    <div class="col-md-6"><p>: <b>Rp. {{ number_format($project->cost->calculation_result, 0) }}</b></p></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6"><p>Biaya Alternatif</p></div>
                                    <div class="col-md-6"><p>: <b>Rp. {{ number_format($project->cost->alternate_cost, 0) }}</b></p></div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row justify-content-end">
                                    <div class="col-md-11 justify-content-end">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <button class="btn btn-danger"
                                                    data-toggle="modal" data-target="#modal-confirm"
                                                    data-project-id="{{$project->id}}">
                                                Batalkan</button>
                                            </div>
                                            <div class="col-md-3">
                                                <a href="{{ route('proyek.print', $project->id) }}" target="_blank" class="btn btn-info"">Cetak</a>
                                            </div>
                                            <div class="col-md-5">
                                                <button type="button" class="btn btn-success"
                                                    data-toggle="modal" data-target="#modal-form"
                                                    data-project-id="{{$project->id}}"
                                                    data-payment-type="{{$project->payment_type}}"
                                                    data-calculation-result="{{ $project->cost->calculation_result }}">
                                                Konfirmasi</button>
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
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Proyek</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Bagaimanakah persetujuan Anda dengan klien?</p>
                        <div class="row justify-content-center mt-4">
                            <div class="col-md-12" id="confirm-form-field">
                                <div class="row form-group">
                                    <div class="col-md-8">
                                        <label for="final_cost" class=" form-control-label">Biaya Akhir</label>
                                        <input type="number" id="final_cost" name="final_cost" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

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
                Apakah Anda yakin akan membatalkan proyek ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <form action="" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-danger"><p style="color: #fff">Batalkan</p></button>
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
        $('#modal-form').on('shown.bs.modal', function(e) {
            var projectId = Number($(e.relatedTarget).data('project-id'));
            var paymentType = Number($(e.relatedTarget).data('payment-type'));

            $('#final_cost').val($(e.relatedTarget).data('calculation-result'));
            var form = $(e.currentTarget).find('form')[0];
            form.action = '{{ URL::to('/') }}/proyek/' + projectId + '/konfirmasi';

            $downPaymentField = $('.down-payment-field');

            if (paymentType === 1) {
                if (!$downPaymentField.length) {
                    $('#confirm-form-field').append('<div class="row form-group down-payment-field"><div class="col-md-8"><label for="down_payment" class=" form-control-label">Uang Muka</label><input type="number" id="down_payment" name="down_payment" class="form-control" required></div></div>');
                }
            }
            else {
                if ($downPaymentField.length) {
                    $downPaymentField.remove();
                }
            }
        });

        $('#modal-confirm').on('shown.bs.modal', function(e) {
            var projectId = Number($(e.relatedTarget).data('project-id'));

            var form = $(e.currentTarget).find('form')[0];
            form.action = '{{ URL::to('/') }}/proyek/' + projectId + '/gagal';
        });
    </script>
    @endsection
