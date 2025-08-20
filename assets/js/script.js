// Soft UI Admin Dashboard - Custom JavaScript

document.addEventListener('DOMContentLoaded', function() {

    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }

    if (toggleConfirmPassword && confirmPasswordInput) {
        toggleConfirmPassword.addEventListener('click', function() {
            const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPasswordInput.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye');
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });
    }

    // Form submission handling
    const loginForm = document.querySelector('.login-form');
    const signupForm = document.querySelector('.signup-form');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            // Add loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Signing In...';
            submitBtn.disabled = true;

            // Simulate login process
            setTimeout(() => {
                // Here you would typically make an API call
                console.log('Login attempt:', { email, password });
                
                // For demo purposes, show success
                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Success!';
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-success');
                
                // Redirect to dashboard after 1 second
                setTimeout(() => {
                    window.location.href = 'dashboard.html';
                }, 1000);
            }, 2000);
        });
    }

    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const firstName = document.getElementById('firstName').value;
            const lastName = document.getElementById('lastName').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            
            // Basic validation
            if (password !== confirmPassword) {
                alert('Passwords do not match!');
                return;
            }
            
            // Add loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Creating Account...';
            submitBtn.disabled = true;

            // Simulate signup process
            setTimeout(() => {
                // Here you would typically make an API call
                console.log('Signup attempt:', { firstName, lastName, email, password });
                
                // For demo purposes, show success
                submitBtn.innerHTML = '<i class="fas fa-check me-2"></i>Account Created!';
                submitBtn.classList.remove('btn-primary');
                submitBtn.classList.add('btn-success');
                
                // Redirect to login after 1 second
                setTimeout(() => {
                    window.location.href = 'index.html';
                }, 1000);
            }, 2000);
        });
    }

    // Social login buttons
    const socialButtons = document.querySelectorAll('.btn-outline-secondary');
    socialButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const provider = this.textContent.includes('Google') ? 'Google' : 'GitHub';
            
            // Add loading state
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Connecting...';
            this.disabled = true;

            // Simulate social login
            setTimeout(() => {
                console.log(`Connecting with ${provider}...`);
                this.innerHTML = originalText;
                this.disabled = false;
                alert(`${provider} login functionality would be implemented here.`);
            }, 1500);
        });
    });

    // Add smooth animations to form elements
    const formElements = document.querySelectorAll('.form-control, .btn');
    formElements.forEach(element => {
        element.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
        });
        
        element.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
        });
    });

    // Add hover effects to feature items
    const featureItems = document.querySelectorAll('.feature-item');
    featureItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Form validation feedback
    const inputs = document.querySelectorAll('input[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                this.classList.remove('is-invalid');
            }
        });
    });

    // Password strength indicator (for signup page)
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            const strength = getPasswordStrength(password);
            updatePasswordStrengthIndicator(strength);
        });
    }
});

// Password strength checker
function getPasswordStrength(password) {
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    return strength;
}

function updatePasswordStrengthIndicator(strength) {
    const strengthIndicator = document.getElementById('password-strength');
    if (!strengthIndicator) return;
    
    const strengthText = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
    const strengthColors = ['danger', 'warning', 'info', 'primary', 'success'];
    
    strengthIndicator.textContent = strengthText[strength - 1] || 'Very Weak';
    strengthIndicator.className = `badge bg-${strengthColors[strength - 1] || 'danger'}`;
}

// Mobile sidebar functionality
function initializeMobileSidebar() {
    // Wait for DOM to be fully loaded
    setTimeout(function() {
        const mobileSidebarToggle = document.querySelector('.mobile-sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        const mobileClose = document.querySelector('.mobile-close');
        
        console.log('Mobile sidebar elements found:', {
            mobileSidebarToggle: !!mobileSidebarToggle,
            sidebarOverlay: !!sidebarOverlay,
            mobileClose: !!mobileClose,
            sidebar: !!sidebar
        });
        
        // If elements don't exist, return early
        // if (!mobileSidebarToggle || !sidebar || !sidebarOverlay) {
        //     console.log('Required sidebar elements not found, skipping initialization');
        //     return;
        // }
        
        // let isAnimating = false;

        // function showSidebar() {
        //     if (isAnimating) return;
        //     isAnimating = true;

        //     console.log('Opening sidebar');
        //     sidebar.classList.add('show');
        //     sidebar.style.transform = 'translateX(0)';
        //     sidebar.style.zIndex = '1050';
        //     sidebarOverlay.classList.add('show');
        //     document.body.style.overflow = 'hidden';

        //     setTimeout(() => {
        //         isAnimating = false;
        //     }, 300);
        // }
        // function hideSidebar() {
        //     if (isAnimating) return;
        //     isAnimating = true;
            
        //     console.log('Closing sidebar');
        //     sidebar.classList.remove('show');
        //     sidebar.style.transform = 'translateX(-100%)';
        //     sidebarOverlay.classList.remove('show');
        //     document.body.style.overflow = '';
            
        //     setTimeout(() => {
        //         isAnimating = false;
        //     }, 100);
        // }
        
        // function handleResize() {
        //     if (window.innerWidth >= 992) {
        //         hideSidebar();
        //         sidebar.style.transform = '';
        //         sidebar.style.zIndex = '';
        //     }
        // }
        
        // Mobile toggle button - only respond to click events
        mobileSidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Mobile sidebar toggle clicked');
            
            if (sidebar.classList.contains('show')) {
                hideSidebar();
            } else {
                showSidebar();
            }
        });
        
        // Mobile close button
        if (mobileClose) {
            mobileClose.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Mobile close button clicked');
                hideSidebar();
            });
        }
        
        // Overlay click - close sidebar when clicking outside
        sidebarOverlay.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            console.log('Sidebar overlay clicked');
            hideSidebar();
        });
        
        // Close sidebar when clicking outside on mobile (document click)
        document.addEventListener('click', function(e) {
            // Only on mobile screens
            if (window.innerWidth <= 991.98 && sidebar.classList.contains('show')) {
                // Check if click is not inside sidebar or toggle button
                if (!sidebar.contains(e.target) && !mobileSidebarToggle.contains(e.target)) {
                    console.log('Clicked outside sidebar, closing');
                    hideSidebar();
                }
            }
        });
        
        // Prevent sidebar clicks from closing the sidebar
        sidebar.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        // Handle window resize
        window.addEventListener('resize', handleResize);
        
        // Handle escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && sidebar.classList.contains('show')) {
                hideSidebar();
            }
        });
        
        // Close sidebar when clicking menu items on mobile (but with delay)
        const sidebarLinks = sidebar.querySelectorAll('.nav-link, .submenu a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 991.98 && sidebar.classList.contains('show')) {
                    // Only close if it's actually a navigation link (has href)
                    if (this.getAttribute('href') && this.getAttribute('href') !== '#') {
                        setTimeout(() => hideSidebar(), 150);
                    }
                }
            });
        });
        
        // Initial resize check
        handleResize();
    }, 100);
}

// Dark mode toggle functionality
function initializeDarkMode() {
    const modeToggle = document.querySelector('.mode-toggle');
    const toggleSwitch = document.querySelector('.toggle-switch');
    
    // Load saved theme preference
    const savedTheme = localStorage.getItem('theme') || 'light';
    applyTheme(savedTheme);
    
    if (modeToggle && toggleSwitch) {
        modeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const currentTheme = document.body.classList.contains('dark-theme') ? 'dark' : 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            applyTheme(newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }
}

function applyTheme(theme) {
    const body = document.body;
    const toggleSwitch = document.querySelector('.toggle-switch');
    
    if (theme === 'dark') {
        body.classList.add('dark-theme');
        if (toggleSwitch) {
            toggleSwitch.classList.add('active');
        }
    } else {
        body.classList.remove('dark-theme');
        if (toggleSwitch) {
            toggleSwitch.classList.remove('active');
        }
    }
}

// Search functionality
function initializeSearch() {
    const searchInputs = document.querySelectorAll('.search-input');
    searchInputs.forEach(input => {
        input.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            // Add search functionality here based on the page
            console.log('Searching for:', searchTerm);
        });
    });
}

// Notification functionality
function initializeNotifications() {
    const notificationBells = document.querySelectorAll('.notification-bell');
    const messageIcons = document.querySelectorAll('.message-icon');
    
    notificationBells.forEach(bell => {
        bell.addEventListener('click', function() {
            showNotification('Notification functionality would be implemented here', 'info');
        });
    });
    
    messageIcons.forEach(icon => {
        icon.addEventListener('click', function() {
            showNotification('Message functionality would be implemented here', 'info');
        });
    });
}

// Utility function to show notifications
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// User profile dropdown functionality
function initializeUserProfile() {
    const userProfiles = document.querySelectorAll('.user-profile');
    
    userProfiles.forEach(profile => {
        profile.addEventListener('click', function(e) {
            e.preventDefault();
            showNotification('User profile menu would be implemented here', 'info');
        });
    });
}

// Form interactions for all pages
function initializeFormInteractions() {
    // Add loading states to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => {
        if (!button.classList.contains('mobile-sidebar-toggle') && 
            !button.classList.contains('mobile-close') &&
            !button.querySelector('.fa-spinner')) {
            
            button.addEventListener('click', function(e) {
                if (this.type === 'submit' || this.textContent.includes('Save') || 
                    this.textContent.includes('Submit') || this.textContent.includes('Update')) {
                    
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                    this.disabled = true;
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }, 2000);
                }
            });
        }
    });
    
    // Enhanced form validation
    const inputs = document.querySelectorAll('input, textarea, select');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                validateField(this);
            }
        });
    });
}

function validateField(field) {
    field.classList.remove('is-valid', 'is-invalid');
    
    if (field.hasAttribute('required') && !field.value.trim()) {
        field.classList.add('is-invalid');
        return false;
    }
    
    if (field.type === 'email' && field.value) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(field.value)) {
            field.classList.add('is-invalid');
            return false;
        }
    }
    
    if (field.value.trim()) {
        field.classList.add('is-valid');
    }
    
    return true;
}

// Initialize all functionality when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeMobileSidebar();
    initializeDarkMode();
    initializeSearch();
    initializeNotifications();
    initializeUserProfile();
    initializeFormInteractions();
}); 