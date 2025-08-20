// Analytics Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Check if Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.warn('Chart.js is not loaded. Loading from CDN...');
        loadChartJS();
        return;
    }
    
    // Initialize all charts
    initializeAllAnalyticsCharts();
});

function loadChartJS() {
    const script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/chart.js';
    script.onload = function() {
        initializeAllAnalyticsCharts();
    };
    document.head.appendChild(script);
}

function initializeAllAnalyticsCharts() {
    try {
        // Initialize all charts
        initializeKPICarts();
        initializeRevenueTrendChart();
        initializeRegionalChart();
        initializeDemographicsChart();
        initializeProductsChart();
        initializeRealtimeChart();
        
        // Auto-refresh real-time data every 10 seconds
        setInterval(refreshRealtimeData, 10000);
    } catch (error) {
        console.error('Error initializing analytics charts:', error);
    }
}

// KPI Mini Charts
function initializeKPICarts() {
    // Revenue KPI Chart
    const revenueCtx = document.getElementById('revenueKPIChart');
    if (revenueCtx) {
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    data: [12, 19, 15, 25, 22, 30, 28],
                    borderColor: '#5e72e4',
                    backgroundColor: 'rgba(94, 114, 228, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: false },
                    y: { display: false }
                }
            }
        });
    }
    
    // Users KPI Chart
    const usersCtx = document.getElementById('usersKPIChart');
    if (usersCtx) {
        new Chart(usersCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    data: [45, 52, 48, 58, 55, 62, 60],
                    borderColor: '#f093fb',
                    backgroundColor: 'rgba(240, 147, 251, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: false },
                    y: { display: false }
                }
            }
        });
    }
    
    // Sales KPI Chart
    const salesCtx = document.getElementById('salesKPIChart');
    if (salesCtx) {
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    data: [18, 22, 19, 26, 24, 31, 29],
                    borderColor: '#4facfe',
                    backgroundColor: 'rgba(79, 172, 254, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: false },
                    y: { display: false }
                }
            }
        });
    }
    
    // Export KPI Chart
    const exportCtx = document.getElementById('exportKPIChart');
    if (exportCtx) {
        new Chart(exportCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    data: [32, 28, 35, 30, 27, 25, 22],
                    borderColor: '#43e97b',
                    backgroundColor: 'rgba(67, 233, 123, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { display: false },
                    y: { display: false }
                }
            }
        });
    }
}

// Revenue Trend Chart
function initializeRevenueTrendChart() {
    const ctx = document.getElementById('revenueTrendChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue (₱)',
                    data: [1850000, 2100000, 1950000, 2300000, 2450000, 2400000, 2600000, 2750000, 2900000, 3100000, 2950000, 3200000],
                    borderColor: '#5e72e4',
                    backgroundColor: 'rgba(94, 114, 228, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + (value / 1000000) + 'M';
                            }
                        }
                    }
                }
            }
        });
    }
}

// Regional Performance Chart
function initializeRegionalChart() {
    const ctx = document.getElementById('regionalChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Metro Manila', 'Cebu', 'Davao', 'Others'],
                datasets: [{
                    data: [45, 25, 20, 10],
                    backgroundColor: [
                        '#5e72e4',
                        '#f093fb',
                        '#4facfe',
                        '#43e97b'
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.label + ': ' + context.parsed + '%';
                            }
                        }
                    }
                }
            }
        });
    }
}

// User Demographics Chart
function initializeDemographicsChart() {
    const ctx = document.getElementById('demographicsChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['18-24', '25-34', '35-44', '45-54', '55+'],
                datasets: [{
                    label: 'Users',
                    data: [3200, 4800, 2900, 1800, 900],
                    backgroundColor: [
                        '#5e72e4',
                        '#f093fb',
                        '#4facfe',
                        '#43e97b',
                        '#fa709a'
                    ],
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y.toLocaleString() + ' users';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return (value / 1000) + 'K';
                            }
                        }
                    }
                }
            }
        });
    }
}

// Top Products Chart
function initializeProductsChart() {
    const ctx = document.getElementById('productsChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                labels: ['Product A', 'Product B', 'Product C', 'Product D', 'Product E'],
                datasets: [{
                    label: 'Revenue (₱)',
                    data: [450000, 380000, 320000, 280000, 250000],
                    backgroundColor: [
                        '#5e72e4',
                        '#f093fb',
                        '#4facfe',
                        '#43e97b',
                        '#fa709a'
                    ],
                    borderRadius: 6,
                    borderSkipped: false
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.parsed.x.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + (value / 1000) + 'K';
                            }
                        }
                    }
                }
            }
        });
    }
}

// Real-time Chart
function initializeRealtimeChart() {
    const ctx = document.getElementById('realtimeChart');
    if (ctx) {
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Revenue (₱)',
                    data: [],
                    borderColor: '#5e72e4',
                    backgroundColor: 'rgba(94, 114, 228, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return '₱' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: { display: false },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '₱' + (value / 1000) + 'K';
                            }
                        }
                    }
                }
            }
        });
        
        // Store chart reference for updates
        window.realtimeChart = chart;
        
        // Initialize with some data
        updateRealtimeChart();
    }
}

// Update real-time chart with new data
function updateRealtimeChart() {
    if (window.realtimeChart) {
        const chart = window.realtimeChart;
        const now = new Date();
        const timeLabel = now.getHours() + ':' + now.getMinutes().toString().padStart(2, '0');
        
        // Add new data point
        chart.data.labels.push(timeLabel);
        chart.data.datasets[0].data.push(Math.random() * 50000 + 10000);
        
        // Keep only last 20 data points
        if (chart.data.labels.length > 20) {
            chart.data.labels.shift();
            chart.data.datasets[0].data.shift();
        }
        
        chart.update('none');
    }
}

// Refresh real-time data
function refreshRealtimeData() {
    updateRealtimeChart();
    
    // Update real-time metrics
    const revenueElement = document.querySelector('.real-time-metric h3.text-primary');
    const ordersElement = document.querySelector('.real-time-metric h3.text-success');
    const usersElement = document.querySelector('.real-time-metric h3.text-info');
    const avgOrderElement = document.querySelector('.real-time-metric h3.text-warning');
    
    if (revenueElement) {
        const currentRevenue = parseInt(revenueElement.textContent.replace(/[₱,]/g, ''));
        const newRevenue = currentRevenue + Math.floor(Math.random() * 5000);
        revenueElement.textContent = '₱' + newRevenue.toLocaleString();
    }
    
    if (ordersElement) {
        const currentOrders = parseInt(ordersElement.textContent);
        const newOrders = currentOrders + Math.floor(Math.random() * 10);
        ordersElement.textContent = newOrders;
    }
    
    if (usersElement) {
        const currentUsers = parseInt(usersElement.textContent);
        const newUsers = currentUsers + Math.floor(Math.random() * 5);
        usersElement.textContent = newUsers;
    }
    
    if (avgOrderElement) {
        const currentAvg = parseInt(avgOrderElement.textContent.replace(/[₱,]/g, ''));
        const newAvg = currentAvg + Math.floor(Math.random() * 2000) - 1000;
        avgOrderElement.textContent = '₱' + Math.max(5000, newAvg).toLocaleString();
    }
}

// Export functionality
document.addEventListener('click', function(e) {
    if (e.target.textContent.includes('Export Report')) {
        alert('Export functionality would be implemented here. This could generate PDF, Excel, or CSV reports.');
    }
    
    if (e.target.textContent.includes('Share Analytics')) {
        alert('Share functionality would be implemented here. This could generate shareable links or send reports via email.');
    }
    
    if (e.target.textContent.includes('Create Dashboard')) {
        alert('Dashboard creation functionality would be implemented here. Users could create custom dashboards.');
    }
    
    if (e.target.textContent.includes('Set Alerts')) {
        alert('Alert functionality would be implemented here. Users could set up automated alerts for specific metrics.');
    }
    
    if (e.target.textContent.includes('Configure')) {
        alert('Configuration functionality would be implemented here. Users could customize analytics settings.');
    }
});

// Chart period selector functionality
document.addEventListener('change', function(e) {
    if (e.target.tagName === 'SELECT' && e.target.closest('.chart-controls')) {
        const chartCard = e.target.closest('.chart-card');
        const chartBody = chartCard.querySelector('.chart-body');
        
        // Show loading state
        chartBody.innerHTML = '<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2">Loading new data...</p></div>';
        
        // Simulate data loading
        setTimeout(() => {
            if (e.target.value === '7') {
                chartBody.innerHTML = '<canvas id="revenueTrendChart" height="300"></canvas>';
                initializeRevenueTrendChart();
            } else if (e.target.value === '30') {
                chartBody.innerHTML = '<canvas id="revenueTrendChart" height="300"></canvas>';
                initializeRevenueTrendChart();
            } else if (e.target.value === '90') {
                chartBody.innerHTML = '<canvas id="revenueTrendChart" height="300"></canvas>';
                initializeRevenueTrendChart();
            } else if (e.target.value === '365') {
                chartBody.innerHTML = '<canvas id="revenueTrendChart" height="300"></canvas>';
                initializeRevenueTrendChart();
            }
        }, 1000);
    }
}); 