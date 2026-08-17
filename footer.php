<?php
/**
 * Sarkar Host Footer Template
 */

$phone = sarkarhost_get_opt('sarkarhost_phone', '01321-222308');
$wa = sarkarhost_get_opt('sarkarhost_whatsapp', '8801321222308');
?>

<!-- Footer -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-top-grid">
            <!-- Col 1 -->
            <div class="footer-col footer-col-brand">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-logo footer-logo">
                    <img src="https://sarkarhost.com/wp-content/uploads/2026/08/sarkar-host-logo.png" 
                         alt="<?php bloginfo('name'); ?>" 
                         class="main-site-logo footer-site-logo"
                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <div class="logo-fallback" style="display: none;">
                        <div class="logo-icon"><i class="fa-solid fa-server"></i></div>
                        <div class="logo-text"><span class="logo-main">SARKAR<span>HOST</span></span></div>
                    </div>
                </a>
                <p class="footer-desc">
                    Sarkar Host দিচ্ছে প্রফেশনাল এসইও (SEO), আধুনিক ওয়েব ও অ্যাপ ডেভেলপমেন্ট, ডিজিটাল মার্কেটিং, ডোমেইন, সুপারফাস্ট হোস্টিং ও প্রিমিয়াম গ্রাফিক্স ডিজাইন সেবা।
                </p>
                <div class="footer-social-links">
                    <a href="https://facebook.com" target="_blank" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa)); ?>" target="_blank" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                    <a href="https://linkedin.com" target="_blank" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="https://youtube.com" target="_blank" aria-label="YouTube"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <!-- Col 2 -->
            <div class="footer-col">
                <h4 class="footer-heading">সেবাসমূহের পেজ</h4>
                <?php
                if (has_nav_menu('footer_services_menu')) {
                    wp_nav_menu([
                        'theme_location' => 'footer_services_menu',
                        'container'      => false,
                        'menu_class'     => 'footer-links',
                    ]);
                } else {
                    ?>
                    <ul class="footer-links">
                        <li><a href="<?php echo esc_url(home_url('/seo-service/')); ?>">Professional SEO Service</a></li>
                        <li><a href="<?php echo esc_url(home_url('/web-development/')); ?>">Web & App Development</a></li>
                        <li><a href="<?php echo esc_url(home_url('/hosting-domain/')); ?>">Domain & BDIX Hosting</a></li>
                        <li><a href="<?php echo esc_url(home_url('/digital-marketing/')); ?>">Digital Marketing & Ads</a></li>
                        <li><a href="<?php echo esc_url(home_url('/graphics-design/')); ?>">Graphics & Branding Design</a></li>
                    </ul>
                    <?php
                }
                ?>
            </div>

            <!-- Col 3 -->
            <div class="footer-col">
                <h4 class="footer-heading">অফিস ও যোগাযোগ</h4>
                <ul class="footer-links">
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">ঢাকা অফিস লোকেশন</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">নীলফামারী হেড অফিস</a></li>
                    <li><a href="<?php echo esc_url(home_url('/contact/')); ?>">সরাসরি যোগাযোগ ফর্ম</a></li>
                    <li><a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $phone)); ?>">হটলাইন: <?php echo esc_html($phone); ?></a></li>
                </ul>
            </div>

            <!-- Col 4 -->
            <div class="footer-col">
                <h4 class="footer-heading">জরুরি সহায়তা</h4>
                <div class="footer-contact-item">
                    <i class="fa-solid fa-phone-volume"></i>
                    <div>
                        <span>ফোন করুন:</span>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <i class="fa-brands fa-whatsapp"></i>
                    <div>
                        <span>WhatsApp:</span>
                        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa)); ?>" target="_blank"><?php echo esc_html($phone); ?></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-inner">
                <p>© <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. সর্বস্বত্ব সংরক্ষিত।</p>
                <div class="footer-legal-links">
                    <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy Policy</a>
                    <a href="<?php echo esc_url(home_url('/terms/')); ?>">Terms of Service</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Order / Inquiry Modal -->
<div class="modal-overlay" id="orderModal">
    <div class="modal-card">
        <button class="modal-close-btn" onclick="closeOrderModal()" aria-label="<?php esc_attr_e('Close Modal', 'sarkarhost'); ?>"><i class="fa-solid fa-xmark"></i></button>
        <div class="modal-header">
            <div class="modal-badge"><i class="fa-solid fa-bolt"></i> Instant Service Request</div>
            <h3 class="modal-title" id="modalServiceTitle">Order Service</h3>
            <p class="modal-subtitle">ফর্মটি পূরণ করে সরাসরি আমাদের টিমের সাথে WhatsApp-এ যুক্ত হোন।</p>
        </div>
        <div class="modal-body">
            <form id="serviceOrderForm" onsubmit="handleFormSubmit(event)">
                <!-- Anti-spam Honeypot -->
                <input type="text" name="sh_website_url" class="sh-honey" tabindex="-1" autocomplete="off" style="position: absolute; left: -9999px; opacity: 0; pointer-events: none;">
                
                <div class="form-group">
                    <label for="clientName"><i class="fa-solid fa-user"></i> আপনার নাম *</label>
                    <input type="text" id="clientName" required minlength="2" placeholder="যেমন: মো: রফিকুল ইসলাম">
                </div>
                <div class="form-group">
                    <label for="clientPhone"><i class="fa-solid fa-phone"></i> মোবাইল নম্বর (১১ ডিজিট) *</label>
                    <input type="tel" id="clientPhone" required pattern="^(?:\+?88|88)?01[3-9]\d{8}$" placeholder="যেমন: 017XXXXXXXX">
                    <small style="color: #94a3b8; font-size: 0.75rem;">সঠিক ও সক্রিয় মোবাইল নম্বর দিন</small>
                </div>
                <div class="form-group">
                    <label for="selectedServiceName"><i class="fa-solid fa-cubes"></i> নির্বাচিত সেবা</label>
                    <input type="text" id="selectedServiceName" readonly value="General Inquiry">
                </div>
                <div class="form-group">
                    <label for="clientMessage"><i class="fa-solid fa-comment-dots"></i> আপনার প্রজেক্ট প্ল্যান বা মেসেজ</label>
                    <textarea id="clientMessage" rows="3" placeholder="আপনার প্রয়োজনীয় তথ্য লিখুন (কোনো লিংক দেওয়া যাবে না)..."></textarea>
                </div>
                <div class="modal-action-buttons">
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fa-brands fa-whatsapp"></i> হোয়াটসঅ্যাপে মেসেজ পাঠান
                    </button>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $phone)); ?>" class="btn btn-outline btn-block text-center">
                        <i class="fa-solid fa-phone"></i> সরাসরি কথা বলুন (<?php echo esc_html($phone); ?>)
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Floating WhatsApp & Scroll Top -->
<a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa)); ?>?text=Hello%20Sarkar%20Host" target="_blank" class="floating-wa-btn" aria-label="Chat on WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
    <span class="wa-tooltip">কথা বলুন WhatsApp-এ</span>
</a>

<button class="scroll-top-btn" id="scrollTopBtn" aria-label="Scroll to top" onclick="scrollToTop()">
    <i class="fa-solid fa-arrow-up"></i>
</button>

<?php wp_footer(); ?>
</body>
</html>
