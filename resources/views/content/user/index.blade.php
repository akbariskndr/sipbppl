@extends('layout.wrapper')
    @section('content')
        @component('layout.navigation')
        @endcomponent
        @component('layout.main')
            @slot('content')
                <div class="row">
                    <div class="col-md-4">
                        <div class="statistic__item">
                            <h2 class="number">{{ $adminCount }}</h2>
                            <span class="desc">Jumlah Admin</span>
                            <div class="icon">
                                <i class="zmdi zmdi-account"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="statistic__item">
                            <h2 class="number">{{ $operatorCount }}</h2>
                            <span class="desc">Jumlah Operator</span>
                            <div class="icon">
                                <i class="zmdi zmdi-settings"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="statistic__item">
                            <h2 class="number">{{ $managerCount }}</h2>
                            <span class="desc">Jumlah Manajer Proyek</span>
                            <div class="icon">
                                <i class="zmdi zmdi-calendar-note"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">daftar pengguna</h2>
                            <button class="au-btn au-btn-icon au-btn--green au-btn--small" data-toggle="modal" data-target="#modal-form">
                                <i class="zmdi zmdi-plus"></i>tambahkan pengguna</button>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="table-responsive table-responsive-data3">
                            <table class="table table-data3">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>nama</th>
                                        <th>akses</th>
                                        <th>no. ponsel</th>
                                        <th>username</th>
                                        <th>status</th>
                                        <th>aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr class="tr-shadow">
                                        <td>
                                            <div class="avatar">
                                                <img src="{{ $user->photo }}" alt="{{ $user->name }}">
                                            </div>
                                        </td>
                                        <td><a href="{{ route('pengguna.show', $user->id) }}">{{ $user->name }}</a></td>
                                        <td>
                                            <span class="role {{ $user->access === 1 ? "admin" : ($user->access === 2 ? "user" : "member") }}">
                                                {{ $user->access_name }}</span>
                                        </td>
                                        <td>
                                            <span class="block-email">{{ $user->phone_number }}</span>
                                        </td>
                                        <td>{{ $user->username }}</td>
                                        <td>
                                            <label class="au-checkbox">
                                                <input disabled type="checkbox" value="1" {{ $user->status ? "checked" : '' }}>
                                                <span class="au-checkmark"></span>
                                            </label>
                                        </td>
                                        <td>
                                            <div class="table-data-feature">
                                                <a href="{{ route('pengguna.edit', ['id' => $user->id]) }}" class="item" data-toggle="tooltip" data-placement="top" title="Ubah">
                                                    <i class="zmdi zmdi-edit"></i>
                                                </a>
                                                <a href="{{ route('pengguna.show', ['id' => $user->id]) }}" class="item" data-toggle="tooltip" data-placement="top" title="Lihat">
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
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        {{ $users->links() }}
                    </div>
                </div>
                <div class="row mt-5"></div>
            @endslot
        @endcomponent
    @endsection
    
    @section('modal-script')
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('pengguna.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambahkan Pengguna Baru</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row justify-content-center">
                            <div class="col-md-11">
                                <div class="row form-group">
                                    <div class="col-md-8">
                                        <label for="name" class=" form-control-label">Nama</label>
                                        <input type="text" id="name" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label class=" form-control-label">Hak Akses</label>
                                        <select name="access" id="access" class="form-control">
                                            <option disabled selected>Silahkan pilih</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Operator</option>
                                            <option value="3">Manajer</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="phone_number" class=" form-control-label">No. Ponsel</label>
                                        <input type="text" id="phone_number" name="phone_number" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="username" class=" form-control-label">Username</label>
                                        <input type="text" id="username" name="username" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-6">
                                        <label for="name" class=" form-control-label">Password : </label>
                                        <strong class="form-control-static">rahasia</strong>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-md-8">
                                        <label for="photo" class="form-control-label">Foto</label>
                                        <input type="file" id="photo" name="photo" class="form-control-file">
                                    </div>
                                </div>
                            </div>
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

    @if(session()->has('warning'))
        <div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Terjadi Kesalahan!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ session('warning') }}
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