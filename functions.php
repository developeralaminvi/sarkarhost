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
        '1.4.1'
    );

    // Main Theme JavaScript
    wp_enqueue_script(
        'sarkarhost-script',
        get_template_directory_uri() . '/assets/js/theme-script.js',
        [],
        '1.4.1',
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

// Helper function to return all default theme colors
function sarkarhost_get_theme_color_defaults() {
    return [
        // Brand & Accents
        'sarkarhost_primary_color'       => '#2563eb',
        'sarkarhost_primary_hover'       => '#1d4ed8',
        'sarkarhost_accent_lime'         => '#c4ee18',
        'sarkarhost_accent_cyan'         => '#06b6d4',
        'sarkarhost_accent_purple'       => '#8b5cf6',
        'sarkarhost_accent_green'        => '#10b981',
        'sarkarhost_accent_orange'       => '#f97316',
        'sarkarhost_accent_yellow'       => '#facc15',
        'sarkarhost_accent_pink'         => '#f472b6',

        // Backgrounds & Surfaces
        'sarkarhost_bg_dark'             => '#090a10',
        'sarkarhost_bg_dark_secondary'   => '#0f121d',
        'sarkarhost_bg_surface'          => '#141824',
        'sarkarhost_bg_card'             => '#151928',
        'sarkarhost_bg_card_hover'       => '#1b2135',

        // Typography / Text
        'sarkarhost_text_main'           => '#f8fafc',
        'sarkarhost_text_muted'          => '#94a3b8',
        'sarkarhost_text_dim'            => '#64748b',
        'sarkarhost_text_white'          => '#ffffff',
        'sarkarhost_text_dark'           => '#090a10',

        // Borders, Focus & Glow
        'sarkarhost_border_color'        => '#222738',
        'sarkarhost_border_hover'        => '#c4ee18',
        'sarkarhost_border_focus'        => '#2563eb',
        'sarkarhost_primary_glow'        => '#2563eb',

        // Action & Status Colors
        'sarkarhost_color_whatsapp'      => '#25d366',
        'sarkarhost_color_call'          => '#2563eb',
        'sarkarhost_color_success'       => '#22c55e',
        'sarkarhost_color_error'         => '#ef4444',
    ];
}

// Helper to convert hex color to rgba
function sarkarhost_hex_to_rgba($hex, $opacity = 1) {
    if (empty($hex)) return 'rgba(0,0,0,' . $opacity . ')';
    if (strpos($hex, 'rgba') !== false || strpos($hex, 'rgb') !== false) return $hex;
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
        $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
        $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
    } elseif (strlen($hex) === 6) {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    } else {
        return $hex;
    }
    return "rgba({$r}, {$g}, {$b}, {$opacity})";
}

// 3. Inject Dynamic Custom Colors from Theme Settings into <head>
function sarkarhost_custom_colors_css() {
    $defaults = sarkarhost_get_theme_color_defaults();
    $colors = [];
    foreach ($defaults as $key => $default_val) {
        $colors[$key] = sarkarhost_get_opt($key, $default_val);
    }

    $primary        = esc_attr($colors['sarkarhost_primary_color']);
    $primary_hover  = esc_attr($colors['sarkarhost_primary_hover']);
    $lime           = esc_attr($colors['sarkarhost_accent_lime']);
    $cyan           = esc_attr($colors['sarkarhost_accent_cyan']);
    $purple         = esc_attr($colors['sarkarhost_accent_purple']);
    $green          = esc_attr($colors['sarkarhost_accent_green']);
    $orange         = esc_attr($colors['sarkarhost_accent_orange']);
    $yellow         = esc_attr($colors['sarkarhost_accent_yellow']);
    $pink           = esc_attr($colors['sarkarhost_accent_pink']);

    $bg_dark        = esc_attr($colors['sarkarhost_bg_dark']);
    $bg_dark_sec    = esc_attr($colors['sarkarhost_bg_dark_secondary']);
    $bg_surface     = esc_attr($colors['sarkarhost_bg_surface']);
    $bg_card_raw    = $colors['sarkarhost_bg_card'];
    $bg_card_h_raw  = $colors['sarkarhost_bg_card_hover'];

    $text_main      = esc_attr($colors['sarkarhost_text_main']);
    $text_muted     = esc_attr($colors['sarkarhost_text_muted']);
    $text_dim       = esc_attr($colors['sarkarhost_text_dim']);
    $text_white     = esc_attr($colors['sarkarhost_text_white']);
    $text_dark      = esc_attr($colors['sarkarhost_text_dark']);

    $border_color   = esc_attr($colors['sarkarhost_border_color']);
    $border_hover   = esc_attr($colors['sarkarhost_border_hover']);
    $border_focus   = esc_attr($colors['sarkarhost_border_focus']);
    $primary_glow   = esc_attr($colors['sarkarhost_primary_glow']);

    $wa_color       = esc_attr($colors['sarkarhost_color_whatsapp']);
    $call_color     = esc_attr($colors['sarkarhost_color_call']);
    $success_color  = esc_attr($colors['sarkarhost_color_success']);
    $error_color    = esc_attr($colors['sarkarhost_color_error']);

    // Computed RGBA versions for rich backdrop effects
    $glow_rgba        = sarkarhost_hex_to_rgba($primary_glow, 0.35);
    $glow_subtle      = sarkarhost_hex_to_rgba($primary_glow, 0.15);
    $card_rgba        = (strpos($bg_card_raw, 'rgba') !== false) ? $bg_card_raw : sarkarhost_hex_to_rgba($bg_card_raw, 0.82);
    $card_hover_rgba  = (strpos($bg_card_h_raw, 'rgba') !== false) ? $bg_card_h_raw : sarkarhost_hex_to_rgba($bg_card_h_raw, 0.95);
    $border_rgba      = (strpos($border_color, 'rgba') !== false) ? $border_color : sarkarhost_hex_to_rgba($border_color, 0.35);
    $border_hover_rgba = (strpos($border_hover, 'rgba') !== false) ? $border_hover : sarkarhost_hex_to_rgba($border_hover, 0.45);

    $custom_css = "
    :root {
        /* Brand & Accents */
        --primary: {$primary} !important;
        --primary-hover: {$primary_hover} !important;
        --primary-glow: {$glow_rgba} !important;
        --primary-glow-subtle: {$glow_subtle} !important;
        --accent-lime: {$lime} !important;
        --accent-cyan: {$cyan} !important;
        --accent-purple: {$purple} !important;
        --accent-green: {$green} !important;
        --accent-orange: {$orange} !important;
        --accent-yellow: {$yellow} !important;
        --accent-pink: {$pink} !important;

        /* Backgrounds & Surfaces */
        --bg-dark: {$bg_dark} !important;
        --bg-dark-secondary: {$bg_dark_sec} !important;
        --bg-surface: {$bg_surface} !important;
        --bg-card: {$card_rgba} !important;
        --bg-card-hover: {$card_hover_rgba} !important;

        /* Typography */
        --text-main: {$text_main} !important;
        --text-muted: {$text_muted} !important;
        --text-dim: {$text_dim} !important;
        --text-white: {$text_white} !important;
        --text-dark: {$text_dark} !important;

        /* Borders & Focus */
        --border-color: {$border_rgba} !important;
        --border-hover: {$border_hover_rgba} !important;
        --border-focus: {$border_focus} !important;

        /* Action & Status */
        --color-whatsapp: {$wa_color} !important;
        --color-call: {$call_color} !important;
        --color-success: {$success_color} !important;
        --color-error: {$error_color} !important;

        /* Dynamic Gradients */
        --gradient-primary: linear-gradient(135deg, {$primary} 0%, {$purple} 100%) !important;
        --gradient-lime: linear-gradient(135deg, {$lime} 0%, {$green} 100%) !important;
        --gradient-accent: linear-gradient(135deg, {$cyan} 0%, {$purple} 50%, {$pink} 100%) !important;
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
