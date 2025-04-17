<!-- Email View Start -->
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    {{-- Email Text --}}
    <p>Yth. <strong>{{ $customerName }}</strong>,</p>

    <p>
        Saya <strong>{{ $senderName }}</strong>, Finance Staff PT ZEN MULTIMEDIA INDONESIA.
        Bersama email ini, terlampir invoice untuk <strong> {{ $term }} ({{ $percentage }}%)</strong> proyek <strong>{{ $projectName }}</strong> senilai <strong>Rp{{ number_format($totalCost, 0, ',', '.') }}</strong>
        ({{ $terbilang }}), dengan tanggal jatuh tempo sesuai yang tercantum di invoice.
    </p>

    <p>Pembayaran dapat ditransfer ke:</p>
    <ul>
        <li><strong>Bank BCA:</strong> 231-266-5213</li>
        <li><strong>Bank BRI:</strong> 005.002.202.100.1</li>
        <li><strong>Atas nama:</strong> PT. ZEN MULTIMEDIA INDONESIA</li>
    </ul>

    <p>Jika ada pertanyaan, silakan hubungi kami kembali.</p>
    <p>Terima kasih.</p>
    <p>Hormat saya,<br><strong>{{ $senderName }}</strong></p>

    <hr>

    {{-- Inline Invoice --}}
    <div class="invoice" style="width: 100%; max-width: 800px; margin: 20px auto; border: 1px solid #ccc; padding: 20px; font-size: 14px;">

        {{-- Header --}}
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <img src="{{ asset('zen-black.png') }}" alt="Logo" style="max-width: 120px; margin-bottom: 10px;">
                <p style="margin: 0;">
                    <strong>PT. ZEN MULTIMEDIA INDONESIA</strong><br>
                    Jl. Tarumanegara Raya Blk EE-1/199 RT.09 RW.005, Purwamekar, Purwakarta<br>
                    Email: info@zenmultimedia.com | Website: www.zenmultimediaexp.com
                </p>
            </div>
            <div style="text-align: right;">
                <h2 style="margin: 0;">INVOICE</h2>
                <p style="margin: 0;">No: {{ $invoiceId }}<br>Tgl: {{ $dueDate }}</p>
            </div>
        </div>

        {{-- Invoice Info --}}
        <div style="margin-top: 20px;">
            <p><strong>Kepada:</strong> {{ $customerName }}</p>
            <p>NPWP: {{ $npwp }}</p>
            <p>Alamat: {{ $alamat }}</p>
        </div>

        {{-- Table --}}
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th style="border: 1px solid #000; padding: 8px;">No</th>
                    <th style="border: 1px solid #000; padding: 8px;">Deskripsi</th>
                    <th style="border: 1px solid #000; padding: 8px;">Unit</th>
                    <th style="border: 1px solid #000; padding: 8px;">Harga (Rp)</th>
                    <th style="border: 1px solid #000; padding: 8px;">Jumlah (Rp)</th>
                </tr>
            </thead>
            <tbody>
                    <tr>
                        <td style="border: 1px solid #000; padding: 8px;">{{ $invoiceId }}</td>
                        <td style="border: 1px solid #000; padding: 8px;">{{$term}} {{$percentage}}</td>
                        <td style="border: 1px solid #000; padding: 8px;">1 Package</td>
                        <td style="border: 1px solid #000; padding: 8px;">Rp{{ number_format($totalCostNoPpn, 0, ',', '.') }}</td>
                        <td style="border: 1px solid #000; padding: 8px;">Rp{{ number_format($totalCostNoPpn, 0, ',', '.') }}</td>
                    </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right; padding: 8px; border: 1px solid #000;">Sub Total</td>
                    <td style="padding: 8px; border: 1px solid #000;">Rp{{ number_format($totalCostNoPpn, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right; padding: 8px; border: 1px solid #000;">PPN {{ number_format($ppn * 100) }}%</td>
                    <td style="padding: 8px; border: 1px solid #000;">Rp{{ number_format($totalCostNoPpn * $ppn, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right; padding: 8px; border: 1px solid #000;"><strong>Total</strong></td>
                    <td style="padding: 8px; border: 1px solid #000;"><strong>Rp{{ number_format($totalCost, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        </table>

        <p><em>Terbilang: {{ $terbilang }}</em></p>

        <div style="margin-top: 20px;">
            <p><strong>Note:</strong></p>
            <p>
                Pembayaran invoice ini mohon ditransfer ke:<br>
                Bank BCA - Rek. 231-266-5213<br>
                Bank BRI - Rek. 005.002.202.100.1<br>
                Atas Nama: PT. ZEN MULTIMEDIA INDONESIA
            </p>
        </div>

        <div style="margin-top: 40px; text-align: right;">
            <p>Purwakarta, {{ $dueDate }}</p>
            <p><strong>Hormat Kami,</strong></p>
            <p><strong>{{ $senderName }}</strong></p>
        </div>
    </div>

</body>
