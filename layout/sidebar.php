<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="logo-container">
            <i class="fas fa-chart-line"></i>
            <span class="logo-text">Soft UI</span>
        </div>
        <div class="mobile-close d-lg-none">
            <i class="fas fa-times"></i>
        </div>
    </div>

    <div class="sidebar-menu">
        <h6 class="text-center">Master Data</h6>
        <ul class="nav flex-column">
            <?php if ($_SESSION['user_role'] == 'admin') : ?>
                <!-- Admin List Menu -->
                <h6 class="text-center badge bg-danger">Admin</h6>
                <li class="nav-item">
                    <a href="dashboard.php?route=dashboard" class="nav-link <?php if (isset($_GET['route']) && $_GET['route'] == 'dashboard') echo 'active'; ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="dashboard.php?route=karyawan" class="nav-link <?php if (isset($_GET['route']) && $_GET['route'] == 'karyawan') echo 'active'; ?>">
                        <i class="fas fa-users"></i>
                        <span>Data Karyawan</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="dashboard.php?route=departemen" class="nav-link <?php if (isset($_GET['route']) && $_GET['route'] == 'departemen') echo 'active'; ?>">
                        <i class="fas fa-building"></i>
                        <span>Data Departemen</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="dashboard.php?route=cuti" class="nav-link <?php if (isset($_GET['route']) && $_GET['route'] == 'cuti') echo 'active'; ?>">
                        <i class="fas fa-calendar-check"></i>
                        <span>Manajemen Cuti</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="dashboard.php?route=laporan" class="nav-link <?php if (isset($_GET['route']) && $_GET['route'] == 'laporan') echo 'active'; ?>">
                        <i class="fas fa-chart-bar"></i>
                        <span>Data Laporan</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="dashboard.php?route=pengaturan" class="nav-link <?php if (isset($_GET['route']) && $_GET['route'] == 'pengaturan') echo 'active'; ?>">
                        <i class="fas fa-cog"></i>
                        <span>Pengaturan</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>
            <?php else : ?>
                <!-- Karyawan Pages -->
                <h6 class="text-center badge bg-success">Karyawan</h6>
                <li class="nav-item">
                    <a href="dashboard.php?route=karyawan-dashboard" class="nav-link <?php if (isset($_GET['route']) && $_GET['route'] == 'karyawan-dashboard') echo 'active'; ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="dashboard.php?route=cuti-karyawan" class="nav-link <?php if (isset($_GET['route']) && $_GET['route'] == 'cuti-karyawan') echo 'active'; ?>">
                        <i class="fas fa-calendar-check"></i>
                        <span>Pengajuan Cuti</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="dashboard.php?route=kalender" class="nav-link <?php if (isset($_GET['route']) && $_GET['route'] == 'kalender') echo 'active'; ?>">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Kalender Cuti</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="dashboard.php?route=riwayat" class="nav-link <?php if (isset($_GET['route']) && $_GET['route'] == 'riwayat') echo 'active'; ?>">
                        <i class="fas fa-history"></i>
                        <span>Riwayat Cuti</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="dashboard.php?route=profile" class="nav-link <?php if (isset($_GET['route']) && $_GET['route'] == 'profile') echo 'active'; ?>">
                        <i class="fas fa-user-circle"></i>
                        <span>Profil Saya</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>
            <?php endif ?>

        </ul>


        <!-- Logout Section -->
        <div class="sidebar-logout">
            <a href="logout.php" class="nav-link logout-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>