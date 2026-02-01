<?php
$source = get_field('numbers_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_block = get_field('show_numbers', $prefix);

if (!$show_block) {
    if (is_admin()) render_global_block_notice('Цифры (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Цифры');
    return;
}

$hint = get_field('numbers_hint', $prefix);
$title = get_field('numbers_title', $prefix);
$slides = get_field('numbers_slides', $prefix);
$items = get_field('numbers_items', $prefix);

if ($slides || $items) :
?>
    <section class="numbers">
        <div class="container">
            <div class="numbers__header">
                <?php if ($hint) : ?>
                    <div class="numbers__hint hint"><?php echo esc_html($hint); ?></div>
                <?php endif; ?>
                <?php if ($title) : ?>
                    <h2 class="numbers__title title-lg"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($slides) : ?>
            <div class="numbers__slider swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($slides as $slide) : ?>
                        <div class="numbers__slide swiper-slide">
                            <img
                                src="<?php echo esc_url($slide['url']); ?>"
                                alt="<?php echo esc_attr($slide['alt']); ?>"
                                class="cover-image">
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ($items) : ?>
            <div class="numbers__bottom">
                <div class="container">
                    <div class="numbers__row">
                        <?php foreach ($items as $item) :
                            $val = $item['value'];
                            $unit = $item['unit'];
                            $desc = $item['description'];
                        ?>
                            <div class="numbers__column">
                                <div class="numbers__column-caption">
                                    <?php if ($val) : ?>
                                        <div class="numbers__column-value" data-counter><?php echo esc_html($val); ?></div>
                                    <?php endif; ?>
                                    <?php if ($unit) : ?>
                                        <div class="numbers__column-unit"><?php echo esc_html($unit); ?></div>
                                    <?php endif; ?>
                                </div>
                                <?php if ($desc) : ?>
                                    <div class="numbers__column-desc"><?php echo esc_html($desc); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>