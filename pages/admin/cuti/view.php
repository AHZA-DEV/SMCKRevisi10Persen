    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 text-dark mb-0">Data Manajemen Cuti</h1>
            <p class="text-muted">Selamat datang, Admin!</p>
        </div>
    </div>

<div class="row mb-4">
    <div class="card-body ">
        <div class="table-responsive">
            <table class="table table-responsive">
                <thead class="">
                    <tr>
                        <th>ID</th>
                        <th>Nama Karyawan</th>
                        <th>Jenis Cuti</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>Cuti Tahunan</td>
                        <td>2023-10-01</td>
                        <td>2023-10-05</td>
                        <td>Disetujui</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Jane Smith</td>
                        <td>Cuti Sakit</td>
                        <td>2023-10-02</td>
                        <td>2023-10-04</td>
                        <td>Ditolak</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Pengajuan Cuti</h5>
                <div>
                    <?php
                    include 'function/admin/cuti.php';
                    $stats = getCutiStatistics();
                    ?>
                    <span class="badge bg-warning me-2">Menunggu: <?php echo $stats['menunggu']; ?></span>
                    <span class="badge bg-success me-2">Disetujui: <?php echo $stats['disetujui']; ?></span>
                    <span class="badge bg-danger">Ditolak: <?php echo $stats['ditolak']; ?></span>
                </div>
            </div>
            <div class="card-body">
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = getAllCuti();
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $status_class = '';
                                switch($row['status']) {
                                    case 'menunggu': $status_class = 'warning'; break;
                                    case 'disetujui': $status_class = 'success'; break;
                                    case 'ditolak': $status_class = 'danger'; break;
                                }
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($row['nip']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_depan'] . ' ' . $row['nama_belakang']); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_departemen'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($row['nama_cuti']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['tanggal_mulai'])) . ' - ' . date('d/m/Y', strtotime($row['tanggal_selesai'])); ?></td>
                                <td><?php echo $row['jumlah_hari']; ?> hari</td>
                                <td><span class="badge bg-<?php echo $status_class; ?>"><?php echo ucfirst($row['status']); ?></span></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="dashboard.php?route=detailcuti&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info me-1">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        <?php if ($row['status'] == 'menunggu'): ?>
                                        <a href="dashboard.php?route=setujuicuti&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-success me-1">
                                            <i class="fas fa-check"></i> Setujui
                                        </a>
                                        <a href="dashboard.php?route=tolakcuti&id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger">
                                            <i class="fas fa-times"></i> Tolak
                                        </a>
                                        <?php endif; ?>
                                    </div>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
