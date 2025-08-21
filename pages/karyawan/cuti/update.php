
<?php
include 'function/karyawan/cuti.php';

$id_cuti = $_GET['id'] ?? 0;
$detail_result = getDetailCuti($id_cuti, $_SESSION['user_id']);
$cuti = mysqli_fetch_assoc($detail_result);

if (!$cuti || $cuti['status'] != 'Pending') {
    echo '<div class="alert alert-warning">Cuti tidak ditemukan atau tidak dapat diedit!</div>';
    exit;
}

if (isset($_POST['update_cuti'])) {
    $result = updateCuti(
        $id_cuti,
        $_SESSION['user_id'],
        $_POST['id_jenis_cuti'],
        $_POST['tanggal_mulai'],
        $_POST['tanggal_selesai'],
        $_POST['alasan'],
        $_POST['alamat_cuti']
    );
    
    if ($result) {
        $success_message = "Pengajuan cuti berhasil diupdate!";
        // Refresh data
        $detail_result = getDetailCuti($id_cuti, $_SESSION['user_id']);
        $cuti = mysqli_fetch_assoc($detail_result);
    } else {
        $error_message = "Gagal mengupdate cuti. Silakan coba lagi.";
    }
}

$jenis_cuti = getJenisCutiAktif();
?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Edit Pengajuan Cuti</h1>
        <p class="text-muted">Ubah detail pengajuan cuti Anda</p>
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
                <h5 class="mb-0">Form Edit Cuti</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Jenis Cuti <span class="text-danger">*</span></label>
                        <select name="id_jenis_cuti" class="form-select" required>
                            <option value="">Pilih Jenis Cuti</option>
                            <?php while ($jc = mysqli_fetch_assoc($jenis_cuti)): ?>
                            <option value="<?php echo $jc['id']; ?>" <?php echo ($cuti['id_jenis_cuti'] == $jc['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($jc['nama_cuti']); ?> 
                                (Max: <?php echo $jc['max_hari']; ?> hari)
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_mulai" class="form-control" required 
                                       value="<?php echo $cuti['tanggal_mulai']; ?>"
                                       min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_selesai" class="form-control" required 
                                       value="<?php echo $cuti['tanggal_selesai']; ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alasan Cuti <span class="text-danger">*</span></label>
                        <textarea name="alasan" class="form-control" rows="4" required><?php echo htmlspecialchars($cuti['alasan']); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Selama Cuti</label>
                        <textarea name="alamat_cuti" class="form-control" rows="3"><?php echo htmlspecialchars($cuti['alamat_cuti']); ?></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="update_cuti" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="dashboard.php?route=cutiview" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Detail Pengajuan</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="small text-muted">ID Cuti:</label>
                    <div><strong><?php echo $cuti['id']; ?></strong></div>
                </div>
                
                <div class="mb-3">
                    <label class="small text-muted">Status:</label>
                    <div><span class="badge bg-warning"><?php echo $cuti['status']; ?></span></div>
                </div>
                
                <div class="mb-3">
                    <label class="small text-muted">Tanggal Pengajuan:</label>
                    <div><?php echo date('d/m/Y H:i', strtotime($cuti['tanggal_pengajuan'])); ?></div>
                </div>
                
                <div class="mb-3">
                    <label class="small text-muted">Jumlah Hari Saat Ini:</label>
                    <div><strong><?php echo $cuti['jumlah_hari']; ?> hari</strong></div>
                </div>

                <div class="alert alert-info">
                    <small><i class="fas fa-info-circle"></i> Hanya cuti dengan status Pending yang dapat diedit</small>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tanggalMulai = document.querySelector('input[name="tanggal_mulai"]');
    const tanggalSelesai = document.querySelector('input[name="tanggal_selesai"]');
    
    tanggalMulai.addEventListener('change', function() {
        tanggalSelesai.min = this.value;
        if (tanggalSelesai.value < this.value) {
            tanggalSelesai.value = this.value;
        }
    });
});
</script>
