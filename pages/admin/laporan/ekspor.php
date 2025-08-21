
<?php
include 'function/admin/laporan.php';

$jenis = $_GET['jenis'] ?? '';
if (empty($jenis)) {
    header('Location: dashboard.php?route=laporan');
    exit;
}

// Set headers untuk download Excel
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Laporan_' . ucfirst($jenis) . '_' . date('Y-m-d') . '.xls"');
header('Pragma: no-cache');
header('Expires: 0');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan <?php echo ucfirst($jenis); ?></title>
</head>
<body>
    <table border="1">
        <tr>
            <td colspan="8" style="text-align: center; font-weight: bold; font-size: 16px;">
                LAPORAN <?php echo strtoupper($jenis); ?>
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center;">
                PT. CONTOH PERUSAHAAN
            </td>
        </tr>
        <tr>
            <td colspan="8" style="text-align: center;">
                Periode: <?php echo $_GET['tanggal_mulai'] ?? 'Semua'; ?> s/d <?php echo $_GET['tanggal_selesai'] ?? 'Semua'; ?>
            </td>
        </tr>
        <tr><td colspan="8"></td></tr>

        <?php if ($jenis == 'cuti'): ?>
            <?php 
            $result = getLaporanCuti($_GET);
            ?>
            <tr style="background-color: #f0f0f0; font-weight: bold;">
                <td>No</td>
                <td>NIP</td>
                <td>Nama Karyawan</td>
                <td>Departemen</td>
                <td>Jenis Cuti</td>
                <td>Tanggal Mulai</td>
                <td>Tanggal Selesai</td>
                <td>Jumlah Hari</td>
                <td>Status</td>
            </tr>
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

        <?php elseif ($jenis == 'karyawan'): ?>
            <?php 
            $result = getLaporanKaryawan($_GET);
            ?>
            <tr style="background-color: #f0f0f0; font-weight: bold;">
                <td>No</td>
                <td>NIP</td>
                <td>Nama Lengkap</td>
                <td>Email</td>
                <td>Departemen</td>
                <td>Jabatan</td>
                <td>Peran</td>
                <td>Total Cuti</td>
            </tr>
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
        <?php endif; ?>

        <tr><td colspan="8"></td></tr>
        <tr>
            <td colspan="8" style="text-align: right; font-size: 10px;">
                Diekspor pada: <?php echo date('d F Y, H:i:s'); ?>
            </td>
        </tr>
    </table>
</body>
</html>
