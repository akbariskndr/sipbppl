@extends('layout.wrapper')
    @section('content')
        @component('layout.navigation')
        @endcomponent
        @component('layout.main')
            @slot('content')
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Selamat Datang, {{ Auth::user()->name }}!</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    @if(Auth::user()->access === 1)
                    <div class="col-md-{{Auth::user()->access === 1 ? 3 : 6}}">
                        <div class="statistic__item">
                            <h2 class="number">{{ $userCount }}</h2>
                            <span class="desc">Jumlah Pengguna</span>
                            <div class="icon">
                                <i class="zmdi zmdi-account"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-{{Auth::user()->access === 1 ? 3 : 6}}">
                        <div class="statistic__item">
                            <h2 class="number">{{ number_format($totalIncomes, 0) }}</h2>
                            <span class="desc">Total Penghasilan</span>
                            <div class="icon">
                                <i class="zmdi zmdi-money"></i>
                            </div>
                        </div>
                    </div>
                    @if(Auth::user()->access !== 2)
                    <div class="col-md-{{Auth::user()->access === 1 ? 3 : 6}}">
                        <div class="statistic__item">
                            <h2 class="number">{{ $totalProjects }}</h2>
                            <span class="desc">Jumlah Proyek</span>
                            <div class="icon">
                                <i class="zmdi zmdi-calendar-note"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                    @if(Auth::user()->access < 3)
                    <div class="col-md-{{Auth::user()->access === 1 ? 3 : 6}}">
                        <div class="statistic__item">
                            <h2 class="number">{{ $weightSum }}X</h2>
                            <span class="desc">Perubahan Bobot</span>
                            <div class="icon">
                                <i class="zmdi zmdi-settings"></i>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="row mt-3">
                    <div class="col-md-8">
                        <h2 class="title-1 m-b-25">Laporan Penghasilan {{ Auth::user()->access === 3 ? 'Anda' : 'Keseluruhan' }}</h2>
                        <div class="recent-report2">
                            <div class="chart-info">
                                <div class="chart-info__left">
                                    <div class="chart-note">
                                        <span class="dot dot--green"></span>
                                        <span>penghasilan (x1000)</span>
                                    </div>
                                </div>
                                <div class="chart-info__right">
                                    <a href="{{ Auth::user()->access !== 3 ? route('pemasukan.index') : route('pemasukan.user_income') }}" class="btn btn-info">Lihat Penghasilan</a>
                                </div>
                            </div>
                            <div class="recent-report__chart"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                                <canvas id="income-chart" height="287" width="807" class="chartjs-render-monitor" style="display: block; height: 230px; width: 646px;"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h2 class="title-1 m-b-25">Informasi Proyek</h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col col-md-5">
                                        <label class=" form-control-label">Dikerjakan</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <p class="form-control-static"><b>{{ $inprogressProjects }}</b></p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-5">
                                        <label class=" form-control-label">Selesai</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <p class="form-control-static"><b>{{ $completedProjects }}</b></p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-5">
                                        <label class=" form-control-label">Gagal</label>
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <p class="form-control-static"><b>{{ $failedProjects }}</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    @if(Auth::user()->access !== 2)
                                    <div class="col-md-12">
                                        <a href="{{ route('proyek.create') }}" class="btn btn-success btn-block">Tambah Proyek Baru</a>
                                    </div>
                                    @endif
                                    <div class="col-md-12 mt-2">
                                        <a href="{{ route('proyek.history') }}" class="btn btn-info btn-block">Lihat Daftar Proyek</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-8">
                        <h2 class="title-1 m-b-25">Nilai Bobot Saat Ini</h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label class=" form-control-label">Bobot Kompleksitas</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="form-control-static"><b>{{ $weight->complexity_weight }}%</b></p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label class=" form-control-label">Bobot Fitur</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="form-control-static"><b>{{ $weight->features_weight }}%</b></p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label class=" form-control-label">Biaya Dasar Instansi Kecil</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="form-control-static"><b>{{ $weight->base_small }}</b></p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label class=" form-control-label">Biaya Dasar Instansi Sedang</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="form-control-static"><b>{{ $weight->base_medium }}</b></p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label class=" form-control-label">Biaya Dasar Instansi Besar</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="form-control-static"><b>{{ $weight->base_big }}</b></p>
                                    </div>
                                </div>
                            </div>
                            @if(Auth::user()->access !== 3)
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="{{ route('bobot.index') }}" class="btn btn-info">Lihat Riwayat Bobot</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if(Auth::user()->access === 1)
                    <div class="col-md-4">
                        <h2 class="title-1 m-b-25">Informasi Pengguna</h2>
                        <div class="card">
                            <div class="card-body">
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label class=" form-control-label">Jumlah Admin</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="form-control-static"><b>{{ $adminCount }}</b></p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label class=" form-control-label">Jumlah Operator</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="form-control-static"><b>{{ $operatorCount }}</b></p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-6">
                                        <label class=" form-control-label">Jumlah Manajer</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <p class="form-control-static"><b>{{ $managerCount }}</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-center">
                                    <div class="col-md-12 mt-2">
                                        <a href="{{ route('pengguna.index') }}" class="btn btn-info btn-block">Lihat Daftar Pengguna</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="row mt-5"></div>
            @endslot
        @endcomponent
    @endsection

    @section('modal-script')
    <script>
        function getMonth(month) {
            return (['Januari', 'Februari', 'Maret',
                    'April', 'Mei', 'Juni', 'Juli',
                    'Agustus', 'September', 'Oktober',
                    'November', 'Desember'])[Number(month) - 1];
        }
          try {
            const bd_brandService2 = 'rgba(0,173,95,0.9)'
            const brandService2 = 'rgba(0,173,95,0.2)'

            var incomes = @json($incomes);

            var months = incomes.map(function(val, index) {
                return getMonth(val.month) + ' ' + val.year;
            });

            var income_sums = incomes.map(function(val, index) {
                return val.sum / 1000;
            });

            var ctx = document.getElementById("income-chart");
            if (ctx) {
                ctx.height = 230;
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: months,
                        datasets: [
                            {
                                label: "Pemasukan (x1000)",
                                data: income_sums,
                                borderColor: "rgba(0, 123, 255, 0.9)",
                                borderWidth: "0",
                                backgroundColor: "rgba(0, 123, 255, 0.5)"
                            },
                        ],
                    },
                    options: {
                        legend: {
                            position: 'top',
                            labels: {
                                fontFamily: 'Poppins'
                            }
                        },
                    },
                });
            }

        } catch (error) {
            console.log(error);
        }
    </script>
    @endsection