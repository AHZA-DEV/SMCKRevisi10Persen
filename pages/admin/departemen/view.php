
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Data Departemen</h1>
        <p class="text-muted">Selamat datang, Admin!</p>
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Departemen</h5>
                <a href="dashboard.php?route=adddepartemen" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Departemen
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Kode Departemen</th>
                                <th>Nama Departemen</th>
                                <th>Deskripsi</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include 'function/admin/departemen.php';
                            $departemen = getAllDepartemen();
                            if ($departemen && mysqli_num_rows($departemen) > 0):
                                while ($row = mysqli_fetch_assoc($departemen)):
                            ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><span class="badge bg-secondary"><?= $row['kode_departemen'] ?></span></td>
                                <td><?= $row['nama_departemen'] ?></td>
                                <td><?= substr($row['deskripsi'], 0, 50) ?>...</td>
                                <td><?= date('d/m/Y', strtotime($row['created_at'])) ?></td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="dashboard.php?route=editdepartemen&id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="dashboard.php?route=deletedepartemen&id=<?= $row['id'] ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin ingin menghapus departemen ini?')">
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
                                <td colspan="6" class="text-center">Tidak ada data departemen</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
