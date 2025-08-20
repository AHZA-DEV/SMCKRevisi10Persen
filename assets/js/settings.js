// Settings Page JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Initialize settings functionality
    initializeSettings();
    
    // Initialize form validation
    initializeFormValidation();
    
    // Initialize theme preview
    initializeThemePreview();
});

// Initialize settings functionality
function initializeSettings() {
    // Save settings button
    const saveButton = document.getElementById('saveSettings');
    if (saveButton) {
        saveButton.addEventListener('click', saveAllSettings);
    }
    
    // Reset settings button
    const resetButton = document.getElementById('resetSettings');
    if (resetButton) {
        resetButton.addEventListener('click', resetToDefaults);
    }
    
    // Initialize all form switches
    initializeFormSwitches();
    
    // Initialize form inputs
    initializeFormInputs();
    
    // Initialize tab functionality
    initializeTabs();
}

// Initialize form switches
function initializeFormSwitches() {
    const switches = document.querySelectorAll('.form-check-input[type="checkbox"]');
    switches.forEach(switchElement => {
        switchElement.addEventListener('change', function() {
            handleSettingChange(this.id, this.checked);
        });
    });
}

// Initialize form inputs
function initializeFormInputs() {
    const inputs = document.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.addEventListener('change', function() {
            handleSettingChange(this.id || this.name, this.value);
        });
        
        input.addEventListener('blur', function() {
            validateInput(this);
        });
    });
}

// Initialize tabs
function initializeTabs() {
    const tabButtons = document.querySelectorAll('[data-bs-toggle="pill"]');
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-bs-target');
            showTab(targetId);
        });
    });
}

// Show specific tab
function showTab(tabId) {
    // Hide all tab panes
    const tabPanes = document.querySelectorAll('.tab-pane');
    tabPanes.forEach(pane => {
        pane.classList.remove('show', 'active');
    });
    
    // Remove active class from all tab buttons
    const tabButtons = document.querySelectorAll('.nav-link');
    tabButtons.forEach(button => {
        button.classList.remove('active');
    });
    
    // Show target tab pane
    const targetPane = document.querySelector(tabId);
    if (targetPane) {
        targetPane.classList.add('show', 'active');
    }
    
    // Activate target tab button
    const targetButton = document.querySelector(`[data-bs-target="${tabId}"]`);
    if (targetButton) {
        targetButton.classList.add('active');
    }
}

// Handle setting changes
function handleSettingChange(settingId, value) {
    console.log(`Setting changed: ${settingId} = ${value}`);
    
    // Show unsaved changes indicator
    showUnsavedChangesIndicator();
    
    // Store setting in local storage for persistence
    localStorage.setItem(`setting_${settingId}`, JSON.stringify(value));
    
    // Apply immediate changes if needed
    applyImmediateSetting(settingId, value);
}

// Apply immediate setting changes
function applyImmediateSetting(settingId, value) {
    switch(settingId) {
        case 'themeSelector':
            applyTheme(value);
            break;
        case 'colorScheme':
            applyColorScheme(value);
            break;
        case 'fontSize':
            applyFontSize(value);
            break;
        case 'compactMode':
            applyCompactMode(value);
            break;
        case 'animationSpeed':
            applyAnimationSpeed(value);
            break;
        case 'twoFactorAuth':
            updateSecurityStatus('2FA', value);
            break;
        case 'sessionTimeout':
            updateSecurityStatus('Session', value);
            break;
        case 'loginNotifications':
            updateSecurityStatus('Notifications', value);
            break;
        case 'ipWhitelist':
            updateSecurityStatus('IP Whitelist', value);
            break;
        case 'passwordPolicy':
            updateSecurityStatus('Password Policy', value);
            break;
        case 'rateLimiting':
            updateSecurityStatus('Rate Limiting', value);
            break;
    }
}

// Apply theme
function applyTheme(theme) {
    document.body.className = `dashboard-page ${theme}-theme`;
    
    // Update theme toggle switch
    const themeToggle = document.querySelector('.mode-toggle .toggle-switch');
    if (themeToggle) {
        if (theme === 'dark') {
            themeToggle.classList.add('active');
        } else {
            themeToggle.classList.remove('active');
        }
    }
    
    // Store theme preference
    localStorage.setItem('theme', theme);
}

// Apply color scheme
function applyColorScheme(scheme) {
    const root = document.documentElement;
    
    // Remove existing color scheme classes
    root.classList.remove('color-blue', 'color-green', 'color-purple', 'color-orange', 'color-red');
    
    // Add new color scheme class
    root.classList.add(`color-${scheme}`);
    
    // Store color scheme preference
    localStorage.setItem('colorScheme', scheme);
}

// Apply font size
function applyFontSize(size) {
    const root = document.documentElement;
    
    // Remove existing font size classes
    root.classList.remove('font-small', 'font-medium', 'font-large', 'font-xlarge');
    
    // Add new font size class
    root.classList.add(`font-${size}`);
    
    // Store font size preference
    localStorage.setItem('fontSize', size);
}

// Apply compact mode
function applyCompactMode(enabled) {
    if (enabled) {
        document.body.classList.add('compact-mode');
    } else {
        document.body.classList.remove('compact-mode');
    }
    
    // Store compact mode preference
    localStorage.setItem('compactMode', enabled);
}

// Apply animation speed
function applyAnimationSpeed(speed) {
    const root = document.documentElement;
    
    // Remove existing animation speed classes
    root.classList.remove('animation-slow', 'animation-normal', 'animation-fast', 'animation-none');
    
    // Add new animation speed class
    root.classList.add(`animation-${speed}`);
    
    // Store animation speed preference
    localStorage.setItem('animationSpeed', speed);
}

// Update security status
function updateSecurityStatus(type, enabled) {
    console.log(`${type} ${enabled ? 'enabled' : 'disabled'}`);
    
    // You can add additional security status updates here
    // For example, updating UI indicators or sending notifications
}

// Show unsaved changes indicator
function showUnsavedChangesIndicator() {
    const saveButton = document.getElementById('saveSettings');
    if (saveButton) {
        saveButton.innerHTML = '<i class="fas fa-save me-2"></i>Save All Settings *';
        saveButton.classList.add('btn-warning');
        saveButton.classList.remove('btn-primary');
    }
}

// Hide unsaved changes indicator
function hideUnsavedChangesIndicator() {
    const saveButton = document.getElementById('saveSettings');
    if (saveButton) {
        saveButton.innerHTML = '<i class="fas fa-save me-2"></i>Save All Settings';
        saveButton.classList.remove('btn-warning');
        saveButton.classList.add('btn-primary');
    }
}

// Save all settings
function saveAllSettings() {
    // Show loading state
    const saveButton = document.getElementById('saveSettings');
    if (saveButton) {
        const originalText = saveButton.innerHTML;
        saveButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Saving...';
        saveButton.disabled = true;
        
        // Simulate save process
        setTimeout(() => {
            saveButton.innerHTML = originalText;
            saveButton.disabled = false;
            
            // Hide unsaved changes indicator
            hideUnsavedChangesIndicator();
            
            // Show success message
            showSuccessMessage('Settings saved successfully!');
            
            // Reload settings from server (in real app)
            // reloadSettingsFromServer();
        }, 2000);
    }
}

// Reset to defaults
function resetToDefaults() {
    if (confirm('Are you sure you want to reset all settings to their default values? This action cannot be undone.')) {
        // Show loading state
        const resetButton = document.getElementById('resetSettings');
        if (resetButton) {
            const originalText = resetButton.innerHTML;
            resetButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Resetting...';
            resetButton.disabled = true;
            
            // Simulate reset process
            setTimeout(() => {
                resetButton.innerHTML = originalText;
                resetButton.disabled = false;
                
                // Reset all form elements to defaults
                resetAllFormElements();
                
                // Hide unsaved changes indicator
                hideUnsavedChangesIndicator();
                
                // Show success message
                showSuccessMessage('Settings reset to defaults successfully!');
            }, 1500);
        }
    }
}

// Reset all form elements to defaults
function resetAllFormElements() {
    // Reset checkboxes
    const checkboxes = document.querySelectorAll('.form-check-input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        if (checkbox.id === 'twoFactorAuth' || checkbox.id === 'sessionTimeout' || 
            checkbox.id === 'loginNotifications' || checkbox.id === 'passwordPolicy' || 
            checkbox.id === 'rateLimiting') {
            checkbox.checked = true;
        } else {
            checkbox.checked = false;
        }
    });
    
    // Reset select elements
    const selects = document.querySelectorAll('.form-select');
    selects.forEach(select => {
        if (select.id === 'themeSelector') {
            select.value = 'light';
        } else if (select.id === 'colorScheme') {
            select.value = 'blue';
        } else if (select.id === 'fontSize') {
            select.value = 'medium';
        } else if (select.id === 'animationSpeed') {
            select.value = 'normal';
        }
    });
    
    // Reset input fields
    const inputs = document.querySelectorAll('.form-control[type="text"], .form-control[type="email"], .form-control[type="tel"]');
    inputs.forEach(input => {
        if (input.placeholder.includes('company name')) {
            input.value = 'Soft UI Philippines';
        } else if (input.placeholder.includes('contact email')) {
            input.value = 'admin@softui.ph';
        } else if (input.placeholder.includes('contact phone')) {
            input.value = '+63 2 8123 4567';
        }
    });
    
    // Reset textarea
    const textarea = document.querySelector('textarea');
    if (textarea) {
        textarea.value = '123 Business District, Makati, Metro Manila, Philippines';
    }
    
    // Apply default settings
    applyTheme('light');
    applyColorScheme('blue');
    applyFontSize('medium');
    applyCompactMode(false);
    applyAnimationSpeed('normal');
}

// Initialize form validation
function initializeFormValidation() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            if (validateForm(this)) {
                saveAllSettings();
            }
        });
    });
}

// Validate form
function validateForm(form) {
    let isValid = true;
    const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
    
    inputs.forEach(input => {
        if (!validateInput(input)) {
            isValid = false;
        }
    });
    
    return isValid;
}

// Validate individual input
function validateInput(input) {
    const value = input.value.trim();
    let isValid = true;
    
    // Remove existing validation classes
    input.classList.remove('is-valid', 'is-invalid');
    
    // Check if required field is empty
    if (input.hasAttribute('required') && !value) {
        input.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validate email format
    if (input.type === 'email' && value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            input.classList.add('is-invalid');
            isValid = false;
        }
    }
    
    // Validate phone format
    if (input.type === 'tel' && value) {
        const phoneRegex = /^[\+]?[0-9\s\-\(\)]+$/;
        if (!phoneRegex.test(value)) {
            input.classList.add('is-invalid');
            isValid = false;
        }
    }
    
    // Add valid class if input is valid
    if (isValid && value) {
        input.classList.add('is-valid');
    }
    
    return isValid;
}

// Initialize theme preview
function initializeThemePreview() {
    const themeSelector = document.getElementById('themeSelector');
    if (themeSelector) {
        themeSelector.addEventListener('change', function() {
            updateThemePreview(this.value);
        });
    }
    
    const colorScheme = document.getElementById('colorScheme');
    if (colorScheme) {
        colorScheme.addEventListener('change', function() {
            updateThemePreview(themeSelector.value, this.value);
        });
    }
}

// Update theme preview
function updateThemePreview(theme, colorScheme = 'blue') {
    const preview = document.querySelector('.theme-preview');
    if (preview) {
        // Remove existing theme classes
        preview.classList.remove('theme-light', 'theme-dark', 'color-blue', 'color-green', 'color-purple', 'color-orange', 'color-red');
        
        // Add new theme and color classes
        preview.classList.add(`theme-${theme}`, `color-${colorScheme}`);
    }
}

// Show success message
function showSuccessMessage(message) {
    // Create success alert
    const alertDiv = document.createElement('div');
    alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <i class="fas fa-check-circle me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    // Add to page
    document.body.appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Load saved settings from localStorage
function loadSavedSettings() {
    const savedSettings = {};
    
    // Load all saved settings
    for (let i = 0; i < localStorage.length; i++) {
        const key = localStorage.key(i);
        if (key.startsWith('setting_')) {
            const settingId = key.replace('setting_', '');
            const value = JSON.parse(localStorage.getItem(key));
            savedSettings[settingId] = value;
        }
    }
    
    // Apply saved settings
    Object.keys(savedSettings).forEach(settingId => {
        const value = savedSettings[settingId];
        const element = document.getElementById(settingId);
        if (element) {
            if (element.type === 'checkbox') {
                element.checked = value;
            } else {
                element.value = value;
            }
            applyImmediateSetting(settingId, value);
        }
    });
    
    // Load other preferences
    const theme = localStorage.getItem('theme') || 'light';
    const colorScheme = localStorage.getItem('colorScheme') || 'blue';
    const fontSize = localStorage.getItem('fontSize') || 'medium';
    const compactMode = localStorage.getItem('compactMode') === 'true';
    const animationSpeed = localStorage.getItem('animationSpeed') || 'normal';
    
    applyTheme(theme);
    applyColorScheme(colorScheme);
    applyFontSize(fontSize);
    applyCompactMode(compactMode);
    applyAnimationSpeed(animationSpeed);
}

// Load settings when page loads
document.addEventListener('DOMContentLoaded', function() {
    loadSavedSettings();
});

// Handle form submission
document.addEventListener('submit', function(e) {
    if (e.target.tagName === 'FORM') {
        e.preventDefault();
        saveAllSettings();
    }
});

// Handle quick action buttons
document.addEventListener('click', function(e) {
    if (e.target.textContent.includes('Check for Updates')) {
        checkForUpdates();
    }
    
    if (e.target.textContent.includes('Download Logs')) {
        downloadLogs();
    }
    
    if (e.target.textContent.includes('View All Logs')) {
        viewAllLogs();
    }
    
    if (e.target.textContent.includes('Run Health Check')) {
        runHealthCheck();
    }
    
    if (e.target.textContent.includes('Optimize System')) {
        optimizeSystem();
    }
});

// Check for updates
function checkForUpdates() {
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Checking...';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        showSuccessMessage('System is up to date!');
    }, 2000);
}

// Download logs
function downloadLogs() {
    showSuccessMessage('Logs download started...');
}

// View all logs
function viewAllLogs() {
    showSuccessMessage('Opening logs viewer...');
}

// Run health check
function runHealthCheck() {
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Running...';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        showSuccessMessage('Health check completed successfully!');
    }, 3000);
}

// Optimize system
function optimizeSystem() {
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Optimizing...';
    button.disabled = true;
    
    setTimeout(() => {
        button.innerHTML = originalText;
        button.disabled = false;
        showSuccessMessage('System optimization completed!');
    }, 4000);
} 