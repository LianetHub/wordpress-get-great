<?php
$source = get_field('licenses_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_block = get_field('show_licenses', $prefix);

if (!$show_block) {
    if (is_admin()) render_global_block_notice('Лицензии (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Лицензии');
    return;
}

$title = get_field('licenses_title', $prefix) ?? "у нас есть";
$items = get_field('licenses_items', $prefix);

if ($items) :
?>
    <section class="licenses">
        <div class="container">
            <?php if ($title) : ?>
                <h2 class="licenses__title hint"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>

            <ul class="licenses__list">
                <?php foreach ($items as $item) :
                    $image = $item['image'];
                    $name = $item['name'];
                ?>
                    <li class="licenses__item">
                        <?php if ($image) : ?>
                            <div class="licenses__item-image">
                                <img src="<?php echo esc_url($image['url']); ?>"
                                    alt="<?php echo esc_attr($image['alt'] ?: $name); ?>">
                            </div>
                        <?php endif; ?>

                        <?php if ($name) : ?>
                            <div class="licenses__item-name"><?php echo esc_html($name); ?></div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>
<?php endif; ?>