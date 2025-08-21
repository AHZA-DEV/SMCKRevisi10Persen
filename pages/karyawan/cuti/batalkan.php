
<?php
include 'function/karyawan/cuti.php';

$id_cuti = $_GET['id'] ?? 0;
$detail_result = getDetailCuti($id_cuti, $_SESSION['user_id']);
$cuti = mysqli_fetch_assoc($detail_result);

if (!$cuti) {
    echo '<div class="alert alert-warning">Cuti tidak ditemukan!</div>';
    exit;
}

if (isset($_POST['batalkan_cuti'])) {
    if ($cuti['status'] != 'Pending') {
        $error_message = "Hanya cuti dengan status Pending yang dapat dibatalkan!";
    } else {
        $result = batalkanCuti($id_cuti, $_SESSION['user_id']);
        
        if ($result) {
            $success_message = "Cuti berhasil dibatalkan!";
            // Refresh data
            $detail_result = getDetailCuti($id_cuti, $_SESSION['user_id']);
            $cuti = mysqli_fetch_assoc($detail_result);
        } else {
            $error_message = "Gagal membatalkan cuti. Silakan coba lagi.";
        }
    }
}
?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Batalkan Pengajuan Cuti</h1>
        <p class="text-muted">Konfirmasi pembatalan pengajuan cuti</p>
    </div>
</div>

<?php if (isset($success_message)): ?>
<div class="alert alert-success alert-dismissible fade show">
    <i class="fas fa-check-circle"></i> <?php echo $success_message; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<?php if (isset($error_message)): ?>
<div class="alert alert-danger alert-dismissible fade show">
    <i class="fas fa-exclamation-circle"></i> <?php echo $error_message; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Detail Pengajuan Cuti</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small text-muted">Jenis Cuti:</label>
                            <div><strong><?php echo htmlspecialchars($cuti['nama_cuti']); ?></strong></div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="small text-muted">Tanggal Mulai:</label>
                            <div><?php echo date('d/m/Y', strtotime($cuti['tanggal_mulai'])); ?></div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="small text-muted">Tanggal Selesai:</label>
                            <div><?php echo date('d/m/Y', strtotime($cuti['tanggal_selesai'])); ?></div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="small text-muted">Jumlah Hari:</label>
                            <div><strong><?php echo $cuti['jumlah_hari']; ?> hari</strong></div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="small text-muted">Status:</label>
                            <div>
                                <?php
                                $badge_class = '';
                                switch($cuti['status']) {
                                    case 'Pending': $badge_class = 'warning'; break;
                                    case 'Disetujui': $badge_class = 'success'; break;
                                    case 'Ditolak': $badge_class = 'danger'; break;
                                    case 'Dibatalkan': $badge_class = 'secondary'; break;
                                    default: $badge_class = 'primary';
                                }
                                ?>
                                <span class="badge bg-<?php echo $badge_class; ?>"><?php echo $cuti['status']; ?></span>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="small text-muted">Tanggal Pengajuan:</label>
                            <div><?php echo date('d/m/Y H:i', strtotime($cuti['tanggal_pengajuan'])); ?></div>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="small text-muted">Alasan Cuti:</label>
                    <div class="p-3 bg-light rounded"><?php echo nl2br(htmlspecialchars($cuti['alasan'])); ?></div>
                </div>
                
                <?php if (!empty($cuti['alamat_cuti'])): ?>
                <div class="mb-3">
                    <label class="small text-muted">Alamat Selama Cuti:</label>
                    <div class="p-3 bg-light rounded"><?php echo nl2br(htmlspecialchars($cuti['alamat_cuti'])); ?></div>
                </div>
                <?php endif; ?>

                <?php if ($cuti['status'] == 'Pending'): ?>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Perhatian!</strong> Tindakan ini akan membatalkan pengajuan cuti Anda dan tidak dapat dibatalkan.
                </div>

                <form method="POST" onsubmit="return confirm('Yakin ingin membatalkan pengajuan cuti ini?')">
                    <div class="d-flex gap-2">
                        <button type="submit" name="batalkan_cuti" class="btn btn-danger">
                            <i class="fas fa-times"></i> Batalkan Cuti
                        </button>
                        <a href="dashboard.php?route=cutiview" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
                <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Cuti dengan status <?php echo $cuti['status']; ?> tidak dapat dibatalkan.
                </div>
                
                <a href="dashboard.php?route=cutiview" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar Cuti
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Informasi Penting</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-danger">Pembatalan Cuti</h6>
                    <ul class="small">
                        <li>Hanya cuti dengan status <span class="badge bg-warning">Pending</span> yang dapat dibatalkan</li>
                        <li>Pembatalan tidak dapat dibatalkan</li>
                        <li>Anda dapat mengajukan cuti baru kapan saja</li>
                    </ul>
                </div>
                
                <div class="alert alert-info">
                    <small><i class="fas fa-lightbulb"></i> <strong>Tips:</strong> Jika ingin mengubah detail cuti, gunakan fitur Edit alih-alih membatalkan.</small>
                </div>
            </div>
        </div>
    </div>
</div>
