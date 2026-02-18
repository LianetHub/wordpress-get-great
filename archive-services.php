<?php
get_header(); ?>



<?php
$donor = get_page_by_path('uslugi-details');
$donor_id = $donor ? $donor->ID : null;

$services_desc = get_field('services_description', $donor_id);
?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>

<?php if (is_post_type_archive('services')) : ?>
    <div class="services services-page">
        <div class="container">
            <?php if ($services_desc): ?>
                <div class="services__desc">
                    <?php echo wp_kses_post($services_desc); ?>
                </div>
            <?php endif; ?>

            <div class="services__grid">
                <?php
                if (have_posts()) :
                    $i = 1;
                    while (have_posts()) : the_post();
                        $index = sprintf('%02d', $i);
                        $image_id = get_post_thumbnail_id();
                        $short_desc = get_the_excerpt();
                ?>
                        <a href="<?php the_permalink(); ?>" class="service-card">

                            <?php if ($image_id): ?>
                                <span class="service-card__image">
                                    <?php echo wp_get_attachment_image($image_id, 'full'); ?>
                                </span>
                            <?php endif; ?>

                            <span class="service-card__content">
                                <span class="service-card__number">
                                    <?php echo $index; ?>
                                </span>
                                <span class="service-card__name">
                                    <?php the_title(); ?>
                                </span>
                                <?php if ($short_desc): ?>
                                    <span class="service-card__desc">
                                        <span><?php echo esc_html($short_desc); ?></span>
                                    </span>
                                <?php endif; ?>
                                <span class="service-card__footer">
                                    <span class="service-card__btn btn btn-primary">Подробнее</span>
                                </span>
                            </span>
                        </a>
                <?php
                        $i++;
                    endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
if ($donor) {
    $content = apply_filters('the_content', $donor->post_content);
    echo $content;
}
?>

<?php get_footer(); ?>