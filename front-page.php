<?php

/**
 * Template for the main landing page (Home)
 */
?>

<?php get_header(); ?>

<div class="homepage-header">
    <?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
    <?php require_once(TEMPLATE_PATH . '_clients-marquee.php'); ?>
</div>

<?php require_once(TEMPLATE_PATH . '_faq.php'); ?>
<?php require_once(TEMPLATE_PATH . '_presentation.php'); ?>



<?php get_footer(); ?>