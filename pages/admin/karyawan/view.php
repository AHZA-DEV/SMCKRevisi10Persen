<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Data Karyawan</h1>
        <p class="text-muted">Selamat datang, Admin!</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Karyawan</h5>
                <a href="dashboard.php?route=addkaryawan" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Karyawan
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>NIP</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>Departemen</th>
                                <th>Jabatan</th>
                                <th>Peran</th>
                                <th>Sisa Cuti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'function/admin/karyawan.php';
                            $karyawan = getAllKaryawan();
                            if ($karyawan && mysqli_num_rows($karyawan) > 0):
                                while ($row = mysqli_fetch_assoc($karyawan)):
                            ?>
                                    <tr>
                                        <td><span class="badge bg-primary"><?= $row['nip'] ?></span></td>
                                        <td><?= $row['nama_depan'] . ' ' . $row['nama_belakang'] ?></td>
                                        <td><?= $row['email'] ?></td>
                                        <td><?= $row['nama_departemen'] ?? 'Tidak Ada' ?></td>
                                        <td><?= $row['jabatan'] ?></td>
                                        <td>
                                            <span class="badge <?= $row['peran'] == 'admin' ? 'bg-success' : 'bg-info' ?>">
                                                <?= ucfirst($row['peran']) ?>
                                            </span>
                                        </td>
                                        <td><?= $row['sisa_cuti'] ?> hari</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="dashboard.php?route=editkaryawan&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="dashboard.php?route=deletekaryawan&id=<?= $row['id'] ?>"
                                                    class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Yakin ingin menghapus karyawan ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                endwhile;
                            else:
                                ?>
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data karyawan</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>