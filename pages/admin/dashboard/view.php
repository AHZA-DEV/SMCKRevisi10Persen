
<?php
include 'function/admin/dashboard.php';
$stats = getDashboardStats();
$recent_activities = getRecentActivities();
?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Dashboard Admin</h1>
        <p class="text-muted">Selamat datang, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</p>
    </div>
</div>

<!-- Key Metrics Cards -->
<div class="row mb-3">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="metric-card">
            <div class="metric-icon revenue">
                <i class="fas fa-users"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-value"><?php echo $stats['total_karyawan']; ?></h3>
                <p class="metric-label">Total Karyawan</p>
                <div class="metric-trend positive">
                    <i class="fas fa-users"></i>
                    <small>Karyawan aktif</small>
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
                <h3 class="metric-value"><?php echo $stats['cuti_menunggu']; ?></h3>
                <p class="metric-label">Cuti Menunggu</p>
                <div class="metric-trend negative">
                    <i class="fas fa-clock"></i>
                    <small>Perlu review</small>
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
                <h3 class="metric-value"><?php echo $stats['cuti_disetujui']; ?></h3>
                <p class="metric-label">Cuti Disetujui</p>
                <div class="metric-trend positive">
                    <i class="fas fa-check"></i>
                    <small>Bulan ini</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="metric-card">
            <div class="metric-icon shipments">
                <i class="fas fa-building"></i>
            </div>
            <div class="metric-content">
                <h3 class="metric-value"><?php echo $stats['total_departemen']; ?></h3>
                <p class="metric-label">Departemen</p>
                <div class="metric-trend positive">
                    <i class="fas fa-building"></i>
                    <small>Departemen aktif</small>
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
                <h5>Statistik Cuti Bulanan</h5>
            </div>
            <div class="chart-body">
                <canvas id="cutiChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-3">
        <div class="chart-card">
            <div class="chart-header">
                <h5>Cuti Berdasarkan Departemen</h5>
            </div>
            <div class="chart-body">
                <canvas id="departemenChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activities -->
<div class="row">
    <div class="col-12">
        <div class="chart-card">
            <div class="chart-header">
                <h5>Aktivitas Terbaru</h5>
            </div>
            <div class="chart-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Karyawan</th>
                                <th>Jenis Cuti</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($activity = mysqli_fetch_assoc($recent_activities)): ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="user-avatar me-2">
                                            <span class="avatar-placeholder">
                                                <?php echo strtoupper(substr($activity['nama_depan'], 0, 1)) . strtoupper(substr($activity['nama_belakang'], 0, 1)); ?>
                                            </span>
                                        </div>
                                        <div>
                                            <div class="fw-bold"><?php echo htmlspecialchars($activity['nama_depan'] . ' ' . $activity['nama_belakang']); ?></div>
                                            <small class="text-muted"><?php echo htmlspecialchars($activity['nip']); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo htmlspecialchars($activity['nama_cuti']); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($activity['tanggal_pengajuan'])); ?></td>
                                <td>
                                    <?php
                                    $status_class = '';
                                    switch($activity['status']) {
                                        case 'menunggu': $status_class = 'warning'; break;
                                        case 'disetujui': $status_class = 'success'; break;
                                        case 'ditolak': $status_class = 'danger'; break;
                                    }
                                    ?>
                                    <span class="badge bg-<?php echo $status_class; ?>"><?php echo ucfirst($activity['status']); ?></span>
                                </td>
                                <td>
                                    <a href="dashboard.php?route=detailcuti&id=<?php echo $activity['id']; ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Chart untuk statistik cuti bulanan
    const cutiCtx = document.getElementById('cutiChart');
    if (cutiCtx) {
        new Chart(cutiCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Pengajuan Cuti',
                    data: [12, 19, 3, 5, 2, 3, 10, 15, 8, 12, 6, 9],
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.1)',
                    tension: 0.1,
                    fill: true
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
    }

    // Chart untuk cuti berdasarkan departemen
    const departemenCtx = document.getElementById('departemenChart');
    if (departemenCtx) {
        new Chart(departemenCtx, {
            type: 'doughnut',
            data: {
                labels: ['IT', 'HR', 'Finance', 'Marketing', 'Operations'],
                datasets: [{
                    data: [30, 20, 15, 25, 10],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.8)',
                        'rgba(54, 162, 235, 0.8)',
                        'rgba(255, 205, 86, 0.8)',
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(153, 102, 255, 0.8)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    }
});
</script>
