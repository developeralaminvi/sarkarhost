/**
 * SARKAR HOST WORDPRESS THEME SCRIPT
 * 
 * Features:
 * - Dynamic Active Menu Detection & Highlighting
 * - Mobile Navigation Drawer & Accordion Dropdown Toggles
 * - Async Form Submission (Database Lead Saving + WhatsApp Launch)
 * - Modal Controls & Toast Notification System
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Highlight Active Menu Item based on current URL
    sarkarhostHighlightActiveMenu();

    // 2. Mobile Menu & Accordion Dropdown Logic
    initMobileNav();

    // 3. Scroll To Top Button
    initScrollToTop();

    // 4. Real-time Phone Number Validation
    initRealtimePhoneValidation();
});

/* ==========================================================================
   1. ACTIVE MENU HIGHLIGHTING
   ========================================================================== */
function sarkarhostHighlightActiveMenu() {
    const currentPath = window.location.pathname.replace(/\/$/, '') || '/';
    const currentUrl  = window.location.href.split('#')[0].replace(/\/$/, '');

    const navLinks = document.querySelectorAll('.nav-menu a');
    navLinks.forEach(link => {
        const linkHref = link.getAttribute('href');
        if (!linkHref || linkHref.startsWith('#')) return;

        const cleanLinkHref = link.href.split('#')[0].replace(/\/$/, '');
        const linkPath = new URL(link.href, window.location.origin).pathname.replace(/\/$/, '') || '/';

        // Check exact match or path match
        if (cleanLinkHref === currentUrl || (linkPath !== '/' && currentPath === linkPath)) {
            link.classList.add('active');
            const parentLi = link.closest('li');
            if (parentLi) {
                parentLi.classList.add('current-menu-item', 'active');
                
                // If it is inside a dropdown, highlight the parent dropdown item
                const parentDropdown = parentLi.closest('.has-dropdown, .menu-item-has-children');
                if (parentDropdown && parentDropdown !== parentLi) {
                    parentDropdown.classList.add('current-menu-ancestor', 'active-parent');
                    const parentLink = parentDropdown.querySelector(':scope > a, :scope > .nav-item-flex > a');
                    if (parentLink) parentLink.classList.add('active');
                }
            }
        }
    });
}

/* ==========================================================================
   2. MOBILE NAVIGATION & ACCORDION
   ========================================================================== */
function initMobileNav() {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const navMenu       = document.getElementById('navMenu');
    const overlay       = document.getElementById('mobileNavOverlay');

    if (!mobileMenuBtn || !navMenu) return;

    function toggleMenu(forceClose = false) {
        const isOpen = forceClose ? false : !navMenu.classList.contains('active');
        
        if (isOpen) {
            navMenu.classList.add('active');
            if (overlay) overlay.classList.add('active');
            document.body.classList.add('mobile-nav-open');
            const icon = mobileMenuBtn.querySelector('i');
            if (icon) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-xmark');
            }
        } else {
            navMenu.classList.remove('active');
            if (overlay) overlay.classList.remove('active');
            document.body.classList.remove('mobile-nav-open');
            const icon = mobileMenuBtn.querySelector('i');
            if (icon) {
                icon.classList.remove('fa-xmark');
                icon.classList.add('fa-bars');
            }
        }
    }

    mobileMenuBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        toggleMenu();
    });

    if (overlay) {
        overlay.addEventListener('click', () => toggleMenu(true));
    }

    // Mobile Accordion Submenu Toggles
    const dropdownItems = navMenu.querySelectorAll('.has-dropdown, .menu-item-has-children');
    dropdownItems.forEach(item => {
        const toggleBtn = item.querySelector('.mobile-submenu-toggle');
        const subMenu   = item.querySelector('.dropdown-menu, .sub-menu');

        if (toggleBtn && subMenu) {
            toggleBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const isExpanded = item.classList.contains('submenu-open');
                if (isExpanded) {
                    item.classList.remove('submenu-open');
                    subMenu.style.maxHeight = null;
                } else {
                    item.classList.add('submenu-open');
                    subMenu.style.maxHeight = subMenu.scrollHeight + 50 + 'px';
                }
            });
        }
    });

    // Close menu when clicking regular anchor links
    navMenu.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            const isDropdownParent = link.parentElement.classList.contains('has-dropdown') || 
                                     link.parentElement.classList.contains('menu-item-has-children') ||
                                     link.parentElement.classList.contains('nav-item-flex');
            
            // If it's a direct navigation link or hash link on mobile, close drawer
            if (!isDropdownParent || link.getAttribute('href').includes('#services-overview')) {
                toggleMenu(true);
            }
        });
    });
}

/* ==========================================================================
   3. SCROLL TO TOP
   ========================================================================== */
function initScrollToTop() {
    const scrollTopBtn = document.getElementById('scrollTopBtn');
    if (!scrollTopBtn) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            scrollTopBtn.classList.add('show');
        } else {
            scrollTopBtn.classList.remove('show');
        }
    });
}

function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

/* ==========================================================================
   4. MODAL CONTROLS
   ========================================================================== */
function openOrderModal(serviceName, ctaText) {
    const modal = document.getElementById('orderModal');
    const titleElem = document.getElementById('modalServiceTitle');
    const serviceInput = document.getElementById('selectedServiceName');

    if (modal && titleElem && serviceInput) {
        titleElem.textContent = ctaText || `Order ${serviceName}`;
        serviceInput.value = serviceName;
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }
}

function closeOrderModal() {
    const modal = document.getElementById('orderModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('click', (e) => {
    const modal = document.getElementById('orderModal');
    if (e.target === modal) {
        closeOrderModal();
    }
});

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        closeOrderModal();
    }
});

/* ==========================================================================
   5. REAL-TIME PHONE NUMBER VALIDATION & FEEDBACK
   ========================================================================== */
function initRealtimePhoneValidation() {
    const phoneInputs = document.querySelectorAll('input[type="tel"], input[id*="Phone"], input[name*="phone"]');
    
    phoneInputs.forEach(input => {
        // Ensure feedback container exists
        let feedback = input.parentElement.querySelector('.phone-validation-feedback');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'phone-validation-feedback';
            input.parentElement.appendChild(feedback);
        }

        function validate(showDetails = false) {
            const rawVal = input.value.trim();
            if (!rawVal) {
                input.classList.remove('is-invalid', 'is-valid');
                feedback.innerHTML = '';
                feedback.className = 'phone-validation-feedback';
                return true;
            }

            const clean = rawVal.replace(/[\s\-\(\)\+]/g, '');
            const bdRegex = /^(?:88)?01[3-9]\d{8}$/;
            const isMatch = bdRegex.test(clean);
            const last8 = clean.slice(-8);
            const isRepeating = /^(\d)\1{7}$/.test(last8);

            if (isMatch && !isRepeating) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
                feedback.className = 'phone-validation-feedback success';
                feedback.innerHTML = '<i class="fa-solid fa-circle-check"></i> <span>সঠিক বাংলাদেশী মোবাইল নম্বর ✓</span>';
                return true;
            } else if (showDetails || clean.length >= 11 || (clean.length > 2 && !clean.startsWith('01') && !clean.startsWith('8801'))) {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
                feedback.className = 'phone-validation-feedback error';

                if (clean.length > 2 && !clean.startsWith('01') && !clean.startsWith('8801')) {
                    feedback.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> <span>ভুল নম্বর! নম্বরটি অবশ্যই 013, 014, 015, 016, 017, 018 বা 019 দিয়ে শুরু হতে হবে।</span>';
                } else if (clean.length < 11) {
                    feedback.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> <span>১১টি ডিজিট আবশ্যক (বর্তমানে ' + clean.length + 'টি ডিজিট আছে)।</span>';
                } else if (isRepeating) {
                    feedback.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> <span>অনুগ্রহ করে একটি সঠিক ও সক্রিয় মোবাইল নম্বর দিন।</span>';
                } else {
                    feedback.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> <span>ভুল নম্বর! সঠিক ১১ ডিজিটের বাংলাদেশী মোবাইল নম্বর দিন (যেমন: 017XXXXXXXX)।</span>';
                }
                return false;
            } else {
                input.classList.remove('is-invalid', 'is-valid');
                feedback.innerHTML = '';
                feedback.className = 'phone-validation-feedback';
                return false;
            }
        }

        input.addEventListener('input', () => validate(false));
        input.addEventListener('blur', () => validate(true));
    });
}

/* ==========================================================================
   6. UNIFIED FORM SUBMIT: SAVE LEAD TO WP DB + OPEN WHATSAPP
   ========================================================================== */
function handleFormSubmit(event) {
    event.preventDefault();
    const form = event.target.closest('form');
    if (!form) return;

    const submitBtn = form.querySelector('button[type="submit"]');
    const origBtnHtml = submitBtn ? submitBtn.innerHTML : '';

    // Collect values from the current form
    const nameInput    = form.querySelector('input[id*="Name"], input[name*="name"]') || document.getElementById('clientName');
    const phoneInput   = form.querySelector('input[id*="Phone"], input[type="tel"], input[name*="phone"]') || document.getElementById('clientPhone');
    const serviceInput = form.querySelector('input[id*="Service"], select[id*="Service"]') || document.getElementById('selectedServiceName');
    const msgInput     = form.querySelector('textarea[id*="Message"], textarea') || document.getElementById('clientMessage');

    const name    = nameInput ? nameInput.value.trim() : '';
    const phone   = phoneInput ? phoneInput.value.trim() : '';
    const service = serviceInput ? serviceInput.value.trim() : 'General Inquiry';
    const message = msgInput ? msgInput.value.trim() : '';

    // 1. Honeypot Bot Check
    const honeyField = form.querySelector('input[name="sh_website_url"], input[name="honeypot"]');
    if (honeyField && honeyField.value.trim() !== '') {
        return; // Silent drop for spam bot
    }

    // 2. Name validation
    if (!name || name.length < 2) {
        if (nameInput) {
            nameInput.classList.add('is-invalid', 'input-shake');
            setTimeout(() => nameInput.classList.remove('input-shake'), 600);
            nameInput.focus();
        }
        sarkarhostShowToast('⚠️ অনুগ্রহ করে আপনার সঠিক নাম লিখুন।', 'error');
        return;
    }

    // 3. Spam Link & URL Blocker
    const spamUrlRegex = /(https?:\/\/|www\.|ftp:\/\/|[a-z0-9\-\_]+\.(com|net|org|xyz|ru|link|info|top|cn|online|site|biz|club|vip|cc|pw|icu|tk|ga|cf|gq|ml)|t\.me\/|telegram\.me|bit\.ly\/|tinyurl\.com|<a\s|\[url=)/i;
    if (spamUrlRegex.test(name) || spamUrlRegex.test(message) || spamUrlRegex.test(phone)) {
        sarkarhostShowToast('⚠️ স্প্যাম লিঙ্ক বা URL শেয়ার করা অনুমোদিত নয়। অনুগ্রহ করে লিংক ছাড়া মেসেজ লিখুন।', 'error');
        return;
    }

    // 4. Bangladesh Mobile Phone Validation (013, 014, 015, 016, 017, 018, 019)
    const cleanPhone = phone.replace(/[\s\-\(\)\+]/g, '');
    const bdPhoneRegex = /^(?:88)?01[3-9]\d{8}$/;
    const last8 = cleanPhone.slice(-8);
    const isRepeating = /^(\d)\1{7}$/.test(last8);

    if (!bdPhoneRegex.test(cleanPhone) || isRepeating) {
        if (phoneInput) {
            phoneInput.classList.remove('is-valid');
            phoneInput.classList.add('is-invalid', 'input-shake');
            setTimeout(() => phoneInput.classList.remove('input-shake'), 600);

            let feedback = phoneInput.parentElement.querySelector('.phone-validation-feedback');
            if (!feedback) {
                feedback = document.createElement('div');
                feedback.className = 'phone-validation-feedback error';
                phoneInput.parentElement.appendChild(feedback);
            }
            feedback.className = 'phone-validation-feedback error';
            feedback.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> <span>ভুল নম্বর! অনুগ্রহ করে সঠিক ১১ ডিজিটের বাংলাদেশী মোবাইল নম্বর দিন (যেমন: 017XXXXXXXX বা 013, 014, 015, 016, 017, 018, 019)।</span>';
            phoneInput.focus();
        }

        sarkarhostShowToast('⚠️ ভুল মোবাইল নম্বর! সঠিক ১১ ডিজিটের বাংলাদেশী মোবাইল নম্বর দিন (যেমন: 017XXXXXXXX)', 'error');
        return;
    }

    // Set Loading state on button
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> যাচাই ও সংরক্ষণ হচ্ছে...';
    }

    // Prepare WhatsApp Message
    const waNumber = (typeof sarkarHostData !== 'undefined' && sarkarHostData.whatsapp_num) ? sarkarHostData.whatsapp_num : '8801321222308';
    let waText = `*New Service Inquiry (Sarkar Host)*\n\n`;
    waText += `👤 *নাম:* ${name}\n`;
    waText += `📱 *ফোন:* ${phone}\n`;
    waText += `🛠️ *নির্বাচিত সেবা:* ${service}\n`;
    if (message) waText += `📝 *মেসেজ:* ${message}\n`;
    waText += `\nআমি এই সেবাটি সম্পর্কে বিস্তারিত জানতে ও শুরু করতে চাই।`;

    const encodedText = encodeURIComponent(waText);
    const cleanWaNumber = waNumber.replace(/[^0-9]/g, '');
    const whatsappUrl = `https://wa.me/${cleanWaNumber}?text=${encodedText}`;

    // Source determination
    const isModal = form.id === 'serviceOrderForm' || form.closest('#orderModal');
    const sourceTag = isModal ? 'Service Request (Modal: ' + service + ')' : 'Contact Page Form';

    // Send AJAX to WordPress backend
    if (typeof sarkarHostData !== 'undefined' && sarkarHostData.ajax_url) {
        const formData = new FormData();
        formData.append('action', 'sarkarhost_submit_form');
        formData.append('nonce', sarkarHostData.nonce || '');
        formData.append('name', name);
        formData.append('phone', phone);
        formData.append('service', service);
        formData.append('message', message);
        formData.append('source', sourceTag);
        formData.append('page_url', window.location.href);

        fetch(sarkarHostData.ajax_url, {
            method: 'POST',
            body: formData,
        })
        .then(res => res.json())
        .then(data => {
            // Restore button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = origBtnHtml;
            }

            if (data.success) {
                // Show Success Toast
                sarkarhostShowToast('✓ তথ্য সফলভাবে সংরক্ষণ ও ইমেইলে প্রেরণ হয়েছে! WhatsApp ওপেন হচ্ছে...', 'success');

                // Open WhatsApp
                window.open(whatsappUrl, '_blank');

                // Reset and close modal
                form.reset();
                if (phoneInput) {
                    phoneInput.classList.remove('is-valid', 'is-invalid');
                    const feedback = phoneInput.parentElement.querySelector('.phone-validation-feedback');
                    if (feedback) feedback.innerHTML = '';
                }
                closeOrderModal();
            } else {
                // Show Error Toast from Backend
                const errMsg = (data.data && data.data.message) ? data.data.message : 'ত্রুটি দেখা দিয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।';
                sarkarhostShowToast(errMsg, 'error');
            }
        })
        .catch(err => {
            console.error('Lead submission error:', err);
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = origBtnHtml;
            }
            window.open(whatsappUrl, '_blank');
            form.reset();
            closeOrderModal();
        });
    } else {
        // Fallback if no ajax
        window.open(whatsappUrl, '_blank');
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = origBtnHtml;
        }
        form.reset();
        closeOrderModal();
    }
}

/* ==========================================================================
   7. TOAST NOTIFICATION UTILITY
   ========================================================================== */
function sarkarhostShowToast(message, type = 'success') {
    let toast = document.getElementById('shToast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'shToast';
        toast.className = 'sh-toast';
        document.body.appendChild(toast);
    }

    toast.className = `sh-toast show ${type}`;
    const iconClass = (type === 'error') ? 'fa-solid fa-triangle-exclamation' : 'fa-solid fa-circle-check';
    toast.innerHTML = `<i class="${iconClass}"></i> <span>${message}</span>`;

    setTimeout(() => {
        toast.classList.remove('show');
    }, 5000);
}
