<?php
/**
 * Sarkar Host Theme Functions & Definitions
 */

if (!defined('ABSPATH')) {
    exit;
}

// 1. Theme Setup
function sarkarhost_theme_setup() {
    // Make theme available for translation
    load_theme_textdomain('sarkarhost', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head
    add_theme_support('automatic-feed-links');

    // Let WordPress manage the document title
    add_theme_support('title-tag');

    // Enable support for Post Thumbnails on posts and pages
    add_theme_support('post-thumbnails');

    // Custom Logo Support
    add_theme_support('custom-logo', [
        'height'      => 80,
        'width'       => 260,
        'flex-height' => true,
        'flex-width'  => true,
    ]);

    // HTML5 markup support
    add_theme_support('html5', [
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ]);

    // Register Navigation Menus with Checkboxes in WP Admin
    register_nav_menus([
        'primary_menu'         => __('Primary Header Menu', 'sarkarhost'),
        'footer_services_menu' => __('Footer Services Menu', 'sarkarhost'),
        'footer_legal_menu'    => __('Footer Legal & Info Menu', 'sarkarhost'),
    ]);
}
add_action('after_setup_theme', 'sarkarhost_theme_setup');

// 2. Enqueue Styles and Scripts
function sarkarhost_enqueue_assets() {
    // Google Fonts: Plus Jakarta Sans & Hind Siliguri
    wp_enqueue_style(
        'sarkarhost-google-fonts',
        'https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
        [],
        null
    );

    // Font Awesome 6
    wp_enqueue_style(
        'font-awesome-6',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );

    // Main Theme Stylesheet
    wp_enqueue_style(
        'sarkarhost-style',
        get_stylesheet_uri(),
        ['font-awesome-6'],
        '1.2.0'
    );

    // Main Theme JavaScript
    wp_enqueue_script(
        'sarkarhost-script',
        get_template_directory_uri() . '/assets/js/theme-script.js',
        [],
        '1.2.0',
        true
    );

    // Pass Dynamic Data to JS
    wp_localize_script('sarkarhost-script', 'sarkarHostData', [
        'ajax_url'     => admin_url('admin-ajax.php'),
        'nonce'        => wp_create_nonce('sarkarhost_lead_nonce'),
        'whatsapp_num' => sarkarhost_get_opt('sarkarhost_whatsapp', '8801321222308'),
        'phone_num'    => sarkarhost_get_opt('sarkarhost_phone', '01321-222308'),
    ]);
}
add_action('wp_enqueue_scripts', 'sarkarhost_enqueue_assets');

// 3. Inject Dynamic Custom Colors from Theme Settings into <head>
function sarkarhost_custom_colors_css() {
    $primary = sarkarhost_get_opt('sarkarhost_primary_color', '#2563eb');
    $lime    = sarkarhost_get_opt('sarkarhost_accent_lime', '#c4ee18');
    $bg_dark = sarkarhost_get_opt('sarkarhost_bg_dark', '#090a10');

    $custom_css = "
    :root {
        --primary: {$primary} !important;
        --accent-lime: {$lime} !important;
        --bg-dark: {$bg_dark} !important;
    }
    ";
    wp_add_inline_style('sarkarhost-style', $custom_css);
}
add_action('wp_enqueue_scripts', 'sarkarhost_custom_colors_css', 20);

// 4. Default Fallback Nav Menu with Dynamic Active State & Mobile Accordion Toggles
function sarkarhost_default_menu() {
    $is_home     = is_front_page() || is_home();
    $is_seo      = is_page('seo-service') || is_page_template('template-seo.php');
    $is_web      = is_page('web-development') || is_page_template('template-web.php');
    $is_hosting  = is_page('hosting-domain') || is_page_template('template-hosting.php');
    $is_mkt      = is_page('digital-marketing') || is_page_template('template-marketing.php');
    $is_gfx      = is_page('graphics-design') || is_page_template('template-graphics.php');
    $is_contact  = is_page('contact') || is_page_template('template-contact.php');
    
    // Services parent is active if on any service page
    $is_services = ($is_seo || $is_web || $is_hosting || $is_mkt || $is_gfx);
    ?>
    <ul class="main-nav-list">
        <li class="menu-item <?php echo $is_home ? 'current-menu-item active' : ''; ?>">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="<?php echo $is_home ? 'active' : ''; ?>">
                <i class="fa-solid fa-house nav-icon"></i>
                <span>হোম</span>
            </a>
        </li>
        
        <li class="menu-item has-dropdown menu-item-has-children <?php echo $is_services ? 'current-menu-ancestor current-menu-parent active-parent' : ''; ?>">
            <div class="nav-item-flex">
                <a href="<?php echo esc_url(home_url('/#services-overview')); ?>" class="<?php echo $is_services ? 'active' : ''; ?>">
                    <i class="fa-solid fa-cubes nav-icon"></i>
                    <span>সেবাসমূহ</span>
                    <i class="fa-solid fa-chevron-down dropdown-arrow"></i>
                </a>
                <button type="button" class="mobile-submenu-toggle" aria-label="Expand Submenu">
                    <i class="fa-solid fa-chevron-down"></i>
                </button>
            </div>
            <div class="dropdown-menu sub-menu">
                <a href="<?php echo esc_url(home_url('/seo-service/')); ?>" class="<?php echo $is_seo ? 'active current-menu-item' : ''; ?>">
                    <span class="sub-icon icon-yellow"><i class="fa-solid fa-magnifying-glass-chart"></i></span>
                    <div class="sub-text">
                        <strong>প্রফেশনাল এসইও (SEO)</strong>
                        <small>Google Ranking & Organic Growth</small>
                    </div>
                </a>
                <a href="<?php echo esc_url(home_url('/web-development/')); ?>" class="<?php echo $is_web ? 'active current-menu-item' : ''; ?>">
                    <span class="sub-icon icon-purple"><i class="fa-solid fa-code"></i></span>
                    <div class="sub-text">
                        <strong>ওয়েব ও অ্যাপ ডেভেলপমেন্ট</strong>
                        <small>E-Commerce, LMS, Landing & Apps</small>
                    </div>
                </a>
                <a href="<?php echo esc_url(home_url('/hosting-domain/')); ?>" class="<?php echo $is_hosting ? 'active current-menu-item' : ''; ?>">
                    <span class="sub-icon icon-green"><i class="fa-solid fa-server"></i></span>
                    <div class="sub-text">
                        <strong>ডোমেইন ও BDIX হোস্টিং</strong>
                        <small>NVMe SSD, 99.9% Uptime & SSL</small>
                    </div>
                </a>
                <a href="<?php echo esc_url(home_url('/digital-marketing/')); ?>" class="<?php echo $is_mkt ? 'active current-menu-item' : ''; ?>">
                    <span class="sub-icon icon-blue"><i class="fa-solid fa-bullhorn"></i></span>
                    <div class="sub-text">
                        <strong>ডিজিটাল মার্কেটিং ও বুস্টিং</strong>
                        <small>Meta Ads, FB Page Setup & Growth</small>
                    </div>
                </a>
                <a href="<?php echo esc_url(home_url('/graphics-design/')); ?>" class="<?php echo $is_gfx ? 'active current-menu-item' : ''; ?>">
                    <span class="sub-icon icon-pink"><i class="fa-solid fa-palette"></i></span>
                    <div class="sub-text">
                        <strong>গ্রাফিক্স ও ব্র্যান্ডিং ডিজাইন</strong>
                        <small>Social Media Posts & Brand Identity</small>
                    </div>
                </a>
            </div>
        </li>

        <li class="menu-item <?php echo $is_seo ? 'current-menu-item active' : ''; ?>">
            <a href="<?php echo esc_url(home_url('/seo-service/')); ?>" class="<?php echo $is_seo ? 'active' : ''; ?>">
                <span>এসইও সার্ভিস</span>
            </a>
        </li>
        <li class="menu-item <?php echo $is_web ? 'current-menu-item active' : ''; ?>">
            <a href="<?php echo esc_url(home_url('/web-development/')); ?>" class="<?php echo $is_web ? 'active' : ''; ?>">
                <span>ওয়েব সলিউশন</span>
            </a>
        </li>
        <li class="menu-item <?php echo $is_hosting ? 'current-menu-item active' : ''; ?>">
            <a href="<?php echo esc_url(home_url('/hosting-domain/')); ?>" class="<?php echo $is_hosting ? 'active' : ''; ?>">
                <span>হোস্টিং</span>
            </a>
        </li>
        <li class="menu-item <?php echo $is_contact ? 'current-menu-item active' : ''; ?>">
            <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="<?php echo $is_contact ? 'active' : ''; ?>">
                <i class="fa-solid fa-location-dot nav-icon"></i>
                <span>অফিস ও যোগাযোগ</span>
            </a>
        </li>
    </ul>
    <?php
}

// 5. Include Settings and Shortcodes
require_once get_template_directory() . '/inc/theme-settings.php';
require_once get_template_directory() . '/inc/shortcodes.php';
