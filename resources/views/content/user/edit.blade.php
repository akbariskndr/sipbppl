@extends('layout.wrapper')
    @section('content')
        @component('layout.navigation')
        @endcomponent
        @component('layout.main')
            @slot('content')
                <div class="row">
                    <div class="col-md-12">
                        <form action="{{ route('pengguna.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <div class="row justify-content-between">
                                        <h4 class="ml-3 card-title">Ubah Data Pengguna</h4>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="mt-2 col-md-5">
                                            <img height="250px" width="250px" class="ml-5 d-block" src="{{ $user->photo }}" alt="{{ $user->name }}">
                                            <input class="mt-4 ml-5" type="file" id="photo" name="photo" class="form-control-file">
                                        </div>
                                        <div class="col-md-7">
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="name" class=" form-control-label">Nama</label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="phone_number" class=" form-control-label">No. Ponsel</label>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="text" id="phone_number" name="phone_number" value="{{ $user->phone_number }}" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="username" class=" form-control-label">Username</label>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <input type="text" id="username" name="username" value="{{ $user->username }}" class="form-control">
                                                </div>
                                            </div>
                                            @if(Auth::id() !== $user->id)
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label class=" form-control-label">Hak Akses</label>
                                                </div>
                                                <div class="col col-md-7">
                                                    <div class="form-check">
                                                        <div class="access">
                                                            <label for="access" class="form-check-label ">
                                                                <input type="radio" id="access" name="access" value="1" class="form-check-input" {{ $user->access === 1 ? "checked" : '' }}>Admin
                                                            </label>
                                                        </div>
                                                        <div class="access">
                                                            <label for="access" class="form-check-label ">
                                                                <input type="radio" id="access" name="access" value="2" class="form-check-input" {{ $user->access === 2 ? "checked" : '' }}>Operator
                                                            </label>
                                                        </div>
                                                        <div class="radio">
                                                            <label for="access" class="form-check-label ">
                                                                <input type="radio" id="access" name="access" value="3" class="form-check-input" {{ $user->access === 3 ? "checked" : '' }}>Manajer
                                                            </label>
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="status" class=" form-control-label">Status</label>
                                                </div>
                                                <div class="col-12 col-md-7">
                                                    <label class="au-checkbox">
                                                        <input type="checkbox" id="status" name="status" value="1" {{ $user->status ? "checked" : '' }}>
                                                        <span class="au-checkmark"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            @else
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="password" class=" form-control-label">Password</label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <input type="password" id="password" name="password" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="new_password" class=" form-control-label">Password Baru</label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <input type="password" id="new_password" name="new_password" class="form-control">
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3">
                                                    <label for="retype_new_password" class=" form-control-label">Konfirmasi Password Baru</label>
                                                </div>
                                                <div class="col-12 col-md-5">
                                                    <input type="password" id="retype_new_password" name="retype_new_password" class="form-control">
                                                </div>
                                            </div>   
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="row justify-content-end">
                                        <div class="col-md-2">
                                            <button class="btn btn-primary btn-block" type="submit">Ubah</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-5"></div>
            @endslot
        @endcomponent
    @endsection

    @section('modal-script')
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
    @endsection