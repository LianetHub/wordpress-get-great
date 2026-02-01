<?php
$source = get_field('founder_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_block = get_field('show_founder', $prefix);

if (!$show_block) {
    if (is_admin()) render_global_block_notice('Основатель (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Основатель');
    return;
}

$quote = get_field('founder_quote', $prefix);
$name = get_field('founder_name', $prefix);
$position = get_field('founder_position', $prefix);
$image = get_field('founder_image', $prefix);

if ($quote || $name) :
?>
    <section class="founder">
        <div class="founder__wrapper">
            <div class="container">
                <div class="founder__content">
                    <div class="founder__main">
                        <?php if ($quote) :
                            $quote_with_marks = preg_replace('/^<p>/', '<p>«', $quote);
                            $quote_with_marks = preg_replace('/<\/p>$/', '»</p>', $quote_with_marks);
                        ?>
                            <blockquote class="founder__blockquote">
                                <?php echo $quote_with_marks; ?>
                            </blockquote>
                        <?php endif; ?>

                        <?php if ($name || $position) : ?>
                            <div class="founder__person">
                                <?php if ($name) : ?>
                                    <div class="founder__person-name"><?php echo esc_html($name); ?></div>
                                <?php endif; ?>

                                <?php if ($position) : ?>
                                    <div class="founder__person-position"><?php echo esc_html($position); ?></div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($image) : ?>
                        <div class="founder__image">
                            <div class="founder__image-block">
                                <img
                                    src="<?php echo esc_url($image['url']); ?>"
                                    alt="<?php echo esc_attr($image['alt'] ?: $name); ?>"
                                    class="cover-image">
                            </div>
                            <svg class="founder__mask hidden">
                                <defs>
                                    <clipPath
                                        id="founder-mask"
                                        clipPathUnits="objectBoundingBox">
                                        <path d="M0.8018,0 L0.9394,0.079 C0.9769,0.1005 1,0.1404 1,0.1835 V1 H0 V0 H0.8018 Z" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
<?php endif; ?>