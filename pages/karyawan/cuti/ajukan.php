
<?php
include 'function/karyawan/cuti.php';

if (isset($_POST['ajukan_cuti'])) {
    $result = ajukanCuti(
        $_SESSION['user_id'],
        $_POST['id_jenis_cuti'],
        $_POST['tanggal_mulai'],
        $_POST['tanggal_selesai'],
        $_POST['alasan'],
        $_POST['alamat_cuti']
    );
    
    if ($result) {
        $success_message = "Pengajuan cuti berhasil disubmit!";
    } else {
        $error_message = "Gagal mengajukan cuti. Silakan coba lagi.";
    }
}

$jenis_cuti = getJenisCutiAktif();
$sisa_cuti = getSisaCuti($_SESSION['user_id']);
?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Ajukan Cuti Baru</h1>
        <p class="text-muted">Isi form di bawah untuk mengajukan cuti</p>
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
                <h5 class="mb-0">Form Pengajuan Cuti</h5>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label">Jenis Cuti <span class="text-danger">*</span></label>
                        <select name="id_jenis_cuti" class="form-select" required>
                            <option value="">Pilih Jenis Cuti</option>
                            <?php while ($jc = mysqli_fetch_assoc($jenis_cuti)): ?>
                            <option value="<?php echo $jc['id']; ?>">
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
                                <input type="date" name="tanggal_mulai" class="form-control" required min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_selesai" class="form-control" required>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alasan Cuti <span class="text-danger">*</span></label>
                        <textarea name="alasan" class="form-control" rows="4" placeholder="Jelaskan alasan mengajukan cuti..." required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Alamat Selama Cuti</label>
                        <textarea name="alamat_cuti" class="form-control" rows="3" placeholder="Alamat yang dapat dihubungi selama cuti (opsional)"></textarea>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="ajukan_cuti" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> Ajukan Cuti
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
                <h5 class="mb-0">Informasi Cuti</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <span>Sisa Cuti Tahun Ini:</span>
                        <strong class="text-primary"><?php echo $sisa_cuti; ?> hari</strong>
                    </div>
                </div>
                
                <hr>
                
                <div class="mb-3">
                    <h6>Tips Pengajuan Cuti:</h6>
                    <ul class="small text-muted">
                        <li>Ajukan cuti minimal 3 hari sebelum tanggal cuti</li>
                        <li>Pastikan alasan cuti jelas dan lengkap</li>
                        <li>Cek ketersediaan tim sebelum mengajukan</li>
                        <li>Sertakan alamat yang dapat dihubungi</li>
                    </ul>
                </div>

                <div class="alert alert-info">
                    <small><i class="fas fa-info-circle"></i> Pengajuan cuti akan diproses dalam 1-3 hari kerja</small>
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
