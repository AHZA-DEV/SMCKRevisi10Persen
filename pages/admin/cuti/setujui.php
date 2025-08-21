
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Setujui Pengajuan Cuti</h1>
        <p class="text-muted">Konfirmasi persetujuan pengajuan cuti</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Form Persetujuan Cuti</h5>
            </div>
            <div class="card-body">
                <?php
                include 'function/admin/cuti.php';
                
                if (isset($_POST['submit'])) {
                    session_start();
                    $admin_id = $_SESSION['id']; // Assuming admin ID is stored in session
                    $result = setujuiCuti($_GET['id'], $admin_id);
                    if ($result) {
                        echo '<div class="alert alert-success">Pengajuan cuti berhasil disetujui!</div>';
                        echo '<script>setTimeout(function(){ window.location.href = "dashboard.php?route=cuti"; }, 1500);</script>';
                    } else {
                        echo '<div class="alert alert-danger">Gagal menyetujui pengajuan cuti!</div>';
                    }
                }
                
                if (isset($_GET['id'])) {
                    $cuti = getCutiById($_GET['id']);
                    if ($cuti && $cuti['status'] == 'menunggu'):
                ?>
                
                <div class="alert alert-info">
                    <strong>Konfirmasi Persetujuan</strong><br>
                    Anda akan menyetujui pengajuan cuti untuk:
                    <ul class="mt-2 mb-0">
                        <li>Karyawan: <?= $cuti['nama_depan'] . ' ' . $cuti['nama_belakang'] ?></li>
                        <li>Jenis Cuti: <?= $cuti['nama_cuti'] ?></li>
                        <li>Periode: <?= date('d/m/Y', strtotime($cuti['tanggal_mulai'])) ?> - <?= date('d/m/Y', strtotime($cuti['tanggal_selesai'])) ?></li>
                        <li>Jumlah Hari: <?= $cuti['jumlah_hari'] ?> hari</li>
                    </ul>
                </div>
                
                <form method="POST" action="">
                    <div class="d-flex gap-2">
                        <button type="submit" name="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Ya, Setujui
                        </button>
                        <a href="dashboard.php?route=detailcuti&id=<?= $cuti['id'] ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
                
                <?php 
                    elseif ($cuti):
                        echo '<div class="alert alert-warning">Pengajuan cuti ini sudah diproses sebelumnya!</div>';
                    else:
                        echo '<div class="alert alert-danger">Data cuti tidak ditemukan!</div>';
                    endif;
                } else {
                    echo '<div class="alert alert-danger">ID cuti tidak ditemukan!</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
