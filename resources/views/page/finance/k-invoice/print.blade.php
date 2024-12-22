<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{asset('zen-blue-logo.png')}}">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
            background: #fff;
        }

        .invoice {
            width: 210mm;
            margin: auto;
            padding: 20mm;
            border: 1px solid #ccc;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px; /* Spasi antara logo dan teks */
        }

        .header-left .logo {
            width: 100px; /* Sesuaikan ukuran logo */
            height: auto;
        }

        .header-right {
            text-align: right;
        }

        .header-right h1 {
            margin: 0;
            font-size: 24px; /* Sesuaikan ukuran */
        }

        .header-right p {
            margin: 0;
            font-size: 12px; /* Sesuaikan ukuran */
        }
        .header-left p strong {
            font-size: 12px; /* Perbesar ukuran font */
            font-weight: bold; /* Gunakan font-weight bold */
        }

        .logo {
            max-width: 150px;
            margin-bottom: 10px;
        }

        .header-right {
            text-align: right;
        }

        main {
            margin-top: 20px;
        }

        .to-section {
            margin-bottom: 20px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table th, .invoice-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .invoice-table th {
            background: #f0f0f0;
        }

        .invoice-table .right-align {
            text-align: right;
        }

        .terbilang {
            font-style: italic;
            margin-top: 10px;
        }

        .notes {
            margin-top: 20px;
        }

        footer {
            margin-top: 30px;
            text-align: right;
        }
            
    </style>    
</head>
<body>
    <div class="invoice">
        <header>
            <div class="header-left">
                <img src="{{ asset('zen-black.png') }}" alt="Logo" class="logo">
                <p style="font-size: 12px">
                    <strong style="font-size: 16px; font-weight: bold;">PT. ZEN MULTIMEDIA INDONESIA</strong><br>
                    Jl. Tarumanegara Raya Blk EE-1/199 RT.09 RW.005, Purwamekar, Purwakarta<br>
                    Email: info@zenmultimedia.com | Website: www.zenmultimediaexp.com
                </p>
            </div>
            <div class="header-right">
                <h1>&nbsp; &nbsp; I&nbsp;&nbsp;N&nbsp;&nbsp;V&nbsp;&nbsp;O&nbsp;&nbsp;I&nbsp;&nbsp;C&nbsp;&nbsp;E&nbsp; &nbsp;  &nbsp; </h1>
                <hr style="margin-top: -5px">
                <p>No: {{$data->no_invoice}}<br>Tgl: {{$data->date}}</p>
            </div>
        </header>
        
        <main>
            <section class="to-section">
                <p><strong>Kepada:</strong> {{$data->kepada}}</p>
                <p>NPWP: {{$data->npwp}}</p>
                <p>Alamat: {{$data->alamat}}</p>
            </section>
            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Deskripsi</th>
                        <th>Unit</th>
                        <th>Harga (Rp)</th>
                        <th>Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoiceDetails as $detail)
                    <tr>
                        <td>{{ $detail['no'] }}</td>
                        <td>{{ $detail['deskripsi'] }}</td>
                        <td>{{ $detail['unit'] }}</td>
                        <td>Rp. {{ number_format($detail['harga'], 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($detail['jumlah'], 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="right-align">Sub Total</td>
                        <td>Rp. {{ number_format($subTotal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="right-align">PPN {{ number_format($detail['ppn'] * 100) }}%</td>
                        <td>Rp. {{ number_format($ppn, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="right-align"><strong>Total</strong></td>
                        <td><strong>Rp. {{ number_format($total, 0, ',', '.') }}</strong></td>
                    </tr>
                </tfoot>
            </table>
            
            <p class="terbilang">Terbilang:{{$data->terbilang}}</p>
            <section class="notes">
                <p><strong>Note:</strong></p>
                <p>Pembayaran invoice ini mohon ditransfer ke:</p>
                <p>
                    Bank BCA - Rek. 231-266-5213<br>
                    Bank BRI - Rek. 005.002.202.100.1<br>
                    Atas Nama: PT. ZEN MULTIMEDIA INDONESIA
                </p>
            </section>
        </main>
        <footer>
            <p>Purwakarta, {{$data->date}}</p>
            <p><strong>Hormat Kami,</strong></p>
            <p><strong>{{$data->pembuat}}</strong></p>
        </footer>
    </div>
</body>
</html>
