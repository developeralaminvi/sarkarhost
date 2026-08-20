<?php
/**
 * Sarkar Host Theme Settings & Leads Management Dashboard
 * 
 * Features:
 * - Smart Modern Admin UI
 * - Form Inquiries / Leads Collection (Service Modal, Contact Page, CF7)
 * - WhatsApp Direct Action & Phone Call Action
 * - Contact Form 7 Auto-capture Integration
 * - Dynamic Brand Colors, Contact Info, Map Links
 * - Interactive Shortcodes with 1-click Copy
 */

if (!defined('ABSPATH')) {
    exit;
}

/* ==========================================================================
   1. SPAM PROTECTION & VALIDATION HELPERS
   ========================================================================== */

/**
 * Check if text contains spam links, domains, or URLs
 */
function sarkarhost_contains_spam_links($text) {
    if (empty($text)) return false;
    $pattern = '/(https?:\/\/|www\.|ftp:\/\/|[a-z0-9\-\_]+\.(com|net|org|xyz|ru|link|info|top|cn|online|site|biz|club|vip|cc|pw|icu|tk|ga|cf|gq|ml)|t\.me\/|telegram\.me|bit\.ly\/|tinyurl\.com|<a\s|\[url=)/i';
    return preg_match($pattern, $text) === 1;
}

/**
 * Validate Bangladesh mobile phone format (013, 014, 015, 016, 017, 018, 019)
 */
function sarkarhost_is_valid_bd_phone($phone) {
    if (empty($phone)) return false;
    $clean = preg_replace('/[\s\-\(\)\+]/', '', $phone);

    // Matches 01[3-9]XXXXXXXX or 8801[3-9]XXXXXXXX
    if (preg_match('/^(?:88)?01[3-9]\d{8}$/', $clean)) {
        // Disallow all repeating digits e.g. 01711111111 or 01700000000
        $last8 = substr($clean, -8);
        if (preg_match('/^(\d)\1{7}$/', $last8)) {
            return false;
        }
        return true;
    }
    return false;
}

/**
 * Send a modern formatted HTML email to admin
 */
function sarkarhost_send_admin_notification_email($lead) {
    $admin_email = sarkarhost_get_opt('sarkarhost_email', get_option('admin_email'));
    if (empty($admin_email)) {
        $admin_email = get_option('admin_email');
    }

    $site_name    = get_bloginfo('name');
    $client_name  = $lead['name'] ?? 'Client';
    $client_phone = $lead['phone'] ?? '';
    $service_name = $lead['service'] ?? 'General Inquiry';
    $message      = $lead['message'] ?? '';
    $source       = $lead['source'] ?? 'Website';
    $page_url     = $lead['page_url'] ?? home_url();
    $time_str     = date('d M, Y - h:i A');

    $clean_phone   = preg_replace('/[^0-9]/', '', $client_phone);
    $wa_phone      = (strpos($clean_phone, '88') === 0) ? $clean_phone : '88' . $clean_phone;
    $wa_reply_url  = 'https://wa.me/' . $wa_phone . '?text=' . urlencode('হ্যালো ' . $client_name . ', Sarkar Host থেকে আপনার ' . $service_name . ' সম্পর্কিত ইনকোয়ারির জন্য যোগাযোগ করছি।');
    $dashboard_url = admin_url('admin.php?page=sarkarhost-settings&tab=leads_list');

    $subject = '⚡ [New Lead] ' . $service_name . ' - ' . $client_name . ' | ' . $site_name;

    $body = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #090a10; margin: 0; padding: 25px 15px; color: #f8fafc; }
            .email-wrap { max-width: 600px; margin: 0 auto; background: #0f121d; border-radius: 14px; overflow: hidden; border: 1px solid rgba(255,255,255,0.1); box-shadow: 0 15px 35px rgba(0,0,0,0.6); }
            .email-head { background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%); padding: 25px 30px; text-align: center; border-bottom: 3px solid #c4ee18; }
            .email-head h1 { margin: 0; color: #ffffff; font-size: 22px; font-weight: 800; }
            .email-head p { margin: 6px 0 0; color: #dbeafe; font-size: 13px; }
            .email-body { padding: 30px; background: #141824; }
            .lead-box { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.08); border-radius: 10px; padding: 20px; margin-bottom: 25px; }
            .lead-row { padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.06); font-size: 14px; }
            .lead-row:last-child { border-bottom: none; }
            .label { color: #94a3b8; font-weight: 600; margin-bottom: 3px; }
            .val { color: #ffffff; font-weight: 700; font-size: 15px; }
            .badge { display: inline-block; background: #2563eb; color: #ffffff; padding: 4px 12px; border-radius: 6px; font-size: 13px; font-weight: 700; }
            .msg-text { background: rgba(0,0,0,0.3); border-left: 3px solid #c4ee18; padding: 12px 15px; border-radius: 6px; color: #e2e8f0; font-size: 13.5px; line-height: 1.6; margin-top: 5px; }
            .cta-box { text-align: center; margin: 25px 0 10px; }
            .btn { display: inline-block; padding: 12px 22px; border-radius: 30px; text-decoration: none; font-weight: 700; font-size: 13.5px; margin: 5px; }
            .btn-wa { background: #22c55e; color: #ffffff; }
            .btn-phone { background: #2563eb; color: #ffffff; }
            .btn-dash { background: rgba(255,255,255,0.1); color: #ffffff; border: 1px solid rgba(255,255,255,0.2); }
            .email-foot { background: #0b0e17; padding: 20px; text-align: center; color: #64748b; font-size: 12px; border-top: 1px solid rgba(255,255,255,0.06); }
        </style>
    </head>
    <body>
        <div class="email-wrap">
            <div class="email-head">
                <h1>⚡ New Service Inquiry Received</h1>
                <p>' . esc_html($site_name) . ' - Website Lead Notification</p>
            </div>
            <div class="email-body">
                <div class="lead-box">
                    <div class="lead-row">
                        <div class="label">👤 কাস্টমারের নাম:</div>
                        <div class="val">' . esc_html($client_name) . '</div>
                    </div>
                    <div class="lead-row">
                        <div class="label">📱 মোবাইল নম্বর:</div>
                        <div class="val"><a href="tel:' . esc_attr($clean_phone) . '" style="color: #38bdf8; text-decoration: none;">' . esc_html($client_phone) . '</a></div>
                    </div>
                    <div class="lead-row">
                        <div class="label">🛠️ নির্বাচিত সেবা:</div>
                        <div class="val"><span class="badge">' . esc_html($service_name) . '</span></div>
                    </div>
                    <div class="lead-row">
                        <div class="label">📝 মেসেজ:</div>
                        <div class="msg-text">' . (!empty($message) ? nl2br(esc_html($message)) : '<em style="color:#64748b;">(কোনো মেসেজ নেই)</em>') . '</div>
                    </div>
                    <div class="lead-row">
                        <div class="label">🌐 ফর্ম উৎস:</div>
                        <div class="val" style="font-size: 12px; color: #94a3b8;">' . esc_html($source) . '</div>
                    </div>
                    <div class="lead-row">
                        <div class="label">⏰ সময়:</div>
                        <div class="val" style="font-size: 12px; color: #94a3b8;">' . esc_html($time_str) . '</div>
                    </div>
                </div>

                <div class="cta-box">
                    <a href="' . esc_url($wa_reply_url) . '" target="_blank" class="btn btn-wa">💬 WhatsApp-এ চ্যাট করুন</a>
                    <a href="tel:' . esc_attr($clean_phone) . '" class="btn btn-phone">📞 সরাসরি কল দিন</a>
                    <a href="' . esc_url($dashboard_url) . '" target="_blank" class="btn btn-dash">📨 ড্যাশবোর্ড দেখুন</a>
                </div>
            </div>
            <div class="email-foot">
                <p>© ' . date('Y') . ' ' . esc_html($site_name) . '. সর্বস্বত্ব সংরক্ষিত।</p>
            </div>
        </div>
    </body>
    </html>
    ';

    $headers = [
        'Content-Type: text/html; charset=UTF-8',
        'From: ' . $site_name . ' <' . get_option('admin_email') . '>',
    ];

    wp_mail($admin_email, $subject, $body, $headers);
}

/* ==========================================================================
   2. LEADS & SUBMISSIONS STORAGE HELPERS
   ========================================================================== */

/**
 * Save a new form submission to the database
 */
function sarkarhost_save_submission($data) {
    $submissions = get_option('sarkarhost_form_submissions', []);
    if (!is_array($submissions)) {
        $submissions = [];
    }

    $lead_id = 'sh_' . time() . '_' . wp_generate_password(4, false);

    $new_lead = [
        'id'         => $lead_id,
        'created_at' => current_time('mysql'),
        'timestamp'  => time(),
        'name'       => isset($data['name']) ? sanitize_text_field($data['name']) : 'Anonymous',
        'phone'      => isset($data['phone']) ? sanitize_text_field($data['phone']) : '',
        'email'      => isset($data['email']) ? sanitize_email($data['email']) : '',
        'service'    => isset($data['service']) ? sanitize_text_field($data['service']) : 'General Inquiry',
        'message'    => isset($data['message']) ? sanitize_textarea_field($data['message']) : '',
        'source'     => isset($data['source']) ? sanitize_text_field($data['source']) : 'Website Form',
        'page_url'   => isset($data['page_url']) ? esc_url_raw($data['page_url']) : home_url(),
        'status'     => 'new', // new, contacted, completed, trash
        'ip'         => sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? ''),
    ];

    // Prepend to show latest leads first
    array_unshift($submissions, $new_lead);

    // Keep max 500 records
    if (count($submissions) > 500) {
        $submissions = array_slice($submissions, 0, 500);
    }

    update_option('sarkarhost_form_submissions', $submissions, false);

    // Send Admin Notification Email
    sarkarhost_send_admin_notification_email($new_lead);

    return $lead_id;
}

/**
 * Get all submissions
 */
function sarkarhost_get_submissions($filter_status = '') {
    $submissions = get_option('sarkarhost_form_submissions', []);
    if (!is_array($submissions)) {
        return [];
    }

    if (!empty($filter_status) && $filter_status !== 'all') {
        return array_values(array_filter($submissions, function($item) use ($filter_status) {
            return isset($item['status']) && $item['status'] === $filter_status;
        }));
    }

    return $submissions;
}

/**
 * Count unread/new leads
 */
function sarkarhost_get_unread_leads_count() {
    $submissions = get_option('sarkarhost_form_submissions', []);
    if (!is_array($submissions)) return 0;
    
    $count = 0;
    foreach ($submissions as $item) {
        if (isset($item['status']) && $item['status'] === 'new') {
            $count++;
        }
    }
    return $count;
}

/**
 * Delete a specific submission
 */
function sarkarhost_delete_submission($id) {
    $submissions = get_option('sarkarhost_form_submissions', []);
    if (!is_array($submissions)) return false;

    $updated = array_filter($submissions, function($item) use ($id) {
        return isset($item['id']) && $item['id'] !== $id;
    });

    return update_option('sarkarhost_form_submissions', array_values($updated), false);
}

/**
 * Update submission status
 */
function sarkarhost_update_submission_status($id, $status) {
    $submissions = get_option('sarkarhost_form_submissions', []);
    if (!is_array($submissions)) return false;

    $allowed = ['new', 'contacted', 'completed', 'trash'];
    if (!in_array($status, $allowed)) return false;

    foreach ($submissions as &$item) {
        if (isset($item['id']) && $item['id'] === $id) {
            $item['status'] = $status;
            break;
        }
    }

    return update_option('sarkarhost_form_submissions', $submissions, false);
}

/**
 * Clear all submissions
 */
function sarkarhost_clear_all_submissions() {
    return update_option('sarkarhost_form_submissions', [], false);
}


/* ==========================================================================
   3. AJAX FORM SUBMISSION HANDLER WITH ANTI-SPAM & VALIDATION
   ========================================================================== */
function sarkarhost_ajax_submit_form() {
    // Nonce verification
    check_ajax_referer('sarkarhost_lead_nonce', 'nonce');

    // 1. Honeypot check (Bots fill hidden fields)
    if (!empty($_POST['sh_website_url']) || !empty($_POST['honeypot'])) {
        wp_send_json_error(['message' => 'Spam detected.']);
    }

    $name     = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
    $phone    = isset($_POST['phone']) ? sanitize_text_field($_POST['phone']) : '';
    $service  = isset($_POST['service']) ? sanitize_text_field($_POST['service']) : 'General Inquiry';
    $message  = isset($_POST['message']) ? sanitize_textarea_field($_POST['message']) : '';
    $source   = isset($_POST['source']) ? sanitize_text_field($_POST['source']) : 'Service Modal';
    $page_url = isset($_POST['page_url']) ? esc_url_raw($_POST['page_url']) : wp_get_referer();

    // 2. Name validation
    if (empty($name) || mb_strlen($name) < 2) {
        wp_send_json_error(['message' => '⚠️ অনুগ্রহ করে আপনার সঠিক নাম লিখুন।']);
    }

    // 3. Spam Link / URL blocker
    if (sarkarhost_contains_spam_links($name) || sarkarhost_contains_spam_links($message) || sarkarhost_contains_spam_links($phone)) {
        wp_send_json_error(['message' => '⚠️ কোনো স্প্যাম লিংক বা ওয়েবসাইট URL শেয়ার করা অনুমোদিত নয়।']);
    }

    // 4. Bangladesh Mobile Number validation
    if (!sarkarhost_is_valid_bd_phone($phone)) {
        wp_send_json_error(['message' => '⚠️ অনুগ্রহ করে সঠিক ১১ ডিজিটের মোবাইল নম্বর দিন (যেমন: 017XXXXXXXX)।']);
    }

    $lead_id = sarkarhost_save_submission([
        'name'     => $name,
        'phone'    => $phone,
        'service'  => $service,
        'message'  => $message,
        'source'   => $source,
        'page_url' => $page_url,
    ]);

    wp_send_json_success([
        'lead_id' => $lead_id,
        'message' => 'আপনার তথ্য সফলভাবে সংরক্ষণ ও ইমেইলে প্রেরণ করা হয়েছে!',
    ]);
}
add_action('wp_ajax_sarkarhost_submit_form', 'sarkarhost_ajax_submit_form');
add_action('wp_ajax_nopriv_sarkarhost_submit_form', 'sarkarhost_ajax_submit_form');


/* ==========================================================================
   3. CONTACT FORM 7 AUTO-CAPTURE HOOK
   ========================================================================== */
function sarkarhost_cf7_capture_submission($contact_form) {
    if (!class_exists('WPCF7_Submission')) {
        return;
    }

    $submission = WPCF7_Submission::get_instance();
    if (!$submission) {
        return;
    }

    $posted_data = $submission->get_posted_data();
    if (empty($posted_data)) {
        return;
    }

    $name = '';
    foreach (['your-name', 'name', 'client-name', 'full-name'] as $key) {
        if (!empty($posted_data[$key])) {
            $name = sanitize_text_field($posted_data[$key]);
            break;
        }
    }

    $phone = '';
    foreach (['your-tel', 'tel', 'phone', 'your-phone', 'mobile'] as $key) {
        if (!empty($posted_data[$key])) {
            $phone = sanitize_text_field($posted_data[$key]);
            break;
        }
    }

    $email = '';
    foreach (['your-email', 'email', 'client-email'] as $key) {
        if (!empty($posted_data[$key])) {
            $email = sanitize_email($posted_data[$key]);
            break;
        }
    }

    $service = $contact_form->title();
    foreach (['your-service', 'service', 'subject', 'your-subject'] as $key) {
        if (!empty($posted_data[$key])) {
            $service = sanitize_text_field($posted_data[$key]);
            break;
        }
    }

    $message = '';
    foreach (['your-message', 'message', 'details'] as $key) {
        if (!empty($posted_data[$key])) {
            $message = sanitize_textarea_field($posted_data[$key]);
            break;
        }
    }

    sarkarhost_save_submission([
        'name'     => $name ?: 'CF7 Submitter',
        'phone'    => $phone,
        'email'    => $email,
        'service'  => $service ?: 'Contact Form 7 Inquiry',
        'message'  => $message,
        'source'   => 'Contact Form 7 (' . esc_html($contact_form->title()) . ')',
        'page_url' => wp_get_referer() ?: home_url(),
    ]);
}
add_action('wpcf7_mail_sent', 'sarkarhost_cf7_capture_submission');


/* ==========================================================================
   4. REGISTER ADMIN MENU & SUBMENU WITH BADGE
   ========================================================================== */
function sarkarhost_add_admin_menu() {
    $unread_count = sarkarhost_get_unread_leads_count();
    $badge = '';
    if ($unread_count > 0) {
        $badge = ' <span class="update-plugins count-' . $unread_count . '" style="background: #ef4444; color: #fff; border-radius: 10px; padding: 2px 7px; font-weight: 700; font-size: 11px;">' . $unread_count . '</span>';
    }

    // Main Menu
    add_menu_page(
        __('Sarkar Host Settings', 'sarkarhost'),
        __('Sarkar Host', 'sarkarhost') . $badge,
        'manage_options',
        'sarkarhost-settings',
        'sarkarhost_settings_page_html',
        'dashicons-superhero-alt',
        59
    );

    // Submenu: Settings
    add_submenu_page(
        'sarkarhost-settings',
        __('Theme Settings', 'sarkarhost'),
        __('⚙️ থিম সেটিংস', 'sarkarhost'),
        'manage_options',
        'sarkarhost-settings',
        'sarkarhost_settings_page_html'
    );

    // Submenu: Leads
    add_submenu_page(
        'sarkarhost-settings',
        __('Leads & Inquiries', 'sarkarhost'),
        __('📨 Leads & Inquiries', 'sarkarhost') . $badge,
        'manage_options',
        'sarkarhost-leads',
        'sarkarhost_leads_page_redirect'
    );
}
add_action('admin_menu', 'sarkarhost_add_admin_menu');

function sarkarhost_leads_page_redirect() {
    echo '<script>window.location.href = "' . admin_url('admin.php?page=sarkarhost-settings&tab=leads_list') . '";</script>';
    exit;
}


/* ==========================================================================
   5. REGISTER SETTINGS
   ========================================================================== */
function sarkarhost_register_settings() {
    // Contact Info
    register_setting('sarkarhost_settings_group', 'sarkarhost_phone');
    register_setting('sarkarhost_settings_group', 'sarkarhost_whatsapp');
    register_setting('sarkarhost_settings_group', 'sarkarhost_email');
    
    // Office Locations
    register_setting('sarkarhost_settings_group', 'sarkarhost_nilphamari_address');
    register_setting('sarkarhost_settings_group', 'sarkarhost_nilphamari_map');
    register_setting('sarkarhost_settings_group', 'sarkarhost_dhaka_address');
    register_setting('sarkarhost_settings_group', 'sarkarhost_dhaka_note');
    register_setting('sarkarhost_settings_group', 'sarkarhost_dhaka_map');

    // Theme Colors
    $color_defaults = function_exists('sarkarhost_get_theme_color_defaults') ? sarkarhost_get_theme_color_defaults() : [
        'sarkarhost_primary_color'       => '#2563eb',
        'sarkarhost_primary_hover'       => '#1d4ed8',
        'sarkarhost_accent_lime'         => '#c4ee18',
        'sarkarhost_accent_cyan'         => '#06b6d4',
        'sarkarhost_accent_purple'       => '#8b5cf6',
        'sarkarhost_accent_green'        => '#10b981',
        'sarkarhost_accent_orange'       => '#f97316',
        'sarkarhost_accent_yellow'       => '#facc15',
        'sarkarhost_accent_pink'         => '#f472b6',
        'sarkarhost_bg_dark'             => '#090a10',
        'sarkarhost_bg_dark_secondary'   => '#0f121d',
        'sarkarhost_bg_surface'          => '#141824',
        'sarkarhost_bg_card'             => '#151928',
        'sarkarhost_bg_card_hover'       => '#1b2135',
        'sarkarhost_text_main'           => '#f8fafc',
        'sarkarhost_text_muted'          => '#94a3b8',
        'sarkarhost_text_dim'            => '#64748b',
        'sarkarhost_text_white'          => '#ffffff',
        'sarkarhost_text_dark'           => '#090a10',
        'sarkarhost_border_color'        => '#222738',
        'sarkarhost_border_hover'        => '#c4ee18',
        'sarkarhost_border_focus'        => '#2563eb',
        'sarkarhost_primary_glow'        => '#2563eb',
        'sarkarhost_color_whatsapp'      => '#25d366',
        'sarkarhost_color_call'          => '#2563eb',
        'sarkarhost_color_success'       => '#22c55e',
        'sarkarhost_color_error'         => '#ef4444',
    ];
    foreach ($color_defaults as $color_key => $default_hex) {
        register_setting('sarkarhost_settings_group', $color_key);
    }

    // Contact Form 7 Shortcode
    register_setting('sarkarhost_settings_group', 'sarkarhost_cf7_shortcode');
}
add_action('admin_init', 'sarkarhost_register_settings');

// Helper function to get option with default
function sarkarhost_get_opt($key, $default = '') {
    $val = get_option($key);
    return ($val !== false && $val !== '') ? $val : $default;
}


/* ==========================================================================
   6. CSV EXPORT & ACTION HANDLERS
   ========================================================================== */
function sarkarhost_handle_admin_actions() {
    if (!isset($_GET['page']) || $_GET['page'] !== 'sarkarhost-settings') {
        return;
    }

    if (!current_user_can('manage_options')) {
        return;
    }

    // CSV Export
    if (isset($_GET['action']) && $_GET['action'] === 'export_leads') {
        check_admin_referer('sarkarhost_export_leads');
        $leads = sarkarhost_get_submissions();

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=sarkarhost-leads-' . date('Y-m-d-His') . '.csv');
        
        $output = fopen('php://output', 'w');
        // Add BOM for UTF-8 Excel support (Bangla)
        fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
        fputcsv($output, ['ID', 'Date & Time', 'Name', 'Phone', 'Email', 'Service / Topic', 'Message', 'Source', 'Status', 'Page URL']);

        foreach ($leads as $lead) {
            fputcsv($output, [
                $lead['id'] ?? '',
                $lead['created_at'] ?? '',
                $lead['name'] ?? '',
                $lead['phone'] ?? '',
                $lead['email'] ?? '',
                $lead['service'] ?? '',
                $lead['message'] ?? '',
                $lead['source'] ?? '',
                $lead['status'] ?? '',
                $lead['page_url'] ?? '',
            ]);
        }
        fclose($output);
        exit;
    }

    // Delete single lead
    if (isset($_GET['action']) && $_GET['action'] === 'delete_lead' && isset($_GET['lead_id'])) {
        check_admin_referer('sarkarhost_delete_lead_' . $_GET['lead_id']);
        sarkarhost_delete_submission(sanitize_text_field($_GET['lead_id']));
        wp_safe_redirect(admin_url('admin.php?page=sarkarhost-settings&tab=leads_list&deleted=1'));
        exit;
    }

    // Status change
    if (isset($_GET['action']) && $_GET['action'] === 'update_status' && isset($_GET['lead_id']) && isset($_GET['new_status'])) {
        check_admin_referer('sarkarhost_status_' . $_GET['lead_id']);
        sarkarhost_update_submission_status(sanitize_text_field($_GET['lead_id']), sanitize_text_field($_GET['new_status']));
        wp_safe_redirect(admin_url('admin.php?page=sarkarhost-settings&tab=leads_list&updated=1'));
        exit;
    }

    // Clear all
    if (isset($_GET['action']) && $_GET['action'] === 'clear_all_leads') {
        check_admin_referer('sarkarhost_clear_all_leads');
        sarkarhost_clear_all_submissions();
        wp_safe_redirect(admin_url('admin.php?page=sarkarhost-settings&tab=leads_list&cleared=1'));
        exit;
    }
}
add_action('admin_init', 'sarkarhost_handle_admin_actions');


/* ==========================================================================
   7. SMART MODERN SETTINGS PAGE UI
   ========================================================================== */
function sarkarhost_settings_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }

    $active_tab   = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'contact_info';
    $filter_status = isset($_GET['lead_status']) ? sanitize_text_field($_GET['lead_status']) : 'all';
    $search_query  = isset($_GET['lead_search']) ? sanitize_text_field($_GET['lead_search']) : '';
    
    $unread_count  = sarkarhost_get_unread_leads_count();
    $all_leads     = sarkarhost_get_submissions();
    $total_leads   = count($all_leads);

    $today_count   = 0;
    $today_date    = date('Y-m-d');
    foreach ($all_leads as $l) {
        if (isset($l['created_at']) && strpos($l['created_at'], $today_date) === 0) {
            $today_count++;
        }
    }

    // Filter leads if searching or filtering status
    $filtered_leads = $all_leads;
    if ($filter_status !== 'all') {
        $filtered_leads = array_values(array_filter($filtered_leads, function($item) use ($filter_status) {
            return isset($item['status']) && $item['status'] === $filter_status;
        }));
    }
    if (!empty($search_query)) {
        $q = mb_strtolower($search_query);
        $filtered_leads = array_values(array_filter($filtered_leads, function($item) use ($q) {
            $name    = mb_strtolower($item['name'] ?? '');
            $phone   = mb_strtolower($item['phone'] ?? '');
            $service = mb_strtolower($item['service'] ?? '');
            $message = mb_strtolower($item['message'] ?? '');
            return (strpos($name, $q) !== false || strpos($phone, $q) !== false || strpos($service, $q) !== false || strpos($message, $q) !== false);
        }));
    }

    $cf7_installed = class_exists('WPCF7');
    ?>
    <div class="wrap sh-admin-wrap" style="max-width: 1160px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
        
        <!-- Admin Header -->
        <div style="background: linear-gradient(135deg, #090a10 0%, #171c2d 100%); color: #fff; padding: 25px 30px; border-radius: 14px; margin-bottom: 25px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; border-left: 6px solid #2563eb;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 52px; height: 52px; border-radius: 12px; background: linear-gradient(135deg, #2563eb, #c4ee18); display: flex; align-items: center; justify-content: center; color: #000; font-size: 26px; box-shadow: 0 4px 15px rgba(37,99,235,0.4);">
                    <span class="dashicons dashicons-superhero-alt" style="font-size: 32px; width: 32px; height: 32px;"></span>
                </div>
                <div>
                    <h1 style="color: #fff; font-size: 24px; font-weight: 800; margin: 0; line-height: 1.2;">
                        Sarkar Host Control Panel
                    </h1>
                    <p style="color: #94a3b8; margin: 4px 0 0; font-size: 13px;">
                        থিম সেটিংস, লাইভ কালার, যোগাযোগ তথ্য, কন্টাক্ট ফর্ম এবং <strong style="color: #c4ee18;">সরাসরি লিড / ইনকোয়ারি ড্যাশবোর্ড</strong>
                    </p>
                </div>
            </div>

            <!-- Quick Hotline & WhatsApp Preview -->
            <div style="display: flex; gap: 12px;">
                <a href="<?php echo admin_url('admin.php?page=sarkarhost-settings&tab=leads_list'); ?>" style="background: rgba(37,99,235,0.2); border: 1px solid rgba(37,99,235,0.5); color: #93c5fd; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <span class="dashicons dashicons-email-alt" style="font-size: 18px; width: 18px; height: 18px;"></span>
                    মোট ইনকোয়ারি: <span style="background: #2563eb; color: #fff; padding: 1px 7px; border-radius: 12px; font-size: 11px; margin-left: 3px;"><?php echo $total_leads; ?></span>
                </a>
                <a href="<?php echo esc_url(home_url('/')); ?>" target="_blank" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2); color: #fff; padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 6px;">
                    <span class="dashicons dashicons-external" style="font-size: 18px; width: 18px; height: 18px;"></span>
                    ওয়েবসাইট দেখুন
                </a>
            </div>
        </div>

        <?php if (isset($_GET['deleted'])) : ?>
            <div class="notice notice-success is-dismissible"><p><strong>সফল হয়েছে:</strong> ইনকোয়ারিটি সফলভাবে ডিলিট করা হয়েছে।</p></div>
        <?php endif; ?>
        <?php if (isset($_GET['updated'])) : ?>
            <div class="notice notice-success is-dismissible"><p><strong>সফল হয়েছে:</strong> স্ট্যাটাস পরিবর্তন সফল হয়েছে।</p></div>
        <?php endif; ?>
        <?php if (isset($_GET['cleared'])) : ?>
            <div class="notice notice-warning is-dismissible"><p>সবগুলো ইনকোয়ারি রেকর্ড মুছে ফেলা হয়েছে।</p></div>
        <?php endif; ?>

        <?php settings_errors(); ?>

        <!-- Modern Tabs Navigation -->
        <div style="display: flex; gap: 8px; margin-bottom: 25px; flex-wrap: wrap; background: #f1f5f9; padding: 6px; border-radius: 10px;">
            <a href="?page=sarkarhost-settings&tab=contact_info" style="padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: all 0.2s; <?php echo $active_tab == 'contact_info' ? 'background: #2563eb; color: #fff; box-shadow: 0 4px 10px rgba(37,99,235,0.3);' : 'color: #475569; background: transparent;'; ?>">
                <span class="dashicons dashicons-phone" style="font-size: 18px; width: 18px; height: 18px;"></span>
                যোগাযোগ ও অফিস
            </a>
            
            <a href="?page=sarkarhost-settings&tab=color_settings" style="padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: all 0.2s; <?php echo $active_tab == 'color_settings' ? 'background: #2563eb; color: #fff; box-shadow: 0 4px 10px rgba(37,99,235,0.3);' : 'color: #475569; background: transparent;'; ?>">
                <span class="dashicons dashicons-art" style="font-size: 18px; width: 18px; height: 18px;"></span>
                কালার ও ব্র্যান্ডিং
            </a>

            <a href="?page=sarkarhost-settings&tab=leads_list" style="padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: all 0.2s; <?php echo $active_tab == 'leads_list' ? 'background: #2563eb; color: #fff; box-shadow: 0 4px 10px rgba(37,99,235,0.3);' : 'color: #475569; background: transparent;'; ?>">
                <span class="dashicons dashicons-email-alt" style="font-size: 18px; width: 18px; height: 18px;"></span>
                📨 Leads & Inquiries
                <?php if ($unread_count > 0): ?>
                    <span style="background: #ef4444; color: #fff; font-size: 11px; padding: 2px 7px; border-radius: 10px; font-weight: 800;"><?php echo $unread_count; ?> NEW</span>
                <?php else: ?>
                    <span style="background: rgba(0,0,0,0.08); color: #64748b; font-size: 11px; padding: 2px 7px; border-radius: 10px;"><?php echo $total_leads; ?></span>
                <?php endif; ?>
            </a>

            <a href="?page=sarkarhost-settings&tab=cf7_settings" style="padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: all 0.2s; <?php echo $active_tab == 'cf7_settings' ? 'background: #2563eb; color: #fff; box-shadow: 0 4px 10px rgba(37,99,235,0.3);' : 'color: #475569; background: transparent;'; ?>">
                <span class="dashicons dashicons-forms" style="font-size: 18px; width: 18px; height: 18px;"></span>
                Contact Form 7
            </a>

            <a href="?page=sarkarhost-settings&tab=shortcodes_list" style="padding: 10px 18px; border-radius: 8px; font-weight: 600; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; gap: 8px; transition: all 0.2s; <?php echo $active_tab == 'shortcodes_list' ? 'background: #2563eb; color: #fff; box-shadow: 0 4px 10px rgba(37,99,235,0.3);' : 'color: #475569; background: transparent;'; ?>">
                <span class="dashicons dashicons-shortcode" style="font-size: 18px; width: 18px; height: 18px;"></span>
                শর্টকোড গাইড
            </a>
        </div>

        <!-- TAB 1: CONTACT INFO -->
        <?php if ($active_tab == 'contact_info') : ?>
        <form method="post" action="options.php" style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <?php settings_fields('sarkarhost_settings_group'); ?>

            <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 25px;">
                <h2 style="margin: 0; color: #0f172a; font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <span class="dashicons dashicons-phone" style="color: #2563eb;"></span>
                    মূল যোগাযোগ ও হটলাইন তথ্য
                </h2>
                <p style="color: #64748b; margin: 5px 0 0; font-size: 13px;">
                    এখানে দেওয়া ফোন ও হোয়াটসঅ্যাপ নম্বর সাইটের হেডার, ফুটার, কল বাটন ও চ্যাটে লাইভ কাজ করবে।
                </p>
            </div>

            <table class="form-table" style="margin-bottom: 25px;">
                <tr>
                    <th scope="row" style="font-weight: 600; width: 260px;">
                        <label for="sarkarhost_phone">📞 হটলাইন নম্বর (Phone)</label>
                    </th>
                    <td>
                        <input type="text" id="sarkarhost_phone" name="sarkarhost_phone" value="<?php echo esc_attr(sarkarhost_get_opt('sarkarhost_phone', '01321-222308')); ?>" class="regular-text" placeholder="01321-222308" style="padding: 8px 12px; border-radius: 6px;">
                        <p class="description">ওয়েবসাইটের সব কল বাটনে এই নম্বরটি যাবে।</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="font-weight: 600;">
                        <label for="sarkarhost_whatsapp">💬 WhatsApp নম্বর (Country Code সহ)</label>
                    </th>
                    <td>
                        <input type="text" id="sarkarhost_whatsapp" name="sarkarhost_whatsapp" value="<?php echo esc_attr(sarkarhost_get_opt('sarkarhost_whatsapp', '8801321222308')); ?>" class="regular-text" placeholder="8801321222308" style="padding: 8px 12px; border-radius: 6px;">
                        <p class="description">যেমন: <code>8801321222308</code> (কোনো <code>+</code> চিহ্ন বা স্পেস ছাড়া লিখুন)। সার্ভিস অর্ডার ও চ্যাট মেসেজ এই নম্বরে সরাসরি যাবে।</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="font-weight: 600;">
                        <label for="sarkarhost_email">✉️ অফিসিয়াল ইমেইল (Email)</label>
                    </th>
                    <td>
                        <input type="email" id="sarkarhost_email" name="sarkarhost_email" value="<?php echo esc_attr(sarkarhost_get_opt('sarkarhost_email', 'info@sarkarhost.com')); ?>" class="regular-text" style="padding: 8px 12px; border-radius: 6px;">
                    </td>
                </tr>
            </table>

            <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; margin: 35px 0 25px;">
                <h2 style="margin: 0; color: #0f172a; font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <span class="dashicons dashicons-location" style="color: #2563eb;"></span>
                    অফিস ঠিকানা ও গুগল ম্যাপ লোকেশন
                </h2>
            </div>

            <table class="form-table">
                <tr>
                    <th scope="row" style="font-weight: 600; width: 260px;">
                        <label for="sarkarhost_nilphamari_address">📍 নীলফামারী অফিস ঠিকানা</label>
                    </th>
                    <td>
                        <textarea id="sarkarhost_nilphamari_address" name="sarkarhost_nilphamari_address" rows="2" class="large-text" style="padding: 8px 12px; border-radius: 6px;"><?php echo esc_textarea(sarkarhost_get_opt('sarkarhost_nilphamari_address', '1st Floor, Zaman Arcade Shopping Complex (Opposite Nilphamari Pouro Market), Nilphamari Sadar, Nilphamari 5300')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="font-weight: 600;">
                        <label for="sarkarhost_nilphamari_map">🗺️ নীলফামারী Google Map URL</label>
                    </th>
                    <td>
                        <input type="url" id="sarkarhost_nilphamari_map" name="sarkarhost_nilphamari_map" value="<?php echo esc_attr(sarkarhost_get_opt('sarkarhost_nilphamari_map', 'https://maps.app.goo.gl/q4gzpCK4V6wKPCEs7')); ?>" class="large-text" style="padding: 8px 12px; border-radius: 6px;">
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="font-weight: 600;">
                        <label for="sarkarhost_dhaka_address">📍 ঢাকা অফিস ঠিকানা</label>
                    </th>
                    <td>
                        <textarea id="sarkarhost_dhaka_address" name="sarkarhost_dhaka_address" rows="2" class="large-text" style="padding: 8px 12px; border-radius: 6px;"><?php echo esc_textarea(sarkarhost_get_opt('sarkarhost_dhaka_address', '1st Floor, House No: 17, Road No: 01, Mohammadi Housing Limited, Mohammadpur, Dhaka – 1207')); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="font-weight: 600;">
                        <label for="sarkarhost_dhaka_note">📌 ঢাকা অফিসের ল্যান্ডমার্ক / বিশেষ নোট</label>
                    </th>
                    <td>
                        <input type="text" id="sarkarhost_dhaka_note" name="sarkarhost_dhaka_note" value="<?php echo esc_attr(sarkarhost_get_opt('sarkarhost_dhaka_note', 'Limited 1-এ প্রবেশ করার পর মসজিদের আগের বিল্ডিং, Nasir Garden-এর ২য় তলায় আমাদের অফিস অবস্থিত।')); ?>" class="large-text" style="padding: 8px 12px; border-radius: 6px;">
                    </td>
                </tr>
                <tr>
                    <th scope="row" style="font-weight: 600;">
                        <label for="sarkarhost_dhaka_map">🗺️ ঢাকা Google Map URL</label>
                    </th>
                    <td>
                        <input type="url" id="sarkarhost_dhaka_map" name="sarkarhost_dhaka_map" value="<?php echo esc_attr(sarkarhost_get_opt('sarkarhost_dhaka_map', 'https://share.google/qL7pM0T8qyyz0MePj')); ?>" class="large-text" style="padding: 8px 12px; border-radius: 6px;">
                    </td>
                </tr>
            </table>

            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <?php submit_button(__('Save Changes (তথ্য সংরক্ষণ করুন)', 'sarkarhost'), 'primary', 'submit', false, ['style' => 'background: #2563eb; border-color: #2563eb; padding: 8px 28px; font-weight: 700; border-radius: 8px;']); ?>
            </div>
        </form>
        <?php endif; ?>


        <!-- TAB 2: COLOR SETTINGS -->
        <?php if ($active_tab == 'color_settings') : 
            $color_defaults = function_exists('sarkarhost_get_theme_color_defaults') ? sarkarhost_get_theme_color_defaults() : [];
            
            // Helper closure for color cards
            $render_color_card = function($key, $label_bn, $label_en, $var_name, $default_val) {
                $current_val = sarkarhost_get_opt($key, $default_val);
                ?>
                <div class="sh-color-card" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); transition: all 0.2s;" data-key="<?php echo esc_attr($key); ?>" data-default="<?php echo esc_attr($default_val); ?>">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px;">
                        <div>
                            <label for="<?php echo esc_attr($key); ?>" style="font-weight: 700; color: #0f172a; font-size: 13.5px; display: block; line-height: 1.3;">
                                <?php echo esc_html($label_bn); ?>
                            </label>
                            <span style="font-size: 11px; color: #64748b;"><?php echo esc_html($label_en); ?></span>
                        </div>
                        <code style="font-size: 10.5px; background: #f1f5f9; color: #2563eb; padding: 2px 6px; border-radius: 4px;"><?php echo esc_html($var_name); ?></code>
                    </div>

                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input type="color" id="<?php echo esc_attr($key); ?>_picker" value="<?php echo esc_attr($current_val); ?>" class="sh-color-picker" style="height: 38px; width: 48px; border: 1px solid #cbd5e1; border-radius: 6px; cursor: pointer; padding: 2px; background: #fff;">
                        <input type="text" id="<?php echo esc_attr($key); ?>" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($current_val); ?>" class="sh-color-text" maxlength="7" placeholder="<?php echo esc_attr($default_val); ?>" style="flex: 1; font-family: monospace; font-size: 13px; font-weight: 600; padding: 7px 10px; border-radius: 6px; border: 1px solid #cbd5e1; text-transform: uppercase;">
                        <button type="button" class="button button-small sh-reset-single" title="Default: <?php echo esc_attr($default_val); ?>" style="padding: 0 8px; height: 32px; line-height: 30px;" onclick="shResetColor('<?php echo esc_js($key); ?>', '<?php echo esc_js($default_val); ?>')">
                            ↺
                        </button>
                    </div>
                </div>
                <?php
            };
        ?>
        <form method="post" action="options.php" id="sh-color-form" style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <?php settings_fields('sarkarhost_settings_group'); ?>

            <!-- Header -->
            <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 18px; margin-bottom: 25px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                <div>
                    <h2 style="margin: 0; color: #0f172a; font-size: 20px; font-weight: 800; display: flex; align-items: center; gap: 8px;">
                        <span class="dashicons dashicons-art" style="color: #2563eb; font-size: 24px; width: 24px; height: 24px;"></span>
                        গ্লোবাল কালার প্যালেট ও থিম স্টাইলিং
                    </h2>
                    <p style="color: #64748b; margin: 4px 0 0; font-size: 13px;">
                        এখানে ব্যাকগ্রাউন্ড, বাটন, কার্ড, টেক্সট ও অ্যাকসেন্টের প্রতিটি কালার পরিবর্তন করুন — সাথে সাথে লাইভ প্রিভিউতে পরিবর্তন দেখুন!
                    </p>
                </div>
                <div style="display: flex; gap: 10px;">
                    <?php submit_button(__('💾 কালার সংরক্ষণ করুন', 'sarkarhost'), 'primary', 'submit_top', false, ['style' => 'background: #2563eb; border-color: #2563eb; padding: 6px 22px; font-weight: 700; border-radius: 8px; font-size: 13.5px;']); ?>
                </div>
            </div>

            <!-- Quick Preset Palettes Toolbar -->
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px; margin-bottom: 30px;">
                <div style="font-weight: 700; color: #0f172a; font-size: 14px; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                    <span class="dashicons dashicons-color-picker" style="color: #2563eb;"></span>
                    ⚡ ১-ক্লিকে রেডিমেড কালার প্রিসেট প্যালেট প্রয়োগ করুন:
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                    <button type="button" class="button sh-preset-btn" onclick="shApplyPreset('clean_white')" style="display: flex; align-items: center; gap: 8px; font-weight: 700; padding: 6px 14px; height: auto; border-color: #2563eb; background: #eff6ff; color: #1e40af;">
                        <span style="display: flex; gap: 3px;">
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #ffffff; border: 1px solid #94a3b8;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #0f172a;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #2563eb;"></span>
                        </span>
                        ☀️ Clean White (লাইট মোড / হোয়াইট বিজি)
                    </button>

                    <button type="button" class="button sh-preset-btn" onclick="shApplyPreset('nordic_frost')" style="display: flex; align-items: center; gap: 8px; font-weight: 600; padding: 6px 14px; height: auto; background: #f0fdf4; border-color: #0284c7; color: #0369a1;">
                        <span style="display: flex; gap: 3px;">
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #f8fafc; border: 1px solid #94a3b8;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #0f172a;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #0284c7;"></span>
                        </span>
                        ❄️ Nordic Frost (সফট লাইট)
                    </button>

                    <button type="button" class="button sh-preset-btn" onclick="shApplyPreset('cyber_tech')" style="display: flex; align-items: center; gap: 8px; font-weight: 600; padding: 6px 14px; height: auto;">
                        <span style="display: flex; gap: 3px;">
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #2563eb;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #c4ee18;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #090a10; border: 1px solid #64748b;"></span>
                        </span>
                        Cyber Tech (ডিফল্ট ডার্ক)
                    </button>

                    <button type="button" class="button sh-preset-btn" onclick="shApplyPreset('midnight_sapphire')" style="display: flex; align-items: center; gap: 8px; font-weight: 600; padding: 6px 14px; height: auto;">
                        <span style="display: flex; gap: 3px;">
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #3b82f6;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #38bdf8;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #030712; border: 1px solid #64748b;"></span>
                        </span>
                        Midnight Sapphire
                    </button>

                    <button type="button" class="button sh-preset-btn" onclick="shApplyPreset('emerald_matrix')" style="display: flex; align-items: center; gap: 8px; font-weight: 600; padding: 6px 14px; height: auto;">
                        <span style="display: flex; gap: 3px;">
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #10b981;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #a3e635;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #022c22; border: 1px solid #64748b;"></span>
                        </span>
                        Emerald Matrix
                    </button>

                    <button type="button" class="button sh-preset-btn" onclick="shApplyPreset('royal_purple')" style="display: flex; align-items: center; gap: 8px; font-weight: 600; padding: 6px 14px; height: auto;">
                        <span style="display: flex; gap: 3px;">
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #8b5cf6;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #f43f5e;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #0b0718; border: 1px solid #64748b;"></span>
                        </span>
                        Royal Cyberpunk
                    </button>

                    <button type="button" class="button sh-preset-btn" onclick="shApplyPreset('sunset_crimson')" style="display: flex; align-items: center; gap: 8px; font-weight: 600; padding: 6px 14px; height: auto;">
                        <span style="display: flex; gap: 3px;">
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #f97316;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #facc15;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #0c0a09; border: 1px solid #64748b;"></span>
                        </span>
                        Sunset Crimson
                    </button>

                    <button type="button" class="button" onclick="shResetAllDefaults()" style="color: #dc2626; border-color: #fca5a5; background: #fff; margin-left: auto; font-weight: 600;">
                        ↺ Reset All to Defaults
                    </button>
                </div>
            </div>

            <!-- Interactive Live Mini-Preview Component -->
            <div style="background: #0f172a; border-radius: 12px; padding: 22px; margin-bottom: 35px; border: 1px solid #334155; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 10px;">
                    <div style="color: #fff; font-weight: 700; font-size: 14px; display: flex; align-items: center; gap: 8px;">
                        <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background: #22c55e; animation: pulse 1.5s infinite;"></span>
                        🖥️ লাইভ রিয়েল-টাইম প্রিভিউ (Live Preview)
                    </div>
                    <span style="color: #94a3b8; font-size: 12px;">নিচের যেকোনো কালার পরিবর্তনের সাথে সাথে এখানে লাইভ প্রিভিউ পরিবর্তিত হবে</span>
                </div>

                <!-- Preview Window -->
                <div id="sh-live-preview-box" style="background-color: #090a10; border-radius: 10px; padding: 25px; border: 1px solid #222738; color: #f8fafc; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; transition: all 0.3s ease;">
                    
                    <!-- Preview Navbar -->
                    <div id="prev-header" style="display: flex; justify-content: space-between; align-items: center; background: #0f121d; padding: 12px 18px; border-radius: 8px; border: 1px solid #222738; margin-bottom: 20px;">
                        <div style="font-weight: 800; font-size: 16px; display: flex; align-items: center; gap: 6px;">
                            <span id="prev-logo-dot" style="width: 12px; height: 12px; border-radius: 3px; background: #2563eb;"></span>
                            <span id="prev-logo-text" style="color: #ffffff;">Sarkar Host</span>
                        </div>
                        <div style="display: flex; gap: 15px; font-size: 13px; font-weight: 600;">
                            <span id="prev-nav-active" style="color: #c4ee18; border-bottom: 2px solid #c4ee18; padding-bottom: 2px;">হোমপেজ</span>
                            <span id="prev-nav-item" style="color: #94a3b8;">সেবাসমূহ</span>
                            <span style="color: #94a3b8;">হোস্টিং</span>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <span id="prev-call-btn" style="background: #2563eb; color: #ffffff; padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 700;">📞 01321-222308</span>
                        </div>
                    </div>

                    <!-- Preview Hero & Card Grid -->
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; align-items: center;">
                        <!-- Hero Text Area -->
                        <div>
                            <div id="prev-badge" style="display: inline-flex; align-items: center; gap: 6px; background: rgba(196, 238, 24, 0.15); border: 1px solid #c4ee18; color: #c4ee18; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; margin-bottom: 12px;">
                                ⚡ টপ রেটেড আইটি ও হোস্টিং সলিউশন
                            </div>
                            <h3 id="prev-hero-title" style="color: #f8fafc; font-size: 20px; font-weight: 800; line-height: 1.3; margin: 0 0 10px;">
                                আপনার বিজনেসের জন্য <span id="prev-hero-highlight" style="color: #c4ee18;">প্রফেশনাল ডিজিটাল</span> সার্ভিস
                            </h3>
                            <p id="prev-hero-desc" style="color: #94a3b8; font-size: 13px; margin: 0 0 16px; line-height: 1.5;">
                                ওয়েবসাইট ডেভেলপমেন্ট, বিডিআইএক্স হোস্টিং এবং গুগল টপ র‍্যাংকিং এসইও সার্ভিস দিয়ে আপনার ব্যবসাকে নিয়ে যান অনন্য উচ্চতায়।
                            </p>
                            <div style="display: flex; gap: 10px;">
                                <span id="prev-btn-primary" style="background: #2563eb; color: #ffffff; padding: 8px 16px; border-radius: 6px; font-weight: 700; font-size: 12.5px; box-shadow: 0 4px 14px rgba(37,99,235,0.4);">
                                    অর্ডার করুন →
                                </span>
                                <span id="prev-btn-wa" style="background: #25d366; color: #ffffff; padding: 8px 14px; border-radius: 6px; font-weight: 700; font-size: 12.5px;">
                                    💬 WhatsApp
                                </span>
                            </div>
                        </div>

                        <!-- Service Card Sample -->
                        <div id="prev-card" style="background: #151928; border: 1px solid #222738; border-radius: 10px; padding: 20px; box-shadow: 0 8px 20px rgba(0,0,0,0.3);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <span id="prev-card-icon" style="width: 36px; height: 36px; border-radius: 8px; background: rgba(37,99,235,0.15); color: #2563eb; display: flex; align-items: center; justify-content: center; font-size: 16px; font-weight: bold;">⚡</span>
                                <span id="prev-card-status" style="background: rgba(34,197,94,0.15); color: #22c55e; font-size: 10px; font-weight: 700; padding: 2px 8px; border-radius: 12px;">৯৯.৯% আপটাইম</span>
                            </div>
                            <h4 id="prev-card-title" style="color: #f8fafc; font-size: 15px; font-weight: 700; margin: 0 0 6px;">BDIX NVMe হোস্টিং প্যাকেজ</h4>
                            <p id="prev-card-text" style="color: #94a3b8; font-size: 12px; margin: 0 0 12px; line-height: 1.4;">সুপার ফাস্ট লোডিং স্পিড এবং আনলিমিটেড ফ্রি SSL সার্টিফিকেট সহ সম্পূর্ণ সিকিউর হোস্টিং।</p>
                            <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #222738; padding-top: 10px;">
                                <span id="prev-card-price" style="font-size: 13px; font-weight: 800; color: #c4ee18;">৳৯৯৯ / বছর</span>
                                <span id="prev-card-btn" style="color: #2563eb; font-size: 12px; font-weight: 700;">বিস্তারিত দেখুন &rarr;</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- SECTION 1: MAIN BRAND & ACCENTS -->
            <div style="margin-bottom: 35px;">
                <div style="border-left: 4px solid #2563eb; padding-left: 12px; margin-bottom: 18px;">
                    <h3 style="margin: 0; color: #0f172a; font-size: 16px; font-weight: 800;">
                        🎨 ১. মূল ব্র্যান্ড ও অ্যাকসেন্ট কালার (Brand & Accent Colors)
                    </h3>
                    <p style="margin: 2px 0 0; color: #64748b; font-size: 12.5px;">সাইটের মূল বাটন, হেডিং হাইলাইট, সার্ভিস ব্যাজ এবং গ্রেডিয়েন্টে ব্যবহৃত কালার</p>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                    <?php 
                    $render_color_card('sarkarhost_primary_color', 'Primary Brand Color', 'মূল বাটন, আইকন ও ফোকাস', '--primary', '#2563eb');
                    $render_color_card('sarkarhost_primary_hover', 'Primary Hover Color', 'বাটন হোভার ইফেক্ট কালার', '--primary-hover', '#1d4ed8');
                    $render_color_card('sarkarhost_accent_lime', 'Accent Lime Green', 'হিরো ট্যাগ ও হাইলাইট পিল', '--accent-lime', '#c4ee18');
                    $render_color_card('sarkarhost_accent_cyan', 'Accent Cyan / Sky', 'ডিজিটাল সলিউশন ও ট্যাগ', '--accent-cyan', '#06b6d4');
                    $render_color_card('sarkarhost_accent_purple', 'Accent Purple', 'ওয়েব ডেভেলপমেন্ট ব্যাজ ও গ্রেডিয়েন্ট', '--accent-purple', '#8b5cf6');
                    $render_color_card('sarkarhost_accent_green', 'Accent Green', 'হোস্টিং ব্যাজ ও সক্রিয় স্টেট', '--accent-green', '#10b981');
                    $render_color_card('sarkarhost_accent_orange', 'Accent Orange', 'মার্কেটিং ও স্পিড ইন্ডিকেটর', '--accent-orange', '#f97316');
                    $render_color_card('sarkarhost_accent_yellow', 'Accent Yellow / Star', 'এসইও ব্যাজ ও স্টার রেটিং', '--accent-yellow', '#facc15');
                    $render_color_card('sarkarhost_accent_pink', 'Accent Pink / Magenta', 'গ্রাফিক্স ডিজাইন ব্যাজ ও ক্রিয়েটিভ', '--accent-pink', '#f472b6');
                    ?>
                </div>
            </div>

            <!-- SECTION 2: BACKGROUNDS & SURFACES -->
            <div style="margin-bottom: 35px;">
                <div style="border-left: 4px solid #090a10; padding-left: 12px; margin-bottom: 18px;">
                    <h3 style="margin: 0; color: #0f172a; font-size: 16px; font-weight: 800;">
                        🌌 ২. ব্যাকগ্রাউন্ড ও সারফেস কালার (Backgrounds & Surface Layers)
                    </h3>
                    <p style="margin: 2px 0 0; color: #64748b; font-size: 12.5px;">সাইটের মূল পেজ ব্যাকগ্রাউন্ড, হেডার-ফুটার ও বিভিন্ন কার্ডের ব্যাকগ্রাউন্ড</p>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                    <?php 
                    $render_color_card('sarkarhost_bg_dark', 'Main Dark Background', 'ওয়েবসাইটের সম্পূর্ণ মূল ব্যাকগ্রাউন্ড', '--bg-dark', '#090a10');
                    $render_color_card('sarkarhost_bg_dark_secondary', 'Secondary Background', 'হেডার, ফুটার ও অলটারনেটিভ সেকশন', '--bg-dark-secondary', '#0f121d');
                    $render_color_card('sarkarhost_bg_surface', 'Surface / Dropdown BG', 'ড্রপডাউন মেনু, মডাল ও ইনপুট সারফেস', '--bg-surface', '#141824');
                    $render_color_card('sarkarhost_bg_card', 'Card Base Background', 'সার্ভিস কার্ড ও প্যাকেজ বক্সের ব্যাকগ্রাউন্ড', '--bg-card', '#151928');
                    $render_color_card('sarkarhost_bg_card_hover', 'Card Hover Background', 'কার্ডে মাউস হোভার করলে পরিবর্তিত ব্যাকগ্রাউন্ড', '--bg-card-hover', '#1b2135');
                    ?>
                </div>
            </div>

            <!-- SECTION 3: TYPOGRAPHY & TEXT -->
            <div style="margin-bottom: 35px;">
                <div style="border-left: 4px solid #94a3b8; padding-left: 12px; margin-bottom: 18px;">
                    <h3 style="margin: 0; color: #0f172a; font-size: 16px; font-weight: 800;">
                        ✍️ ৩. টেক্সট ও টাইপোগ্রাফি কালার (Typography & Text Colors)
                    </h3>
                    <p style="margin: 2px 0 0; color: #64748b; font-size: 12.5px;">হেডিং, প্যারাগ্রাফ, সাবটাইটেল এবং ব্রাইট হাইলাইটের উপর টেক্সট কালার</p>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                    <?php 
                    $render_color_card('sarkarhost_text_main', 'Main Text / Headings', 'প্রধান হেডিং ও মূল বডি টেক্সট', '--text-main', '#f8fafc');
                    $render_color_card('sarkarhost_text_muted', 'Muted Text', 'সাবটাইটেল ও বর্ণনামূলক টেক্সট', '--text-muted', '#94a3b8');
                    $render_color_card('sarkarhost_text_dim', 'Dim / Meta Text', 'টাইমস্ট্যাম্প, মেটা ও ফুটনোট টেক্সট', '--text-dim', '#64748b');
                    $render_color_card('sarkarhost_text_white', 'Pure White Text', 'সম্পূর্ণ সাদা টেক্সট কালার', '--text-white', '#ffffff');
                    $render_color_card('sarkarhost_text_dark', 'Dark Contrast Text', 'উজ্জ্বল লাইম/হলুদ ব্যাকগ্রাউন্ডের ওপর টেক্সট', '--text-dark', '#090a10');
                    ?>
                </div>
            </div>

            <!-- SECTION 4: BORDERS, FOCUS & GLOW -->
            <div style="margin-bottom: 35px;">
                <div style="border-left: 4px solid #c4ee18; padding-left: 12px; margin-bottom: 18px;">
                    <h3 style="margin: 0; color: #0f172a; font-size: 16px; font-weight: 800;">
                        🔲 ৪. বর্ডার, ফোকাস ও গ্লো ইফেক্ট (Borders, Focus & Glow Effects)
                    </h3>
                    <p style="margin: 2px 0 0; color: #64748b; font-size: 12.5px;">কার্ডের বর্ডার লাইন, ইনপুট ফোকাস এবং হিরো সেকশনের গ্লো লাইট কালার</p>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                    <?php 
                    $render_color_card('sarkarhost_border_color', 'Default Border Color', 'কার্ড ও কন্টেইনারের স্বাভাবিক বর্ডার', '--border-color', '#222738');
                    $render_color_card('sarkarhost_border_hover', 'Border Hover Color', 'কার্ডে মাউস নিলে অ্যাক্টিভ বর্ডার', '--border-hover', '#c4ee18');
                    $render_color_card('sarkarhost_border_focus', 'Input Focus Border', 'ফর্মের ইনপুট ফিল্ড সিলেক্ট করলে বর্ডার', '--border-focus', '#2563eb');
                    $render_color_card('sarkarhost_primary_glow', 'Primary Glow Color', 'হিরো ব্যাকগ্রাউন্ড ও বাটনের গ্লো লাইট', '--primary-glow', '#2563eb');
                    ?>
                </div>
            </div>

            <!-- SECTION 5: ACTION & STATUS BUTTONS -->
            <div style="margin-bottom: 30px;">
                <div style="border-left: 4px solid #25d366; padding-left: 12px; margin-bottom: 18px;">
                    <h3 style="margin: 0; color: #0f172a; font-size: 16px; font-weight: 800;">
                        ⚡ ৫. অ্যাকশন বাটন ও স্ট্যাটাস ব্যাজ (Action & Status Colors)
                    </h3>
                    <p style="margin: 2px 0 0; color: #64748b; font-size: 12.5px;">হোয়াটসঅ্যাপ বাটন, ফোন কল বাটন, সফল ও সতর্কতা অ্যালার্ট কালার</p>
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                    <?php 
                    $render_color_card('sarkarhost_color_whatsapp', 'WhatsApp CTA Button', 'ফ্লোটিং ও সরাসরি হোয়াটসঅ্যাপ বাটন', '--color-whatsapp', '#25d366');
                    $render_color_card('sarkarhost_color_call', 'Direct Call Button', 'হেডার ও ফ্লোটিং ফোন কল বাটন', '--color-call', '#2563eb');
                    $render_color_card('sarkarhost_color_success', 'Success / Online Badge', 'সফল ফর্ম মেসেজ ও অনলাইন স্ট্যাটাস', '--color-success', '#22c55e');
                    $render_color_card('sarkarhost_color_error', 'Error / Alert Badge', 'ভুল তথ্য ও জরুরি নোটিফিকেশন অ্যালার্ট', '--color-error', '#ef4444');
                    ?>
                </div>
            </div>

            <!-- Bottom Save Button -->
            <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <button type="button" class="button" onclick="shResetAllDefaults()" style="color: #dc2626; border-color: #fca5a5; font-weight: 600;">
                    ↺ ডিফল্ট কালার রিস্টোর করুন (Reset Defaults)
                </button>
                <?php submit_button(__('Save Colors (সব কালার সংরক্ষণ করুন)', 'sarkarhost'), 'primary', 'submit', false, ['style' => 'background: #2563eb; border-color: #2563eb; padding: 10px 32px; font-weight: 800; border-radius: 8px; font-size: 14px;']); ?>
            </div>
        </form>

        <script>
        // Preset Palette Configurations
        const SH_PRESETS = {
            cyber_tech: {
                sarkarhost_primary_color: '#2563eb',
                sarkarhost_primary_hover: '#1d4ed8',
                sarkarhost_accent_lime: '#c4ee18',
                sarkarhost_accent_cyan: '#06b6d4',
                sarkarhost_accent_purple: '#8b5cf6',
                sarkarhost_accent_green: '#10b981',
                sarkarhost_accent_orange: '#f97316',
                sarkarhost_accent_yellow: '#facc15',
                sarkarhost_accent_pink: '#f472b6',
                sarkarhost_bg_dark: '#090a10',
                sarkarhost_bg_dark_secondary: '#0f121d',
                sarkarhost_bg_surface: '#141824',
                sarkarhost_bg_card: '#151928',
                sarkarhost_bg_card_hover: '#1b2135',
                sarkarhost_text_main: '#f8fafc',
                sarkarhost_text_muted: '#94a3b8',
                sarkarhost_text_dim: '#64748b',
                sarkarhost_text_white: '#ffffff',
                sarkarhost_text_dark: '#090a10',
                sarkarhost_border_color: '#222738',
                sarkarhost_border_hover: '#c4ee18',
                sarkarhost_border_focus: '#2563eb',
                sarkarhost_primary_glow: '#2563eb',
                sarkarhost_color_whatsapp: '#25d366',
                sarkarhost_color_call: '#2563eb',
                sarkarhost_color_success: '#22c55e',
                sarkarhost_color_error: '#ef4444'
            },
            midnight_sapphire: {
                sarkarhost_primary_color: '#3b82f6',
                sarkarhost_primary_hover: '#2563eb',
                sarkarhost_accent_lime: '#38bdf8',
                sarkarhost_accent_cyan: '#0ea5e9',
                sarkarhost_accent_purple: '#6366f1',
                sarkarhost_accent_green: '#06b6d4',
                sarkarhost_accent_orange: '#f59e0b',
                sarkarhost_accent_yellow: '#eab308',
                sarkarhost_accent_pink: '#ec4899',
                sarkarhost_bg_dark: '#030712',
                sarkarhost_bg_dark_secondary: '#0b0f19',
                sarkarhost_bg_surface: '#111827',
                sarkarhost_bg_card: '#1e293b',
                sarkarhost_bg_card_hover: '#334155',
                sarkarhost_text_main: '#f9fafb',
                sarkarhost_text_muted: '#9ca3af',
                sarkarhost_text_dim: '#6b7280',
                sarkarhost_text_white: '#ffffff',
                sarkarhost_text_dark: '#030712',
                sarkarhost_border_color: '#1f2937',
                sarkarhost_border_hover: '#38bdf8',
                sarkarhost_border_focus: '#3b82f6',
                sarkarhost_primary_glow: '#3b82f6',
                sarkarhost_color_whatsapp: '#22c55e',
                sarkarhost_color_call: '#3b82f6',
                sarkarhost_color_success: '#10b981',
                sarkarhost_color_error: '#ef4444'
            },
            emerald_matrix: {
                sarkarhost_primary_color: '#10b981',
                sarkarhost_primary_hover: '#059669',
                sarkarhost_accent_lime: '#a3e635',
                sarkarhost_accent_cyan: '#2dd4bf',
                sarkarhost_accent_purple: '#8b5cf6',
                sarkarhost_accent_green: '#22c55e',
                sarkarhost_accent_orange: '#f59e0b',
                sarkarhost_accent_yellow: '#facc15',
                sarkarhost_accent_pink: '#f43f5e',
                sarkarhost_bg_dark: '#022c22',
                sarkarhost_bg_dark_secondary: '#064e3b',
                sarkarhost_bg_surface: '#043a2d',
                sarkarhost_bg_card: '#065f46',
                sarkarhost_bg_card_hover: '#047857',
                sarkarhost_text_main: '#f0fdf4',
                sarkarhost_text_muted: '#86efac',
                sarkarhost_text_dim: '#4ade80',
                sarkarhost_text_white: '#ffffff',
                sarkarhost_text_dark: '#022c22',
                sarkarhost_border_color: '#065f46',
                sarkarhost_border_hover: '#a3e635',
                sarkarhost_border_focus: '#10b981',
                sarkarhost_primary_glow: '#10b981',
                sarkarhost_color_whatsapp: '#22c55e',
                sarkarhost_color_call: '#10b981',
                sarkarhost_color_success: '#22c55e',
                sarkarhost_color_error: '#ef4444'
            },
            royal_purple: {
                sarkarhost_primary_color: '#8b5cf6',
                sarkarhost_primary_hover: '#7c3aed',
                sarkarhost_accent_lime: '#f43f5e',
                sarkarhost_accent_cyan: '#38bdf8',
                sarkarhost_accent_purple: '#a855f7',
                sarkarhost_accent_green: '#10b981',
                sarkarhost_accent_orange: '#fb923c',
                sarkarhost_accent_yellow: '#facc15',
                sarkarhost_accent_pink: '#f472b6',
                sarkarhost_bg_dark: '#0b0718',
                sarkarhost_bg_dark_secondary: '#150d2e',
                sarkarhost_bg_surface: '#1c123d',
                sarkarhost_bg_card: '#271854',
                sarkarhost_bg_card_hover: '#3b207e',
                sarkarhost_text_main: '#fdf4ff',
                sarkarhost_text_muted: '#d8b4fe',
                sarkarhost_text_dim: '#a855f7',
                sarkarhost_text_white: '#ffffff',
                sarkarhost_text_dark: '#0b0718',
                sarkarhost_border_color: '#3b207e',
                sarkarhost_border_hover: '#f43f5e',
                sarkarhost_border_focus: '#8b5cf6',
                sarkarhost_primary_glow: '#8b5cf6',
                sarkarhost_color_whatsapp: '#25d366',
                sarkarhost_color_call: '#8b5cf6',
                sarkarhost_color_success: '#22c55e',
                sarkarhost_color_error: '#ef4444'
            },
            clean_white: {
                sarkarhost_primary_color: '#2563eb',
                sarkarhost_primary_hover: '#1d4ed8',
                sarkarhost_accent_lime: '#2563eb',
                sarkarhost_accent_cyan: '#0284c7',
                sarkarhost_accent_purple: '#7c3aed',
                sarkarhost_accent_green: '#16a34a',
                sarkarhost_accent_orange: '#ea580c',
                sarkarhost_accent_yellow: '#ca8a04',
                sarkarhost_accent_pink: '#db2777',
                sarkarhost_bg_dark: '#ffffff',
                sarkarhost_bg_dark_secondary: '#f8fafc',
                sarkarhost_bg_surface: '#ffffff',
                sarkarhost_bg_card: '#ffffff',
                sarkarhost_bg_card_hover: '#f1f5f9',
                sarkarhost_text_main: '#0f172a',
                sarkarhost_text_muted: '#475569',
                sarkarhost_text_dim: '#64748b',
                sarkarhost_text_white: '#ffffff',
                sarkarhost_text_dark: '#0f172a',
                sarkarhost_border_color: '#e2e8f0',
                sarkarhost_border_hover: '#2563eb',
                sarkarhost_border_focus: '#2563eb',
                sarkarhost_primary_glow: '#2563eb',
                sarkarhost_color_whatsapp: '#25d366',
                sarkarhost_color_call: '#2563eb',
                sarkarhost_color_success: '#16a34a',
                sarkarhost_color_error: '#dc2626'
            },
            nordic_frost: {
                sarkarhost_primary_color: '#0284c7',
                sarkarhost_primary_hover: '#0369a1',
                sarkarhost_accent_lime: '#0284c7',
                sarkarhost_accent_cyan: '#06b6d4',
                sarkarhost_accent_purple: '#6366f1',
                sarkarhost_accent_green: '#10b981',
                sarkarhost_accent_orange: '#f97316',
                sarkarhost_accent_yellow: '#eab308',
                sarkarhost_accent_pink: '#ec4899',
                sarkarhost_bg_dark: '#f8fafc',
                sarkarhost_bg_dark_secondary: '#f1f5f9',
                sarkarhost_bg_surface: '#ffffff',
                sarkarhost_bg_card: '#ffffff',
                sarkarhost_bg_card_hover: '#e2e8f0',
                sarkarhost_text_main: '#0f172a',
                sarkarhost_text_muted: '#334155',
                sarkarhost_text_dim: '#64748b',
                sarkarhost_text_white: '#ffffff',
                sarkarhost_text_dark: '#0f172a',
                sarkarhost_border_color: '#cbd5e1',
                sarkarhost_border_hover: '#0284c7',
                sarkarhost_border_focus: '#0284c7',
                sarkarhost_primary_glow: '#0284c7',
                sarkarhost_color_whatsapp: '#25d366',
                sarkarhost_color_call: '#0284c7',
                sarkarhost_color_success: '#16a34a',
                sarkarhost_color_error: '#dc2626'
            },
            sunset_crimson: {
                sarkarhost_primary_color: '#f97316',
                sarkarhost_primary_hover: '#ea580c',
                sarkarhost_accent_lime: '#facc15',
                sarkarhost_accent_cyan: '#38bdf8',
                sarkarhost_accent_purple: '#c084fc',
                sarkarhost_accent_green: '#10b981',
                sarkarhost_accent_orange: '#fb923c',
                sarkarhost_accent_yellow: '#fde047',
                sarkarhost_accent_pink: '#f43f5e',
                sarkarhost_bg_dark: '#0c0a09',
                sarkarhost_bg_dark_secondary: '#1c1917',
                sarkarhost_bg_surface: '#292524',
                sarkarhost_bg_card: '#3b2c28',
                sarkarhost_bg_card_hover: '#573d36',
                sarkarhost_text_main: '#fafaf9',
                sarkarhost_text_muted: '#d6d3d1',
                sarkarhost_text_dim: '#a8a29e',
                sarkarhost_text_white: '#ffffff',
                sarkarhost_text_dark: '#0c0a09',
                sarkarhost_border_color: '#44403c',
                sarkarhost_border_hover: '#facc15',
                sarkarhost_border_focus: '#f97316',
                sarkarhost_primary_glow: '#f97316',
                sarkarhost_color_whatsapp: '#25d366',
                sarkarhost_color_call: '#f97316',
                sarkarhost_color_success: '#22c55e',
                sarkarhost_color_error: '#ef4444'
            }
        };

        // Reset single color
        function shResetColor(key, defaultVal) {
            const txt = document.getElementById(key);
            const pkr = document.getElementById(key + '_picker');
            if (txt && pkr) {
                txt.value = defaultVal;
                pkr.value = defaultVal;
                shUpdateLivePreview();
            }
        }

        // Apply preset palette
        function shApplyPreset(presetKey) {
            const preset = SH_PRESETS[presetKey];
            if (!preset) return;
            for (const [key, val] of Object.entries(preset)) {
                const txt = document.getElementById(key);
                const pkr = document.getElementById(key + '_picker');
                if (txt && pkr) {
                    txt.value = val;
                    pkr.value = val;
                }
            }
            shUpdateLivePreview();
        }

        // Reset all to defaults
        function shResetAllDefaults() {
            if (!confirm('আপনি কি সব কালার ডিফল্ট সেটিংস-এ রিস্টোর করতে চান?')) return;
            shApplyPreset('cyber_tech');
        }

        // Update live preview in real-time
        function shUpdateLivePreview() {
            const getVal = (id, def) => {
                const el = document.getElementById(id);
                return (el && el.value) ? el.value : def;
            };

            const primary     = getVal('sarkarhost_primary_color', '#2563eb');
            const lime        = getVal('sarkarhost_accent_lime', '#c4ee18');
            const bgDark      = getVal('sarkarhost_bg_dark', '#090a10');
            const bgDarkSec   = getVal('sarkarhost_bg_dark_secondary', '#0f121d');
            const bgCard      = getVal('sarkarhost_bg_card', '#151928');
            const textMain    = getVal('sarkarhost_text_main', '#f8fafc');
            const textMuted   = getVal('sarkarhost_text_muted', '#94a3b8');
            const borderCol   = getVal('sarkarhost_border_color', '#222738');
            const callColor   = getVal('sarkarhost_color_call', '#2563eb');
            const waColor     = getVal('sarkarhost_color_whatsapp', '#25d366');

            // Apply to preview elements
            const box = document.getElementById('sh-live-preview-box');
            if (box) {
                box.style.backgroundColor = bgDark;
                box.style.borderColor = borderCol;
            }

            const header = document.getElementById('prev-header');
            if (header) {
                header.style.backgroundColor = bgDarkSec;
                header.style.borderColor = borderCol;
            }

            const logoDot = document.getElementById('prev-logo-dot');
            if (logoDot) logoDot.style.backgroundColor = primary;

            const logoText = document.getElementById('prev-logo-text');
            if (logoText) logoText.style.color = textMain;

            const navActive = document.getElementById('prev-nav-active');
            if (navActive) {
                navActive.style.color = lime;
                navActive.style.borderBottomColor = lime;
            }

            const navItem = document.getElementById('prev-nav-item');
            if (navItem) navItem.style.color = textMuted;

            const callBtn = document.getElementById('prev-call-btn');
            if (callBtn) callBtn.style.backgroundColor = callColor;

            const badge = document.getElementById('prev-badge');
            if (badge) {
                badge.style.borderColor = lime;
                badge.style.color = lime;
            }

            const heroTitle = document.getElementById('prev-hero-title');
            if (heroTitle) heroTitle.style.color = textMain;

            const heroHl = document.getElementById('prev-hero-highlight');
            if (heroHl) heroHl.style.color = lime;

            const heroDesc = document.getElementById('prev-hero-desc');
            if (heroDesc) heroDesc.style.color = textMuted;

            const btnPrimary = document.getElementById('prev-btn-primary');
            if (btnPrimary) btnPrimary.style.backgroundColor = primary;

            const btnWa = document.getElementById('prev-btn-wa');
            if (btnWa) btnWa.style.backgroundColor = waColor;

            const card = document.getElementById('prev-card');
            if (card) {
                card.style.backgroundColor = bgCard;
                card.style.borderColor = borderCol;
            }

            const cardTitle = document.getElementById('prev-card-title');
            if (cardTitle) cardTitle.style.color = textMain;

            const cardText = document.getElementById('prev-card-text');
            if (cardText) cardText.style.color = textMuted;

            const cardPrice = document.getElementById('prev-card-price');
            if (cardPrice) cardPrice.style.color = lime;

            const cardBtn = document.getElementById('prev-card-btn');
            if (cardBtn) cardBtn.style.color = primary;
        }

        // Initialize two-way synchronization on load
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.sh-color-picker').forEach(picker => {
                const targetTextId = picker.id.replace('_picker', '');
                const targetText = document.getElementById(targetTextId);

                picker.addEventListener('input', function() {
                    if (targetText) targetText.value = picker.value.toUpperCase();
                    shUpdateLivePreview();
                });
            });

            document.querySelectorAll('.sh-color-text').forEach(textInput => {
                const targetPicker = document.getElementById(textInput.id + '_picker');

                textInput.addEventListener('input', function() {
                    let val = textInput.value.trim();
                    if (!val.startsWith('#') && val.length > 0) {
                        val = '#' + val;
                        textInput.value = val;
                    }
                    if (/^#[0-9A-Fa-f]{6}$/.test(val)) {
                        if (targetPicker) targetPicker.value = val;
                        shUpdateLivePreview();
                    }
                });
            });

            // Initial preview sync
            shUpdateLivePreview();
        });
        </script>
        <?php endif; ?>


        <!-- TAB 3: LEADS & INQUIRIES DASHBOARD -->
        <?php if ($active_tab == 'leads_list') : ?>
        <div style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            
            <!-- Summary Metric Cards -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 30px;">
                <div style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(37,99,235,0.25);">
                    <div style="font-size: 13px; opacity: 0.9; text-transform: uppercase; font-weight: 600;">সর্বমোট ইনকোয়ারি</div>
                    <div style="font-size: 32px; font-weight: 800; margin-top: 4px;"><?php echo $total_leads; ?></div>
                    <div style="font-size: 12px; opacity: 0.8; margin-top: 4px;">সব ফর্ম থেকে প্রাপ্ত লিড</div>
                </div>

                <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(16,185,129,0.25);">
                    <div style="font-size: 13px; opacity: 0.9; text-transform: uppercase; font-weight: 600;">আজকের ইনকোয়ারি</div>
                    <div style="font-size: 32px; font-weight: 800; margin-top: 4px;"><?php echo $today_count; ?></div>
                    <div style="font-size: 12px; opacity: 0.8; margin-top: 4px;"><?php echo date('d M, Y'); ?></div>
                </div>

                <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(245,158,11,0.25);">
                    <div style="font-size: 13px; opacity: 0.9; text-transform: uppercase; font-weight: 600;">নতুন / অপেক্ষমাণ (New)</div>
                    <div style="font-size: 32px; font-weight: 800; margin-top: 4px;"><?php echo $unread_count; ?></div>
                    <div style="font-size: 12px; opacity: 0.8; margin-top: 4px;">এখনও যোগাযোগ করা হয়নি</div>
                </div>

                <div style="background: linear-gradient(135deg, #090a10 0%, #1e293b 100%); color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <div style="font-size: 13px; opacity: 0.9; text-transform: uppercase; font-weight: 600;">লিড এক্সপোর্ট</div>
                    <div style="margin-top: 10px;">
                        <?php
                        $export_url = wp_nonce_url(admin_url('admin.php?page=sarkarhost-settings&action=export_leads'), 'sarkarhost_export_leads');
                        ?>
                        <a href="<?php echo esc_url($export_url); ?>" style="background: #2563eb; color: #fff; padding: 8px 16px; border-radius: 6px; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 6px;">
                            <span class="dashicons dashicons-download" style="font-size: 16px; width: 16px; height: 16px;"></span>
                            Download CSV
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filter & Search Toolbar -->
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; padding: 15px; background: #f8fafc; border-radius: 8px; border: 1px solid #e2e8f0;">
                <!-- Filter Pills -->
                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                    <a href="?page=sarkarhost-settings&tab=leads_list&lead_status=all" style="padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; <?php echo $filter_status == 'all' ? 'background: #0f172a; color: #fff;' : 'background: #e2e8f0; color: #475569;'; ?>">
                        সবগুলো (<?php echo $total_leads; ?>)
                    </a>
                    <a href="?page=sarkarhost-settings&tab=leads_list&lead_status=new" style="padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; <?php echo $filter_status == 'new' ? 'background: #ef4444; color: #fff;' : 'background: #fee2e2; color: #991b1b;'; ?>">
                        নতুন (<?php echo $unread_count; ?>)
                    </a>
                    <a href="?page=sarkarhost-settings&tab=leads_list&lead_status=contacted" style="padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; <?php echo $filter_status == 'contacted' ? 'background: #3b82f6; color: #fff;' : 'background: #dbeafe; color: #1e40af;'; ?>">
                        যোগাযোগ সম্পন্ন
                    </a>
                    <a href="?page=sarkarhost-settings&tab=leads_list&lead_status=completed" style="padding: 6px 14px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; <?php echo $filter_status == 'completed' ? 'background: #10b981; color: #fff;' : 'background: #d1fae5; color: #065f46;'; ?>">
                        অর্ডার কনফার্মড
                    </a>
                </div>

                <!-- Search Box -->
                <form method="get" action="" style="display: flex; gap: 8px;">
                    <input type="hidden" name="page" value="sarkarhost-settings">
                    <input type="hidden" name="tab" value="leads_list">
                    <input type="hidden" name="lead_status" value="<?php echo esc_attr($filter_status); ?>">
                    <input type="search" name="lead_search" value="<?php echo esc_attr($search_query); ?>" placeholder="নাম, ফোন বা সার্ভিস সার্চ..." style="padding: 6px 12px; border-radius: 6px; border: 1px solid #cbd5e1; font-size: 13px; width: 220px;">
                    <button type="submit" class="button button-secondary" style="padding: 0 14px; font-weight: 600;">খুঁজুন</button>
                    <?php if (!empty($search_query)) : ?>
                        <a href="?page=sarkarhost-settings&tab=leads_list" class="button" style="color: #ef4444;">রিসেট</a>
                    <?php endif; ?>
                </form>
            </div>

            <!-- Leads Data Table -->
            <?php if (empty($filtered_leads)) : ?>
                <div style="text-align: center; padding: 50px 20px; background: #f8fafc; border-radius: 8px; border: 1px dashed #cbd5e1;">
                    <span class="dashicons dashicons-email" style="font-size: 48px; width: 48px; height: 48px; color: #94a3b8; margin-bottom: 10px;"></span>
                    <h3 style="margin: 0; color: #475569;">কোনো ইনকোয়ারি পাওয়া যায়নি</h3>
                    <p style="color: #94a3b8; font-size: 13px; margin: 6px 0 0;">ওয়েবসাইট বা কন্টাক্ট পেজ থেকে কেউ ফর্ম জমা দিলে বা WhatsApp মেসেজ পাঠালে এখানে স্বয়ংক্রিয়ভাবে দেখাবে।</p>
                </div>
            <?php else : ?>
                <div style="overflow-x: auto;">
                    <table class="wp-list-table widefat fixed striped" style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                        <thead>
                            <tr style="background: #0f172a; color: #fff;">
                                <th style="width: 14%; color: #fff; font-weight: 700; padding: 12px 10px;">তারিখ ও সময়</th>
                                <th style="width: 16%; color: #fff; font-weight: 700; padding: 12px 10px;">নাম</th>
                                <th style="width: 16%; color: #fff; font-weight: 700; padding: 12px 10px;">মোবাইল নম্বর</th>
                                <th style="width: 18%; color: #fff; font-weight: 700; padding: 12px 10px;">নির্বাচিত সেবা</th>
                                <th style="width: 20%; color: #fff; font-weight: 700; padding: 12px 10px;">মেসেজ</th>
                                <th style="width: 16%; color: #fff; font-weight: 700; padding: 12px 10px; text-align: center;">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($filtered_leads as $lead) : 
                                $raw_phone = preg_replace('/[^0-9]/', '', $lead['phone'] ?? '');
                                $status = $lead['status'] ?? 'new';
                                
                                $status_badge_style = 'background: #fee2e2; color: #b91c1c;';
                                $status_label = 'নতুন';
                                if ($status === 'contacted') {
                                    $status_badge_style = 'background: #dbeafe; color: #1d4ed8;';
                                    $status_label = 'যোগাযোগ সম্পন্ন';
                                } elseif ($status === 'completed') {
                                    $status_badge_style = 'background: #d1fae5; color: #047857;';
                                    $status_label = 'অর্ডার কনফার্মড';
                                }

                                $delete_url = wp_nonce_url(admin_url('admin.php?page=sarkarhost-settings&action=delete_lead&lead_id=' . urlencode($lead['id'])), 'sarkarhost_delete_lead_' . $lead['id']);
                                $status_url_contacted = wp_nonce_url(admin_url('admin.php?page=sarkarhost-settings&action=update_status&lead_id=' . urlencode($lead['id']) . '&new_status=contacted'), 'sarkarhost_status_' . $lead['id']);
                                $status_url_completed = wp_nonce_url(admin_url('admin.php?page=sarkarhost-settings&action=update_status&lead_id=' . urlencode($lead['id']) . '&new_status=completed'), 'sarkarhost_status_' . $lead['id']);
                            ?>
                            <tr style="<?php echo $status === 'new' ? 'background: #fffdf5;' : ''; ?>">
                                <td style="font-size: 12px; color: #64748b;">
                                    <strong><?php echo esc_html(date('d M, Y', strtotime($lead['created_at'] ?? 'now'))); ?></strong><br>
                                    <span><?php echo esc_html(date('h:i A', strtotime($lead['created_at'] ?? 'now'))); ?></span>
                                    <div style="margin-top: 4px;">
                                        <span style="font-size: 10px; font-weight: 700; padding: 2px 6px; border-radius: 4px; <?php echo $status_badge_style; ?>">
                                            <?php echo esc_html($status_label); ?>
                                        </span>
                                    </div>
                                </td>

                                <td>
                                    <strong style="color: #0f172a; font-size: 14px;"><?php echo esc_html($lead['name'] ?? 'N/A'); ?></strong>
                                    <?php if (!empty($lead['email'])) : ?>
                                        <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                                            <a href="mailto:<?php echo esc_attr($lead['email']); ?>" style="text-decoration: none; color: #2563eb;"><?php echo esc_html($lead['email']); ?></a>
                                        </div>
                                    <?php endif; ?>
                                    <div style="font-size: 10px; color: #94a3b8; margin-top: 2px;">উৎস: <?php echo esc_html($lead['source'] ?? 'Website'); ?></div>
                                </td>

                                <td>
                                    <strong style="font-size: 13.5px; color: #1e293b;"><?php echo esc_html($lead['phone'] ?? 'N/A'); ?></strong>
                                    <div style="display: flex; gap: 6px; margin-top: 6px;">
                                        <?php if (!empty($raw_phone)) : ?>
                                            <!-- Direct Call -->
                                            <a href="tel:<?php echo esc_attr($raw_phone); ?>" title="সরাসরি কল দিন" style="background: #e0f2fe; color: #0284c7; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;">
                                                <span class="dashicons dashicons-phone" style="font-size: 13px; width: 13px; height: 13px;"></span> Call
                                            </a>
                                            <!-- Direct WhatsApp -->
                                            <a href="https://wa.me/<?php echo (strpos($raw_phone, '88') === 0) ? $raw_phone : '88' . $raw_phone; ?>?text=<?php echo urlencode('হ্যালো ' . ($lead['name'] ?? '') . ', Sarkar Host থেকে আপনার ' . ($lead['service'] ?? '') . ' সম্পর্কিত ইনকোয়ারির জন্য যোগাযোগ করছি।'); ?>" target="_blank" title="WhatsApp-এ মেসেজ পাঠান" style="background: #dcfce7; color: #16a34a; padding: 4px 8px; border-radius: 4px; font-size: 11px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;">
                                                💬 WhatsApp
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <td>
                                    <span style="background: #eff6ff; color: #1d4ed8; font-weight: 700; font-size: 12px; padding: 4px 8px; border-radius: 4px; display: inline-block;">
                                        <?php echo esc_html($lead['service'] ?? 'General Inquiry'); ?>
                                    </span>
                                </td>

                                <td style="font-size: 12.5px; color: #334155;">
                                    <?php 
                                    $msg = $lead['message'] ?? '';
                                    if (empty($msg)) {
                                        echo '<span style="color: #94a3b8; font-style: italic;">(কোনো মেসেজ নেই)</span>';
                                    } else {
                                        echo nl2br(esc_html($msg));
                                    }
                                    ?>
                                </td>

                                <td style="text-align: center;">
                                    <div style="display: flex; flex-direction: column; gap: 5px; align-items: center;">
                                        <?php if ($status !== 'contacted') : ?>
                                            <a href="<?php echo esc_url($status_url_contacted); ?>" style="font-size: 11px; color: #2563eb; text-decoration: none; font-weight: 600; background: #f1f5f9; padding: 3px 8px; border-radius: 4px; width: 100%; text-align: center;">
                                                ✓ মার্ক Contacted
                                            </a>
                                        <?php endif; ?>
                                        <?php if ($status !== 'completed') : ?>
                                            <a href="<?php echo esc_url($status_url_completed); ?>" style="font-size: 11px; color: #16a34a; text-decoration: none; font-weight: 600; background: #f0fdf4; padding: 3px 8px; border-radius: 4px; width: 100%; text-align: center;">
                                                ✓ মার্ক Confirmed
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?php echo esc_url($delete_url); ?>" onclick="return confirm('আপনি কি নিশ্চিত যে এই ইনকোয়ারিটি ডিলিট করতে চান?');" style="font-size: 11px; color: #ef4444; text-decoration: none; font-weight: 600; background: #fef2f2; padding: 3px 8px; border-radius: 4px; width: 100%; text-align: center;">
                                            🗑️ ডিলিট
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Clear All Button -->
                <div style="margin-top: 25px; padding-top: 15px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end;">
                    <?php
                    $clear_url = wp_nonce_url(admin_url('admin.php?page=sarkarhost-settings&action=clear_all_leads'), 'sarkarhost_clear_all_leads');
                    ?>
                    <a href="<?php echo esc_url($clear_url); ?>" onclick="return confirm('⚠️ সতর্কবার্তা: আপনি কি নিশ্চিত যে সব ইনকোয়ারি চিরতরে মুছে ফেলতে চান?');" style="color: #991b1b; background: #fee2e2; padding: 6px 16px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none;">
                        🗑️ সব ইনকোয়ারি ক্লিয়ার করুন
                    </a>
                </div>
            <?php endif; ?>

        </div>
        <?php endif; ?>


        <!-- TAB 4: CONTACT FORM 7 -->
        <?php if ($active_tab == 'cf7_settings') : ?>
        <form method="post" action="options.php" style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <?php settings_fields('sarkarhost_settings_group'); ?>

            <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 25px;">
                <h2 style="margin: 0; color: #0f172a; font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <span class="dashicons dashicons-forms" style="color: #2563eb;"></span>
                    Contact Form 7 ইন্টিগ্রেশন ও অটো-কানেকশন
                </h2>
                <p style="color: #64748b; margin: 5px 0 0; font-size: 13px;">
                    Contact Form 7 প্লাগইন ব্যবহার করে ফর্ম তৈরি করলে তা স্বয়ংক্রিয়ভাবে থিমের লিড সিস্টেমে যুক্ত হয়ে যাবে।
                </p>
            </div>

            <!-- Plugin Status Alert -->
            <div style="background: <?php echo $cf7_installed ? '#f0fdf4' : '#fffbeb'; ?>; border: 1px solid <?php echo $cf7_installed ? '#86efac' : '#fde68a'; ?>; padding: 15px 20px; border-radius: 8px; margin-bottom: 25px; display: flex; align-items: center; gap: 12px;">
                <span class="dashicons <?php echo $cf7_installed ? 'dashicons-yes-alt' : 'dashicons-warning'; ?>" style="font-size: 24px; width: 24px; height: 24px; color: <?php echo $cf7_installed ? '#16a34a' : '#d97706'; ?>;"></span>
                <div>
                    <strong style="color: <?php echo $cf7_installed ? '#15803d' : '#b45309'; ?>;">
                        <?php echo $cf7_installed ? 'Contact Form 7 প্লাগইনটি সক্রিয় (Active) আছে।' : 'Contact Form 7 প্লাগইনটি ইনস্টল করা নেই বা নিষ্ক্রিয় রয়েছে।'; ?>
                    </strong>
                    <div style="font-size: 12px; color: #64748b; margin-top: 2px;">
                        <?php echo $cf7_installed ? 'ফর্ম সাবমিট হলে অটোমেটিক এই থিমের Leads তালিকায় জমা হবে।' : 'আপনি চাইলে Contact Form 7 প্লাগইন ইনস্টল করতে পারেন, অথবা থিমের বিল্ট-ইন WhatsApp ফর্ম ব্যবহার করতে পারেন।'; ?>
                    </div>
                </div>
            </div>

            <table class="form-table">
                <tr>
                    <th scope="row" style="font-weight: 600; width: 260px;">
                        <label for="sarkarhost_cf7_shortcode">কন্টাক্ট পেজ CF7 শর্টকোড</label>
                    </th>
                    <td>
                        <input type="text" id="sarkarhost_cf7_shortcode" name="sarkarhost_cf7_shortcode" value="<?php echo esc_attr(sarkarhost_get_opt('sarkarhost_cf7_shortcode', '')); ?>" class="large-text" placeholder='[contact-form-7 id="123" title="Contact Form"]' style="padding: 8px 12px; border-radius: 6px;">
                        <p class="description">
                            এখানে শর্টকোড বসালে কন্টাক্ট পেজে ডিফল্ট ফর্মের পরিবর্তে Contact Form 7 প্রদর্শিত হবে। ফাঁকা রাখলে থিমের নিজস্ব ফাস্ট WhatsApp ফর্ম কাজ করবে।
                        </p>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #e2e8f0;">
                <?php submit_button(__('Save Settings (সংরক্ষণ করুন)', 'sarkarhost'), 'primary', 'submit', false, ['style' => 'background: #2563eb; border-color: #2563eb; padding: 8px 28px; font-weight: 700; border-radius: 8px;']); ?>
            </div>
        </form>
        <?php endif; ?>


        <!-- TAB 5: SHORTCODES LIST -->
        <?php if ($active_tab == 'shortcodes_list') : ?>
        <div style="background: #fff; padding: 30px; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
            <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 15px; margin-bottom: 25px;">
                <h2 style="margin: 0; color: #0f172a; font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                    <span class="dashicons dashicons-shortcode" style="color: #2563eb;"></span>
                    📋 পেজ ও সেকশন শর্টকোড নির্দেশিকা
                </h2>
                <p style="color: #64748b; margin: 5px 0 0; font-size: 13px;">
                    যেকোনো পেজ, পোস্ট বা Elementor HTML উইজেটে নিচের শর্টকোডগুলো বসিয়ে সরাসরি রেডিমেড সেকশন প্রদর্শন করতে পারেন। শর্টকোডের উপর ক্লিক করলেই কপি হয়ে যাবে!
                </p>
            </div>

            <table class="wp-list-table widefat fixed striped" style="border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;">
                <thead>
                    <tr style="background: #0f172a; color: #fff;">
                        <th style="width: 30%; color: #fff; font-weight: 700; padding: 12px 10px;">শর্টকোড (Shortcode)</th>
                        <th style="width: 45%; color: #fff; font-weight: 700; padding: 12px 10px;">বিবরণ</th>
                        <th style="color: #fff; font-weight: 700; padding: 12px 10px; text-align: center;">কপি করুন</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $shortcodes_data = [
                        ['[sarkarhost_header]', 'কাস্টম হেডার, লোগো, মেনু ও হটলাইন বাটন', 'যেকোনো পেজের শুরুতে'],
                        ['[sarkarhost_footer]', 'কাস্টম ফুটার, অফিস ঠিকানা, সোশ্যাল ও জরুরি সাপোর্ট', 'যেকোনো পেজের শেষে'],
                        ['[sarkarhost_hero]', 'মেইন হিরো ব্যানার, হেডলাইন ও অ্যানিমেটেড টিকার', 'হোমপেজ ব্যানারে'],
                        ['[sarkarhost_home_overview]', 'হোমপেজের কম্প্যাক্ট ৬টি মূল সার্ভিস ওভারভিউ কার্ড', 'হোমপেজে সব সেবার সামারি'],
                        ['[sarkarhost_seo_service]', 'সম্পূর্ণ Professional SEO Service, ৬-ধাপের প্রসেস ও অডিট', 'SEO পেজে'],
                        ['[sarkarhost_web_development]', 'E-commerce, LMS, Corporate, Landing & Mobile App সেকশন', 'Web Development পেজে'],
                        ['[sarkarhost_hosting_domain]', 'Domain Registration ও Fast BDIX NVMe হোস্টিং প্যাকেজ', 'Hosting পেজে'],
                        ['[sarkarhost_digital_marketing]', 'Facebook Page Promotion, Setup, Boosting ও Ad Account', 'Digital Marketing পেজে'],
                        ['[sarkarhost_graphics_design]', 'Social Media Posts, Logo & Brand Identity Design', 'Graphics Design পেজে'],
                        ['[sarkarhost_why_choose]', 'কেন সরকার হোস্ট বেছে নেবেন (৭টি মূল পয়েন্ট)', 'হোমপেজ বা অ্যাবাউট পেজে'],
                        ['[sarkarhost_offices]', 'ঢাকা ও নীলফামারী অফিসের ঠিকানা, ম্যাপ ও কন্টাক্ট ফর্ম', 'Contact পেজে'],
                        ['[sarkarhost_cta_banner]', 'হাই-কনভার্টিং কল টু অ্যাকশন ব্যানার', 'পেজের নিচে'],
                    ];

                    foreach ($shortcodes_data as $sc) : ?>
                    <tr>
                        <td>
                            <code style="background: #f1f5f9; color: #2563eb; font-size: 13.5px; font-weight: 700; padding: 5px 10px; border-radius: 6px; border: 1px solid #e2e8f0; display: inline-block;">
                                <?php echo esc_html($sc[0]); ?>
                            </code>
                        </td>
                        <td>
                            <strong style="color: #1e293b;"><?php echo esc_html($sc[1]); ?></strong>
                            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">ব্যবহার: <?php echo esc_html($sc[2]); ?></div>
                        </td>
                        <td style="text-align: center;">
                            <button type="button" class="button" onclick="navigator.clipboard.writeText('<?php echo esc_js($sc[0]); ?>'); this.innerText='✓ Copied!'; setTimeout(()=>{this.innerText='Copy';}, 1500);" style="font-weight: 600; font-size: 12px; border-radius: 6px;">
                                Copy
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

    </div>
    <?php
}
