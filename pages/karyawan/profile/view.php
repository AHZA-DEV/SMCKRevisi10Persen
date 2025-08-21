<?php
include 'function/karyawan/profile.php';

$id_karyawan = $_SESSION['user_id'];
$profile = getProfileKaryawan($id_karyawan);
$statistik = getStatistikKaryawan($id_karyawan);
$aktivitas = getRiwayatAktivitas($id_karyawan, 5);

// Handle messages
$message = '';
$message_type = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];
    unset($_SESSION['message'], $_SESSION['message_type']);
}
?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Profile Saya</h1>
        <p class="text-muted">Kelola informasi personal Anda</p>
    </div>
</div>

<!-- Messages -->
<?php if ($message): ?>
<div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show" role="alert">
    <?php echo $message; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<div class="row">
    <!-- Profile Info -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="position-relative d-inline-block mb-3">
                    <img src="<?php echo $profile['foto_profil'] ?: 'https://via.placeholder.com/150'; ?>"
                         alt="Profile Picture" class="rounded-circle" width="150" height="150">
                    <button class="btn btn-primary btn-sm position-absolute bottom-0 end-0 rounded-circle"
                            data-bs-toggle="modal" data-bs-target="#photoModal" style="width: 35px; height: 35px;">
                        <i class="fas fa-camera"></i>
                    </button>
                </div>
                <h5 class="card-title"><?php echo $profile['nama_depan'] . ' ' . $profile['nama_belakang']; ?></h5>
                <p class="text-muted"><?php echo $profile['nama_departemen'] ?: 'Belum ada departemen'; ?></p>
                <p class="text-muted small">
                    <i class="fas fa-calendar"></i>
                    Bergabung: <?php echo isset($profile['tanggal_mulai_kerja']) ? date('d F Y', strtotime($profile['tanggal_mulai_kerja'])) : 'N/A'; ?>
                </p>
            </div>
        </div>

        <!-- Statistics -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Statistik Cuti</h6>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <h4 class="text-success"><?php echo $statistik['cuti_digunakan']; ?></h4>
                        <small class="text-muted">Digunakan</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-warning"><?php echo $statistik['sisa_cuti']; ?></h4>
                        <small class="text-muted">Sisa</small>
                    </div>
                    <div class="col-4">
                        <h4 class="text-info"><?php echo $statistik['total_pengajuan']; ?></h4>
                        <small class="text-muted">Total</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Form -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Personal</h5>
            </div>
            <div class="card-body">
                <form id="profileForm" action="dashboard.php?route=editprofile" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_depan" class="form-label">Nama Depan</label>
                            <input type="text" class="form-control" id="nama_depan" name="nama_depan"
                                   value="<?php echo htmlspecialchars($profile['nama_depan']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_belakang" class="form-label">Nama Belakang</label>
                            <input type="text" class="form-control" id="nama_belakang" name="nama_belakang"
                                   value="<?php echo htmlspecialchars($profile['nama_belakang']); ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="<?php echo htmlspecialchars($profile['email']); ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="no_telepon" class="form-label">No. Telepon</label>
                            <input type="tel" class="form-control" id="no_telepon" name="no_telepon"
                                   value="<?php echo htmlspecialchars($profile['no_telepon']); ?>">
                        </div>
                    </div>

                    <!-- <div class="mb-3">
                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                               value="">
                    </div> -->

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"><?php echo htmlspecialchars($profile['alamat']); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#passwordModal">
                            <i class="fas fa-key"></i> Ubah Password
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Aktivitas Terakhir</h6>
            </div>
            <div class="card-body">
                <?php if (mysqli_num_rows($aktivitas) > 0): ?>
                    <div class="list-group list-group-flush">
                        <?php while ($activity = mysqli_fetch_assoc($aktivitas)): ?>
                        <div class="list-group-item border-0 px-0">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <p class="mb-1"><?php echo $activity['aktivitas']; ?></p>
                                    <small class="text-muted"><?php echo date('d/m/Y H:i', strtotime($activity['tanggal'])); ?></small>
                                </div>
                                <span class="badge bg-<?php
                                    echo $activity['status'] == 'Disetujui' ? 'success' :
                                        ($activity['status'] == 'Pending' ? 'warning' : 'danger');
                                ?>">
                                    <?php echo $activity['status']; ?>
                                </span>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted mb-0">Belum ada aktivitas</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Photo Upload Modal -->
<div class="modal fade" id="photoModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="dashboard.php?route=editprofile" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="foto_profil" class="form-label">Pilih Foto</label>
                        <input type="file" class="form-control" id="foto_profil" name="foto_profil"
                               accept="image/*" required>
                        <small class="text-muted">Maksimal 2MB, format: JPG, PNG</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="upload_foto" class="btn btn-primary">Upload</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="dashboard.php?route=editprofile" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="password_lama" class="form-label">Password Lama</label>
                        <input type="password" class="form-control" id="password_lama" name="password_lama" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_baru" class="form-label">Password Baru</label>
                        <input type="password" class="form-control" id="password_baru" name="password_baru"
                               minlength="6" required>
                    </div>
                    <div class="mb-3">
                        <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" id="konfirmasi_password"
                               name="konfirmasi_password" minlength="6" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" name="ubah_password" class="btn btn-primary">Ubah Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Validate password confirmation
document.getElementById('konfirmasi_password').addEventListener('input', function() {
    const password = document.getElementById('password_baru').value;
    const confirmation = this.value;

    if (password !== confirmation) {
        this.setCustomValidity('Password tidak sama');
    } else {
        this.setCustomValidity('');
    }
});
</script>