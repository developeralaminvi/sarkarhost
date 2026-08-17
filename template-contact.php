<?php
/**
 * Template Name: Sarkar Host - Contact & Offices
 * Description: Dedicated Contact, Map Locations, and Form Page.
 */

get_header();
?>

<!-- Banner -->
<section class="inner-page-banner">
    <div class="container">
        <div class="breadcrumbs">
            <a href="<?php echo esc_url(home_url('/')); ?>"><i class="fa-solid fa-house"></i> হোম</a>
            <i class="fa-solid fa-chevron-right"></i>
            <span>যোগাযোগ ও অফিস</span>
        </div>
        <h1 class="page-title">
            আমাদের সাথে যোগাযোগ করুন<br>
            <span class="highlight-text">ঢাকা ও নীলফামারী অফিস</span>
        </h1>
        <p class="page-desc">
            আপনার ব্যবসা বা আইডিয়ার জন্য যে কোনো পরামর্শ বা সেবায় সরাসরি অফিসে এসে কথা বলুন অথবা হটলাইনে কল দিন।
        </p>
    </div>
</section>

<!-- Offices, Maps, and Contact Form -->
<?php echo do_shortcode('[sarkarhost_offices]'); ?>

<?php
get_footer();
