<?php
$source = get_field('how_we_work_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_block = get_field('show_how_we_work', $prefix);

if (!$show_block) {
    if (is_admin()) render_global_block_notice('Как мы работаем (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Как мы работаем');
    return;
}

$hint = get_field('how_we_work_hint', $prefix);
$title = get_field('how_we_work_title', $prefix);
$items = get_field('how_we_work_items', $prefix);

if ($items) :
?>
    <section class="how-we-work">
        <div class="how-we-work__wrapper">
            <div class="container">
                <div class="how-we-work__header">
                    <?php if ($hint) : ?>
                        <div class="how-we-work__hint hint"><?php echo esc_html($hint); ?></div>
                    <?php endif; ?>
                    <?php if ($title) : ?>
                        <h2 class="how-we-work__title title-lg"><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>
                </div>

                <div class="how-we-work__slider swiper">
                    <ol class="swiper-wrapper">
                        <?php foreach ($items as $item) :
                            $caption = $item['caption'];
                            $desc = $item['description'];
                        ?>
                            <li class="how-we-work__item swiper-slide">
                                <?php if ($caption) : ?>
                                    <div class="how-we-work__caption"><?php echo esc_html($caption); ?></div>
                                <?php endif; ?>
                                <?php if ($desc) : ?>
                                    <div class="how-we-work__desc"><?php echo esc_html($desc); ?></div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>