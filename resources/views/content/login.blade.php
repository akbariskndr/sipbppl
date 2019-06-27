@extends('layout.wrapper')
    @section('content')
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="{{ asset('/images/icon/logo_jenderal_1.png') }}" alt="Jenderal Software">
                            </a>
                        </div>
                        <div class="login-form">
                            <form action="{{ url('/login') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Username</label>
                                    <input class="au-input au-input--full" type="text" name="username">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <div class="input-group">
                                        <input class="form-control" type="password" name="password" id="password">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="zmdi zmdi-eye" id="password-eye"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit">Masuk</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('modal-script')
    @if(session()->has('alert'))
    <div class="modal fade" id="modal-alert" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Perhatian!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{ session('alert') }}
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
        $('#password-eye').on('mousedown', function(e) {
            $('#password').attr('type', 'text');
        });
        $('#password-eye').on('mouseup', function(e) {
            $('#password').attr('type', 'password');
        });
    </script>
    @endsection