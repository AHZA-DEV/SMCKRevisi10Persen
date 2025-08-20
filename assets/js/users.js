document.addEventListener('DOMContentLoaded', function() {
   
    initializeUserKPICarts();
    initializeUserGrowthChart();
    initializeUserDemographicsChart();
    
    initializeUserManagement();
    
    setInterval(refreshUserData, 30000);
});

function initializeUserKPICarts() {
  
    const totalUsersCtx = document.getElementById('totalUsersChart');
    if (totalUsersCtx) {
        new Chart(totalUsersCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    data: [12500, 12600, 12700, 12800, 12850, 12900, 12847],
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
    
    // Active Users KPI Chart
    const activeUsersCtx = document.getElementById('activeUsersChart');
    if (activeUsersCtx) {
        new Chart(activeUsersCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    data: [11000, 11100, 11200, 11300, 11350, 11400, 11234],
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
    
    // New Users KPI Chart
    const newUsersCtx = document.getElementById('newUsersChart');
    if (newUsersCtx) {
        new Chart(newUsersCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    data: [150, 180, 200, 220, 250, 280, 1613],
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
    
    // Retention Rate KPI Chart
    const retentionCtx = document.getElementById('retentionChart');
    if (retentionCtx) {
        new Chart(retentionCtx, {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    data: [85.2, 85.8, 86.1, 86.5, 86.9, 87.1, 87.4],
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

// User Growth Chart
function initializeUserGrowthChart() {
    const ctx = document.getElementById('userGrowthChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Total Users',
                    data: [8500, 9200, 9800, 10500, 11200, 11800, 12400, 12900, 13400, 13800, 14100, 14400],
                    borderColor: '#5e72e4',
                    backgroundColor: 'rgba(94, 114, 228, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }, {
                    label: 'Active Users',
                    data: [7200, 7800, 8300, 8900, 9500, 10000, 10500, 10900, 11300, 11600, 11800, 12000],
                    borderColor: '#f093fb',
                    backgroundColor: 'rgba(240, 147, 251, 0.1)',
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
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y.toLocaleString();
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

// User Demographics Chart
function initializeUserDemographicsChart() {
    const ctx = document.getElementById('userDemographicsChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['18-24', '25-34', '35-44', '45+'],
                datasets: [{
                    data: [25, 38, 23, 14],
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

function initializeUserManagement() {
    // Select all functionality
    const selectAllCheckbox = document.querySelector('thead .form-check-input');
    const userCheckboxes = document.querySelectorAll('tbody .form-check-input');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            updateSelectAllCheckbox();
        });
    }
    
    userCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllCheckbox();
        });
    });
    
    // Search functionality
    const searchInput = document.querySelector('input[placeholder="Filter users..."]');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            filterUsers(this.value);
        });
        
        // Clear search button
        const clearSearch = document.createElement('button');
        clearSearch.innerHTML = '<i class="fas fa-times"></i>';
        clearSearch.className = 'btn btn-outline-secondary btn-sm ms-2';
        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            filterUsers('');
        });
        searchInput.parentNode.appendChild(clearSearch);
    }
    
    // Table responsive controls
    const showSelect = document.querySelector('select[value="25"]');
    if (showSelect) {
        showSelect.addEventListener('change', function() {
            const rows = document.querySelectorAll('tbody tr');
            const limit = parseInt(this.value);
            
            rows.forEach((row, index) => {
                if (index < limit) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    initializeActionButtons();
}

function updateSelectAllCheckbox() {
    const selectAllCheckbox = document.querySelector('thead .form-check-input');
    const userCheckboxes = document.querySelectorAll('tbody .form-check-input');
    const checkedCheckboxes = document.querySelectorAll('tbody .form-check-input:checked');
    
    if (selectAllCheckbox) {
        if (checkedCheckboxes.length === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (checkedCheckboxes.length === userCheckboxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
            selectAllCheckbox.checked = false;
        }
    }
}

function filterUsers(searchTerm) {
    const tableRows = document.querySelectorAll('tbody tr');
    const searchLower = searchTerm.toLowerCase();
    
    tableRows.forEach(row => {
        const userName = row.querySelector('h6').textContent.toLowerCase();
        const userEmail = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        const userLocation = row.querySelector('td:nth-child(4)').textContent.toLowerCase();
        
        if (userName.includes(searchLower) || userEmail.includes(searchLower) || userLocation.includes(searchLower)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}

function initializeActionButtons() {
 
    const addUserBtn = document.querySelector('.btn-primary:contains("Add New User")');
    if (addUserBtn) {
        addUserBtn.addEventListener('click', function() {
            showAddUserModal();
        });
    }
    
    const exportBtn = document.querySelector('.btn-outline-primary:contains("Export Users")');
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            exportUsers();
        });
    }
    
    const syncBtn = document.querySelector('.btn-outline-success:contains("Sync Data")');
    if (syncBtn) {
        syncBtn.addEventListener('click', function() {
            syncUserData();
        });
    }
    
    document.querySelectorAll('.management-tool .btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.textContent.trim();
            handleManagementAction(action);
        });
    });
    
    document.querySelectorAll('.btn-group .btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.title;
            const row = this.closest('tr');
            handleTableAction(action, row);
        });
    });
}

function showAddUserModal() {
    alert('Add User modal would be implemented here. This would include a form for creating new user accounts.');
}

function exportUsers() {
    alert('Export functionality would be implemented here. This could generate CSV, Excel, or PDF reports of user data.');
}

function syncUserData() {
    const syncBtn = document.querySelector('.btn-outline-success:contains("Sync Data")');
    if (syncBtn) {
        const originalText = syncBtn.innerHTML;
        syncBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Syncing...';
        syncBtn.disabled = true;
        
        setTimeout(() => {
            syncBtn.innerHTML = originalText;
            syncBtn.disabled = false;
            alert('User data has been synchronized successfully!');
        }, 2000);
    }
}

function handleManagementAction(action) {
    switch(action) {
        case 'Add User':
            showAddUserModal();
            break;
        case 'Edit':
            alert('Edit functionality would be implemented here. This would allow bulk editing of selected users.');
            break;
        case 'Manage':
            alert('Permission management would be implemented here. This would allow setting user roles and permissions.');
            break;
        case 'Remove':
            if (confirm('Are you sure you want to remove the selected users? This action cannot be undone.')) {
                alert('User removal functionality would be implemented here.');
            }
            break;
    }
}

// Handle table action buttons
function handleTableAction(action, row) {
    const userName = row.querySelector('h6').textContent;
    
    switch(action) {
        case 'Edit':
            alert(`Edit functionality for ${userName} would be implemented here.`);
            break;
        case 'View':
            alert(`View details for ${userName} would be implemented here.`);
            break;
        case 'Delete':
            if (confirm(`Are you sure you want to delete ${userName}? This action cannot be undone.`)) {
                alert(`Delete functionality for ${userName} would be implemented here.`);
            }
            break;
    }
}

// Refresh user data
function refreshUserData() {
    
    const totalUsersElement = document.querySelector('.metric-value');
    const activeUsersElement = document.querySelectorAll('.metric-value')[1];
    const newUsersElement = document.querySelectorAll('.metric-value')[2];
    const retentionElement = document.querySelectorAll('.metric-value')[3];
    
    if (totalUsersElement) {
        const currentTotal = parseInt(totalUsersElement.textContent.replace(/,/g, ''));
        const newTotal = currentTotal + Math.floor(Math.random() * 10);
        totalUsersElement.textContent = newTotal.toLocaleString();
    }
    
    if (activeUsersElement) {
        const currentActive = parseInt(activeUsersElement.textContent.replace(/,/g, ''));
        const newActive = currentActive + Math.floor(Math.random() * 5) - 2;
        activeUsersElement.textContent = Math.max(10000, newActive).toLocaleString();
    }
    
    if (newUsersElement) {
        const currentNew = parseInt(newUsersElement.textContent.replace(/,/g, ''));
        const newCount = currentNew + Math.floor(Math.random() * 20);
        newUsersElement.textContent = newCount.toLocaleString();
    }
    
    if (retentionElement) {
        const currentRetention = parseFloat(retentionElement.textContent.replace('%', ''));
        const newRetention = currentRetention + (Math.random() * 0.4 - 0.2);
        retentionElement.textContent = Math.max(80, Math.min(95, newRetention)).toFixed(1) + '%';
    }
}

// Quick action button functionality
document.addEventListener('click', function(e) {
    if (e.target.textContent.includes('Invite Users')) {
        alert('Invite functionality would be implemented here. This could send email invitations to new users.');
    }
    
    if (e.target.textContent.includes('Bulk Actions')) {
        alert('Bulk actions functionality would be implemented here. This could include bulk editing, deletion, or permission changes.');
    }
    
    if (e.target.textContent.includes('User Reports')) {
        alert('User reports functionality would be implemented here. This could generate detailed user analytics reports.');
    }
    
    if (e.target.textContent.includes('Set Alerts')) {
        alert('Alert functionality would be implemented here. This could set up automated alerts for user activity or issues.');
    }
    
    if (e.target.textContent.includes('User Settings')) {
        alert('User settings functionality would be implemented here. This could configure user management preferences.');
    }
});

document.addEventListener('change', function(e) {
    if (e.target.tagName === 'SELECT' && e.target.closest('.chart-controls')) {
        const chartCard = e.target.closest('.chart-card');
        const chartBody = chartCard.querySelector('.chart-body');
        
        chartBody.innerHTML = '<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x text-primary"></i><p class="mt-2">Loading new data...</p></div>';
        
        setTimeout(() => {
            if (e.target.value === '7') {
                chartBody.innerHTML = '<canvas id="userGrowthChart" height="300"></canvas>';
                initializeUserGrowthChart();
            } else if (e.target.value === '30') {
                chartBody.innerHTML = '<canvas id="userGrowthChart" height="300"></canvas>';
                initializeUserGrowthChart();
            } else if (e.target.value === '90') {
                chartBody.innerHTML = '<canvas id="userGrowthChart" height="300"></canvas>';
                initializeUserGrowthChart();
            } else if (e.target.value === '365') {
                chartBody.innerHTML = '<canvas id="userGrowthChart" height="300"></canvas>';
                initializeUserGrowthChart();
            }
        }, 1000);
    }
}); 