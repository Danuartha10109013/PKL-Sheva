<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Plan Notification</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px;">
    <div style="background-color: white; padding: 20px; border-radius: 10px;">
        <h2 style="color: #007bff;">📄 Project Plan Telah Selesai Dirancang</h2>
        @php
            $klien = \App\Models\User::find($data['customer_id']);
            $tl = \App\Models\User::find($data['team_leader_id']);
            $pm = \App\Models\User::find(1);
        @endphp
        <p>Halo {{ $klien->name ?? 'Client' }},</p>

        <p>
            Kami ingin menginformasikan bahwa dokumen <strong>Project Plan</strong> untuk proyek berikut telah selesai dirancang:
        </p>

        <table style="width: 100%; border-collapse: collapse; margin: 20px 0;">
            <tr>
                <td><strong>Judul Proyek:</strong></td>
                <td>{{ $data['judul'] }}</td>
            </tr>
            <tr>
                <td><strong>Project Manager:</strong></td>
                <td>{{ $pm->name ?? 'Project Manager'}}</td>
            </tr>
            <tr>
                <td><strong>Team Leader:</strong></td>
                <td>{{ $tl->name ' Team Leader'}}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Mulai:</strong></td>
                <td>{{ \Carbon\Carbon::parse($data['start'])->format('d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Tanggal Selesai:</strong></td>
                <td>{{ \Carbon\Carbon::parse($data['end'])->format('d M Y') }}</td>
            </tr>
            <tr>
                <td><strong>Biaya Proyek:</strong></td>
                <td>Rp {{ number_format($data['biaya'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td><strong>Progress Saat Ini:</strong></td>
                <td>{{ $data['progres'] }}%</td>
            </tr>
        </table>

        <p>
            Kami membutuhkan <strong>respon dan masukan</strong> dari Anda sebelum proses peluncuran proyek dimulai.
            Silakan beri komentar atau persetujuan Anda melalui platform kami.
        </p>

        <p>
            Terima kasih atas kerja sama Anda.
        </p>

        <p>Salam hangat,<br><strong>Tim Project Management</strong></p>
    </div>
</body>
</html>
