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
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="dashboard.html" class="nav-link <?php if (basename($_SERVER['PHP_SELF']) == 'dashboard.html') echo 'active'; ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="dashboard.php?route=admin" class="nav-link <?php if (isset($_GET['route']) && $_GET['route'] == 'admin') echo 'active'; ?>">
                    <i class="fas fa-user-shield"></i>
                    <span>Admin</span>
                    <i class="fas fa-chevron-right ms-auto"></i>
                </a>
            </li>
        </ul>

        <div class="sidebar-category">
            <h6>MODULES</h6>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="analytics.html" class="nav-link">
                        <i class="fas fa-chart-bar"></i>
                        <span>Analytics</span>
                        <i class="fas fa-chevron-down ms-auto"></i>
                    </a>
                    <ul class="submenu">
                        <li><a href="analytics.html">Overview</a></li>
                        <li><a href="#">Reports</a></li>
                        <li><a href="#">Insights</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="users.html" class="nav-link">
                        <i class="fas fa-users"></i>
                        <span>Users</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="settings.html" class="nav-link">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-chart-pie"></i>
                        <span>Reports</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-bell"></i>
                        <span>Notifications</span>
                        <i class="fas fa-chevron-right ms-auto"></i>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Logout Section -->
        <div class="sidebar-logout">
            <a href="index.html" class="nav-link logout-link">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>