<?php
$source = get_field('other_services_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_block = get_field('show_other_services', $prefix);

if (!$show_block) {
    if (is_admin()) render_global_block_notice('Другие услуги (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Другие услуги');
    return;
}

$title = get_field('other_services_title', $prefix) ?: 'Другие услуги';

$args = [
    'post_type'      => 'services',
    'posts_per_page' => 4,
    'post__not_in'   => [get_the_ID()],
    'orderby'        => 'rand',
];

$query = new WP_Query($args);

if ($query->have_posts()) :
?>

    <section class="other-services">
        <div class="container">
            <h2 class="other-services__title hint">
                <?php echo esc_html($title); ?>
            </h2>
            <?php if ($query->have_posts()) : ?>
                <div class="other-services__grid">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="other-services__item icon-chevron-right">
                            <?php the_title(); ?>
                        </a>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>