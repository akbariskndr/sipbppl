<html lang="en">
<head>
    <style>

        * {
            margin: 0;
            padding: 0;

            font-family: 'Times New Roman', Times, serif;
        }
        body {
            min-width: 100%;
            min-height: 100%;
        }

        header {
            margin-top: 5%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .company-name, .company-note {
            font-family: montserratlight, arial;
            color: #259dab;
        }
        .company-note, .company-slogan {
            margin-top: 5%;
        }
        .company-address {
            margin-top: 2%;
        }
        .company-email {
            margin-bottom: 5%;
        }

        .atas {
            display: flex;
            flex-direction: row;
            width: 100%;
            margin-top: 2%;
            margin-left: 2%;
        }
        .perihal, {
            width: 50%;
        }

        .tanggal {
            width: 50%;
            margin-left: 7%;
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
        }

        .tengah, .bawah {
            display: flex;
            width: 100%;
            flex-direction: column;
            margin-top: 4%;
            margin-left: 2%;
        }

        .tertanda {
            margin-top: 10%;
            width: 95%;
            display: flex;
            flex-direction: row;
            justify-content: flex-end;
        }

        .tertanda-container {
            text-align: center;
        }

        .nama-direktur {
            margin-top: 50%;
        }
    </style>
</head>
<body>
    <header>
        <div>
            <h1 class="company-name">JENDERAL SOFTWARE</h1>
        </div>
        <div>
            <h6 class="company-note">SOFTWORKS|SOLUTION</h6>
        </div>
        <div>
            <p class="company-slogan"><i><b>We Think, We do, We Change The World</b></i></p>
        </div>
        <div>
            <p class="company-address">
                Alamat : Jalan HR Bahrun, Perum Berkoh No 365, Purwokerto Selatan, Kab Banyumas 53146
            </p>
        </div>
        <div>
            <p class="company-email">
                Email : jenderal.software@gmail.com Website : jenderalcorp.com
            </p>
        </div>
    </header>
    <hr>
    <hr>
    <main>
        <div class="atas">
            <div class="perihal">
                <div>
                    <p>Nomor &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : {{$project->id}}/HH/{{ \Carbon\Carbon::now()->year }}</p>
                </div>
                <div>
                    <p>Lampiran &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : -</p>
                </div>
                <div>
                    <p>Perihal &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : Hasil Perhitungan Biaya Proyek</p>
                </div>
            </div>
            <div class="tanggal">
                <p>{{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
            </div>
        </div>
        <div class="tengah">
            <div>
                <p>Kepada Yth</p>
            </div>
            <div>
                <p>Saudara/i {{ $project->client_name }}</p>
            </div>
            <div>
                <p>{{ $project->instance_name }}</p>
            </div>
            <div>
                <p>Di Tempat</p>
            </div>
        </div>
        <div class="bawah">
            <p>Menindaklanjuti permohonan Anda dalam pembuatan {{ $project->title }} 
                pada tanggal {{ \Carbon\Carbon::parse($project->created_at)->format('d/m/Y') }} 
                dan berdasarkan hasil diskusi tim kami, maka dengan ini kami mengemukakan bahwa total biaya yang dibutuhkan dalam pengembangan sistem
            ini adalah sejumlah <b>Rp. {{ number_format($project->cost->calculation_result, 0) }}</b>.</p>
            @if($project->cost->calculation_result !== $project->cost->alternate_cost)
            <p>Dengan memberikan alternatif harga sekurang - kurangnya sebesar <b>Rp. {{number_format($project->cost->alternate_cost, 0) }}</b> dengan melakukan pengurangan fitur</p>
            <p>yang kami anggap tidak terlalu penting.</p>
            @endif
            <br>
            <p>Demikian surat ini kami sampaikan, atas perhatian dan kerjasamanya kami ucapkan terima kasih.</p>
        </div>
        <div class="tertanda">
            <div class="tertanda-container">
                <p class="direktur">Direktur CV. Jenderal Software</p>
                <p class="nama-direktur"><b>Mohammad Irham Akbar</b></p>
            </div>
        </div>
    </main>

    <script>
        window.print();
    </script>
</body>
</html>