

    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 text-dark mb-0">Dashboard Admin</h1>
            <p class="text-muted">Selamat datang, Admin!</p>
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
                    <h3 class="metric-value">25</h3>
                    <p class="metric-label">Total Karyawan</p>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>5%</span>
                        <small>Dari bulan lalu</small>
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
                    <h3 class="metric-value">12</h3>
                    <p class="metric-label">Cuti Menunggu</p>
                    <div class="metric-trend negative">
                        <i class="fas fa-arrow-down"></i>
                        <span>2</span>
                        <small>Dari kemarin</small>
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
                    <h3 class="metric-value">45</h3>
                    <p class="metric-label">Cuti Disetujui</p>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>15%</span>
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
                    <h3 class="metric-value">5</h3>
                    <p class="metric-label">Departemen</p>
                    <div class="metric-trend positive">
                        <i class="fas fa-arrow-up"></i>
                        <span>0%</span>
                        <small>Tidak berubah</small>
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
                                    <th>Aktivitas</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Budi Santoso</td>
                                    <td>Mengajukan cuti tahunan</td>
                                    <td>2023-11-15</td>
                                    <td><span class="badge bg-warning">Menunggu</span></td>
                                </tr>
                                <tr>
                                    <td>Siti Rahayu</td>
                                    <td>Cuti sakit disetujui</td>
                                    <td>2023-11-14</td>
                                    <td><span class="badge bg-success">Disetujui</span></td>
                                </tr>
                                <tr>
                                    <td>Ahmad Fauzi</td>
                                    <td>Mengajukan cuti penting</td>
                                    <td>2023-11-13</td>
                                    <td><span class="badge bg-warning">Menunggu</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>