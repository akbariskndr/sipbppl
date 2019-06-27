@extends('layout.wrapper')
    @section('content')
        @component('layout.navigation')
        @endcomponent
        @component('layout.main')
            @slot('content')
                <div class="row">
                    <div class="col-md-4">
                        <div class="statistic__item">
                            <h2 class="number">{{ number_format($totalSum, 0) }}</h2>
                            <span class="desc">Penghasilan Keseluruhan</span>
                            <div class="icon">
                                <i class="zmdi zmdi-money"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="statistic__item">
                            <h2 class="number">{{ number_format($sumMonthBefore, 0) }}</h2>
                            <span class="desc">Penghasilan Bulan Kemarin</span>
                            <div class="icon">
                                <i class="zmdi zmdi-money"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="statistic__item">
                            <h2 class="number">{{ number_format($sumCurrentMonth, 0) }}</h2>
                            <span class="desc">Penghasilan Bulan Ini</span>
                            <div class="icon">
                                <i class="zmdi zmdi-money"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">{{ $title }}</h2>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        @if($incomes->count() > 0)
                        <div class="table-responsive table-responsive-data3">
                            <table class="table table-data3">
                                <thead>
                                    <tr>
                                        <th>no.</th>
                                        <th>jumlah</th>
                                        <th>keterangan</th>
                                        <th>tanggal masuk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($incomes as $income)
                                    <tr class="tr-shadow">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $income->quantity }}</td>
                                        <td>{{ $income->note }}</td>
                                        <td>{{ \Carbon\Carbon::parse($income->income_date)->format('d/m/Y') }}</td>
                                    </tr>
                                    <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- END DATA TABLE -->
                        @else
                        <p>Maaf, belum terdapat penghasilan</p>
                        @endif
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        {{ $incomes->links() }}
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-8">
                        <div class="au-card m-b-30">
                            <div class="au-card-inner">
                                <div class="row">
                                    <div class="col-md-5">
                                        <h3 class="title-2 m-b-40">Grafik Penghasilan</h3>
                                    </div>
                                    <div class="col-md-7">
                                        <form class="form-inline" id="form-search-income">
                                            <select name="month" id="month" class="custom-select form-control">
                                                <option selected disabled>Bulan</option>
                                                <option value="">-</option>
                                                <option value="1" {{ \Carbon\Carbon::now()->month === 1 ? 'selected' : ''}}>Januari</option>
                                                <option value="2" {{ \Carbon\Carbon::now()->month === 2 ? 'selected' : ''}}>Februari</option>
                                                <option value="3" {{ \Carbon\Carbon::now()->month === 3 ? 'selected' : ''}}>Maret</option>
                                                <option value="4" {{ \Carbon\Carbon::now()->month === 4 ? 'selected' : ''}}>April</option>
                                                <option value="5" {{ \Carbon\Carbon::now()->month === 5 ? 'selected' : ''}}>Mei</option>
                                                <option value="6" {{ \Carbon\Carbon::now()->month === 6 ? 'selected' : ''}}>Juni</option>
                                                <option value="7" {{ \Carbon\Carbon::now()->month === 7 ? 'selected' : ''}}>Juli</option>
                                                <option value="8" {{ \Carbon\Carbon::now()->month === 8 ? 'selected' : ''}}>Agustus</option>
                                                <option value="9" {{ \Carbon\Carbon::now()->month === 9 ? 'selected' : ''}}>September</option>
                                                <option value="10" {{ \Carbon\Carbon::now()->month === 10 ? 'selected' : ''}}>Oktober</option>
                                                <option value="11" {{ \Carbon\Carbon::now()->month === 11 ? 'selected' : ''}}>November</option>
                                                <option value="12" {{ \Carbon\Carbon::now()->month === 12 ? 'selected' : ''}}>Desember</option>
                                            </select>
                                            <select name="year" id="year" class="custom-select form-control">
                                                <option selected disabled>Tahun</option>
                                                @foreach($years as $year)
                                                    <option value="{{ $year->year }}" {{ \Carbon\Carbon::now()->year === $year->year ? 'selected' : '' }}>{{ $year->year }}</option>
                                                @endforeach
                                            </select>
                                            <button type="button "class="btn btn-primary">
                                                Cari
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <canvas id="income-chart" height="138" width="278" class="chartjs-render-monitor" style="display: block; height: 111px; width: 223px;"></canvas>
                            </div>
                        </div>
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
            var ctx = document.getElementById("income-chart");

            if (ctx) {
                var config = {
                    type: 'bar',
                    data: {
                        labels: @json($date),
                        datasets: [
                            {
                                label: "Pemasukan (x1000)",
                                data: @json($sums),
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
                };
                ctx.height = 150;
                var myChart = new Chart(ctx, config);
            }

        } catch (error) {
            console.log(error);
        }

        $('#form-search-income').on('submit', function(e) {
            e.preventDefault();

            var month = $('#month').val();
            var year = $('#year').val();

            if (!month && !year ) return;

            $.get('{{ $user ? url("/api/pemasukan/pengguna/$user") : url("/api/pemasukan") }}', $('#form-search-income').serialize(), function(data) {
                console.log(data);
                var date = data.map(function(val, index) {
                    if (!month) {
                        return getMonth(val['month']) + ' ' + year;
                    }
                    return val['day'] + ' ' + getMonth(val['month']) + ' ' + val['year'];
                });

                var sums = data.map(function(val, index) {
                    return Number(val['sum']) / 1000;
                });

                config.data.labels = date;
                config.data.datasets[0].data = sums;

                myChart.update();
            });
        });
    </script>

    @endsection