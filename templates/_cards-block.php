<?php
$source = get_field('cards_block_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_block = get_field('show_cards_block', $prefix);

if (!$show_block) {
    if (is_admin()) render_global_block_notice('Карточки "Мы делаем" (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Карточки "Мы делаем"');
    return;
}

$hint = get_field('cards_block_hint', $prefix);
$title = get_field('cards_block_title', $prefix);
$subtitle = get_field('cards_block_subtitle', $prefix);
$cards = get_field('cards_block_items', $prefix);

if ($cards) :
?>
    <section class="cards-block">
        <div class="container">
            <div class="cards-block__header">
                <?php if ($hint): ?>
                    <div class="cards-block__hint hint"><?php echo esc_html($hint); ?></div>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h2 class="cards-block__title title-lg"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($subtitle): ?>
                    <p class="cards-block__subtitle subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>

            <div class="cards-block__content">
                <?php foreach ($cards as $card) :
                    $size = $card['size'] ?: 'span-5';
                    $icon = $card['icon'];
                    $text = $card['text'];
                    $tooltip = $card['tooltip'];
                    $individual_color = $card['icon_color'] ?: '#ff4d00';
                    $desc = $card['desc'];
                ?>
                    <div class="cards-block__column cards-block__column--<?php echo esc_attr($size); ?>">
                        <div class="cards-block__icon">
                            <?php
                            if ($icon) {
                                echo get_processed_svg($icon['url'], $individual_color);
                            }
                            ?>
                        </div>
                        <div class="cards-block__bottom">
                            <?php if ($text) : ?>
                                <div class="cards-block__text"><?php echo esc_html($text); ?></div>
                            <?php endif; ?>

                            <?php if ($tooltip) : ?>
                                <div class="cards-block__tooltip icon-help-circle" data-tooltip-content="<?php echo esc_attr($tooltip); ?>"></div>
                            <?php endif; ?>
                        </div>
                        <?php if ($desc) : ?>
                            <p class="cards-block__desc"><?php echo esc_html($desc); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>