// Dashboard JavaScript - Modern Chart Implementation
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all charts with error handling
    try {
        // Check if Chart.js is loaded
        if (typeof Chart === 'undefined') {
            console.warn('Chart.js is not loaded. Charts will not be displayed.');
            return;
        }

        // Initialize all charts
        initializeMetricCharts();
        initializeMainCharts();

        // Add smooth animations and interactions
        addChartInteractions();

        // Update charts with real-time data (simulated)
        setInterval(updateCharts, 8000);
    } catch (error) {
        console.error('Error initializing charts:', error);
    }
});

// Initialize small metric card charts
function initializeMetricCharts() {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const gradient = revenueCtx.getContext('2d').createLinearGradient(0, 0, 0, 40);
        gradient.addColorStop(0, 'rgba(94, 114, 228, 0.8)');
        gradient.addColorStop(1, 'rgba(94, 114, 228, 0.1)');

        window.revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', '', '', ''],
                datasets: [{
                    label: 'Revenue',
                    data: [12, 19, 15, 25, 22, 30, 28, 35],
                    borderColor: '#5e72e4',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { display: false },
                    x: { display: false }
                },
                elements: { point: { radius: 0 } }
            }
        });
    }

    // Costs Chart
    const costsCtx = document.getElementById('costsChart');
    if (costsCtx) {
        const gradient = costsCtx.getContext('2d').createLinearGradient(0, 0, 0, 40);
        gradient.addColorStop(0, 'rgba(251, 99, 64, 0.8)');
        gradient.addColorStop(1, 'rgba(251, 99, 64, 0.1)');

        window.costsChart = new Chart(costsCtx, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', '', '', ''],
                datasets: [{
                    label: 'Costs',
                    data: [8, 15, 12, 18, 20, 16, 22, 19],
                    borderColor: '#fb6340',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { display: false },
                    x: { display: false }
                },
                elements: { point: { radius: 0 } }
            }
        });
    }

    // Profits Chart
    const profitsCtx = document.getElementById('profitsChart');
    if (profitsCtx) {
        const gradient = profitsCtx.getContext('2d').createLinearGradient(0, 0, 0, 40);
        gradient.addColorStop(0, 'rgba(45, 206, 137, 0.8)');
        gradient.addColorStop(1, 'rgba(45, 206, 137, 0.1)');

        window.profitsChart = new Chart(profitsCtx, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', '', '', ''],
                datasets: [{
                    label: 'Profits',
                    data: [5, 12, 8, 15, 18, 14, 20, 25],
                    borderColor: '#2dce89',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { display: false },
                    x: { display: false }
                },
                elements: { point: { radius: 0 } }
            }
        });
    }

    // Shipments Chart
    const shipmentsCtx = document.getElementById('shipmentsChart');
    if (shipmentsCtx) {
        const gradient = shipmentsCtx.getContext('2d').createLinearGradient(0, 0, 0, 40);
        gradient.addColorStop(0, 'rgba(17, 205, 239, 0.8)');
        gradient.addColorStop(1, 'rgba(17, 205, 239, 0.1)');

        window.shipmentsChart = new Chart(shipmentsCtx, {
            type: 'line',
            data: {
                labels: ['', '', '', '', '', '', '', ''],
                datasets: [{
                    label: 'Shipments',
                    data: [20, 35, 28, 42, 38, 45, 50, 48],
                    borderColor: '#11cdef',
                    backgroundColor: gradient,
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { display: false },
                    x: { display: false }
                },
                elements: { point: { radius: 0 } }
            }
        });
    }
}

// Initialize main dashboard charts
function initializeMainCharts() {
    // Yearly Order Rate Chart
    const yearlyOrderCtx = document.getElementById('yearlyOrderChart');
    if (yearlyOrderCtx) {
        const gradient = yearlyOrderCtx.getContext('2d').createLinearGradient(0, 0, 0, 200);
        gradient.addColorStop(0, 'rgba(94, 114, 228, 0.3)');
        gradient.addColorStop(1, 'rgba(94, 114, 228, 0.05)');

        window.yearlyOrderChart = new Chart(yearlyOrderCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Week',
                    data: [1200, 1350, 1500, 1400, 1600, 1800, 1700, 1900, 2100, 2000, 2200, 2400],
                    borderColor: '#4facfe',
                    backgroundColor: 'transparent',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: false,
                    pointBackgroundColor: '#4facfe',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }, {
                    label: 'Month',
                    data: [1100, 1250, 1400, 1300, 1500, 1700, 1600, 1800, 2000, 1900, 2100, 2300],
                    borderColor: '#764ba2',
                    backgroundColor: 'transparent',
                    borderWidth: 3,
                    tension: 0.4,
                    fill: false,
                    pointBackgroundColor: '#764ba2',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#5e72e4',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.08)',
                            drawBorder: false
                        },
                        ticks: {
                            font: { size: 12 },
                            color: '#6c757d',
                            callback: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 12 },
                            color: '#6c757d'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }

    // Carrying Costs Chart
    const carryingCostsCtx = document.getElementById('carryingCostsChart');
    if (carryingCostsCtx) {
        const gradient = carryingCostsCtx.getContext('2d').createLinearGradient(0, 0, 0, 120);
        gradient.addColorStop(0, 'rgba(94, 114, 228, 0.3)');
        gradient.addColorStop(1, 'rgba(94, 114, 228, 0.05)');

        window.carryingCostsChart = new Chart(carryingCostsCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Carrying Costs',
                    data: [250, 320, 280, 380, 420, 350, 400],
                    borderColor: '#5e72e4',
                    backgroundColor: gradient,
                    borderWidth: 3,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#5e72e4',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#5e72e4',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.08)',
                            drawBorder: false
                        },
                        ticks: {
                            font: { size: 11 },
                            color: '#6c757d',
                            callback: function(value) {
                                return '$' + value;
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 11 },
                            color: '#6c757d'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });
    }
}

// Add interactive features to charts
function addChartInteractions() {
    // Add hover effects to chart containers
    const chartContainers = document.querySelectorAll('.chart-card');
    chartContainers.forEach(container => {
        container.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.02)';
            this.style.transition = 'transform 0.3s ease';
        });

        container.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Add legend interaction for yearly order chart
    const legendItems = document.querySelectorAll('.legend-item');
    legendItems.forEach(item => {
        item.addEventListener('click', function() {
            const isActive = this.classList.contains('active');
            if (isActive) {
                this.classList.remove('active');
                this.style.opacity = '0.6';
            } else {
                this.classList.add('active');
                this.style.opacity = '1';
            }
        });
    });
}

// Update charts with new data for real-time feel
function updateCharts() {
    // Update Metric Charts
    updateMetricCharts();

    // Update Main Charts
    updateMainCharts();
}

// Update metric card charts
function updateMetricCharts() {
    // Update Revenue Chart
    if (window.revenueChart) {
        const currentData = window.revenueChart.data.datasets[0].data;
        const newData = currentData.map(() => Math.floor(Math.random() * 40) + 10);
        window.revenueChart.data.datasets[0].data = newData;
        window.revenueChart.update('active');
    }

    // Update Costs Chart
    if (window.costsChart) {
        const currentData = window.costsChart.data.datasets[0].data;
        const newData = currentData.map(() => Math.floor(Math.random() * 30) + 8);
        window.costsChart.data.datasets[0].data = newData;
        window.costsChart.update('active');
    }

    // Update Profits Chart
    if (window.profitsChart) {
        const currentData = window.profitsChart.data.datasets[0].data;
        const newData = currentData.map(() => Math.floor(Math.random() * 25) + 5);
        window.profitsChart.data.datasets[0].data = newData;
        window.profitsChart.update('active');
    }

    // Update Shipments Chart
    if (window.shipmentsChart) {
        const currentData = window.shipmentsChart.data.datasets[0].data;
        const newData = currentData.map(() => Math.floor(Math.random() * 50) + 20);
        window.shipmentsChart.data.datasets[0].data = newData;
        window.shipmentsChart.update('active');
    }
}

// Update main dashboard charts
function updateMainCharts() {
    // Update Yearly Order Chart
    if (window.yearlyOrderChart) {
        const currentData1 = window.yearlyOrderChart.data.datasets[0].data;
        const currentData2 = window.yearlyOrderChart.data.datasets[1].data;

        const newData1 = currentData1.map(value => {
            const variation = (Math.random() - 0.5) * 0.15; // ±7.5% variation
            return Math.max(800, Math.floor(value * (1 + variation)));
        });

        const newData2 = currentData2.map(value => {
            const variation = (Math.random() - 0.5) * 0.15; // ±7.5% variation
            return Math.max(700, Math.floor(value * (1 + variation)));
        });

        window.yearlyOrderChart.data.datasets[0].data = newData1;
        window.yearlyOrderChart.data.datasets[1].data = newData2;
        window.yearlyOrderChart.update('active');
    }

    // Update Carrying Costs Chart
    if (window.carryingCostsChart) {
        const currentData = window.carryingCostsChart.data.datasets[0].data;
        const newData = currentData.map(value => {
            const variation = (Math.random() - 0.5) * 0.2; // ±10% variation
            return Math.max(200, Math.floor(value * (1 + variation)));
        });
        window.carryingCostsChart.data.datasets[0].data = newData;
        window.carryingCostsChart.update('active');
    }
}

// Add smooth scrolling and enhanced interactions
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Add loading animations to cards
    const cards = document.querySelectorAll('.metric-card, .chart-card, .placeholder-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // Add sidebar toggle functionality
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');

    if (sidebarToggle && sidebar && mainContent) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }

    // Add mobile sidebar toggle functionality
    const mobileSidebarToggle = document.querySelector('.mobile-sidebar-toggle');
    const sidebarOverlay = document.querySelector('#sidebarOverlay');
    const mobileClose = document.querySelector('.mobile-close');

    console.log('Mobile sidebar elements found:', {
        mobileSidebarToggle: !!mobileSidebarToggle,
        sidebarOverlay: !!sidebarOverlay,
        mobileClose: !!mobileClose,
        sidebar: !!sidebar
    });

    // Log current screen size and sidebar state
    console.log('Current screen width:', window.innerWidth);
    console.log('Sidebar current transform:', getComputedStyle(sidebar).transform);
    console.log('Sidebar has show class:', sidebar.classList.contains('show'));

    if (mobileSidebarToggle && sidebar && sidebarOverlay) {
        // Function to close sidebar
        function closeSidebar() {
            console.log('Closing sidebar');
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Function to open sidebar
        function openSidebar() {
            sidebar.classList.add('show');
            sidebarOverlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        // Mobile toggle button
        mobileSidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Mobile toggle button clicked');
            console.log('Current sidebar state:', sidebar.classList.contains('show'));
            if (sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });

        // Mobile close button - improved event handling
        if (mobileClose) {
            mobileClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Mobile close button clicked');
                closeSidebar();
            });

            // Also add touch events for mobile
            mobileClose.addEventListener('touchend', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Mobile close button touched');
                closeSidebar();
            });
        }

        // Close sidebar when clicking overlay
        sidebarOverlay.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            closeSidebar();
        });

        // Close sidebar when pressing Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                closeSidebar();
            }
        });

        // Close sidebar when clicking on menu items on mobile
        const sidebarLinks = sidebar.querySelectorAll('.nav-link, .submenu a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 991.98) {
                    console.log('Menu item clicked, closing sidebar');
                    // Small delay to show the click effect before closing
                    setTimeout(() => {
                        closeSidebar();
                    }, 150);
                }
            });
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(e) {
            if (window.innerWidth <= 991.98 &&
                !sidebar.contains(e.target) &&
                !mobileSidebarToggle.contains(e.target) &&
                sidebar.classList.contains('show')) {
                closeSidebar();
            }
        });

        // Close sidebar when resizing to desktop
        window.addEventListener('resize', function() {
            if (window.innerWidth > 991.98 && sidebar.classList.contains('show')) {
                closeSidebar();
            }
        });
    }

    // Add submenu toggle functionality
    const submenuItems = document.querySelectorAll('.nav-link .fa-chevron-down');
    submenuItems.forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const navItem = this.closest('.nav-item');
            const submenu = navItem.querySelector('.submenu');
            const icon = this;

            if (submenu) {
                if (submenu.style.maxHeight) {
                    submenu.style.maxHeight = null;
                    icon.style.transform = 'rotate(0deg)';
                } else {
                    submenu.style.maxHeight = submenu.scrollHeight + 'px';
                    icon.style.transform = 'rotate(180deg)';
                }
            }
        });
    });
});