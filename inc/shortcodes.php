<?php
/**
 * Sarkar Host Theme Shortcodes
 * Output buffering methods for easy rendering in any page or template.
 */

if (!defined('ABSPATH')) {
    exit;
}

// 1. Header Shortcode: [sarkarhost_header]
function sarkarhost_header_shortcode($atts) {
    ob_start();
    get_header();
    return ob_get_clean();
}
add_shortcode('sarkarhost_header', 'sarkarhost_header_shortcode');

// 2. Footer Shortcode: [sarkarhost_footer]
function sarkarhost_footer_shortcode($atts) {
    ob_start();
    get_footer();
    return ob_get_clean();
}
add_shortcode('sarkarhost_footer', 'sarkarhost_footer_shortcode');

// 3. Hero Shortcode: [sarkarhost_hero]
function sarkarhost_hero_shortcode($atts) {
    $phone = sarkarhost_get_opt('sarkarhost_phone', '01321-222308');
    $wa = sarkarhost_get_opt('sarkarhost_whatsapp', '8801321222308');
    
    ob_start();
    ?>
    <section class="hero-section">
        <div class="glow-sphere glow-1"></div>
        <div class="glow-sphere glow-2"></div>
        <div class="grid-overlay"></div>
        
        <div class="container text-center">
            <div class="hero-badge">
                <span class="badge-icon"><i class="fa-solid fa-shield-halved"></i></span>
                <span>Sarkar Host • #1 Trusted Digital Solutions Partner</span>
            </div>
            
            <h1 class="hero-title">
                ডিজিটাল সফলতার জন্য আপনার<br>
                <span class="highlight-text">একমাত্র নির্ভরযোগ্য প্রতিষ্ঠান</span>
            </h1>
            
            <p class="hero-subtitle">
                আপনার ব্যবসা, প্রতিষ্ঠান ও অনলাইন উপস্থিতিকে আরও শক্তিশালী ও গতিশীল করতে <strong>Sarkar Host</strong> দিচ্ছে প্রফেশনাল এসইও (SEO), কাস্টম ওয়েব ও মোবাইল অ্যাপ, সুপারফাস্ট বিডিআইএক্স হোস্টিং এবং ফলাফলমুখী ডিজিটাল মার্কেটিং সেবা।
            </p>

            <div class="hero-cta-group">
                <a href="#services-overview" class="btn btn-primary btn-lg">
                    <span>আমাদের সেবাসমূহ এক্সপ্লোর করুন</span>
                    <i class="fa-solid fa-arrow-down"></i>
                </a>
                <a href="https://wa.me/<?php echo esc_attr($wa); ?>?text=Hello%20Sarkar%20Host,%20I%20want%20to%20discuss%20a%20project" target="_blank" class="btn btn-glass btn-lg">
                    <i class="fa-brands fa-whatsapp text-success"></i>
                    <span>হোয়াটসঅ্যাপে কথা বলুন</span>
                </a>
            </div>

            <!-- Trust Metrics -->
            <div class="hero-metrics">
                <div class="metric-card">
                    <h3>500+</h3>
                    <p>সফল প্রজেক্ট ডেলিভারি</p>
                </div>
                <div class="metric-divider"></div>
                <div class="metric-card">
                    <h3>Google #1</h3>
                    <p>র‍্যাঙ্কিং ও এসইও এক্সপার্টাইজ</p>
                </div>
                <div class="metric-divider"></div>
                <div class="metric-card">
                    <h3>99.9%</h3>
                    <p>সার্ভার আপটাইম গ্যারান্টি</p>
                </div>
                <div class="metric-divider"></div>
                <div class="metric-card">
                    <h3>24/7</h3>
                    <p>ডেডিকেটেড টেক সাপোর্ট</p>
                </div>
            </div>
        </div>

        <!-- Marquee Ticker -->
        <div class="marquee-wrapper">
            <div class="marquee-track">
                <span><i class="fa-solid fa-bolt"></i> Professional SEO Service</span>
                <span><i class="fa-solid fa-bolt"></i> E-commerce Solution</span>
                <span><i class="fa-solid fa-bolt"></i> Fast BDIX Hosting</span>
                <span><i class="fa-solid fa-bolt"></i> High-Converting Landing Page</span>
                <span><i class="fa-solid fa-bolt"></i> Custom Web & Mobile App</span>
                <span><i class="fa-solid fa-bolt"></i> Meta Ads & Boosting</span>
                <span><i class="fa-solid fa-bolt"></i> Creative Graphics Design</span>
                <!-- Loop -->
                <span><i class="fa-solid fa-bolt"></i> Professional SEO Service</span>
                <span><i class="fa-solid fa-bolt"></i> E-commerce Solution</span>
                <span><i class="fa-solid fa-bolt"></i> Fast BDIX Hosting</span>
                <span><i class="fa-solid fa-bolt"></i> High-Converting Landing Page</span>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('sarkarhost_hero', 'sarkarhost_hero_shortcode');

// 4. Home Overview Shortcode: [sarkarhost_home_overview]
function sarkarhost_home_overview_shortcode($atts) {
    ob_start();
    ?>
    <section class="home-overview-section" id="services-overview">
        <div class="container">
            <div class="section-header text-center">
                <div class="section-tag"><i class="fa-solid fa-cubes"></i> OUR CORE SERVICES</div>
                <h2 class="section-title">আমাদের প্রধান <span class="gradient-text">ডিজিটাল সেবাসমূহ</span></h2>
                <p class="section-desc">নিচের প্রতিটি সেবার আলাদা পূর্ণাঙ্গ বিবরণ ও প্যাকেজ দেখতে বিস্তারিত বাটনে ক্লিক করুন।</p>
            </div>

            <div class="overview-grid">
                <!-- 1. SEO -->
                <div class="overview-card">
                    <div class="popular-ribbon"><i class="fa-brands fa-google"></i> Google Ranking</div>
                    <div class="overview-icon-wrap icon-yellow"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
                    <span class="overview-badge">Organic Growth</span>
                    <h3 class="overview-title">Professional SEO Service</h3>
                    <p class="overview-desc">গুগলে আপনার ওয়েবসাইটকে ১ম পেজে নিয়ে আসুন। অর্গানিক ট্রাফিক ও সঠিক কাস্টমার অর্জনের জন্য কমপ্লিট এসইও সলিউশন।</p>
                    <ul class="overview-subservices">
                        <li><i class="fa-solid fa-check"></i> Complete Website SEO Audit</li>
                        <li><i class="fa-solid fa-check"></i> Keyword Research & Strategy</li>
                        <li><i class="fa-solid fa-check"></i> On-Page & Technical SEO</li>
                        <li><i class="fa-solid fa-check"></i> Off-Page Link Building</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/seo-service/')); ?>" class="btn-view-page">
                        <span>সম্পূর্ণ এসইও সার্ভিস দেখুন</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <!-- 2. Web & App -->
                <div class="overview-card">
                    <div class="overview-icon-wrap icon-purple"><i class="fa-solid fa-laptop-code"></i></div>
                    <span class="overview-badge">Web & Mobile Solutions</span>
                    <h3 class="overview-title">Web & App Development</h3>
                    <p class="overview-desc">আপনার অনলাইন ব্যবসার জন্য আধুনিক, দ্রুতগতির ই-কমার্স, এলএমএস, কর্পোরেট ওয়েবসাইট ও মোবাইল অ্যাপ।</p>
                    <ul class="overview-subservices">
                        <li><i class="fa-solid fa-check"></i> E-commerce Website Solution</li>
                        <li><i class="fa-solid fa-check"></i> Complete LMS Platform</li>
                        <li><i class="fa-solid fa-check"></i> High-Converting Landing Page</li>
                        <li><i class="fa-solid fa-check"></i> Custom Android & iOS App</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/web-development/')); ?>" class="btn-view-page">
                        <span>সব ওয়েব ও অ্যাপ সলিউশন দেখুন</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <!-- 3. Domain & Hosting -->
                <div class="overview-card">
                    <div class="overview-icon-wrap icon-green"><i class="fa-solid fa-server"></i></div>
                    <span class="overview-badge">Fast & Secure Hosting</span>
                    <h3 class="overview-title">Domain + Hosting</h3>
                    <p class="overview-desc">সুপারফাস্ট BDIX নেটওয়ার্ক, NVMe SSD স্টোরেজ, ফ্রি SSL ও ২৪/৭ টেকনিক্যাল সাপোর্টসহ নির্ভরযোগ্য হোস্টিং প্যাকেজ।</p>
                    <ul class="overview-subservices">
                        <li><i class="fa-solid fa-check"></i> Domain Registration</li>
                        <li><i class="fa-solid fa-check"></i> Super-Fast BDIX Hosting</li>
                        <li><i class="fa-solid fa-check"></i> Free Lifetime SSL Certificate</li>
                        <li><i class="fa-solid fa-check"></i> 99.9% Uptime & 24/7 Support</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/hosting-domain/')); ?>" class="btn-view-page">
                        <span>হোস্টিং প্যাকেজ ও বিস্তারিত দেখুন</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <!-- 4. Digital Marketing -->
                <div class="overview-card">
                    <div class="overview-icon-wrap icon-indigo"><i class="fa-solid fa-bullhorn"></i></div>
                    <span class="overview-badge">Marketing & Boosting</span>
                    <h3 class="overview-title">Digital Marketing & Ads</h3>
                    <p class="overview-desc">টার্গেটেড ফেইসবুক প্রমোশন, পেজ সেটআপ, ক্যাম্পেইন প্ল্যানিং, পোস্ট বুস্টিং এবং মেটা অ্যাড অ্যাকাউন্ট কনফিগারেশন।</p>
                    <ul class="overview-subservices">
                        <li><i class="fa-solid fa-check"></i> Facebook Page Setup</li>
                        <li><i class="fa-solid fa-check"></i> Targeted Page Promotion</li>
                        <li><i class="fa-solid fa-check"></i> High-ROI Post Boosting</li>
                        <li><i class="fa-solid fa-check"></i> Meta Ad Account Setup</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/digital-marketing/')); ?>" class="btn-view-page">
                        <span>মার্কেটিং ও বুস্টিং সেবা দেখুন</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <!-- 5. Graphics Design -->
                <div class="overview-card">
                    <div class="overview-icon-wrap icon-orange"><i class="fa-solid fa-palette"></i></div>
                    <span class="overview-badge">Creative Visuals</span>
                    <h3 class="overview-title">Graphics & Design Service</h3>
                    <p class="overview-desc">সোশ্যাল মিডিয়া পোস্ট, আকর্ষণীয় ব্যানার, ফেসবুক কভার, প্রোডাক্ট ডিজাইন ও ইউনিক ব্র্যান্ড লোগো ডিজাইন সার্ভিস।</p>
                    <ul class="overview-subservices">
                        <li><i class="fa-solid fa-check"></i> Social Media Post Design</li>
                        <li><i class="fa-solid fa-check"></i> Facebook Cover & Banner</li>
                        <li><i class="fa-solid fa-check"></i> Product Showcase Mockups</li>
                        <li><i class="fa-solid fa-check"></i> Premium Logo Design</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/graphics-design/')); ?>" class="btn-view-page">
                        <span>ডিজাইন সেবা ও পোর্টফোলিও দেখুন</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>

                <!-- 6. Contact & Offices -->
                <div class="overview-card highlight-card">
                    <div class="overview-icon-wrap icon-cyan"><i class="fa-solid fa-handshake"></i></div>
                    <span class="overview-badge">Direct Help & Consultation</span>
                    <h3 class="overview-title">অফিস ও সরাসরি যোগাযোগ</h3>
                    <p class="overview-desc">ঢাকা ও নীলফামারী অফিসে সরাসরি এসে কথা বলুন অথবা হটলাইনে সরাসরি কল দিয়ে আপনার প্রজেক্ট প্ল্যান শেয়ার করুন।</p>
                    <ul class="overview-subservices">
                        <li><i class="fa-solid fa-location-dot"></i> ঢাকা অফিস (মোহাম্মদী হাউজিং লি:)</li>
                        <li><i class="fa-solid fa-location-dot"></i> নীলফামারী হেড অফিস (Zaman Arcade)</li>
                        <li><i class="fa-solid fa-phone"></i> হটলাইন: <?php echo esc_html(sarkarhost_get_opt('sarkarhost_phone', '01321-222308')); ?></li>
                        <li><i class="fa-brands fa-whatsapp"></i> ২৪/৭ হোয়াটসঅ্যাপ সাপোর্ট</li>
                    </ul>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>" class="btn-view-page">
                        <span>অফিস লোকেশন ও ঠিকানা দেখুন</span>
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('sarkarhost_home_overview', 'sarkarhost_home_overview_shortcode');

// 5. Professional SEO Shortcode: [sarkarhost_seo_service]
function sarkarhost_seo_service_shortcode($atts) {
    ob_start();
    ?>
    <section class="service-details-section">
        <div class="container">
            <div class="section-header text-center">
                <div class="section-tag"><i class="fa-solid fa-list-check"></i> COMPLETE SEO MASTERY</div>
                <h2 class="section-title">Professional SEO Service</h2>
                <p class="section-desc">আপনার ওয়েবসাইটকে Google-এ আরও ভালো অবস্থানে নিয়ে আসুন। Search Engine Ranking, Organic Traffic এবং Online Visibility বাড়ানোর পূর্ণাঙ্গ সমাধান।</p>
            </div>

            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon-box icon-yellow"><i class="fa-solid fa-magnifying-glass"></i></div>
                    <h3 class="service-title">Website SEO Audit & Strategy</h3>
                    <p class="service-summary">ওয়েবসাইটের বর্তমান পারফরম্যান্স, ত্রুটি, ইনডেক্সিং সমস্যা ও সুযোগ বিশ্লেষণ করে কাস্টমাইজড এসইও স্ট্র্যাটেজি তৈরি।</p>
                    <ul class="features-list">
                        <li><i class="fa-solid fa-circle-check"></i> Complete Website SEO Audit</li>
                        <li><i class="fa-solid fa-circle-check"></i> Competitor Analysis & Gap Audit</li>
                        <li><i class="fa-solid fa-circle-check"></i> Traffic & Keyword Performance</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon-box icon-purple"><i class="fa-solid fa-key"></i></div>
                    <h3 class="service-title">Keyword Research & Strategy</h3>
                    <p class="service-summary">আপনার নির্দিষ্ট নিশ অনুযায়ী উচ্চ সার্চ ভলিউম ও কম প্রতিযোগিতামূলক লাভজনক কীওয়ার্ড নির্বাচন।</p>
                    <ul class="features-list">
                        <li><i class="fa-solid fa-circle-check"></i> High-Intent Buyer Keywords</li>
                        <li><i class="fa-solid fa-circle-check"></i> Long-Tail Keyword Mapping</li>
                        <li><i class="fa-solid fa-circle-check"></i> Search Intent & Trend Analysis</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon-box icon-blue"><i class="fa-solid fa-file-pen"></i></div>
                    <h3 class="service-title">On-Page SEO Optimization</h3>
                    <p class="service-summary">প্রতিটি পেজের কনটেন্ট, মেটা ট্যাগ, হেডিং ও ইন্টারনাল লিঙ্কিং নিখুঁতভাবে অপ্টিমাইজেশন।</p>
                    <ul class="features-list">
                        <li><i class="fa-solid fa-circle-check"></i> Meta Title & Description Setup</li>
                        <li><i class="fa-solid fa-circle-check"></i> Heading Structure Optimization</li>
                        <li><i class="fa-solid fa-circle-check"></i> Image SEO & Alt Tag Setup</li>
                        <li><i class="fa-solid fa-circle-check"></i> URL & Internal Linking Optimization</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon-box icon-green"><i class="fa-solid fa-bolt"></i></div>
                    <h3 class="service-title">Technical SEO & Speed</h3>
                    <p class="service-summary">সাইট স্পিড, মোবাইল রেসপন্সিভনেস, ক্রলিং ও ইনডেক্সিং সমস্যা দূর করে টেকনিক্যাল হেলথ ১০০% নিশ্চিতকরণ।</p>
                    <ul class="features-list">
                        <li><i class="fa-solid fa-circle-check"></i> Website Speed Optimization</li>
                        <li><i class="fa-solid fa-circle-check"></i> XML Sitemap & Robots.txt Config</li>
                        <li><i class="fa-solid fa-circle-check"></i> Google Search Console & GA4 Setup</li>
                        <li><i class="fa-solid fa-circle-check"></i> Schema Markup Structured Data</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon-box icon-cyan"><i class="fa-solid fa-map-location-dot"></i></div>
                    <h3 class="service-title">Local SEO & Google Business</h3>
                    <p class="service-summary">আপনার নির্দিষ্ট এলাকার কাস্টমারদের কাছে পৌঁছাতে Google Maps ও Google Business Profile অপ্টিমাইজেশন।</p>
                    <ul class="features-list">
                        <li><i class="fa-solid fa-circle-check"></i> Google Business Profile Optimization</li>
                        <li><i class="fa-solid fa-circle-check"></i> Local Citations & NAP Consistency</li>
                        <li><i class="fa-solid fa-circle-check"></i> Google Map Ranking Improvement</li>
                    </ul>
                </div>
                <div class="service-card">
                    <div class="service-icon-box icon-orange"><i class="fa-solid fa-link"></i></div>
                    <h3 class="service-title">Off-Page SEO & Backlinks</h3>
                    <p class="service-summary">হাই-অথরিটি সাইট থেকে ন্যাচারাল White-Hat ব্যাকলিংক তৈরি করে ডোমেইন অথরিটি বৃদ্ধি।</p>
                    <ul class="features-list">
                        <li><i class="fa-solid fa-circle-check"></i> High-DA Quality Link Building</li>
                        <li><i class="fa-solid fa-circle-check"></i> 100% White-Hat Outreach Backlinks</li>
                        <li><i class="fa-solid fa-circle-check"></i> Monthly Detailed SEO Progress Report</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- 6-Step SEO Process -->
    <section class="seo-spotlight-section">
        <div class="container">
            <div class="seo-spotlight-wrapper">
                <div class="text-center" style="margin-bottom: 3.5rem;">
                    <div class="section-tag"><i class="fa-solid fa-gears"></i> HOW WE WORK</div>
                    <h2 class="section-title">আমাদের প্রমাণিত ৬-ধাপের <span class="highlight-text">SEO Process</span></h2>
                </div>
                <div class="process-grid">
                    <div class="process-card">
                        <div class="process-num">01</div>
                        <div class="process-icon"><i class="fa-solid fa-file-circle-check"></i></div>
                        <h4>1. Website Audit</h4>
                        <p>প্রথমে আপনার ওয়েবসাইটের বর্তমান SEO অবস্থান, ইনডেক্সিং এবং টেকনিক্যাল সমস্যাগুলো বিশ্লেষণ করা হবে।</p>
                    </div>
                    <div class="process-card">
                        <div class="process-num">02</div>
                        <div class="process-icon"><i class="fa-solid fa-key"></i></div>
                        <h4>2. Keyword Research</h4>
                        <p>আপনার ব্যবসার জন্য প্রয়োজনীয় ও সম্ভাবনাময় Keywords নির্বাচন করা হবে।</p>
                    </div>
                    <div class="process-card">
                        <div class="process-num">03</div>
                        <div class="process-icon"><i class="fa-solid fa-code"></i></div>
                        <h4>3. On-Page Optimization</h4>
                        <p>Website Content, Meta Tags, Heading, URL, Images ও Internal Linking অপ্টিমাইজ করা হবে।</p>
                    </div>
                    <div class="process-card">
                        <div class="process-num">04</div>
                        <div class="process-icon"><i class="fa-solid fa-gears"></i></div>
                        <h4>4. Technical SEO</h4>
                        <p>Website Speed, Mobile Responsiveness, Indexing, Sitemap, Crawlability উন্নত করা হবে।</p>
                    </div>
                    <div class="process-card">
                        <div class="process-num">05</div>
                        <div class="process-icon"><i class="fa-solid fa-link"></i></div>
                        <h4>5. Off-Page SEO</h4>
                        <p>প্রয়োজন অনুযায়ী Quality Backlink এবং Off-Page SEO কার্যক্রম পরিচালনা করা হবে।</p>
                    </div>
                    <div class="process-card">
                        <div class="process-num">06</div>
                        <div class="process-icon"><i class="fa-solid fa-chart-pie"></i></div>
                        <h4>6. Monitoring & Reporting</h4>
                        <p>Ranking, Traffic এবং SEO Performance নিয়মিত পর্যবেক্ষণ করে মাসিক রিপোর্ট প্রদান করা হবে।</p>
                    </div>
                </div>

                <div class="seo-reasons-box">
                    <div class="text-center">
                        <h3 style="font-size: 1.6rem; font-weight: 800; color: #fff; margin-bottom: 0.5rem;">কেন আমাদের SEO Service নেবেন?</h3>
                        <p style="color: var(--text-muted);">আমরা সততা ও গুগলের White-Hat নিয়মানুযায়ী স্থায়ী প্রবৃদ্ধির নিশ্চয়তা দিই।</p>
                    </div>
                    <div class="seo-reasons-grid">
                        <div class="reason-item"><i class="fa-solid fa-circle-check"></i> <span>আপনার Target Customer অনুযায়ী SEO Strategy</span></div>
                        <div class="reason-item"><i class="fa-solid fa-circle-check"></i> <span>১০০% White-Hat SEO Practices</span></div>
                        <div class="reason-item"><i class="fa-solid fa-circle-check"></i> <span>Search Engine Friendly Optimization</span></div>
                        <div class="reason-item"><i class="fa-solid fa-circle-check"></i> <span>Keyword Ranking Improvement</span></div>
                        <div class="reason-item"><i class="fa-solid fa-circle-check"></i> <span>Organic Traffic Growth</span></div>
                        <div class="reason-item"><i class="fa-solid fa-circle-check"></i> <span>Competitor Analysis</span></div>
                        <div class="reason-item"><i class="fa-solid fa-circle-check"></i> <span>Regular Performance Monitoring</span></div>
                        <div class="reason-item"><i class="fa-solid fa-circle-check"></i> <span>Monthly Detailed Report</span></div>
                        <div class="reason-item"><i class="fa-solid fa-circle-check"></i> <span>Experienced SEO Team</span></div>
                        <div class="reason-item"><i class="fa-solid fa-circle-check"></i> <span>Long-Term Growth Focus</span></div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-cta-primary btn-lg" onclick="openOrderModal('Professional SEO Service', 'Get Started Today | SEO Consultation')">
                            <i class="fa-solid fa-rocket"></i>
                            <span>Get Started Today | Contact Us for SEO Consultation</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('sarkarhost_seo_service', 'sarkarhost_seo_service_shortcode');

// 6. Web Development Shortcode: [sarkarhost_web_development]
function sarkarhost_web_development_shortcode($atts) {
    ob_start();
    ?>
    <section class="service-details-section">
        <div class="container">
            <div class="services-grid">
                <!-- 1. E-commerce -->
                <div class="service-card">
                    <div class="service-card-top"><div class="service-number">01</div><div class="service-icon-box icon-purple"><i class="fa-solid fa-cart-shopping"></i></div></div>
                    <div class="service-badge">eCommerce Special</div>
                    <h3 class="service-title">1. E-commerce Website Solution</h3>
                    <p class="service-summary">আপনার অনলাইন ব্যবসার জন্য আধুনিক, দ্রুতগতির ও মোবাইল-ফ্রেন্ডলি E-commerce Website তৈরি করুন। পণ্য, অর্ডার, কাস্টমার, পেমেন্ট ও ডেলিভারি ম্যানেজমেন্টসহ প্রয়োজনীয় ফিচার নিয়ে সম্পূর্ণ অনলাইন শপ।</p>
                    <div class="service-features-box">
                        <h4 class="features-label">মূল সুবিধা:</h4>
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> Professional E-commerce Design</li>
                            <li><i class="fa-solid fa-circle-check"></i> Product & Category Management</li>
                            <li><i class="fa-solid fa-circle-check"></i> Order & Customer Management</li>
                            <li><i class="fa-solid fa-circle-check"></i> Payment Gateway Integration</li>
                            <li><i class="fa-solid fa-circle-check"></i> Mobile Responsive Design</li>
                            <li><i class="fa-solid fa-circle-check"></i> Admin Dashboard</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('E-commerce Website Solution', 'Get E-commerce Website')"><span>Get E-commerce Website</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- 2. LMS -->
                <div class="service-card">
                    <div class="service-card-top"><div class="service-number">02</div><div class="service-icon-box icon-blue"><i class="fa-solid fa-graduation-cap"></i></div></div>
                    <div class="service-badge">Education & Academy</div>
                    <h3 class="service-title">2. LMS Website</h3>
                    <p class="service-summary">অনলাইন কোর্স, ক্লাস, কুইজ ও শিক্ষামূলক কনটেন্ট পরিচালনার জন্য সম্পূর্ণ Learning Management System (LMS) তৈরি করুন।</p>
                    <div class="service-features-box">
                        <h4 class="features-label">মূল সুবিধা:</h4>
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> Student & Teacher Portal</li>
                            <li><i class="fa-solid fa-circle-check"></i> Online Course Management</li>
                            <li><i class="fa-solid fa-circle-check"></i> Video Course</li>
                            <li><i class="fa-solid fa-circle-check"></i> Quiz & Exam System</li>
                            <li><i class="fa-solid fa-circle-check"></i> Result & Certificate</li>
                            <li><i class="fa-solid fa-circle-check"></i> Payment Integration</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('LMS Website', 'Build Your LMS')"><span>Build Your LMS</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- 3. Corporate -->
                <div class="service-card">
                    <div class="service-card-top"><div class="service-number">03</div><div class="service-icon-box icon-cyan"><i class="fa-solid fa-building"></i></div></div>
                    <div class="service-badge">Brand & Authority</div>
                    <h3 class="service-title">3. Corporate Website</h3>
                    <p class="service-summary">আপনার কোম্পানি বা প্রতিষ্ঠানের জন্য আধুনিক ও প্রফেশনাল Corporate Website তৈরি করুন, যা আপনার ব্র্যান্ডের বিশ্বাসযোগ্যতা ও অনলাইন উপস্থিতি বৃদ্ধি করবে।</p>
                    <div class="service-features-box">
                        <h4 class="features-label">মূল সুবিধা:</h4>
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> Professional UI/UX Design</li>
                            <li><i class="fa-solid fa-circle-check"></i> About & Services Section</li>
                            <li><i class="fa-solid fa-circle-check"></i> Team & Portfolio</li>
                            <li><i class="fa-solid fa-circle-check"></i> Contact Form & Google Map</li>
                            <li><i class="fa-solid fa-circle-check"></i> Mobile Responsive</li>
                            <li><i class="fa-solid fa-circle-check"></i> Basic SEO Friendly Structure</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Corporate Website', 'Create Corporate Website')"><span>Create Corporate Website</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- 5. Landing Page -->
                <div class="service-card">
                    <div class="service-card-top"><div class="service-number">04</div><div class="service-icon-box icon-orange"><i class="fa-solid fa-rocket"></i></div></div>
                    <div class="service-badge">High Conversion</div>
                    <h3 class="service-title">5. Landing Page Service</h3>
                    <p class="service-summary">Facebook Ads, Product Promotion ও Lead Generation-এর জন্য High-Converting Professional Landing Page তৈরি করুন।</p>
                    <div class="service-features-box">
                        <h4 class="features-label">মূল সুবিধা:</h4>
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> Attractive Landing Page Design</li>
                            <li><i class="fa-solid fa-circle-check"></i> Product/Service Showcase</li>
                            <li><i class="fa-solid fa-circle-check"></i> Lead Collection Form</li>
                            <li><i class="fa-solid fa-circle-check"></i> WhatsApp/Messenger Integration</li>
                            <li><i class="fa-solid fa-circle-check"></i> Mobile Responsive & Fast Loading</li>
                            <li><i class="fa-solid fa-circle-check"></i> Conversion-Focused Design</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Landing Page Service', 'Create Landing Page')"><span>Create Landing Page</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- 6. Web + App -->
                <div class="service-card highlight-card">
                    <div class="service-card-top"><div class="service-number">05</div><div class="service-icon-box icon-pink"><i class="fa-solid fa-mobile-screen-button"></i></div></div>
                    <div class="service-badge">Custom Engineering</div>
                    <h3 class="service-title">6. Web + App Development</h3>
                    <p class="service-summary">আপনার ব্যবসা বা আইডিয়াকে ওয়েবসাইট ও মোবাইল অ্যাপে রূপ দিতে আমরা দিচ্ছি Custom Web & App Development Service।</p>
                    <div class="service-features-box">
                        <h4 class="features-label">মূল সুবিধা:</h4>
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> Custom Website Development</li>
                            <li><i class="fa-solid fa-circle-check"></i> Android & iOS App Development</li>
                            <li><i class="fa-solid fa-circle-check"></i> Flutter App Development</li>
                            <li><i class="fa-solid fa-circle-check"></i> API Integration</li>
                            <li><i class="fa-solid fa-circle-check"></i> Admin Panel & Database Management</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Web + App Development', 'Discuss Your Project')"><span>Discuss Your Project</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('sarkarhost_web_development', 'sarkarhost_web_development_shortcode');

// 7. Domain & Hosting Shortcode: [sarkarhost_hosting_domain]
function sarkarhost_hosting_domain_shortcode($atts) {
    ob_start();
    ?>
    <section class="service-details-section">
        <div class="container">
            <div class="services-grid">
                <div class="service-card highlight-card">
                    <div class="popular-ribbon"><i class="fa-solid fa-star"></i> High Performance</div>
                    <div class="service-icon-box icon-green"><i class="fa-solid fa-server"></i></div>
                    <div class="service-badge">Complete Package</div>
                    <h3 class="service-title">Domain + Hosting Solution</h3>
                    <p class="service-summary">আপনার ওয়েবসাইটের জন্য নির্ভরযোগ্য Domain ও Fast Hosting Solution। ব্যবসা বা ব্যক্তিগত ওয়েবসাইটের জন্য প্রয়োজন অনুযায়ী Domain ও Hosting প্যাকেজ বেছে নিন।</p>
                    <div class="service-features-box">
                        <h4 class="features-label">সেবাসমূহ:</h4>
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> Domain Registration</li>
                            <li><i class="fa-solid fa-circle-check"></i> High Speed NVMe Web Hosting</li>
                            <li><i class="fa-solid fa-circle-check"></i> BDIX Hosting Network</li>
                            <li><i class="fa-solid fa-circle-check"></i> Free Lifetime SSL Certificate</li>
                            <li><i class="fa-solid fa-circle-check"></i> 1-Click Website Setup</li>
                            <li><i class="fa-solid fa-circle-check"></i> 24/7 Dedicated Technical Support</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Domain + Hosting', 'Get Domain & Hosting')"><span>Get Domain & Hosting</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-icon-box icon-blue"><i class="fa-solid fa-globe"></i></div>
                    <div class="service-badge">Domain Registration</div>
                    <h3 class="service-title">Domain Name Service</h3>
                    <p class="service-summary">আপনার ব্র্যান্ডের নামে ইনস্ট্যান্ট ডোমেইন রেজিস্ট্রেশন, DNS ম্যানেজমেন্ট ও ফুল কন্ট্রোল প্যানেল অ্যাক্সেস।</p>
                    <div class="service-features-box">
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> Instant Domain Activation</li>
                            <li><i class="fa-solid fa-circle-check"></i> Free DNS Management Panel</li>
                            <li><i class="fa-solid fa-circle-check"></i> Domain Privacy Protection</li>
                            <li><i class="fa-solid fa-circle-check"></i> 100% Ownership & Transfer Lock</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Domain Registration', 'Register Your Domain')"><span>Register Your Domain</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-icon-box icon-cyan"><i class="fa-solid fa-shield-halved"></i></div>
                    <div class="service-badge">Security & Support</div>
                    <h3 class="service-title">24/7 Server Management</h3>
                    <p class="service-summary">অটোমেটিক ব্যাকআপ, ম্যালওয়্যার স্ক্যানার, ডিডস প্রটেকশন ও ডেডিকেটেড সাপোর্ট ইঞ্জিনিয়ার টিম।</p>
                    <div class="service-features-box">
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> 99.9% Uptime Guarantee</li>
                            <li><i class="fa-solid fa-circle-check"></i> Free Auto Backup</li>
                            <li><i class="fa-solid fa-circle-check"></i> Advanced DDoS Protection</li>
                            <li><i class="fa-solid fa-circle-check"></i> cPanel & LiteSpeed Web Server</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Server Support', 'Get Server Support')"><span>Get Server Support</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('sarkarhost_hosting_domain', 'sarkarhost_hosting_domain_shortcode');

// 8. Digital Marketing Shortcode: [sarkarhost_digital_marketing]
function sarkarhost_digital_marketing_shortcode($atts) {
    ob_start();
    ?>
    <section class="service-details-section">
        <div class="container">
            <div class="services-grid">
                <!-- 7. Page Promotion -->
                <div class="service-card">
                    <div class="service-card-top"><div class="service-number">01</div><div class="service-icon-box icon-indigo"><i class="fa-solid fa-bullhorn"></i></div></div>
                    <div class="service-badge">Reach & Followers</div>
                    <h3 class="service-title">7. Page Promotion Service</h3>
                    <p class="service-summary">আপনার Facebook Page, Business বা Brand-এর পরিচিতি ও Reach বাড়াতে পরিকল্পিত Page Promotion Service।</p>
                    <div class="service-features-box">
                        <h4 class="features-label">সেবার মধ্যে রয়েছে:</h4>
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> Page Promotion</li>
                            <li><i class="fa-solid fa-circle-check"></i> Content Promotion</li>
                            <li><i class="fa-solid fa-circle-check"></i> Audience Targeting</li>
                            <li><i class="fa-solid fa-circle-check"></i> Campaign Planning & Monitoring</li>
                            <li><i class="fa-solid fa-circle-check"></i> Promotion Strategy</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Page Promotion Service', 'Promote Your Page')"><span>Promote Your Page</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- 8. Page Setup -->
                <div class="service-card">
                    <div class="service-card-top"><div class="service-number">02</div><div class="service-icon-box icon-teal"><i class="fa-brands fa-facebook"></i></div></div>
                    <div class="service-badge">Page Optimization</div>
                    <h3 class="service-title">8. Page Setup Service</h3>
                    <p class="service-summary">নতুন Facebook Business Page সুন্দর ও প্রফেশনালভাবে সেটআপ করতে আমাদের Page Setup Service গ্রহণ করুন।</p>
                    <div class="service-features-box">
                        <h4 class="features-label">আমরা যা করে দিই:</h4>
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> Professional Page Setup</li>
                            <li><i class="fa-solid fa-circle-check"></i> Profile & Cover Setup</li>
                            <li><i class="fa-solid fa-circle-check"></i> Business & Contact Info</li>
                            <li><i class="fa-solid fa-circle-check"></i> Page Category & CTA Button</li>
                            <li><i class="fa-solid fa-circle-check"></i> Basic Optimization</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Page Setup Service', 'Setup My Page')"><span>Setup My Page</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- 9. Boosting -->
                <div class="service-card highlight-card">
                    <div class="popular-ribbon"><i class="fa-solid fa-chart-line"></i> High Sales</div>
                    <div class="service-card-top"><div class="service-number">03</div><div class="service-icon-box icon-yellow"><i class="fa-solid fa-bolt"></i></div></div>
                    <div class="service-badge">Targeted Ads</div>
                    <h3 class="service-title">9. Boosting Service</h3>
                    <p class="service-summary">আপনার গুরুত্বপূর্ণ পোস্ট, অফার বা প্রোডাক্টকে সঠিক Audience-এর কাছে পৌঁছে দিতে Professional Boosting Service।</p>
                    <div class="service-features-box">
                        <h4 class="features-label">সুবিধা:</h4>
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> Target Audience Selection</li>
                            <li><i class="fa-solid fa-circle-check"></i> Location & Interest Targeting</li>
                            <li><i class="fa-solid fa-circle-check"></i> Budget Planning</li>
                            <li><i class="fa-solid fa-circle-check"></i> Campaign Setup</li>
                            <li><i class="fa-solid fa-circle-check"></i> Performance Monitoring</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Boosting Service', 'Boost Your Post')"><span>Boost Your Post</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>

                <!-- 10. Ad Account -->
                <div class="service-card">
                    <div class="service-card-top"><div class="service-number">04</div><div class="service-icon-box icon-red"><i class="fa-solid fa-id-card-clip"></i></div></div>
                    <div class="service-badge">Meta Business</div>
                    <h3 class="service-title">10. Ad Account Service</h3>
                    <p class="service-summary">অনলাইন বিজ্ঞাপনের জন্য প্রয়োজনীয় Ad Account Setup ও Configuration Service।</p>
                    <div class="service-features-box">
                        <h4 class="features-label">সেবার মধ্যে রয়েছে:</h4>
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> Ad Account Setup</li>
                            <li><i class="fa-solid fa-circle-check"></i> Business Manager Setup</li>
                            <li><i class="fa-solid fa-circle-check"></i> Payment Method Setup Guidance</li>
                            <li><i class="fa-solid fa-circle-check"></i> Basic Ad Configuration</li>
                            <li><i class="fa-solid fa-circle-check"></i> Tracking & Pixel Setup</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Ad Account Service', 'Setup Ad Account')"><span>Setup Ad Account</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('sarkarhost_digital_marketing', 'sarkarhost_digital_marketing_shortcode');

// 9. Graphics Design Shortcode: [sarkarhost_graphics_design]
function sarkarhost_graphics_design_shortcode($atts) {
    ob_start();
    ?>
    <section class="service-details-section">
        <div class="container">
            <div class="services-grid">
                <div class="service-card highlight-card">
                    <div class="service-icon-box icon-purple"><i class="fa-solid fa-palette"></i></div>
                    <div class="service-badge">Full Creative Suite</div>
                    <h3 class="service-title">11. Graphics & Design Service</h3>
                    <p class="service-summary">আপনার ব্যবসা ও ব্র্যান্ডের জন্য আকর্ষণীয় ও প্রফেশনাল Graphics Design Service।</p>
                    <div class="service-features-box">
                        <h4 class="features-label">আমাদের ডিজাইন সেবা:</h4>
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> Social Media Post Design</li>
                            <li><i class="fa-solid fa-circle-check"></i> Facebook Banner & Cover Design</li>
                            <li><i class="fa-solid fa-circle-check"></i> Product Showcase & Mockup Design</li>
                            <li><i class="fa-solid fa-circle-check"></i> Promotional Ad Creative Banner</li>
                            <li><i class="fa-solid fa-circle-check"></i> Premium Logo & Brand Identity</li>
                            <li><i class="fa-solid fa-circle-check"></i> অন্যান্য প্রয়োজনীয় প্রফেশনাল Graphics</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Graphics & Design Service', 'Get Design Service')"><span>Get Design Service</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-icon-box icon-orange"><i class="fa-solid fa-pen-nib"></i></div>
                    <div class="service-badge">Logo & Brand Identity</div>
                    <h3 class="service-title">Unique Logo Design</h3>
                    <p class="service-summary">আপনার ব্র্যান্ডের জন্য অর্থবহ, আধুনিক ও ইউনিক ভেক্টর লোগো ডিজাইন প্যাকেজ।</p>
                    <div class="service-features-box">
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> 100% Original Vector Concept</li>
                            <li><i class="fa-solid fa-circle-check"></i> High Resolution PNG, JPG, PDF</li>
                            <li><i class="fa-solid fa-circle-check"></i> Source Files (AI, EPS, SVG)</li>
                            <li><i class="fa-solid fa-circle-check"></i> Full Commercial Copyright</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Logo Design', 'Order Logo Design')"><span>Order Logo Design</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="service-card">
                    <div class="service-icon-box icon-cyan"><i class="fa-solid fa-images"></i></div>
                    <div class="service-badge">Monthly Creative Pack</div>
                    <h3 class="service-title">Social Media Monthly Pack</h3>
                    <p class="service-summary">আপনার পেজের জন্য মাসিক ১০টি/২০টি/৩০টি কন্টেন্ট ও প্রমোশনাল অ্যাড পোস্ট ডিজাইন।</p>
                    <div class="service-features-box">
                        <ul class="features-list">
                            <li><i class="fa-solid fa-circle-check"></i> High-Converting Ad Creatives</li>
                            <li><i class="fa-solid fa-circle-check"></i> Brand Consistent Color Palette</li>
                            <li><i class="fa-solid fa-circle-check"></i> Fast Delivery Support</li>
                            <li><i class="fa-solid fa-circle-check"></i> Unlimited Minor Revisions</li>
                        </ul>
                    </div>
                    <div class="service-card-footer">
                        <button class="btn btn-service-cta" onclick="openOrderModal('Monthly Social Media Pack', 'Get Monthly Pack')"><span>Get Monthly Pack</span><i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('sarkarhost_graphics_design', 'sarkarhost_graphics_design_shortcode');

// 10. Why Choose Us: [sarkarhost_why_choose]
function sarkarhost_why_choose_shortcode($atts) {
    ob_start();
    ?>
    <section class="why-choose-section">
        <div class="container">
            <div class="why-choose-wrapper">
                <div class="text-center">
                    <div class="section-tag"><i class="fa-solid fa-award"></i> WHY SARKAR HOST?</div>
                    <h2 class="section-title">আপনার ডিজিটাল ব্যবসার জন্য একটি <span class="highlight-text">Complete Solution</span></h2>
                    <p class="section-desc">আমরা শুধু সেবা প্রদান করি না, আপনার ব্যবসার দীর্ঘমেয়াদী সফলতার জন্য বিশ্বস্ত ডিজিটাল পার্টনার হিসেবে কাজ করি।</p>
                </div>

                <div class="why-grid">
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                        <div class="why-content">
                            <h3>Professional & Modern Design</h3>
                            <p>আন্তর্জাতিক মানের আধুনিক, আকর্ষণীয় ও ইউজার-ফ্রেন্ডলি ডিজাইন যা কাস্টমারকে মুগ্ধ করবে।</p>
                        </div>
                    </div>
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fa-solid fa-users-gear"></i></div>
                        <div class="why-content">
                            <h3>Experienced Specialist Team</h3>
                            <p>দক্ষ ডেভেলপার ও সার্টিফাইড এসইও টিম যারা আপনার যে কোনো প্রজেক্ট বাস্তবায়নে পারদর্শী।</p>
                        </div>
                    </div>
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fa-solid fa-mobile-screen"></i></div>
                        <div class="why-content">
                            <h3>Mobile Responsive Solutions</h3>
                            <p>মোবাইল, ট্যাবলেট বা কম্পিউটার—সব ডিভাইসে পারফেক্ট ও দ্রুতগতির রেসপন্সিভ পারফরম্যান্স।</p>
                        </div>
                    </div>
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fa-solid fa-chart-pie"></i></div>
                        <div class="why-content">
                            <h3>Business-Focused Development</h3>
                            <p>সেলস বৃদ্ধি, কাস্টমার এনগেজমেন্ট ও ব্র্যান্ড ভ্যালু বাড়ানোর উদ্দেশ্যে সুপরিকল্পিত ডেভেলপমেন্ট।</p>
                        </div>
                    </div>
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fa-solid fa-tags"></i></div>
                        <div class="why-content">
                            <h3>Affordable Transparent Pricing</h3>
                            <p>বাজেটের মধ্যে সর্বোচ্চ কোয়ালিটির প্রিমিয়াম সেবা এবং কোনো লুকানো চার্জ ছাড়া স্বচ্ছ ডিল।</p>
                        </div>
                    </div>
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fa-solid fa-headset"></i></div>
                        <div class="why-content">
                            <h3>After-Sales Technical Support</h3>
                            <p>প্রজেক্ট ডেলিভারির পরেও নিরবচ্ছিন্ন টেকনিক্যাল সাপোর্ট ও মেইনটেনেন্স সহায়তা।</p>
                        </div>
                    </div>
                    <div class="why-card why-card-full">
                        <div class="why-icon-wrap"><i class="fa-solid fa-sliders"></i></div>
                        <div class="why-content">
                            <h3>Customized Complete Solutions</h3>
                            <p>আপনার নির্দিষ্ট ব্যবসার চাহিদা অনুযায়ী কাস্টমাইজড ফিচার, ডিজাইন ও আর্কিটেকচার তৈরি করার সক্ষমতা।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('sarkarhost_why_choose', 'sarkarhost_why_choose_shortcode');

// 11. Offices & Contact Shortcode: [sarkarhost_offices]
function sarkarhost_offices_shortcode($atts) {
    $phone = sarkarhost_get_opt('sarkarhost_phone', '01321-222308');
    $wa = sarkarhost_get_opt('sarkarhost_whatsapp', '8801321222308');
    $nil_addr = sarkarhost_get_opt('sarkarhost_nilphamari_address', '1st Floor, Zaman Arcade Shopping Complex (Opposite Nilphamari Pouro Market), Nilphamari Sadar, Nilphamari 5300');
    $nil_map = sarkarhost_get_opt('sarkarhost_nilphamari_map', 'https://maps.app.goo.gl/q4gzpCK4V6wKPCEs7');
    $dhk_addr = sarkarhost_get_opt('sarkarhost_dhaka_address', '1st Floor, House No: 17, Road No: 01, Mohammadi Housing Limited, Mohammadpur, Dhaka – 1207');
    $dhk_note = sarkarhost_get_opt('sarkarhost_dhaka_note', 'Limited 1-এ প্রবেশ করার পর মসজিদের আগের বিল্ডিং, Nasir Garden-এর ২য় তলায় আমাদের অফিস অবস্থিত।');
    $dhk_map = sarkarhost_get_opt('sarkarhost_dhaka_map', 'https://share.google/qL7pM0T8qyyz0MePj');
    $cf7_code = sarkarhost_get_opt('sarkarhost_cf7_shortcode', '');

    ob_start();
    ?>
    <section class="offices-section">
        <div class="container">
            <div class="offices-grid">
                <!-- Nilphamari -->
                <div class="office-card highlight-card">
                    <div class="office-header">
                        <div class="office-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                        <div>
                            <span class="office-badge">হেড অফিস</span>
                            <h3 class="office-name">Nilphamari Office</h3>
                        </div>
                    </div>
                    <div class="office-body">
                        <p class="office-address">
                            <strong><i class="fa-solid fa-building"></i> Address:</strong><br>
                            <?php echo esc_html($nil_addr); ?>
                        </p>
                    </div>
                    <div class="office-footer">
                        <a href="<?php echo esc_url($nil_map); ?>" target="_blank" class="btn btn-map">
                            <i class="fa-solid fa-location-arrow"></i>
                            <span>Google Map-এ লোকেশন দেখুন</span>
                        </a>
                    </div>
                </div>

                <!-- Dhaka -->
                <div class="office-card">
                    <div class="office-header">
                        <div class="office-icon"><i class="fa-solid fa-city"></i></div>
                        <div>
                            <span class="office-badge">ঢাকা ব্রাঞ্চ অফিস</span>
                            <h3 class="office-name">Dhaka Office</h3>
                        </div>
                    </div>
                    <div class="office-body">
                        <p class="office-address">
                            <strong><i class="fa-solid fa-building"></i> Address:</strong><br>
                            <?php echo esc_html($dhk_addr); ?>
                        </p>
                        <?php if (!empty($dhk_note)) : ?>
                        <div class="office-note">
                            <i class="fa-solid fa-circle-info"></i>
                            <span><strong>Note:</strong> <?php echo esc_html($dhk_note); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="office-footer">
                        <a href="<?php echo esc_url($dhk_map); ?>" target="_blank" class="btn btn-map">
                            <i class="fa-solid fa-location-arrow"></i>
                            <span>Google Map-এ লোকেশন দেখুন</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Contact Strip -->
            <div class="contact-strip">
                <div class="contact-strip-item">
                    <div class="strip-icon"><i class="fa-solid fa-phone-volume"></i></div>
                    <div>
                        <span class="strip-label">হটলাইন নম্বর</span>
                        <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $phone)); ?>" class="strip-value"><?php echo esc_html($phone); ?></a>
                    </div>
                </div>
                <div class="strip-divider"></div>
                <div class="contact-strip-item">
                    <div class="strip-icon"><i class="fa-brands fa-whatsapp"></i></div>
                    <div>
                        <span class="strip-label">হোয়াটসঅ্যাপ সাপোর্ট</span>
                        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa)); ?>" target="_blank" class="strip-value">+<?php echo esc_html($wa); ?></a>
                    </div>
                </div>
                <div class="strip-divider"></div>
                <div class="contact-strip-item">
                    <div class="strip-icon"><i class="fa-solid fa-globe"></i></div>
                    <div>
                        <span class="strip-label">অফিসিয়াল ওয়েবসাইট</span>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="strip-value">sarkarhost.com</a>
                    </div>
                </div>
            </div>

            <!-- Contact Form Area (CF7 or Default) -->
            <div class="contact-page-wrapper" style="margin-top: 4rem;">
                <div class="contact-form-box">
                    <h3 style="font-size: 1.8rem; font-weight: 800; color: #fff; margin-bottom: 0.5rem;">সরাসরি মেসেজ পাঠান</h3>
                    <p style="color: var(--text-muted); margin-bottom: 2rem;">ফর্মটি পূরণ করলে আমাদের টিম দ্রুত আপনার সাথে যোগাযোগ করবে।</p>
                    
                    <?php if (!empty($cf7_code) && function_exists('wpcf7')) : ?>
                        <?php echo do_shortcode($cf7_code); ?>
                    <?php else : ?>
                        <form onsubmit="handleFormSubmit(event)">
                            <!-- Anti-spam Honeypot -->
                            <input type="text" name="sh_website_url" class="sh-honey" tabindex="-1" autocomplete="off" style="position: absolute; left: -9999px; opacity: 0; pointer-events: none;">
                            
                            <div class="form-group">
                                <label><i class="fa-solid fa-user"></i> আপনার নাম *</label>
                                <input type="text" id="clientName" required minlength="2" placeholder="আপনার পুরো নাম লিখুন">
                            </div>
                            <div class="form-group">
                                <label><i class="fa-solid fa-phone"></i> মোবাইল নম্বর (১১ ডিজিট) *</label>
                                <input type="tel" id="clientPhone" required pattern="^(?:\+?88|88)?01[3-9]\d{8}$" placeholder="যেমন: 017XXXXXXXX">
                                <small style="color: #94a3b8; font-size: 0.75rem;">সঠিক ও সক্রিয় মোবাইল নম্বর দিন</small>
                            </div>
                            <div class="form-group">
                                <label><i class="fa-solid fa-list"></i> আপনার প্রয়োজনীয় সেবা</label>
                                <input type="text" id="selectedServiceName" value="সাধারণ অনুসন্ধান / যোগাযোগ">
                            </div>
                            <div class="form-group">
                                <label><i class="fa-solid fa-comment-dots"></i> আপনার মেসেজ</label>
                                <textarea id="clientMessage" rows="4" placeholder="আপনার প্রশ্ন বা প্রজেক্ট সম্পর্কে লিখুন (কোনো লিংক বা URL দেওয়া যাবে না)..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-lg">
                                <i class="fa-brands fa-whatsapp"></i> হোয়াটসঅ্যাপে মেসেজ পাঠান
                            </button>
                        </form>
                    <?php endif; ?>
                </div>

                <div class="contact-info-box">
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fa-solid fa-clock"></i></div>
                        <div class="why-content">
                            <h3>অফিস সময়</h3>
                            <p>শনিবার থেকে বৃহস্পতিবার: সকাল ১০:০০ টা থেকে রাত ০৮:০০ টা পর্যন্ত। অনলাইন সাপোর্ট ২৪/৭ চালু আছে।</p>
                        </div>
                    </div>
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fa-solid fa-comments"></i></div>
                        <div class="why-content">
                            <h3>ফ্রি কনসালটেশন</h3>
                            <p>আপনার ব্যবসার জন্য সেরা ডিজিটাল স্ট্র্যাটেজি ঠিক করতে আমাদের এক্সপার্ট টিমের সাথে ফ্রিতে আলোচনা করুন।</p>
                        </div>
                    </div>
                    <div class="why-card">
                        <div class="why-icon-wrap"><i class="fa-solid fa-headset"></i></div>
                        <div class="why-content">
                            <h3>জরুরি সাপোর্ট</h3>
                            <p>সার্ভার বা টেকনিক্যাল জরুরি প্রয়োজনে যেকোনো সময় <?php echo esc_html($phone); ?> নম্বরে কল দিন।</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('sarkarhost_offices', 'sarkarhost_offices_shortcode');
add_shortcode('sarkarhost_contact_section', 'sarkarhost_offices_shortcode');

// 12. CTA Banner: [sarkarhost_cta_banner]
function sarkarhost_cta_banner_shortcode($atts) {
    $phone = sarkarhost_get_opt('sarkarhost_phone', '01321-222308');
    $wa = sarkarhost_get_opt('sarkarhost_whatsapp', '8801321222308');

    ob_start();
    ?>
    <section class="cta-banner-section">
        <div class="container">
            <div class="cta-banner-box text-center">
                <span class="cta-subtag">READY TO GROW YOUR BUSINESS?</span>
                <h2 class="cta-title">
                    আপনার প্রয়োজন অনুযায়ী সঠিক Digital Solution নিতে<br>
                    আজই আমাদের সাথে যোগাযোগ করুন
                </h2>
                <p class="cta-desc">
                    আমাদের এক্সপার্ট টিমের সাথে কথা বলে আপনার ব্যবসার জন্য সবচেয়ে উপযুক্ত সমাধান ও ফ্রি পরামর্শ নিন।
                </p>
                <div class="cta-btn-group">
                    <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $wa)); ?>?text=Hello%20Sarkar%20Host,%20I%20want%20to%20get%20started" target="_blank" class="btn btn-cta-primary btn-lg">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span>Get Started With Sarkar Host</span>
                    </a>
                    <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9]/', '', $phone)); ?>" class="btn btn-cta-secondary btn-lg">
                        <i class="fa-solid fa-phone-volume"></i>
                        <span>কল করুন: <?php echo esc_html($phone); ?></span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('sarkarhost_cta_banner', 'sarkarhost_cta_banner_shortcode');
