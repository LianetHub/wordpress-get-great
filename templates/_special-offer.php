<?php
$source = get_field('special_offer_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_block = get_field('show_special_offer', $prefix);

if (!$show_block) {
    if (is_admin()) render_global_block_notice('Спецпредложение (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Спецпредложение');
    return;
}

$hint     = get_field('special_offer_hint', $prefix) ?: "спец. предложение";
$title    = get_field('special_offer_title', $prefix);
$subtitle = get_field('special_offer_subtitle', $prefix);
$image    = get_field('special_offer_image', $prefix);
?>

<section class="special-offer">
    <div class="special-offer__wrapper">
        <div class="container">
            <div class="special-offer__body">
                <div class="special-offer__main">
                    <?php if ($hint): ?>
                        <div class="special-offer__hint hint"><?php echo esc_html($hint); ?></div>
                    <?php endif; ?>

                    <?php if ($title): ?>
                        <h2 class="special-offer__title title-md"><?php echo $title; ?></h2>
                    <?php endif; ?>

                    <?php if ($subtitle): ?>
                        <p class="special-offer__subtitle subtitle"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>

                    <?php if (have_rows('special_offer_cards', $prefix)): ?>
                        <ul class="special-offer__cards">
                            <?php while (have_rows('special_offer_cards', $prefix)): the_row();
                                $card_icon = get_sub_field('card_icon');
                                $card_text = get_sub_field('card_text');
                            ?>
                                <li class="special-offer__card">
                                    <?php if ($card_icon): ?>
                                        <div class="special-offer__card-icon">
                                            <?php
                                            $icon_id = is_array($card_icon) ? $card_icon['id'] : $card_icon;
                                            $icon_path = get_attached_file($icon_id);

                                            if ($icon_path && file_exists($icon_path)) {
                                                $ext = pathinfo($icon_path, PATHINFO_EXTENSION);
                                                if ($ext === 'svg') {
                                                    echo file_get_contents($icon_path);
                                                } else {
                                                    echo wp_get_attachment_image($icon_id, 'full');
                                                }
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if ($card_text): ?>
                                        <div class="special-offer__card-text"><?php echo esc_html($card_text); ?></div>
                                    <?php endif; ?>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                    <?php endif; ?>

                    <?php
                    $btn_field = get_field('special_offer_button', $prefix);
                    if ($btn_field && !empty($btn_field['btn']['btn_txt'])):
                        get_template_part('templates/components/button', null, [
                            'data'  => $btn_field['btn'],
                            'class' => 'special-offer__btn',
                        ]);
                    endif;
                    ?>
                </div>

                <?php if ($image): ?>
                    <div class="special-offer__image">
                        <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>