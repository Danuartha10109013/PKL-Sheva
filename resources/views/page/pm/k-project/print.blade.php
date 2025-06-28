<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{asset('zen-blue-logo.png')}}">

    <title>Print Project Plan</title>
    <style>
        /* Print settings for A4 size */
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Cover page styles */
        .cover-page {
            position: relative;
            width: 210mm;
            height: 297mm;
            background: url('{{ asset("cover.jpg") }}') no-repeat center center;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            color: rgb(18, 24, 111);
            page-break-after: always;
        }

        .cover-page h1 {
            font-size: 36px;
            font-weight: bolder;
            margin-bottom: 50px;
            text-transform: uppercase; /* Makes text uppercase */
            font-family: Arial, sans-serif;
            margin-top: -70px
        }

        .cover-page p {
            font-size: 18px;
            margin: 5px 0;
        }

        /* Content styles */
        .content {
            width: 210mm;
            padding: 20mm;
            box-sizing: border-box;
            position: relative;
            page-break-after: always;
        }

        .content h2 {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .content p {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        /* Watermark styles */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 500px;
            height: 500px;
            background: url('{{ asset("zen-blue-logo.png") }}') no-repeat center center;
            background-size: cover;
            opacity: 0.5;
            z-index: -1;
            pointer-events: none;
        }

        /* Print button for screen view */
        .btn-print {
            margin: 20px;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .btn-print:hover {
            background-color: #0056b3;
        }

        @media print {
            .btn-print {
                display: none;
            }
            @page:first {
                margin: 0; /* No margin for the first page */
            }

            @page {
                margin-top: 50px;
                margin-bottom: 50px
                /* margin: 5mm; Apply margin to all subsequent pages */
            }
        }
    </style>
</head>
<body>
    <!-- Cover Page -->
    <div class="cover-page">
        <h1>{{$project->judul}}</h1>
        <p style="margin-top: -12px;margin-left: 50px">{{$data->no_projec_plan}} <br> 
            <div style="margin-left: -220px;margin-top: -4px">
                {{$data->no_rev}}
            </div>  </p>
    </div>

    <!-- Watermark -->
    <div class="watermark"></div>

    <!-- Content -->
    <div class="content">
        <h2>Pengantar</h2>
        <p>{!! $data->pengantar !!}</p>

        <h2>Ringkasan Eksekutif</h2>
        <p>{!! $data->ringkasan !!}</p>

        <h2>Ruang Lingkup Proyek</h2>
        <p>{!! $data->ruang_lingkup !!}</p>

        <h2>Jadwal Proyek</h2>
        <p>{!! $data->jadwal_proyek !!}</p>

        @if (!empty($fase))
            @foreach ($fase as $index => $item)
                <h2><strong>Fase {{ $index + 1 }}:</strong> {{ $item['scrum_name'] }} <strong>Start:</strong> {{ $item['start'] }} <strong>End:</strong> {{ $item['end'] }}</h2>
                <p>{!! $item['description'] !!}</p>
            @endforeach
        @endif

        <h2><strong>Tim Proyek:</strong></h2>
        <p>{!! $data->team_proyek !!}</p>

        <h2><strong>Fitur Utama Aplikasi:</strong></h2>
        <p>{!! $data->fitur_utama !!}</p>

        <h2><strong>Rincian Teknis & Tugas:</strong></h2>
        <p>{!! $data->rincian_teknis !!}</p>

        <h2><strong>Topologi Microservices Cloud Server dengan AWS:</strong></h2>
        <p>{!! $data->topologi !!}</p>

        <h2><strong>Diagram Arsitektur:</strong></h2>
        <p>{!! $data->diagram !!}</p>

        <h2><strong>Anggaran Pengerjaan:</strong></h2>
        <p>{!! $data->anggaran !!}</p>

        <h2><strong>Nilai Proyek:</strong></h2>
        <p>{!! $data->nilai !!}</p>

        <h2>Pernyataan Kesepakatan Dokumen Perencanaan Proyek</h2>
        <p>{!! $data->pernyataan !!}</p>

        <h2>Catatan Tambahan</h2>
        <p>{!! $data->catatan !!}</p>
    </div>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
