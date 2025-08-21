
<?php
require_once 'vendor/autoload.php'; // Jika menggunakan TCPDF via Composer
// Atau include manual jika tidak menggunakan Composer

include 'function/karyawan/riwayat.php';
include 'function/karyawan/profile.php';

$id_karyawan = $_SESSION['user_id'];
$profile = getProfileKaryawan($id_karyawan);

// Handle filters (sama seperti view.php)
$filters = [];
if (isset($_GET['status']) && !empty($_GET['status'])) {
    $filters['status'] = $_GET['status'];
}
if (isset($_GET['jenis_cuti']) && !empty($_GET['jenis_cuti'])) {
    $filters['jenis_cuti'] = $_GET['jenis_cuti'];
}
if (isset($_GET['tahun']) && !empty($_GET['tahun'])) {
    $filters['tahun'] = $_GET['tahun'];
}

$riwayat_cuti = getRiwayatCuti($id_karyawan, $filters);
$statistik = getStatistikRiwayat($id_karyawan, $filters['tahun'] ?? null);

// Simple HTML to PDF (jika tidak ada library khusus)
ob_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Riwayat Cuti</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .info { margin-bottom: 20px; }
        .stats { display: flex; justify-content: space-around; margin: 20px 0; }
        .stat-box { text-align: center; padding: 10px; border: 1px solid #ccc; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .status-approved { color: green; font-weight: bold; }
        .status-pending { color: orange; font-weight: bold; }
        .status-rejected { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN RIWAYAT CUTI KARYAWAN</h2>
        <p>Periode: <?php echo date('d F Y'); ?></p>
    </div>
    
    <div class="info">
        <h3>Informasi Karyawan</h3>
        <p><strong>Nama:</strong> <?php echo $profile['nama_depan'] . ' ' . $profile['nama_belakang']; ?></p>
        <p><strong>Departemen:</strong> <?php echo $profile['nama_departemen']; ?></p>
        <p><strong>Email:</strong> <?php echo $profile['email']; ?></p>
    </div>
    
    <div class="stats">
        <div class="stat-box">
            <h4><?php echo $statistik['total_pengajuan']; ?></h4>
            <p>Total Pengajuan</p>
        </div>
        <div class="stat-box">
            <h4><?php echo $statistik['disetujui']; ?></h4>
            <p>Disetujui</p>
        </div>
        <div class="stat-box">
            <h4><?php echo $statistik['pending']; ?></h4>
            <p>Pending</p>
        </div>
        <div class="stat-box">
            <h4><?php echo $statistik['total_hari_cuti']; ?></h4>
            <p>Total Hari Cuti</p>
        </div>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis Cuti</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Jumlah Hari</th>
                <th>Status</th>
                <th>Alasan</th>
                <th>Tanggal Pengajuan</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($riwayat_cuti) > 0): ?>
                <?php 
                $no = 1;
                while ($riwayat = mysqli_fetch_assoc($riwayat_cuti)): 
                ?>
                <tr>
                    <td><?php echo $no++; ?></td>
                    <td><?php echo $riwayat['nama_cuti']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($riwayat['tanggal_mulai'])); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($riwayat['tanggal_selesai'])); ?></td>
                    <td><?php echo $riwayat['jumlah_hari']; ?> hari</td>
                    <td class="status-<?php echo strtolower($riwayat['status']); ?>">
                        <?php echo $riwayat['status']; ?>
                    </td>
                    <td><?php echo substr($riwayat['alasan'], 0, 100) . (strlen($riwayat['alasan']) > 100 ? '...' : ''); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($riwayat['tanggal_pengajuan'])); ?></td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data riwayat cuti</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak pada: <?php echo date('d F Y H:i'); ?> WIB</p>
    </div>
</body>
</html>
<?php
$html = ob_get_clean();

// Output sebagai PDF (basic implementation)
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Riwayat_Cuti_' . date('Y-m-d') . '.pdf"');

// Jika menggunakan library seperti TCPDF atau mPDF, gunakan di sini
// Untuk contoh sederhana, kita output sebagai HTML yang bisa dicetak
header('Content-Type: text/html');
echo $html;
?>
