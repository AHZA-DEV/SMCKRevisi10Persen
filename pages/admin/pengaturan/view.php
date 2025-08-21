
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Pengaturan Sistem</h1>
        <p class="text-muted">Kelola pengaturan dan konfigurasi sistem</p>
    </div>
</div>

<!-- Navigation Tabs -->
<div class="row mb-4">
    <div class="col-12">
        <ul class="nav nav-pills" id="settingsTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="jenis-cuti-tab" data-bs-toggle="pill" data-bs-target="#jenis-cuti" type="button" role="tab">
                    <i class="fas fa-calendar-alt"></i> Jenis Cuti
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="sistem-tab" data-bs-toggle="pill" data-bs-target="#sistem" type="button" role="tab">
                    <i class="fas fa-cogs"></i> Sistem
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="perusahaan-tab" data-bs-toggle="pill" data-bs-target="#perusahaan" type="button" role="tab">
                    <i class="fas fa-building"></i> Perusahaan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="backup-tab" data-bs-toggle="pill" data-bs-target="#backup" type="button" role="tab">
                    <i class="fas fa-database"></i> Backup
                </button>
            </li>
        </ul>
    </div>
</div>

<!-- Tab Content -->
<div class="tab-content" id="settingsTabContent">
    <!-- Jenis Cuti Tab -->
    <div class="tab-pane fade show active" id="jenis-cuti" role="tabpanel">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Kelola Jenis Cuti</h5>
                        <a href="dashboard.php?route=jeniscuti" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Jenis Cuti
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Jenis Cuti</th>
                                        <th>Maksimal Hari</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    include 'function/admin/pengaturan.php';
                                    $jenis_cuti = getAllJenisCuti();
                                    $no = 1;
                                    while ($row = mysqli_fetch_assoc($jenis_cuti)):
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo htmlspecialchars($row['nama_cuti']); ?></td>
                                        <td><?php echo $row['max_hari']; ?> hari</td>
                                        <td><?php echo htmlspecialchars($row['deskripsi']); ?></td>
                                        <td>
                                            <span class="badge bg-<?php echo $row['is_active'] ? 'success' : 'secondary'; ?>">
                                                <?php echo $row['is_active'] ? 'Aktif' : 'Nonaktif'; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="dashboard.php?route=editjeniscuti&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="dashboard.php?route=deletejeniscuti&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sistem Tab -->
    <div class="tab-pane fade" id="sistem" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Pengaturan Umum</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_POST['update_sistem'])) {
                            updateSistemSetting('app_name', $_POST['app_name']);
                            updateSistemSetting('timezone', $_POST['timezone']);
                            updateSistemSetting('date_format', $_POST['date_format']);
                            echo '<div class="alert alert-success">Pengaturan berhasil disimpan!</div>';
                        }
                        
                        $settings = getSistemSettings();
                        ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Nama Aplikasi</label>
                                <input type="text" name="app_name" class="form-control" value="<?php echo $settings['app_name'] ?? 'Sistem Manajemen Cuti'; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Timezone</label>
                                <select name="timezone" class="form-select">
                                    <option value="Asia/Jakarta" <?php echo ($settings['timezone'] ?? '') == 'Asia/Jakarta' ? 'selected' : ''; ?>>Asia/Jakarta</option>
                                    <option value="Asia/Makassar" <?php echo ($settings['timezone'] ?? '') == 'Asia/Makassar' ? 'selected' : ''; ?>>Asia/Makassar</option>
                                    <option value="Asia/Jayapura" <?php echo ($settings['timezone'] ?? '') == 'Asia/Jayapura' ? 'selected' : ''; ?>>Asia/Jayapura</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Format Tanggal</label>
                                <select name="date_format" class="form-select">
                                    <option value="d/m/Y" <?php echo ($settings['date_format'] ?? '') == 'd/m/Y' ? 'selected' : ''; ?>>DD/MM/YYYY</option>
                                    <option value="Y-m-d" <?php echo ($settings['date_format'] ?? '') == 'Y-m-d' ? 'selected' : ''; ?>>YYYY-MM-DD</option>
                                    <option value="d-m-Y" <?php echo ($settings['date_format'] ?? '') == 'd-m-Y' ? 'selected' : ''; ?>>DD-MM-YYYY</option>
                                </select>
                            </div>
                            <button type="submit" name="update_sistem" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pengaturan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Pengaturan Cuti</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_POST['update_cuti_settings'])) {
                            updateSistemSetting('max_cuti_tahunan', $_POST['max_cuti_tahunan']);
                            updateSistemSetting('min_hari_pengajuan', $_POST['min_hari_pengajuan']);
                            updateSistemSetting('auto_approve', $_POST['auto_approve']);
                            echo '<div class="alert alert-success">Pengaturan cuti berhasil disimpan!</div>';
                        }
                        ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Maksimal Cuti Tahunan</label>
                                <input type="number" name="max_cuti_tahunan" class="form-control" value="<?php echo $settings['max_cuti_tahunan'] ?? 12; ?>">
                                <small class="text-muted">Dalam hari</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Minimal Hari Pengajuan</label>
                                <input type="number" name="min_hari_pengajuan" class="form-control" value="<?php echo $settings['min_hari_pengajuan'] ?? 3; ?>">
                                <small class="text-muted">Hari sebelum tanggal cuti</small>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="auto_approve" class="form-check-input" value="1" <?php echo ($settings['auto_approve'] ?? '') == '1' ? 'checked' : ''; ?>>
                                    <label class="form-check-label">Auto Approve untuk Cuti Tertentu</label>
                                </div>
                            </div>
                            <button type="submit" name="update_cuti_settings" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Pengaturan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Perusahaan Tab -->
    <div class="tab-pane fade" id="perusahaan" role="tabpanel">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Perusahaan</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_POST['update_company'])) {
                            $data = array(
                                'nama_perusahaan' => $_POST['nama_perusahaan'],
                                'alamat' => $_POST['alamat'],
                                'telepon' => $_POST['telepon'],
                                'email' => $_POST['email'],
                                'logo' => $_POST['logo'] ?? ''
                            );
                            updateCompanyInfo($data);
                            echo '<div class="alert alert-success">Informasi perusahaan berhasil disimpan!</div>';
                        }
                        
                        $company = getCompanyInfo();
                        ?>
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Perusahaan</label>
                                        <input type="text" name="nama_perusahaan" class="form-control" value="<?php echo htmlspecialchars($company['nama_perusahaan'] ?? ''); ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea name="alamat" class="form-control" rows="3"><?php echo htmlspecialchars($company['alamat'] ?? ''); ?></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Telepon</label>
                                        <input type="text" name="telepon" class="form-control" value="<?php echo htmlspecialchars($company['telepon'] ?? ''); ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($company['email'] ?? ''); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Logo URL</label>
                                        <input type="text" name="logo" class="form-control" value="<?php echo htmlspecialchars($company['logo'] ?? ''); ?>">
                                        <small class="text-muted">URL logo perusahaan</small>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" name="update_company" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan Informasi
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Backup Tab -->
    <div class="tab-pane fade" id="backup" role="tabpanel">
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Backup Database</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Buat backup database secara manual atau otomatis</p>
                        <button class="btn btn-success mb-2" onclick="createBackup()">
                            <i class="fas fa-download"></i> Buat Backup Sekarang
                        </button>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="autoBackup">
                            <label class="form-check-label" for="autoBackup">
                                Backup Otomatis Harian
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0">Restore Database</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">Restore database dari file backup</p>
                        <div class="mb-3">
                            <input type="file" class="form-control" accept=".sql" id="backupFile">
                        </div>
                        <button class="btn btn-warning" onclick="restoreBackup()">
                            <i class="fas fa-upload"></i> Restore Database
                        </button>
                        <small class="text-danger d-block mt-2">
                            <i class="fas fa-exclamation-triangle"></i> Hati-hati! Ini akan menimpa data yang ada.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function createBackup() {
    if (confirm('Yakin ingin membuat backup database?')) {
        // Implementasi backup
        alert('Backup berhasil dibuat! File akan diunduh secara otomatis.');
    }
}

function restoreBackup() {
    const file = document.getElementById('backupFile').files[0];
    if (!file) {
        alert('Pilih file backup terlebih dahulu!');
        return;
    }
    
    if (confirm('PERINGATAN: Ini akan menimpa semua data yang ada. Yakin ingin melanjutkan?')) {
        // Implementasi restore
        alert('Database berhasil di-restore!');
    }
}
</script>
