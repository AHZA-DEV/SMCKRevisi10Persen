
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Tambah Karyawan</h1>
        <p class="text-muted">Tambah karyawan baru</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Form Tambah Karyawan</h5>
            </div>
            <div class="card-body">
                <?php
                if (isset($_POST['submit'])) {
                    include 'function/admin/karyawan.php';
                    $result = createKaryawan($_POST);
                    if ($result) {
                        echo '<div class="alert alert-success">Karyawan berhasil ditambahkan!</div>';
                        echo '<script>setTimeout(function(){ window.location.href = "dashboard.php?route=karyawan"; }, 1500);</script>';
                    } else {
                        echo '<div class="alert alert-danger">Gagal menambahkan karyawan!</div>';
                    }
                }
                
                include 'function/admin/departemen.php';
                $departemen = getAllDepartemen();
                ?>
                
                <form method="POST" action="">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_depan" class="form-label">Nama Depan</label>
                                <input type="text" class="form-control" id="nama_depan" name="nama_depan" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nama_belakang" class="form-label">Nama Belakang</label>
                                <input type="text" class="form-control" id="nama_belakang" name="nama_belakang" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_departemen" class="form-label">Departemen</label>
                                <select class="form-control" id="id_departemen" name="id_departemen">
                                    <option value="">Pilih Departemen</option>
                                    <?php while ($dept = mysqli_fetch_assoc($departemen)): ?>
                                    <option value="<?= $dept['id'] ?>"><?= $dept['nama_departemen'] ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="tanggal_mulai_kerja" class="form-label">Tanggal Mulai Kerja</label>
                                <input type="date" class="form-control" id="tanggal_mulai_kerja" name="tanggal_mulai_kerja">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="no_telepon" class="form-label">No Telepon</label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="peran" class="form-label">Peran</label>
                                <select class="form-control" id="peran" name="peran" required>
                                    <option value="karyawan">Karyawan</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="dashboard.php?route=karyawan" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
