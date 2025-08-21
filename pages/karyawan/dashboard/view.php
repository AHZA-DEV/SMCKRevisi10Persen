
            <div class="row mb-4">
                <div class="col-12">
                    <h1 class="h3 text-dark mb-0">Dashboard Karyawan</h1>
                    <p class="text-muted">Selamat datang, Karyawan!</p>
                </div>
            </div>

            <!-- Key Metrics Cards -->
            <div class="row mb-3">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="metric-card">
                        <div class="metric-icon revenue">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="metric-content">
                            <h3 class="metric-value">12</h3>
                            <p class="metric-label">Sisa Cuti</p>
                            <div class="metric-trend positive">
                                <i class="fas fa-info-circle"></i>
                                <span>Dari 12 hari</span>
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
                            <h3 class="metric-value">2</h3>
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
                            <h3 class="metric-value">8</h3>
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
                            <h3 class="metric-value">3</h3>
                            <p class="metric-label">Tahun Kerja</p>
                            <div class="metric-trend positive">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Sejak 2021</span>
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
                        </div>
                        <div class="chart-body">

                        </div>
                    </div>
                </div>
            </div>