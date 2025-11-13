/**
 * Getlead Partner Website - JavaScript
 * Handles interactivity, form submissions, and animations
 */

// ============================================
// Document Ready
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    initScrollAnimations();
    initFormHandlers();
    initNavigation();
});

// ============================================
// Scroll Animations
// ============================================

function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    // Observe benefit cards
    document.querySelectorAll('.benefit-card').forEach(card => {
        observer.observe(card);
    });

    // Observe program cards
    document.querySelectorAll('.program-card').forEach(card => {
        observer.observe(card);
    });

    // Observe timeline items
    document.querySelectorAll('.timeline-item').forEach(item => {
        observer.observe(item);
    });
}

// ============================================
// Form Handlers
// ============================================

function initFormHandlers() {
    // Contact Form Handler
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', handleContactFormSubmit);
    }

    // Partner Modal Form Handler
    const partnerForm = document.getElementById('partnerForm');
    if (partnerForm) {
        partnerForm.addEventListener('submit', handlePartnerFormSubmit);
    }
}

/**
 * Handle Contact Form Submission
 */
function handleContactFormSubmit(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = {
        name: formData.get('name'),
        email: formData.get('email'),
        company: formData.get('company'),
        message: formData.get('message')
    };

    // Validate form data
    if (!data.name || !data.email || !data.company) {
        showNotification('Please fill in all required fields', 'error');
        return;
    }

    // Validate email
    if (!isValidEmail(data.email)) {
        showNotification('Please enter a valid email address', 'error');
        return;
    }

    // Simulate form submission (replace with actual API call)
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Sending...';

    // Simulate API call delay
    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;

        showNotification('Message sent successfully! We\'ll contact you soon.', 'success');
        this.reset();
    }, 1500);
}

/**
 * Handle Partner Modal Form Submission
 */
function handlePartnerFormSubmit(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = {
        name: formData.get('pname'),
        email: formData.get('pemail'),
        company: formData.get('pcompany'),
        program: formData.get('pprogram'),
        terms: document.getElementById('terms').checked
    };

    // Validate form data
    if (!data.name || !data.email || !data.company || !data.program) {
        showNotification('Please fill in all required fields', 'error');
        return;
    }

    if (!data.terms) {
        showNotification('Please accept the terms and conditions', 'error');
        return;
    }

    if (!isValidEmail(data.email)) {
        showNotification('Please enter a valid email address', 'error');
        return;
    }

    // Simulate form submission
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Submitting...';

    setTimeout(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = originalText;

        showNotification('Application submitted successfully! Check your email for next steps.', 'success');
        this.reset();

        // Close modal
        const modal = bootstrap.Modal.getInstance(document.getElementById('partnerModal'));
        if (modal) {
            modal.hide();
        }
    }, 1500);
}

// ============================================
// Utility Functions
// ============================================

/**
 * Validate email format
 */
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

/**
 * Show notification toast
 */
function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'error' ? 'danger' : type === 'success' ? 'success' : 'info'} position-fixed`;
    notification.style.cssText = `
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideIn 0.3s ease-out;
    `;
    notification.setAttribute('role', 'alert');

    // Set appropriate icon
    let icon = '✓';
    if (type === 'error') icon = '✕';
    if (type === 'info') icon = 'ℹ';

    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <span style="font-weight: bold; margin-right: 10px;">${icon}</span>
            <span>${message}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" style="margin-left: auto;"></button>
        </div>
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease-out forwards';
        setTimeout(() => notification.remove(), 300);
    }, 5000);
}

// ============================================
// Navigation
// ============================================

function initNavigation() {
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Check if link is internal (has href starting with #)
            const href = this.getAttribute('href');
            if (href && href.startsWith('#') && href !== '#') {
                e.preventDefault();

                const target = document.querySelector(href);
                if (target) {
                    // Close navbar if open
                    const navbar = document.querySelector('.navbar-collapse');
                    if (navbar && navbar.classList.contains('show')) {
                        const navbarToggler = document.querySelector('.navbar-toggler');
                        navbarToggler.click();
                    }

                    // Scroll to target
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });
}

// ============================================
// Smooth Scroll Enhancement
// ============================================

/**
 * Add smooth scroll to hash links
 */
window.addEventListener('hashchange', function() {
    const target = document.querySelector(window.location.hash);
    if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
});

// ============================================
// Navbar Styling on Scroll
// ============================================

window.addEventListener('scroll', function() {
    const navbar = document.querySelector('.navbar');
    if (window.scrollY > 50) {
        navbar.style.boxShadow = '0 2px 12px rgba(0, 0, 0, 0.1)';
    } else {
        navbar.style.boxShadow = '0 2px 8px rgba(0, 0, 0, 0.08)';
    }
});

// ============================================
// Animations & Effects
// ============================================

/**
 * Add CSS for animations if not already present
 */
function addAnimationStyles() {
    if (!document.getElementById('animation-styles')) {
        const style = document.createElement('style');
        style.id = 'animation-styles';
        style.innerHTML = `
            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateX(400px);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes slideOut {
                from {
                    opacity: 1;
                    transform: translateX(0);
                }
                to {
                    opacity: 0;
                    transform: translateX(400px);
                }
            }

            .spinner-border {
                display: inline-block;
                width: 1rem;
                height: 1rem;
                vertical-align: text-bottom;
                border: 0.25em solid currentColor;
                border-right-color: transparent;
                border-radius: 50%;
                animation: spinner-border 0.75s linear infinite;
            }

            .spinner-border-sm {
                width: 0.875rem;
                height: 0.875rem;
                border-width: 0.2em;
            }

            @keyframes spinner-border {
                to { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    }
}

// Initialize animation styles when DOM is ready
document.addEventListener('DOMContentLoaded', addAnimationStyles);

// ============================================
// Analytics & Tracking (Optional)
// ============================================

/**
 * Track button clicks for analytics
 */
function trackEvent(eventName, eventData = {}) {
    // Replace with your analytics solution (Google Analytics, etc.)
    console.log('Event:', eventName, eventData);
}

// Track button clicks
document.querySelectorAll('button, a.btn').forEach(element => {
    element.addEventListener('click', function() {
        const trackingId = this.getAttribute('data-track') || this.textContent.trim();
        trackEvent('click', { element: trackingId });
    });
});

// ============================================
// Service Worker (Optional for PWA)
// ============================================

if ('serviceWorker' in navigator) {
    // Uncomment to register service worker
    // window.addEventListener('load', () => {
    //     navigator.serviceWorker.register('sw.js');
    // });
}

// ============================================
// Initialization Complete
// ============================================

console.log('Getlead Partner Website loaded successfully');
