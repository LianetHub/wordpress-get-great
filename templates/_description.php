<?php
$source = get_field('description_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_block = get_field('show_description', $prefix);

if (!$show_block) {
    if (is_admin()) render_global_block_notice('Описание (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Описание');
    return;
}

$title = get_field('description_title', $prefix);
$text = get_field('description_text', $prefix);

if ($title || $text) :
?>
    <section class="description">
        <div class="container">
            <div class="description__content">
                <?php if ($title) : ?>
                    <h2 class="description__title hint"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($text) : ?>
                    <div class="description__text typography-block">
                        <?php echo $text; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>