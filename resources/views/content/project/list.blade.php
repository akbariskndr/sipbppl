@extends('layout.wrapper')
    @section('content')
        @component('layout.navigation')
        @endcomponent
        @component('layout.main')
            @slot('content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">{{ $title }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        @if($projects->count() > 0)
                        <div class="table-responsive table-responsive-data3">
                            <table class="table table-data3">
                                <thead>
                                    <tr>
                                        <th>no.</th>
                                        <th>judul</th>
                                        <th>nama instansi</th>
                                        <th>status proyek</th>
                                        <th>status pembayaran</th>
                                        <th>ditangani oleh</th>
                                        <th>tanggal mulai</th>
                                        <th>tanggal selesai</th>
                                        <th>aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($projects as $project)
                                    <tr class="tr-shadow">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $project->title }}</td>
                                        <td>{{ $project->instance_name }}</td>
                                        <td>{{ $project->project_status_name }}</td>
                                        <td>{{ $project->payment_status_name }}</td>
                                        <td>{{ $project->user->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($project->start_date)->format('d/m/Y') }}</td>
                                        <td>{{ $project->finish_date ? \Carbon\Carbon::parse($project->finish_date)->format('d/m/Y') : '--/--/----' }}</td>
                                        <td>
                                            <div class="table-data-feature">
                                                @if(Auth::user()->access === 1 || (Auth::user()->access === 3 && $project->user->id === Auth::id() ))
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
                        <p>Maaf, belum ada proyek disini</p>
                        @endif
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        {{ $projects->links() }}
                    </div>
                </div>
            @endslot
        @endcomponent
    @endsection

    @section('modal-script')
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
    @endsection
