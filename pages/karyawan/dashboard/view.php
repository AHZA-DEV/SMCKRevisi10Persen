<?php
include 'function/karyawan/dashboard.php';

// Ambil data dashboard
$id_karyawan = $_SESSION['user_id'];
$dashboard_data = getDashboardSummary($id_karyawan);
$cuti_terbaru = getCutiTerbaru($id_karyawan, 5);
$chart_data = getChartCutiPerBulan($id_karyawan, date('Y'));
$notifikasi = getNotifikasiKaryawan($id_karyawan);
?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Dashboard Karyawan</h1>
        <p class="text-muted">Selamat datang, <?php echo $dashboard_data['karyawan']['nama_depan'] . ' ' . $dashboard_data['karyawan']['nama_belakang']; ?>!</p>
    </div>
</div>

<!-- Notifikasi -->
<?php if (!empty($notifikasi)): ?>
<div class="row mb-3">
    <div class="col-12">
        <?php foreach ($notifikasi as $notif): ?>
        <div class="alert alert-<?php echo $notif['type']; ?> alert-dismissible fade show" role="alert">
            <strong><?php echo $notif['title']; ?>:</strong> <?php echo $notif['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- Key Metrics Cards -->
<div class="row mb-3">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="metric-card">
            <div class="metric-icon revenue">
                <i class="fas fa-calendar"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-value"><?php echo $dashboard_data['sisa_cuti']; ?></h3>
                <p class="metric-label">Sisa Cuti</p>
                <div class="metric-trend positive">
                    <i class="fas fa-info-circle"></i>
                    <span>Dari <?php echo $dashboard_data['total_cuti']; ?> hari</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="metric-card">
            <div class="metric-icon costs">
                <i class="fas fa-clock"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-value"><?php echo $dashboard_data['statistik']['pending']; ?></h3>
                <p class="metric-label">Cuti Menunggu</p>
                <div class="metric-trend negative">
                    <i class="fas fa-hourglass-half"></i>
                    <span>Proses review</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="metric-card">
            <div class="metric-icon profits">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-value"><?php echo $dashboard_data['statistik']['disetujui']; ?></h3>
                <p class="metric-label">Cuti Disetujui</p>
                <div class="metric-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>Tahun ini</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="metric-card">
            <div class="metric-icon shipments">
                <i class="fas fa-user"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-value">
                    <?php 
                    $tahun_kerja = date('Y') - date('Y', strtotime($dashboard_data['karyawan']['tanggal_mulai_kerja']));
                    echo $tahun_kerja;
                    ?>
                </h3>
                <p class="metric-label">Tahun Kerja</p>
                <div class="metric-trend positive">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Sejak <?php echo date('Y', strtotime($dashboard_data['karyawan']['tanggal_mulai_kerja'])); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row mb-3">
    <div class="col-lg-8 mb-3">
        <div class="chart-card">
            <div class="chart-header">
                <h5>Riwayat Cuti Saya</h5>
            </div>
            <div class="chart-body">
                <canvas id="cutiChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="chart-card">
            <div class="chart-header">
                <h5>Status Cuti</h5>
            </div>
            <div class="chart-body">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Leave Requests -->
<div class="row">
    <div class="col-12">
        <div class="chart-card">
            <div class="chart-header">
                <h5>Pengajuan Cuti Terbaru</h5>
                <a href="dashboard.php?route=cuti-karyawan" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="chart-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Jenis Cuti</th>
                                <th>Tanggal</th>
                                <th>Durasi</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($cuti_terbaru) > 0): ?>
                                <?php while ($cuti = mysqli_fetch_assoc($cuti_terbaru)): ?>
                                <tr>
                                    <td><?php echo $cuti['nama_cuti']; ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($cuti['tanggal_mulai'])); ?> - <?php echo date('d/m/Y', strtotime($cuti['tanggal_selesai'])); ?></td>
                                    <td><?php echo $cuti['jumlah_hari']; ?> hari</td>
                                    <td>
                                        <?php
                                        $badge_class = '';
                                        switch($cuti['status']) {
                                            case 'Pending': $badge_class = 'warning'; break;
                                            case 'Disetujui': $badge_class = 'success'; break;
                                            case 'Ditolak': $badge_class = 'danger'; break;
                                            default: $badge_class = 'secondary';
                                        }
                                        ?>
                                        <span class="badge bg-<?php echo $badge_class; ?>"><?php echo $cuti['status']; ?></span>
                                    </td>
                                    <td>
                                        <a href="dashboard.php?route=detail-cuti&id=<?php echo $cuti['id']; ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada pengajuan cuti</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Chart data from PHP
const chartData = <?php echo json_encode($chart_data); ?>;
const statistik = <?php echo json_encode($dashboard_data['statistik']); ?>;

// Riwayat Cuti Chart
const cutiCtx = document.getElementById('cutiChart').getContext('2d');
const cutiChart = new Chart(cutiCtx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Hari Cuti',
            data: chartData,
            borderColor: '#5e72e4',
            backgroundColor: 'rgba(94, 114, 228, 0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Status Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusChart = new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Disetujui', 'Pending', 'Ditolak'],
        datasets: [{
            data: [statistik.disetujui, statistik.pending, (statistik.total_pengajuan - statistik.disetujui - statistik.pending)],
            backgroundColor: ['#28a745', '#ffc107', '#dc3545']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>