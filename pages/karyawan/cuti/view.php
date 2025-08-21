<?php
include 'function/karyawan/cuti.php';
$cuti_list = getCutiKaryawan($_SESSION['user_id']);
?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Manajemen Cuti</h1>
        <p class="text-muted">Kelola pengajuan cuti Anda</p>
    </div>
</div>

<!-- Quick Stats -->
<div class="row mb-3">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="metric-card">
            <div class="metric-icon revenue">
                <i class="fas fa-calendar-check"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-value"><?php echo getSisaCuti($_SESSION['user_id']); ?></h3>
                <p class="metric-label">Sisa Cuti</p>
                <div class="metric-trend positive">
                    <i class="fas fa-calendar"></i>
                    <span>Tahun <?php echo date('Y'); ?></span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="metric-card">
            <div class="metric-icon orders">
                <i class="fas fa-clock"></i>
            </div>
            <div class="metric-content">
                <?php
                $pending = mysqli_query($GLOBALS['conn'], "SELECT COUNT(*) as total FROM cuti WHERE id_karyawan = {$_SESSION['user_id']} AND status = 'Pending'");
                $pending_count = mysqli_fetch_assoc($pending)['total'];
                ?>
                <h3 class="metric-value"><?php echo $pending_count; ?></h3>
                <p class="metric-label">Menunggu Persetujuan</p>
                <div class="metric-trend warning">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Pending</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="metric-card">
            <div class="metric-icon shipments">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="metric-content">
                <?php
                $approved = mysqli_query($GLOBALS['conn'], "SELECT COUNT(*) as total FROM cuti WHERE id_karyawan = {$_SESSION['user_id']} AND status = 'Disetujui'");
                $approved_count = mysqli_fetch_assoc($approved)['total'];
                ?>
                <h3 class="metric-value"><?php echo $approved_count; ?></h3>
                <p class="metric-label">Disetujui</p>
                <div class="metric-trend positive">
                    <i class="fas fa-thumbs-up"></i>
                    <span>Approved</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="metric-card">
            <div class="metric-icon customers">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="metric-content">
                <?php
                $rejected = mysqli_query($GLOBALS['conn'], "SELECT COUNT(*) as total FROM cuti WHERE id_karyawan = {$_SESSION['user_id']} AND status = 'Ditolak'");
                $rejected_count = mysqli_fetch_assoc($rejected)['total'];
                ?>
                <h3 class="metric-value"><?php echo $rejected_count; ?></h3>
                <p class="metric-label">Ditolak</p>
                <div class="metric-trend negative">
                    <i class="fas fa-thumbs-down"></i>
                    <span>Rejected</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Action Buttons -->
<div class="row mb-4">
    <div class="col-12">
        <div class="d-flex gap-2 flex-wrap">
            <a href="dashboard.php?route=ajukancuti" class="btn btn-primary">
                <i class="fas fa-plus"></i> Ajukan Cuti Baru
            </a>
            <a href="dashboard.php?route=riwayatcuti" class="btn btn-outline-secondary">
                <i class="fas fa-history"></i> Lihat Riwayat
            </a>
            <a href="dashboard.php?route=kalendercuti" class="btn btn-outline-info">
                <i class="fas fa-calendar-alt"></i> Kalender Cuti
            </a>
        </div>
    </div>
</div>

<!-- Daftar Cuti -->
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Pengajuan Cuti</h5>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="Pending">Pending</option>
                        <option value="Disetujui">Disetujui</option>
                        <option value="Ditolak">Ditolak</option>
                        <option value="Dibatalkan">Dibatalkan</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Cuti</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Jumlah Hari</th>
                                <th>Status</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($cuti_list)):
                            ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td>
                                    <span class="badge bg-info"><?php echo htmlspecialchars($row['nama_cuti']); ?></span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($row['tanggal_mulai'])); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($row['tanggal_selesai'])); ?></td>
                                <td><?php echo $row['jumlah_hari']; ?> hari</td>
                                <td>
                                    <?php
                                    $badge_class = '';
                                    switch($row['status']) {
                                        case 'Pending': $badge_class = 'warning'; break;
                                        case 'Disetujui': $badge_class = 'success'; break;
                                        case 'Ditolak': $badge_class = 'danger'; break;
                                        case 'Dibatalkan': $badge_class = 'secondary'; break;
                                        default: $badge_class = 'primary';
                                    }
                                    ?>
                                    <span class="badge bg-<?php echo $badge_class; ?>"><?php echo $row['status']; ?></span>
                                </td>
                                <td><?php echo date('d/m/Y H:i', strtotime($row['created_at'])); ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        <?php if ($row['status'] == 'Pending'): ?>
                                        <a href="dashboard.php?route=editcuti&id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="dashboard.php?route=batalcuti&id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membatalkan cuti ini?')">
                                            <i class="fas fa-times"></i>
                                        </a>
                                        <?php endif; ?>
                                        <button class="btn btn-info btn-sm" onclick="showDetail(<?php echo $row['id']; ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
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

<!-- Modal Detail Cuti -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengajuan Cuti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>
</div>

<script>
// Filter status
document.getElementById('filterStatus').addEventListener('change', function() {
    const status = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        if (status === '' || row.innerHTML.toLowerCase().includes(status)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

function showDetail(id) {
    // Show loading
    document.getElementById('modalContent').innerHTML = '<div class="text-center"><i class="fas fa-spinner fa-spin"></i> Loading...</div>';
    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();

    // Load detail via fetch (simplified)
    // In real implementation, you would fetch detail from server
    setTimeout(() => {
        document.getElementById('modalContent').innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Informasi Cuti</h6>
                    <p><strong>ID:</strong> ${id}</p>
                    <p><strong>Status:</strong> <span class="badge bg-warning">Pending</span></p>
                </div>
                <div class="col-md-6">
                    <h6>Detail</h6>
                    <p>Detail lengkap akan dimuat dari server</p>
                </div>
            </div>
        `;
    }, 1000);
}
</script>