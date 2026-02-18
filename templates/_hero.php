<?php
$current_id = get_the_ID();

if (is_post_type_archive('services')) {
    $donor = get_page_by_path('uslugi-details');
    $current_id = $donor ? $donor->ID : null;
}

$has_thumbnail = has_post_thumbnail($current_id);
$hero_class = $has_thumbnail ? ' hero--has-poster' : '';
?>

<section class="hero<?php echo $hero_class; ?>">
    <div class="container">
        <div class="hero__content">
            <?php
            require_once(TEMPLATE_PATH . '/components/breadcrumbs.php');
            ?>

            <h1 class="hero__title title-md">
                <?php
                if (is_singular()) {
                    the_title();
                } else {
                    echo get_the_archive_title();
                }
                ?>
            </h1>

            <?php if ($has_thumbnail) : ?>
                <div class="hero__image">
                    <img
                        src="<?php echo get_the_post_thumbnail_url($current_id, 'full'); ?>"
                        alt="<?php echo esc_attr(get_the_title($current_id)); ?>"
                        class="cover-image">
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>