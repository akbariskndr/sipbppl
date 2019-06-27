@extends('layout.wrapper')
    @section('content')
        @component('layout.navigation')
        @endcomponent
        @component('layout.main')
            @slot('content')
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('proyek.update', $project->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                            <div class="card">
                                <div class="card-header">
                                    <div class="row justify-content-between">
                                        <h4 class="ml-3 card-title">Ubah Proyek {{ $project->title }}</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="title" class=" form-control-label">Judul</label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <input type="text" id="title" name="title" class="form-control" value="{{ $project->title }}">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="client_name" class=" form-control-label">Nama Klien</label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <input type="text" id="client_name" name="client_name" class="form-control" value="{{ $project->client_name }}">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="client_phone" class=" form-control-label">No. Ponsel Klien</label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <input type="text" id="client_phone" name="client_phone" class="form-control" value="{{ $project->client_phone }}">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="client_email" class=" form-control-label">Email Klien</label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <input type="text" id="client_email" name="client_email" class="form-control" value="{{ $project->client_email }}">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="instance_name" class=" form-control-label">Nama Instansi</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <input type="text" id="instance_name" name="instance_name" class="form-control" value="{{ $project->instance_name }}">
                                                </div>
                                            </div>
                                            @if($project->project_status < 3)
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="payment_type" class=" form-control-label">Jenis Pembayaran</label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <select name="payment_type" id="payment_type" class="form-control">
                                                        <option disabled>Silahkan pilih</option>
                                                        <option value="1" {{ $project->payment_type === 1 ? 'selected' : '' }}>Parsial</option>
                                                        <option value="2" {{ $project->payment_type === 2 ? 'selected' : '' }}>Penuh</option>
                                                    </select>
                                                </div>
                                            </div>
                                            @endif
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="start_date" class=" form-control-label">Tanggal Mulai</label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <div class="input-group date">
                                                        <input type="text" id="start_date" name="start_date" class="form-control datepicker" value="{{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        @if($project->payment_status === 1)
                                        <div class="col-md-6">
                                            <div class="row form-group">
                                                <div class="col col-md-5">
                                                    <label for="instance_level" class=" form-control-label">Tingkat Instansi</label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <select name="instance_level" id="instance_level" class="form-control">
                                                        <option disabled selected>Silahkan pilih</option>
                                                        <option value="1" {{ $project->criterion->instance_level === 1 ? 'selected' : '' }}>Kecil</option>
                                                        <option value="2" {{ $project->criterion->instance_level === 2 ? 'selected' : '' }}>Sedang</option>
                                                        <option value="3" {{ $project->criterion->instance_level === 3 ? 'selected' : '' }}>Besar</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-5">
                                                    <label for="complexity_level" class=" form-control-label">Tingkat Kerumitan Sistem</label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <select name="complexity_level" id="complexity_level" class="form-control">
                                                        <option disabled selected>Silahkan pilih</option>
                                                        <option value="1" {{ $project->criterion->complexity_level === 1 ? 'selected' : '' }}>Sangat Mudah</option>
                                                        <option value="2" {{ $project->criterion->complexity_level === 2 ? 'selected' : '' }}>Mudah</option>
                                                        <option value="3" {{ $project->criterion->complexity_level === 3 ? 'selected' : '' }}>Biasa</option>
                                                        <option value="4" {{ $project->criterion->complexity_level === 4 ? 'selected' : '' }}>Rumit</option>
                                                        <option value="5" {{ $project->criterion->complexity_level === 5 ? 'selected' : '' }}>Sangat Rumit</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-5">
                                                    <label class="form-control-label">Fitur</label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <button type="button" id="new-feature-button" class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" data-target="#modal-form">
                                                        <i class="zmdi zmdi-plus"></i>tambahkan fitur</button>
                                                </div>
                                            </div>
                                            <div class="row justify-content-between" id="features-area">
                                                @foreach($project->features as $feature)
                                                <div class="col-md-4">
                                                    <button onclick="deleteFeature(this)" type="button" class="text-truncate btn btn-primary btn-block m-l-10 m-b-10 feature-display-button">
                                                        <span class="badge badge-light">{{ $feature->priority }}</span> {{ $feature->name }}
                                                    </button>
                                                    <input type="hidden" name="name[]" value="{{ $feature->name }}">
                                                    <input type="hidden" name="priority[]" value="{{ $feature->priority }}">
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row justify-content-end">
                                        <div class="col-md-2">
                                            <button class="btn btn-primary btn-block" type="submit">Simpan</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endslot
        @endcomponent
    @endsection

    @section('modal-script')
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambahkan Fitur Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-md-11">
                            <div class="row form-group">
                                <div class="col-md-8">
                                    <label for="feature_name" class=" form-control-label">Nama Fitur</label>
                                    <input type="text" id="feature_name" class="form-control" required maxlength="20">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col col-md-7">
                                    <label class=" form-control-label">Prioritas</label>
                                    <select name="feature_priority" id="feature_priority" class="form-control" required>
                                        <option disabled selected>Silahkan pilih</option>
                                        <option value="1">Diperlukan</option>
                                        <option value="2">Penting</option>
                                        <option value="3">Opsional</option>
                                        <option value="4">Tidak Penting</option>
                                        <option value="5">Tidak Diperlukan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" id="submit-new-feature" class="btn btn-primary" data-dismiss="modal">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
        });
        $('#submit-new-feature').click(function(e) {
            var name = $('#feature_name').val();
            var priority = $('#feature_priority').val();

            var featuresArea = $('#features-area');
            var content = '<div class="col-md-4"><button onclick="deleteFeature(this)" type="button" class="text-truncate btn btn-primary m-l-10 m-b-10 feature-display-button btn-block"><span class="badge badge-light">' + priority + '</span> ' + name + '</button><input type="hidden" name="name[]" value="'+ name + '"><input type="hidden" name="priority[]" value="'+ priority + '"></div>';
            featuresArea.append(content);
        });

        function deleteFeature(el) {
            el.parentNode.parentNode.removeChild(el.parentNode);
        };
    </script>
    @endsection