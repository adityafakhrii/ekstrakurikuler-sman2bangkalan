<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Absensi</title>
    <style>
        @page { margin: 24px 20px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #111827; }
        .page { page-break-after: always; }
        .page:last-child { page-break-after: auto; }
        .wrapper { background: #fff7f7; border: 1px solid #f0dede; border-radius: 18px; padding: 20px; }
        .title { text-align: center; font-size: 24px; font-weight: 700; margin: 0; }
        .subtitle { text-align: center; margin: 8px 0 14px; font-size: 12px; font-weight: 600; }
        .underline { width: 180px; height: 1px; background: #9ca3af; margin: 8px auto 18px; }
        .meta { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .meta td { padding: 3px 0; vertical-align: top; }
        .meta td:first-child { width: 110px; }
        .meta td:nth-child(2) { width: 10px; }
        table.report { width: 100%; border-collapse: collapse; background: #fff; }
        table.report th, table.report td { border: 1px solid #e5e7eb; padding: 6px 8px; font-size: 10px; }
        table.report th { background: #f9fafb; text-align: center; font-weight: 700; }
        .text-center { text-align: center; }
        .legend { margin-top: 18px; }
        .legend-title { font-weight: 700; margin-bottom: 6px; }
        .legend table { border-collapse: collapse; }
        .legend td { padding: 2px 8px 2px 0; }
        .formula { margin-top: 14px; padding: 10px 12px; background: #111111; color: #ffffff; font-size: 12px; font-weight: 700; }
    </style>
</head>
<body>
    @foreach($pages as $pageIndex => $rows)
        <div class="page">
            <div class="wrapper">
                <h1 class="title">Laporan Absensi</h1>
                <div class="subtitle">Periode Semester : {{ $semester }}</div>
                <div class="underline"></div>

                <div style="text-align: center; font-size: 13px; font-weight: 600; margin-bottom: 2px;">{{ $ekskul->nama }} - SMAN 2 Bangkalan</div>


                <table class="meta">
                    <tr>
                        <td>Nama Pembina</td>
                        <td>:</td>
                        <td>{{ $ekskul->pembina ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Nama Ketua</td>
                        <td>:</td>
                        <td>{{ $ketua->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Jadwal latihan</td>
                        <td>:</td>
                        <td>{{ $ekskul->jadwal ?: '-' }}</td>
                    </tr>
                    <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>Halaman {{ $pageIndex + 1 }} dari {{ $pages->count() }}</td>
                    </tr>
                </table>

                <table class="report">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIS</th>
                            <th>Nama Lengkap</th>
                            <th>TP</th>
                            <th>H</th>
                            <th>S</th>
                            <th>I</th>
                            <th>A</th>
                            <th>% Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $rowIndex => $row)
                            <tr>
                                <td class="text-center">{{ $row['index'] }}</td>
                                <td class="text-center">{{ $row['nis'] }}</td>
                                <td>{{ $row['nama'] }}</td>
                                <td class="text-center">{{ $row['tp'] }}</td>
                                <td class="text-center">{{ $row['hadir'] }}</td>
                                <td class="text-center">{{ $row['sakit'] }}</td>
                                <td class="text-center">{{ $row['izin'] }}</td>
                                <td class="text-center">{{ $row['alpha'] }}</td>
                                <td class="text-center">{{ rtrim(rtrim(number_format($row['percentage'], 2), '0'), '.') }}% {{ $row['rating'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="legend">
                    <div class="legend-title">Keterangan</div>
                    <table>
                        <tr><td>TP</td><td>:</td><td>Total Pertemuan</td></tr>
                        <tr><td>H</td><td>:</td><td>Hadir</td></tr>
                        <tr><td>S</td><td>:</td><td>Sakit</td></tr>
                        <tr><td>I</td><td>:</td><td>Izin</td></tr>
                        <tr><td>A</td><td>:</td><td>Alfa</td></tr>
                        <tr><td>% Kehadiran</td><td>:</td><td>Presentase Kehadiran</td></tr>
                    </table>
                </div>

                <div class="formula">
                    Persentase Kehadiran = ((H + (S × 0.5) + (I × 0.5)) / TP) × 100%
                </div>
            </div>
        </div>
    @endforeach
</body>
</html>
