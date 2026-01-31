<?php
$source = get_field('cases_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_block = get_field('show_cases', $prefix);

if (!$show_block) {
    if (is_admin()) render_global_block_notice('Наши кейсы (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Наши кейсы');
    return;
}

$hint         = get_field('cases_hint', $prefix) ?: "портфолио";
$title        = get_field('cases_title', $prefix) ?: "Наши кейсы";
$subtitle     = get_field('cases_subtitle', $prefix) ?: "Мы знаем, что такое брендбук, стиль, первые лица, «надо вчера»";
$manual_cases = get_field('selected_cases', $prefix);

$posts_per_page = wp_is_mobile() ? 5 : 9;

if ($manual_cases) {
    if (wp_is_mobile() && count($manual_cases) > 5) {
        $manual_cases = array_slice($manual_cases, 0, 5);
    }

    $args = [
        'post_type'      => 'portfolio',
        'post__in'       => $manual_cases,
        'orderby'        => 'post__in',
        'posts_per_page' => -1,
    ];
} else {
    $args = [
        'post_type'      => 'portfolio',
        'posts_per_page' => $posts_per_page,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ];
}

$query = new WP_Query($args);
?>

<section class="cases">
    <div class="container">
        <div class="cases__header">
            <?php if ($hint): ?>
                <div class="cases__hint hint"><?php echo esc_html($hint); ?></div>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 class="cases__title title-lg"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($subtitle): ?>
                <div class="cases__subtitle subtitle"><?php echo esc_html($subtitle); ?></div>
            <?php endif; ?>
        </div>

        <?php if ($query->have_posts()): ?>
            <ul class="cases__list">
                <?php while ($query->have_posts()): $query->the_post(); ?>
                    <li class="cases__item">
                        <?php get_template_part('templates/components/case-card'); ?>
                    </li>
                <?php endwhile;
                wp_reset_postdata(); ?>
            </ul>
        <?php endif; ?>

        <?php
        $archive_link = get_post_type_archive_link('portfolio');
        if ($archive_link):
            $count_all = wp_count_posts('portfolio')->publish;
        ?>
            <a href="<?php echo esc_url($archive_link); ?>" class="cases__more btn btn-primary">
                Смотреть все <?php echo $count_all; ?> кейсов
            </a>
        <?php endif; ?>
    </div>
</section>