<?php
/**
 * Template Name: Sarkar Host - Homepage
 * Description: Complete Homepage with Hero, Overview Cards, Why Choose Us, and CTA.
 */

get_header();
?>

<!-- Hero Banner -->
<?php echo do_shortcode('[sarkarhost_hero]'); ?>

<!-- Compact Overview of Services -->
<?php echo do_shortcode('[sarkarhost_home_overview]'); ?>

<!-- Why Choose Us -->
<?php echo do_shortcode('[sarkarhost_why_choose]'); ?>

<!-- Call To Action -->
<?php echo do_shortcode('[sarkarhost_cta_banner]'); ?>

<?php
get_footer();
