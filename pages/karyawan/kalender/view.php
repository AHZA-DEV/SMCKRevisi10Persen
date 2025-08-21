
<?php
include 'function/karyawan/kalender.php';

$id_karyawan = $_SESSION['user_id'];
$bulan = isset($_GET['bulan']) ? (int)$_GET['bulan'] : date('n');
$tahun = isset($_GET['tahun']) ? (int)$_GET['tahun'] : date('Y');

// Ambil data kalender
$kalender_cuti = getKalenderCuti($id_karyawan, $bulan, $tahun);
$kalender_tim = getKalenderCutiTim($id_karyawan, $bulan, $tahun);
$kalender = generateKalender($bulan, $tahun);
$libur_nasional = getLiburNasional($tahun);

// Nama bulan
$nama_bulan = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];
?>

<div class="row mb-4">
    <div class="col-12">
        <h1 class="h3 text-dark mb-0">Kalender Cuti</h1>
        <p class="text-muted">Lihat jadwal cuti Anda dan tim</p>
    </div>
</div>

<!-- Controls -->
<div class="row mb-3">
    <div class="col-md-6">
        <div class="d-flex align-items-center">
            <a href="?route=kalender&bulan=<?php echo $bulan > 1 ? $bulan - 1 : 12; ?>&tahun=<?php echo $bulan > 1 ? $tahun : $tahun - 1; ?>" class="btn btn-outline-primary me-2">
                <i class="fas fa-chevron-left"></i>
            </a>
            <h4 class="mb-0 me-2"><?php echo $nama_bulan[$bulan] . ' ' . $tahun; ?></h4>
            <a href="?route=kalender&bulan=<?php echo $bulan < 12 ? $bulan + 1 : 1; ?>&tahun=<?php echo $bulan < 12 ? $tahun : $tahun + 1; ?>" class="btn btn-outline-primary">
                <i class="fas fa-chevron-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-6 text-end">
        <button type="button" class="btn btn-primary" onclick="goToday()">Hari Ini</button>
        <a href="dashboard.php?route=cuti-karyawan" class="btn btn-success">
            <i class="fas fa-plus"></i> Ajukan Cuti
        </a>
    </div>
</div>

<!-- Legend -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card">
            <div class="card-body py-2">
                <div class="d-flex flex-wrap">
                    <div class="me-3 mb-1">
                        <span class="badge bg-success"></span> Cuti Saya (Disetujui)
                    </div>
                    <div class="me-3 mb-1">
                        <span class="badge bg-warning"></span> Cuti Saya (Pending)
                    </div>
                    <div class="me-3 mb-1">
                        <span class="badge bg-info"></span> Cuti Tim
                    </div>
                    <div class="me-3 mb-1">
                        <span class="badge bg-danger"></span> Libur Nasional
                    </div>
                    <div class="me-3 mb-1">
                        <span class="badge bg-secondary"></span> Weekend
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Calendar -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0 calendar-table">
                        <thead class="table-light">
                            <tr>
                                <th class="text-center py-3">Minggu</th>
                                <th class="text-center py-3">Senin</th>
                                <th class="text-center py-3">Selasa</th>
                                <th class="text-center py-3">Rabu</th>
                                <th class="text-center py-3">Kamis</th>
                                <th class="text-center py-3">Jumat</th>
                                <th class="text-center py-3">Sabtu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kalender as $week): ?>
                            <tr>
                                <?php foreach ($week as $day): ?>
                                <td class="calendar-day p-0" style="height: 120px; vertical-align: top;">
                                    <?php if ($day != ''): ?>
                                        <?php
                                        $current_date = $tahun . '-' . sprintf('%02d', $bulan) . '-' . sprintf('%02d', $day);
                                        $is_weekend = isWeekend($current_date);
                                        $is_holiday = isset($libur_nasional[$current_date]);
                                        $is_today = ($current_date == date('Y-m-d'));
                                        
                                        // Get events for this day
                                        $events_cuti = getEventPadaTanggal($current_date, $kalender_cuti);
                                        $events_tim = getEventPadaTanggal($current_date, $kalender_tim);
                                        ?>
                                        
                                        <div class="h-100 p-2 <?php echo $is_today ? 'bg-light' : ''; ?>">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <span class="fw-bold <?php echo $is_weekend || $is_holiday ? 'text-danger' : ''; ?>">
                                                    <?php echo $day; ?>
                                                </span>
                                                <?php if ($is_today): ?>
                                                    <small class="badge bg-primary">Hari ini</small>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Holiday -->
                                            <?php if ($is_holiday): ?>
                                                <div class="mt-1">
                                                    <small class="badge bg-danger" title="<?php echo $libur_nasional[$current_date]; ?>">
                                                        Libur
                                                    </small>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <!-- My Leave Events -->
                                            <?php foreach ($events_cuti as $event): ?>
                                                <div class="mt-1">
                                                    <small class="badge bg-<?php echo $event['status'] == 'Disetujui' ? 'success' : 'warning'; ?>" 
                                                           title="<?php echo $event['nama_cuti'] . ' - ' . $event['status']; ?>">
                                                        <?php echo substr($event['nama_cuti'], 0, 10); ?>
                                                    </small>
                                                </div>
                                            <?php endforeach; ?>
                                            
                                            <!-- Team Leave Events -->
                                            <?php foreach ($events_tim as $event): ?>
                                                <div class="mt-1">
                                                    <small class="badge bg-info" 
                                                           title="<?php echo $event['nama_depan'] . ' - ' . $event['nama_cuti']; ?>">
                                                        <?php echo substr($event['nama_depan'], 0, 8); ?>
                                                    </small>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Leave -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Cuti Mendatang</h5>
            </div>
            <div class="card-body">
                <?php
                $cuti_mendatang = getCutiMendatang($id_karyawan);
                if (mysqli_num_rows($cuti_mendatang) > 0):
                ?>
                <div class="row">
                    <?php while ($cuti = mysqli_fetch_assoc($cuti_mendatang)): ?>
                    <div class="col-md-4 mb-3">
                        <div class="card border-left-primary">
                            <div class="card-body py-2">
                                <h6 class="text-primary mb-1"><?php echo $cuti['nama_cuti']; ?></h6>
                                <p class="mb-1 small">
                                    <?php echo date('d/m/Y', strtotime($cuti['tanggal_mulai'])); ?> - 
                                    <?php echo date('d/m/Y', strtotime($cuti['tanggal_selesai'])); ?>
                                </p>
                                <span class="badge bg-<?php echo $cuti['status'] == 'Disetujui' ? 'success' : 'warning'; ?>">
                                    <?php echo $cuti['status']; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
                <?php else: ?>
                    <p class="text-muted mb-0">Tidak ada cuti yang akan datang</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function goToday() {
    const today = new Date();
    const month = today.getMonth() + 1;
    const year = today.getFullYear();
    window.location.href = `?route=kalender&bulan=${month}&tahun=${year}`;
}
</script>

<style>
.calendar-day {
    border: 1px solid #dee2e6 !important;
    min-height: 120px;
}

.calendar-table td {
    position: relative;
}

.border-left-primary {
    border-left: 4px solid #5e72e4 !important;
}
</style>
