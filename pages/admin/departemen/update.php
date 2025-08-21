
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Edit Departemen</h1>
        <p class="text-muted">Edit data departemen</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Form Edit Departemen</h5>
            </div>
            <div class="card-body">
                <?php
                include 'function/admin/departemen.php';
                
                if (isset($_POST['submit'])) {
                    $result = updateDepartemen($_GET['id'], $_POST);
                    if ($result) {
                        echo '<div class="alert alert-success">Departemen berhasil diupdate!</div>';
                        echo '<script>setTimeout(function(){ window.location.href = "dashboard.php?route=departemen"; }, 1500);</script>';
                    } else {
                        echo '<div class="alert alert-danger">Gagal mengupdate departemen!</div>';
                    }
                }
                
                $departemen = getDepartemenById($_GET['id']);
                if ($departemen):
                ?>
                
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="kode_departemen" class="form-label">Kode Departemen</label>
                        <input type="text" class="form-control" id="kode_departemen" name="kode_departemen" 
                               value="<?= $departemen['kode_departemen'] ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nama_departemen" class="form-label">Nama Departemen</label>
                        <input type="text" class="form-control" id="nama_departemen" name="nama_departemen" 
                               value="<?= $departemen['nama_departemen'] ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"><?= $departemen['deskripsi'] ?></textarea>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" name="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="dashboard.php?route=departemen" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
                
                <?php else: ?>
                <div class="alert alert-danger">Departemen tidak ditemukan!</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
