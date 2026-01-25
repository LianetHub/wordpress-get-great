<?php

/**
 * The template for displaying the main Services archive (list of services)
 */
?>
<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>

<?php
$donor = get_page_by_path('uslugi-details');
$donor_id = $donor ? $donor->ID : null;

$services_desc  = get_field('services_description', $donor_id);
?>

<?php if (is_post_type_archive('services')) : ?>
    <div class="services">
        <div class="container">
            <?php if ($services_desc): ?>
                <div class="services__desc">
                    <?php echo wp_kses_post($services_desc);  ?>
                </div>
            <?php endif; ?>

            <div class="services__grid">
                <?php
                $terms = get_terms([
                    'taxonomy'   => 'service_cat',
                    'hide_empty' => false,
                    'orderby'    => 'description',
                    'order'      => 'ASC',
                ]);

                if (!empty($terms) && !is_wp_error($terms)) :
                    $i = 1;
                    foreach ($terms as $term) :
                        $index = sprintf('%02d', $i);

                        $image_id = get_field('category_image', 'service_cat_' . $term->term_id);
                ?>
                        <a href="<?php echo esc_url(get_term_link($term)); ?>" class="service-card">

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
                                    <?php echo esc_html($term->name); ?>
                                </span>
                                <?php if ($term->description): ?>
                                    <span class="service-card__desc">
                                        <span><?php echo esc_html($term->description); ?></span>
                                    </span>
                                <?php endif; ?>
                                <span class="service-card__footer">
                                    <span class="service-card__btn btn btn-primary">Подробнее</span>
                                </span>
                            </span>
                        </a>
                <?php
                        $i++;
                    endforeach;
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