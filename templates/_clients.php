<?php
$source = get_field('clients_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_block = get_field('show_clients', $prefix);

if (!$show_block) {
    if (is_admin()) render_global_block_notice('Клиенты (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Клиенты');
    return;
}

$clients_text = get_field('clients_description', $prefix);
$clients_list = get_field('clients_list', 'option');

$initial_count = get_field('clients_initial_count', $prefix) ?: 16;

if ($clients_list) :
    $total_clients = count($clients_list);
?>
    <section class="clients">
        <div class="container">
            <?php if ($clients_text) : ?>
                <div class="clients__text typography-block">
                    <?php echo $clients_text; ?>
                </div>
            <?php endif; ?>

            <div class="clients__content">
                <div class="clients__items">
                    <?php foreach ($clients_list as $index => $item) :
                        $logo = $item['logo'];
                        $case = $item['case_project'];

                        $logo_url = is_array($logo) ? $logo['url'] : $logo;
                        $logo_alt = is_array($logo) ? $logo['alt'] : '';

                        $hidden_class = ($index >= $initial_count) ? 'is-hidden' : '';
                    ?>
                        <?php if ($case) : ?>
                            <a href="<?php echo esc_url(get_permalink($case)); ?>" class="clients__item <?php echo $hidden_class; ?>">
                                <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>">
                            </a>
                        <?php else : ?>
                            <div class="clients__item <?php echo $hidden_class; ?>">
                                <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_alt); ?>">
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <?php if ($total_clients > $initial_count) : ?>
                    <button type="button" class="clients__more btn btn-primary" data-show-more="clients">
                        Загрузить ещё <?php echo ($total_clients - $initial_count); ?> клиентов
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>