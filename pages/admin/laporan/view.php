
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Laporan Sistem</h1>
        <p class="text-muted">Generate dan kelola laporan sistem</p>
    </div>
</div>

<!-- Filter Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Filter Laporan</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="dashboard.php">
                    <input type="hidden" name="route" value="laporan">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Jenis Laporan</label>
                            <select name="jenis_laporan" class="form-select" required>
                                <option value="">Pilih Jenis Laporan</option>
                                <option value="cuti" <?php echo (isset($_GET['jenis_laporan']) && $_GET['jenis_laporan'] == 'cuti') ? 'selected' : ''; ?>>Laporan Cuti</option>
                                <option value="karyawan" <?php echo (isset($_GET['jenis_laporan']) && $_GET['jenis_laporan'] == 'karyawan') ? 'selected' : ''; ?>>Laporan Karyawan</option>
                                <option value="departemen" <?php echo (isset($_GET['jenis_laporan']) && $_GET['jenis_laporan'] == 'departemen') ? 'selected' : ''; ?>>Laporan Departemen</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control" value="<?php echo $_GET['tanggal_mulai'] ?? ''; ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control" value="<?php echo $_GET['tanggal_selesai'] ?? ''; ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="menunggu" <?php echo (isset($_GET['status']) && $_GET['status'] == 'menunggu') ? 'selected' : ''; ?>>Menunggu</option>
                                <option value="disetujui" <?php echo (isset($_GET['status']) && $_GET['status'] == 'disetujui') ? 'selected' : ''; ?>>Disetujui</option>
                                <option value="ditolak" <?php echo (isset($_GET['status']) && $_GET['status'] == 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Filter
                                </button>
                                <a href="dashboard.php?route=laporan" class="btn btn-secondary">
                                    <i class="fas fa-refresh"></i> Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Quick Reports -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-calendar-alt fa-3x text-primary"></i>
                </div>
                <h5>Laporan Cuti</h5>
                <p class="text-muted">Generate laporan pengajuan cuti karyawan</p>
                <a href="dashboard.php?route=cetaklaporan&jenis=cuti" class="btn btn-primary btn-sm">
                    <i class="fas fa-print"></i> Cetak
                </a>
                <a href="dashboard.php?route=eksporlaporan&jenis=cuti" class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i> Ekspor
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-users fa-3x text-success"></i>
                </div>
                <h5>Laporan Karyawan</h5>
                <p class="text-muted">Generate laporan data karyawan</p>
                <a href="dashboard.php?route=cetaklaporan&jenis=karyawan" class="btn btn-primary btn-sm">
                    <i class="fas fa-print"></i> Cetak
                </a>
                <a href="dashboard.php?route=eksporlaporan&jenis=karyawan" class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i> Ekspor
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-building fa-3x text-warning"></i>
                </div>
                <h5>Laporan Departemen</h5>
                <p class="text-muted">Generate laporan data departemen</p>
                <a href="dashboard.php?route=cetaklaporan&jenis=departemen" class="btn btn-primary btn-sm">
                    <i class="fas fa-print"></i> Cetak
                </a>
                <a href="dashboard.php?route=eksporlaporan&jenis=departemen" class="btn btn-success btn-sm">
                    <i class="fas fa-download"></i> Ekspor
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="fas fa-chart-bar fa-3x text-info"></i>
                </div>
                <h5>Statistik</h5>
                <p class="text-muted">Lihat statistik dan analisis data</p>
                <button class="btn btn-info btn-sm" onclick="showStatistics()">
                    <i class="fas fa-chart-line"></i> Lihat
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Results Section -->
<?php if (isset($_GET['jenis_laporan']) && !empty($_GET['jenis_laporan'])): ?>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Hasil Laporan: <?php echo ucfirst($_GET['jenis_laporan']); ?></h5>
                <div>
                    <a href="dashboard.php?route=cetaklaporan&<?php echo http_build_query($_GET); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-print"></i> Cetak PDF
                    </a>
                    <a href="dashboard.php?route=eksporlaporan&<?php echo http_build_query($_GET); ?>" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Ekspor Excel
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php
                include 'function/admin/laporan.php';
                
                if ($_GET['jenis_laporan'] == 'cuti') {
                    $result = getLaporanCuti($_GET);
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama Karyawan</th>
                                    <th>Departemen</th>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal</th>
                                    <th>Jumlah Hari</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)): 
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nip']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_departemen'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_cuti']); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($row['tanggal_mulai'])) . ' - ' . date('d/m/Y', strtotime($row['tanggal_selesai'])); ?></td>
                                    <td><?php echo $row['jumlah_hari']; ?> hari</td>
                                    <td>
                                        <?php
                                        $status_class = '';
                                        switch($row['status']) {
                                            case 'menunggu': $status_class = 'warning'; break;
                                            case 'disetujui': $status_class = 'success'; break;
                                            case 'ditolak': $status_class = 'danger'; break;
                                        }
                                        ?>
                                        <span class="badge bg-<?php echo $status_class; ?>"><?php echo ucfirst($row['status']); ?></span>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                } elseif ($_GET['jenis_laporan'] == 'karyawan') {
                    $result = getLaporanKaryawan($_GET);
                    ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Departemen</th>
                                    <th>Jabatan</th>
                                    <th>Total Cuti</th>
                                    <th>Total Hari Cuti</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($result)): 
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nip']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']); ?></td>
                                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_departemen'] ?? '-'); ?></td>
                                    <td><?php echo htmlspecialchars($row['jabatan']); ?></td>
                                    <td><?php echo $row['total_cuti']; ?></td>
                                    <td><?php echo $row['total_hari_cuti']; ?> hari</td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<script>
function showStatistics() {
    // Implementasi untuk menampilkan modal statistik
    alert('Fitur statistik akan ditampilkan di sini dengan chart dan analisis data');
}
</script>
