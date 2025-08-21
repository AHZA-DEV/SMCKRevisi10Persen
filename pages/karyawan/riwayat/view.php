<?php
include 'function/karyawan/riwayat.php';

$id_karyawan = $_SESSION['user_id'];

// Handle filters
$filters = [];
if (isset($_GET['status']) && !empty($_GET['status'])) {
    $filters['status'] = $_GET['status'];
}
if (isset($_GET['jenis_cuti']) && !empty($_GET['jenis_cuti'])) {
    $filters['jenis_cuti'] = $_GET['jenis_cuti'];
}
if (isset($_GET['tahun']) && !empty($_GET['tahun'])) {
    $filters['tahun'] = $_GET['tahun'];
}
if (isset($_GET['tanggal_dari']) && isset($_GET['tanggal_sampai']) && 
    !empty($_GET['tanggal_dari']) && !empty($_GET['tanggal_sampai'])) {
    $filters['tanggal_dari'] = $_GET['tanggal_dari'];
    $filters['tanggal_sampai'] = $_GET['tanggal_sampai'];
}

// Get data
$riwayat_cuti = getRiwayatCuti($id_karyawan, $filters);
$statistik = getStatistikRiwayat($id_karyawan, $filters['tahun'] ?? null);
$tahun_tersedia = getTahunRiwayat($id_karyawan);
$riwayat_per_jenis = getRiwayatPerJenisCuti($id_karyawan, $filters['tahun'] ?? null);

// Get jenis cuti for filter
include 'config/koneksi.php';
$jenis_cuti_query = mysqli_query($conn, "SELECT * FROM jenis_cuti ORDER BY nama_cuti");
?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Riwayat Cuti</h1>
        <p class="text-muted">Lihat riwayat pengajuan cuti Anda</p>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card border-left-primary">
            <div class="card-body">
                <div class="text-primary small font-weight-bold text-uppercase">Total Pengajuan</div>
                <div class="h5 mb-0"><?php echo $statistik['total_pengajuan']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-success">
            <div class="card-body">
                <div class="text-success small font-weight-bold text-uppercase">Disetujui</div>
                <div class="h5 mb-0"><?php echo $statistik['disetujui']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-warning">
            <div class="card-body">
                <div class="text-warning small font-weight-bold text-uppercase">Pending</div>
                <div class="h5 mb-0"><?php echo $statistik['pending']; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card border-left-info">
            <div class="card-body">
                <div class="text-info small font-weight-bold text-uppercase">Total Hari Cuti</div>
                <div class="h5 mb-0"><?php echo $statistik['total_hari_cuti']; ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="dashboard.php">
                    <input type="hidden" name="route" value="riwayat">
                    <div class="row">
                        <div class="col-md-2 mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="">Semua Status</option>
                                <option value="Pending" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                                <option value="Disetujui" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Disetujui') ? 'selected' : ''; ?>>Disetujui</option>
                                <option value="Ditolak" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                                <option value="Dibatalkan" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="jenis_cuti" class="form-label">Jenis Cuti</label>
                            <select class="form-select" name="jenis_cuti" id="jenis_cuti">
                                <option value="">Semua Jenis</option>
                                <?php while ($jenis = mysqli_fetch_assoc($jenis_cuti_query)): ?>
                                    <option value="<?php echo $jenis['id']; ?>" 
                                            <?php echo (isset($_GET['jenis_cuti']) && $_GET['jenis_cuti'] == $jenis['id']) ? 'selected' : ''; ?>>
                                        <?php echo $jenis['nama_cuti']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select class="form-select" name="tahun" id="tahun">
                                <option value="">Semua Tahun</option>
                                <?php while ($tahun = mysqli_fetch_assoc($tahun_tersedia)): ?>
                                    <option value="<?php echo $tahun['tahun']; ?>" 
                                            <?php echo (isset($_GET['tahun']) && $_GET['tahun'] == $tahun['tahun']) ? 'selected' : ''; ?>>
                                        <?php echo $tahun['tahun']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="tanggal_dari" class="form-label">Dari Tanggal</label>
                            <input type="date" class="form-control" name="tanggal_dari" id="tanggal_dari" 
                                   value="<?php echo $_GET['tanggal_dari'] ?? ''; ?>">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label for="tanggal_sampai" class="form-label">Sampai Tanggal</label>
                            <input type="date" class="form-control" name="tanggal_sampai" id="tanggal_sampai" 
                                   value="<?php echo $_GET['tanggal_sampai'] ?? ''; ?>">
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="dashboard.php?route=riwayat" class="btn btn-outline-secondary btn-sm">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Export Buttons -->
<div class="row mb-3">
    <div class="col-12 text-end">
        <a href="dashboard.php?route=rekappdf<?php echo !empty($_SERVER['QUERY_STRING']) ? '&' . str_replace('route=riwayat', 'route=rekappdf', $_SERVER['QUERY_STRING']) : ''; ?>" 
           class="btn btn-success" target="_blank">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
        <button onclick="exportCSV()" class="btn btn-info">
            <i class="fas fa-file-csv"></i> Export CSV
        </button>
    </div>
</div>

<!-- History Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
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
                                <th>Alasan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Disetujui Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($riwayat_cuti) > 0): ?>
                                <?php 
                                $no = 1;
                                while ($riwayat = mysqli_fetch_assoc($riwayat_cuti)): 
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td>
                                        <span class="fw-bold"><?php echo $riwayat['nama_cuti']; ?></span>
                                    </td>
                                    <td><?php echo date('d/m/Y', strtotime($riwayat['tanggal_mulai'])); ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($riwayat['tanggal_selesai'])); ?></td>
                                    <td>
                                        <span class="badge bg-secondary"><?php echo $riwayat['jumlah_hari']; ?> hari</span>
                                    </td>
                                    <td>
                                        <?php
                                        $badge_class = '';
                                        switch($riwayat['status']) {
                                            case 'Pending': $badge_class = 'warning'; break;
                                            case 'Disetujui': $badge_class = 'success'; break;
                                            case 'Ditolak': $badge_class = 'danger'; break;
                                            case 'Dibatalkan': $badge_class = 'secondary'; break;
                                            default: $badge_class = 'secondary';
                                        }
                                        ?>
                                        <span class="badge bg-<?php echo $badge_class; ?>"><?php echo $riwayat['status']; ?></span>
                                    </td>
                                    <td>
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                              title="<?php echo htmlspecialchars($riwayat['alasan']); ?>">
                                            <?php echo htmlspecialchars(substr($riwayat['alasan'], 0, 50)) . (strlen($riwayat['alasan']) > 50 ? '...' : ''); ?>
                                        </span>
                                    </td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($riwayat['created_at'])); ?></td>
                                    <td><?php echo $riwayat['nama_penyetuju'] ?: '-'; ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary" 
                                                onclick="showDetail(<?php echo htmlspecialchars(json_encode($riwayat)); ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <?php if ($riwayat['status'] == 'Pending'): ?>
                                            <a href="dashboard.php?route=batalkan-cuti&id=<?php echo $riwayat['id']; ?>" 
                                               class="btn btn-sm btn-outline-danger"
                                               onclick="return confirm('Yakin ingin membatalkan cuti ini?')">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="10" class="text-center">Tidak ada data riwayat cuti</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Distribusi Cuti per Jenis</h6>
            </div>
            <div class="card-body">
                <canvas id="jenisChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Cuti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart for jenis cuti
const jenisData = <?php echo json_encode(array_map(function($row) {
    return [
        'label' => $row['nama_cuti'],
        'pengajuan' => $row['jumlah_pengajuan'],
        'hari' => $row['hari_cuti']
    ];
}, mysqli_fetch_all($riwayat_per_jenis, MYSQLI_ASSOC))); ?>;

const ctx = document.getElementById('jenisChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: jenisData.map(item => item.label),
        datasets: [{
            label: 'Jumlah Pengajuan',
            data: jenisData.map(item => item.pengajuan),
            backgroundColor: '#5e72e4',
            yAxisID: 'y'
        }, {
            label: 'Total Hari',
            data: jenisData.map(item => item.hari),
            backgroundColor: '#f5365c',
            yAxisID: 'y1'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                title: {
                    display: true,
                    text: 'Jumlah Pengajuan'
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                title: {
                    display: true,
                    text: 'Total Hari'
                },
                grid: {
                    drawOnChartArea: false,
                }
            }
        }
    }
});

function showDetail(data) {
    const statusBadge = data.status === 'Disetujui' ? 'success' : 
                       data.status === 'Pending' ? 'warning' : 
                       data.status === 'Ditolak' ? 'danger' : 'secondary';

    const content = `
        <div class="row">
            <div class="col-md-6">
                <h6>Informasi Cuti</h6>
                <table class="table table-borderless">
                    <tr><td><strong>Jenis Cuti:</strong></td><td>${data.nama_cuti}</td></tr>
                    <tr><td><strong>Tanggal Mulai:</strong></td><td>${new Date(data.tanggal_mulai).toLocaleDateString('id-ID')}</td></tr>
                    <tr><td><strong>Tanggal Selesai:</strong></td><td>${new Date(data.tanggal_selesai).toLocaleDateString('id-ID')}</td></tr>
                    <tr><td><strong>Jumlah Hari:</strong></td><td>${data.jumlah_hari} hari</td></tr>
                    <tr><td><strong>Status:</strong></td><td><span class="badge bg-${statusBadge}">${data.status}</span></td></tr>
                </table>
            </div>
            <div class="col-md-6">
                <h6>Timeline</h6>
                <table class="table table-borderless">
                    <tr><td><strong>Tanggal Pengajuan:</strong></td><td>${new Date(data.created_at).toLocaleString('id-ID')}</td></tr>
                    <tr><td><strong>Disetujui Oleh:</strong></td><td>${data.nama_penyetuju || '-'}</td></tr>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h6>Alasan</h6>
                <p class="border p-3 rounded">${data.alasan}</p>
            </div>
        </div>
    `;

    document.getElementById('modalContent').innerHTML = content;
    new bootstrap.Modal(document.getElementById('detailModal')).show();
}

function exportCSV() {
    const queryString = new URLSearchParams(window.location.search);
    queryString.set('route', 'export-riwayat-csv');
    window.location.href = 'dashboard.php?' + queryString.toString();
}
</script>

<style>
.border-left-primary { border-left: 4px solid #5e72e4 !important; }
.border-left-success { border-left: 4px solid #28a745 !important; }
.border-left-warning { border-left: 4px solid #ffc107 !important; }
.border-left-info { border-left: 4px solid #17a2b8 !important; }
</style>