<?php
/**
 * Sarkar Host Header Template
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$phone = sarkarhost_get_opt('sarkarhost_phone', '01321-222308');
$wa = sarkarhost_get_opt('sarkarhost_whatsapp', '8801321222308');
?>

<!-- Top Announcement Bar -->
<div class="top-announcement-bar">
    <div class="container d-flex justify-between align-center">
        <div class="top-announcement-left">
            <span class="badge-pulse"><span class="pulse-dot"></span> 24/7 সাপোর্ট সার্ভিস চালু আছে</span>
            <span class="top-phone"><i class="fa-solid fa-phone"></i> সরাসরি কথা বলুন: <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $phone)); ?>"><?php echo esc_html($phone); ?></a></span>
        </div>
        <div class="top-announcement-right">
            <span><i class="fa-solid fa-location-dot"></i> ঢাকা ও নীলফামারী অফিস</span>
            <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa)); ?>" target="_blank" class="top-wa-link"><i class="fa-brands fa-whatsapp"></i> WhatsApp Chat</a>
        </div>
    </div>
</div>

<!-- Header -->
<header class="site-header" id="mainHeader">
    <div class="container header-container">
        <!-- Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="brand-logo">
            <?php
            if (has_custom_logo()) {
                the_custom_logo();
            } else {
                ?>
                <img src="https://sarkarhost.com/wp-content/uploads/2026/08/sarkar-host-logo.png" 
                     alt="<?php bloginfo('name'); ?>" 
                     class="main-site-logo"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                
                <div class="logo-fallback" style="display: none;">
                    <div class="logo-icon"><i class="fa-solid fa-server"></i></div>
                    <div class="logo-text">
                        <span class="logo-main">SARKAR<span>HOST</span></span>
                        <span class="logo-sub">IT & Digital Solutions</span>
                    </div>
                </div>
                <?php
            }
            ?>
        </a>

        <!-- Navigation Menu -->
        <nav class="nav-menu" id="navMenu">
            <div class="nav-menu-inner">
                <!-- Mobile Drawer Header -->
                <div class="mobile-drawer-header">
                    <div class="drawer-logo-wrap">
                        <span class="drawer-logo-main">SARKAR<span>HOST</span></span>
                        <span class="drawer-logo-sub">IT & Digital Solutions</span>
                    </div>
                    <button type="button" class="drawer-close-btn" id="drawerCloseBtn" aria-label="<?php esc_attr_e('Close Menu', 'sarkarhost'); ?>">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Navigation List -->
                <div class="nav-menu-links-wrap">
                    <?php
                    if (has_nav_menu('primary_menu')) {
                        wp_nav_menu([
                            'theme_location' => 'primary_menu',
                            'container'      => false,
                            'fallback_cb'    => 'sarkarhost_default_menu',
                            'items_wrap'     => '<ul class="main-nav-list">%3$s</ul>',
                        ]);
                    } else {
                        sarkarhost_default_menu();
                    }
                    ?>
                </div>

                <!-- Mobile Drawer Actions & Contact Info -->
                <div class="mobile-nav-actions">
                    <!-- Primary Contact CTA -->
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary btn-block mobile-drawer-cta">
                        <span>যোগাযোগ করুন</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                    <!-- Hotline & WhatsApp Quick Actions -->
                    <div class="mobile-action-buttons-grid">
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $phone)); ?>" class="btn btn-outline btn-block">
                            <i class="fa-solid fa-phone-volume"></i> <span>কল: <?php echo esc_html($phone); ?></span>
                        </a>
                        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa)); ?>?text=Hello%20Sarkar%20Host" target="_blank" class="btn btn-wa-drawer btn-block">
                            <i class="fa-brands fa-whatsapp"></i> <span>WhatsApp চ্যাট</span>
                        </a>
                    </div>

                    <!-- Contact & Office Info Box -->
                    <div class="mobile-drawer-info-card">
                        <div class="drawer-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>ঢাকা ও নীলফামারী অফিস</span>
                        </div>
                        <div class="drawer-info-item">
                            <i class="fa-solid fa-envelope"></i>
                            <span><?php echo esc_html(sarkarhost_get_opt('sarkarhost_email', 'info@sarkarhost.com')); ?></span>
                        </div>
                        <div class="drawer-info-item highlight">
                            <span class="pulse-dot"></span>
                            <span>24/7 সাপোর্ট সার্ভিস চালু আছে</span>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Header Actions -->
        <div class="header-actions">
            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $phone)); ?>" class="btn btn-outline d-none-mobile">
                <i class="fa-solid fa-phone-volume"></i> <?php echo esc_html($phone); ?>
            </a>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn btn-primary d-none-mobile header-contact-btn">
                <span>যোগাযোগ করুন</span>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
            <button class="mobile-menu-toggle" id="mobileMenuBtn" aria-label="<?php esc_attr_e('Toggle Menu', 'sarkarhost'); ?>">
                <i class="fa-solid fa-bars"></i>
            </button>
        </div>
    </div>
</header>
<div class="mobile-nav-overlay" id="mobileNavOverlay"></div>
