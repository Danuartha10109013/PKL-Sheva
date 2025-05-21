<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Project Baru Dibuat</title>
</head>
<body>
    <p>Yth. Tim Finance,</p>

    <p>Sebuah proyek baru telah dibuat dengan detail sebagai berikut:</p>

    <ul>
        <li><strong>Judul:</strong> {{ $project->judul }}</li>
        <li><strong>Customer:</strong> {{ $project->customer->name ?? '-' }}</li>
        <li><strong>Start:</strong> {{ $project->start }}</li>
        <li><strong>End:</strong> {{ $project->end }}</li>
        <li><strong>Biaya:</strong> Rp {{ number_format($project->biaya, 0, ',', '.') }}</li>
        <li><strong>Project Manager:</strong> {{ $project->pm->name ?? '-' }}</li>
    </ul>

    <p>Mohon untuk segera melengkapi data invoice terkait proyek ini agar proses dapat berjalan dengan lancar.</p>

    <p>Terima kasih atas kerjasamanya.</p>

    <p>Hormat kami,<br>
    Project Manager</p>
</body>
</html>
