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

$selected_clients = get_field('selected_clients', $prefix);

if (!$selected_clients) {
    $selected_clients = get_posts([
        'post_type'      => 'clients',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'orderby'        => 'date',
        'order'          => 'ASC',
    ]);
}

$initial_count = get_field('clients_initial_count', $prefix) ?: 16;

if ($selected_clients) :
    $total_clients = count($selected_clients);
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
                    <?php foreach ($selected_clients as $index => $client_item) :
                        $c_id = (is_object($client_item)) ? $client_item->ID : $client_item;

                        if (get_field('is_logo_hidden', $c_id)) {
                            $total_clients--;
                            continue;
                        }

                        $logo_url = get_the_post_thumbnail_url($c_id, 'full');
                        $case = get_field('case_project', $c_id);
                        $hidden_class = ($index >= $initial_count) ? 'is-hidden' : '';
                        $client_title = get_the_title($c_id);
                    ?>
                        <?php if ($case) : ?>
                            <a href="<?php echo esc_url(get_permalink($case)); ?>" class="clients__item <?php echo $hidden_class; ?>">
                                <?php if ($logo_url) : ?>
                                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($client_title); ?>">
                                <?php endif; ?>
                            </a>
                        <?php else : ?>
                            <div class="clients__item <?php echo $hidden_class; ?>">
                                <?php if ($logo_url) : ?>
                                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($client_title); ?>">
                                <?php endif; ?>
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