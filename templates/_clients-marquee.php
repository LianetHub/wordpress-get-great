<?php
$show_block = get_field('show_clients_marquee', 'option');

if (!$show_block) {
    if (is_admin()) render_global_block_notice('Клиенты Marquee (Скрыто)');
    return;
}

if (is_admin() && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Наши клиенты (Marquee)');
    return;
}

$selected_clients = get_field('selected_clients_marquee', 'option');

if (!$selected_clients) {
    $selected_clients = get_posts([
        'post_type'      => 'clients',
        'posts_per_page' => 10,
        'post_status'    => 'publish',
        'fields'         => 'ids',
        'orderby'        => 'date',
        'order'          => 'ASC',
    ]);
}

if ($selected_clients): ?>
    <div class="clients clients--marquee">
        <div class="container">
            <div class="clients__marquee marquee">
                <div class="marquee__slider swiper marquee__slider--images">
                    <div class="swiper-wrapper">
                        <?php
                        foreach ($selected_clients as $client_item):
                            $c_id = (is_object($client_item)) ? $client_item->ID : $client_item;

                            if (get_field('is_logo_hidden', $c_id)) continue;

                            $logo_url = get_the_post_thumbnail_url($c_id, 'full');

                            $show_tooltip_acf = get_field('show_tooltip', $c_id);
                            $show_tooltip_field = ($show_tooltip_acf === null) ? true : $show_tooltip_acf;

                            $has_tooltip = false;
                            $tooltip_content = '';

                            if ($show_tooltip_field) {
                                $client_name = get_the_title($c_id);
                                $desc = get_the_excerpt($c_id);

                                if (!empty($client_name) || !empty($desc)) {
                                    $has_tooltip = true;
                                    $html = '<strong>' . esc_html($client_name) . '</strong>';
                                    if (!empty($desc)) {
                                        $html .= '<br>' . esc_html($desc);
                                    }
                                    $tooltip_content = htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
                                }
                            }
                        ?>
                            <div class="marquee__image swiper-slide" <?php echo $has_tooltip ? 'data-tooltip-content="' . $tooltip_content . '"' : ''; ?>>
                                <?php if ($logo_url): ?>
                                    <img src="<?php echo esc_url($logo_url); ?>"
                                        alt="<?php echo esc_attr(get_the_title($c_id)); ?>">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>