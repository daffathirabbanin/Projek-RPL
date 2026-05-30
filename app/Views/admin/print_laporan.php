<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($data['title']) ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0 0 5px 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header p {
            margin: 0;
            font-size: 12px;
            color: #666;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        .footer {
            text-align: right;
            margin-top: 50px;
        }
        .signature {
            display: inline-block;
            text-align: center;
        }
        .signature p {
            margin: 0;
        }
        .signature-name {
            margin-top: 60px !important;
            font-weight: bold;
            text-decoration: underline;
        }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="margin-bottom:20px; text-align:center;">
        <button onclick="window.print()" style="padding:10px 20px; cursor:pointer; font-weight:bold;">Print Laporan</button>
        <button onclick="window.close()" style="padding:10px 20px; cursor:pointer;">Tutup</button>
    </div>

    <div class="header">
        <h1><?= htmlspecialchars($data['title']) ?></h1>
        <p>PENERIMAAN PESERTA DIDIK BARU (PPDB) TAHUN AJARAN 2026/2027</p>
        <p>Dicetak pada: <?= date('d F Y, H:i') ?></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="15%">ID Pendaftaran</th>
                <th width="20%">Nama Lengkap</th>
                <th width="10%">NISN</th>
                <th width="7%">L/P</th>
                <th width="15%">Tempat, Tgl Lahir</th>
                <th width="12%">No. HP</th>
                <th width="18%">Alamat</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($data['results'])): ?>
            <tr>
                <td colspan="8" style="text-align:center; padding: 20px;">Tidak ada data.</td>
            </tr>
            <?php else: ?>
                <?php $i=1; foreach($data['results'] as $row): ?>
                <tr>
                    <td style="text-align:center;"><?= $i++ ?></td>
                    <td><?= htmlspecialchars($row['pendaftaran_id']) ?></td>
                    <td><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                    <td><?= htmlspecialchars($row['nisn']) ?></td>
                    <td style="text-align:center;"><?= $row['jenis_kelamin'] == 'Laki-laki' ? 'L' : ($row['jenis_kelamin'] == 'Perempuan' ? 'P' : '-') ?></td>
                    <td><?= htmlspecialchars($row['tempat_lahir']) ?>, <?= htmlspecialchars($row['tanggal_lahir']) ?></td>
                    <td><?= htmlspecialchars($row['no_hp']) ?></td>
                    <td><?= htmlspecialchars($row['alamat']) ?></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Panitia PPDB,</p>
            <p class="signature-name">______________________</p>
        </div>
    </div>

</body>
</html>
