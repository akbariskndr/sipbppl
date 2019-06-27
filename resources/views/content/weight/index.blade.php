@extends('layout.wrapper')
    @section('content')
        @component('layout.navigation')
        @endcomponent
        @component('layout.main')
            @slot('content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">riwayat bobot</h2>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" data-target="#modal-form">
                                <i class="zmdi zmdi-plus"></i>perbaharui bobot</button>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="table-responsive table-responsive-data3">
                            <table class="table table-data3">
                                <thead>
                                    <tr>
                                        <th>no.</th>
                                        <th>bobot kompleksitas</th>
                                        <th>bobot fitur</th>
                                        <th>biaya dasar instansi kecil</th>
                                        <th>biaya dasar instansi sedang</th>
                                        <th>biaya dasar instansi besar</th>
                                        <th>pengubah</th>
                                        <th>tanggal berubah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($weights as $weight)
                                    <tr class="tr-shadow">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $weight->complexity_weight }}%</td>
                                        <td>{{ $weight->features_weight }}%</td>
                                        <td>Rp. {{ number_format($weight->base_small) }}</td>
                                        <td>Rp. {{ number_format($weight->base_medium) }}</td>
                                        <td>Rp. {{ number_format($weight->base_big) }}</td>
                                        <td>{{ $weight->user->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($weight->created_at)->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        {{ $weights->links() }}
                    </div>
                </div>
            @endslot
        @endcomponent
    @endsection

    @section('modal-script')
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('bobot.store') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Perbaharuan Bobot</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="complexity_weight" class=" form-control-label">Bobot Kompleksitas : <span id="complexity">{{ $latestWeight->complexity_weight }}%</span></label>
                                    <input type="range" min="0" max="100" step="0.01" value="{{ $latestWeight->complexity_weight }}" class="custom-range" id="complexity_weight" name="complexity_weight" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="features_weight" class=" form-control-label">Bobot Fitur : <span id="features">{{ $latestWeight->features_weight }}%</span></label>
                                    <input type="range" min="0" max="100" step="0.01" value="{{ $latestWeight->features_weight }}" class="custom-range" id="features_weight" name="features_weight" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="base_small" class=" form-control-label">Biaya Dasar Instansi Kecil</label>
                            <input type="text" value="{{ $latestWeight->base_small }}" id="base_small" name="base_small" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="base_medium" class=" form-control-label">Biaya Dasar Instansi Sedang</label>
                            <input type="text" value="{{ $latestWeight->base_medium }}" id="base_medium" name="base_medium" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="base_sbig class=" form-control-label">Biaya Dasar Instansi Besar</label>
                            <input type="text" value="{{ $latestWeight->base_big }}" id="base_big" name="base_big" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
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
        $('input[type="range"]').on('input', function() {
            var id = $(this).attr('id').split('_')[0];
            $('#'+id).text($(this).val() + '%');
        });
    </script>
    @endsection