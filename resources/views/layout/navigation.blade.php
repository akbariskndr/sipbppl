<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <img src="{{ asset('/images/icon/logo_jenderal_1.png') }}" alt="Jenderal Software" />
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}">
                        <i class="fas fa-home"></i>Dashboard</a>
                </li>
                @if(Auth::user()->access === 1 || Auth::user()->access === 3)
                <li class="{{ Request::is('proyek*') ? 'active' : '' }} has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-tasks"></i>Proyek</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="{{ route('proyek.history') }}">Riwayat</a>
                            </li>
                            <li>
                                <a href="{{ route('proyek.handled') }}">Ditangani</a>
                            </li>
                            <li>
                                <a href="{{ route('proyek.create') }}">Tambah</a>
                            </li>
                            <li>
                                <a href="{{ route('proyek.not_calculated') }}">Belum Dihitung <span class="badge badge-primary">{{ $projectCountBadge[0] }}</span></a>
                            </li>
                            <li>
                                <a href="{{ route('proyek.not_confirmed') }}">Belum Dikonfirmasi <span class="badge badge-primary">{{ $projectCountBadge[1] }}</span></a>
                            </li>
                            <li>
                                <a href="{{ route('proyek.in_progress') }}">Sedang Dikerjakan <span class="badge badge-primary">{{ $projectCountBadge[2] }}</span></a>
                            </li>
                            <li>
                                <a href="{{ route('proyek.completed') }}">Selesai <span class="badge badge-primary">{{ $projectCountBadge[3] }}</span></a>
                            </li>
                            <li>
                                <a href="{{ route('proyek.failed') }}">Batal <span class="badge badge-primary">{{ $projectCountBadge[4] }}</span></a>
                            </li>
                        </ul>
                </li>
                @else
                <li class="{{ Request::is('proyek*') ? 'active' : '' }}">
                    <a href="{{ route('proyek.history') }}">
                        <i class="fas fa-tasks"></i>Proyek</a>
                </li>
                @endif
                @if(Auth::user()->access === 1)
                <li class="{{ Request::is('pengguna*') ? 'active' : '' }}">
                    <a href="{{ url('pengguna') }}">
                        <i class="fas fa-users"></i>Pengguna</a>
                </li>
                @endif
                @if(Auth::user()->access === 1 || Auth::user()->access === 2)
                <li class="{{ Request::is('bobot*') ? 'active' : '' }}">
                    <a href="{{ url('bobot') }}">
                        <i class="fas fa-adjust"></i>Bobot</a>
                </li>
                @endif
                @if(Auth::user()->access !== 2)
                <li class="{{ Request::is('pemasukan*') ? 'active' : '' }} has-sub">
                    <a class="js-arrow" href="#">
                        <i class="fas fa-book"></i>Penghasilan</a>
                        <ul class="list-unstyled navbar__sub-list js-sub-list">
                            <li>
                                <a href="{{ route('pemasukan.index') }}">Keseluruhan</a>
                            </li>
                            <li>
                                <a href="{{ route('pemasukan.user_income') }}">Sendiri</a>
                            </li>
                        </ul>
                </li>
                @else
                <li class="{{ Request::is('pemasukan*') ? 'active' : '' }}">
                    <a href="{{ route('pemasukan.index') }}">
                        <i class="fas fa-book"></i>Penghasilan</a>
                </li>
                @endif
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->

<!-- PAGE CONTAINER-->
<div class="page-container">
    <!-- HEADER DESKTOP-->
    <header class="header-desktop">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="header-wrap">
                    <form action="{{ route('cari') }}" method="GET" class="form-header form-inline">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <select class="custom-select" name="type_parameter" id="type_parameter">
                                    <option selected disabled>Pilih Tipe</option>
                                    <option value="1">Pengguna</option>
                                    <option value="2">Proyek</option>
                                </select>
                                <select class="custom-select" name="data_parameter" id="data_parameter" >
                                    <option selected disabled>Pilih Data</option>
                                </select>
                            </div>
                            <input type="text" placeholder="Masukkan kata kunci..." name="search_keyword" id="search_keyword" class="form-control" aria-label="Text input with dropdown button">
                            <div class="input-group-append">
                                <button class="btn btn-primary form-control">
                                    <i class="zmdi zmdi-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="header-button">
                        <div class=" ml-5 account-wrapt">
                            <div class="account-item js-item-menu ml-3">
                                <div class="image">
                                    <img src="{{ Auth::user()->photo }}"/>
                                </div>
                                <div class="content">
                                    <a class="js-acc-btn" href="#">{{ Auth::user()->name }}</a>
                                </div>
                                <div class="account-dropdown js-dropdown">
                                    <div class="info clearfix">
                                        <div class="image">
                                            <a href="#">
                                                <img src="{{ Auth::user()->photo }}"/>
                                            </a>
                                        </div>
                                        <div class="content">
                                            <h5 class="name">
                                                <a href="#">{{ Auth::user()->name }}</a>
                                            </h5>
                                            <span class="email">{{ Auth::user()->phone_number }}</span>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__body">
                                        <div class="account-dropdown__item">
                                            <a href="{{ route('pengguna.show', Auth::id()) }}">
                                                <i class="zmdi zmdi-account"></i>Akun</a>
                                        </div>
                                    </div>
                                    <div class="account-dropdown__footer">
                                        <a href="{{ url('logout') }}">
                                            <i class="zmdi zmdi-power"></i>Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>