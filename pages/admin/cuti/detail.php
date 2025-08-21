
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Detail Pengajuan Cuti</h1>
        <p class="text-muted">Detail informasi pengajuan cuti karyawan</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0">Informasi Pengajuan Cuti</h5>
            </div>
            <div class="card-body">
                <?php
                include 'function/admin/cuti.php';
                
                if (isset($_GET['id'])) {
                    $cuti = getCutiById($_GET['id']);
                    if ($cuti):
                ?>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>ID Pengajuan:</strong>
                        <p><?= $cuti['id'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p>
                            <span class="badge 
                                <?= $cuti['status'] == 'disetujui' ? 'bg-success' : 
                                   ($cuti['status'] == 'ditolak' ? 'bg-danger' : 'bg-warning') ?>">
                                <?= ucfirst($cuti['status']) ?>
                            </span>
                        </p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Nama Karyawan:</strong>
                        <p><?= $cuti['nama_depan'] . ' ' . $cuti['nama_belakang'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>NIP:</strong>
                        <p><?= $cuti['nip'] ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Departemen:</strong>
                        <p><?= $cuti['nama_departemen'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Jabatan:</strong>
                        <p><?= $cuti['jabatan'] ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Jenis Cuti:</strong>
                        <p><?= $cuti['nama_cuti'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Jumlah Hari:</strong>
                        <p><?= $cuti['jumlah_hari'] ?> hari</p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Tanggal Mulai:</strong>
                        <p><?= date('d/m/Y', strtotime($cuti['tanggal_mulai'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Selesai:</strong>
                        <p><?= date('d/m/Y', strtotime($cuti['tanggal_selesai'])) ?></p>
                    </div>
                </div>
                
                <div class="mb-3">
                    <strong>Alasan Cuti:</strong>
                    <p><?= $cuti['alasan'] ?></p>
                </div>
                
                <?php if ($cuti['status'] == 'disetujui'): ?>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Disetujui Oleh:</strong>
                        <p><?= $cuti['nama_penyetuju'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Tanggal Persetujuan:</strong>
                        <p><?= date('d/m/Y H:i', strtotime($cuti['disetujui_pada'])) ?></p>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($cuti['status'] == 'ditolak' && $cuti['alasan_penolakan']): ?>
                <div class="mb-3">
                    <strong>Alasan Penolakan:</strong>
                    <div class="alert alert-danger"><?= $cuti['alasan_penolakan'] ?></div>
                </div>
                <?php endif; ?>
                
                <?php if ($cuti['status'] == 'menunggu'): ?>
                <div class="d-flex gap-2 mt-4">
                    <a href="dashboard.php?route=setujuicuti&id=<?= $cuti['id'] ?>" class="btn btn-success">
                        <i class="fas fa-check"></i> Setujui
                    </a>
                    <a href="dashboard.php?route=tolakcuti&id=<?= $cuti['id'] ?>" class="btn btn-danger">
                        <i class="fas fa-times"></i> Tolak
                    </a>
                </div>
                <?php endif; ?>
                
                <div class="mt-4">
                    <a href="dashboard.php?route=cuti" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
                
                <?php else: ?>
                <div class="alert alert-danger">Data cuti tidak ditemukan!</div>
                <?php 
                    endif; 
                } else {
                    echo '<div class="alert alert-danger">ID cuti tidak ditemukan!</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>
