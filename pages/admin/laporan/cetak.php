
<?php
include 'function/admin/laporan.php';

$jenis = $_GET['jenis'] ?? '';
if (empty($jenis)) {
    header('Location: dashboard.php?route=laporan');
    exit;
}

// Set content type untuk PDF
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan <?php echo ucfirst($jenis); ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .company-info { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; }
        @media print {
            .no-print { display: none; }
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin: 20px 0; text-align: center;">
        <button onclick="window.print()" class="btn btn-primary">Cetak Laporan</button>
        <button onclick="window.close()" class="btn btn-secondary">Tutup</button>
    </div>

    <div class="company-info">
        <h2>PT. CONTOH PERUSAHAAN</h2>
        <p>Jl. Contoh No. 123, Jakarta | Tel: (021) 1234567 | Email: info@perusahaan.com</p>
    </div>

    <div class="header">
        <h1>LAPORAN <?php echo strtoupper($jenis); ?></h1>
        <p>Periode: <?php echo $_GET['tanggal_mulai'] ?? 'Semua'; ?> s/d <?php echo $_GET['tanggal_selesai'] ?? 'Semua'; ?></p>
        <p>Dicetak pada: <?php echo date('d F Y, H:i:s'); ?></p>
    </div>

    <?php if ($jenis == 'cuti'): ?>
        <?php 
        $result = getLaporanCuti($_GET);
        ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Karyawan</th>
                    <th>Departemen</th>
                    <th>Jenis Cuti</th>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Jumlah Hari</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $total_hari = 0;
                while ($row = mysqli_fetch_assoc($result)): 
                    if ($row['status'] == 'disetujui') {
                        $total_hari += $row['jumlah_hari'];
                    }
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nip']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_departemen'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_cuti']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['tanggal_mulai'])); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($row['tanggal_selesai'])); ?></td>
                    <td><?php echo $row['jumlah_hari']; ?></td>
                    <td><?php echo ucfirst($row['status']); ?></td>
                </tr>
                <?php endwhile; ?>
                <tr style="background-color: #f0f0f0; font-weight: bold;">
                    <td colspan="7">Total Hari Cuti Disetujui:</td>
                    <td><?php echo $total_hari; ?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>

    <?php elseif ($jenis == 'karyawan'): ?>
        <?php 
        $result = getLaporanKaryawan($_GET);
        ?>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Departemen</th>
                    <th>Jabatan</th>
                    <th>Peran</th>
                    <th>Total Cuti</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                $total_karyawan = 0;
                while ($row = mysqli_fetch_assoc($result)): 
                    $total_karyawan++;
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo htmlspecialchars($row['nip']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['nama_departemen'] ?? '-'); ?></td>
                    <td><?php echo htmlspecialchars($row['jabatan']); ?></td>
                    <td><?php echo ucfirst($row['peran']); ?></td>
                    <td><?php echo $row['total_cuti']; ?></td>
                </tr>
                <?php endwhile; ?>
                <tr style="background-color: #f0f0f0; font-weight: bold;">
                    <td colspan="7">Total Karyawan:</td>
                    <td><?php echo $total_karyawan; ?></td>
                </tr>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis oleh sistem pada <?php echo date('d F Y, H:i:s'); ?></p>
    </div>

    <script>
        // Auto print when page loads (optional)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
