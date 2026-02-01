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

$clients = get_field('clients_list', 'option');

if ($clients): ?>
    <div class="clients clients--marquee">
        <div class="container">
            <div class="clients__marquee marquee">
                <div class="marquee__slider swiper marquee__slider--images">
                    <div class="swiper-wrapper">
                        <?php foreach ($clients as $client):
                            $logo = $client['logo'];
                            $project = $client['case_project'];
                            $has_tooltip = false;
                            $tooltip_content = '';

                            if ($project) {
                                $post_id = $project->ID;
                                $client_name = get_field('client_name', $post_id);
                                $desc = get_the_excerpt($post_id);

                                if (!empty($client_name) && !empty($desc)) {
                                    $has_tooltip = true;

                                    $html = '<strong>' . $client_name . '</strong><br>' . $desc;
                                    $tooltip_content = htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
                                }
                            }
                        ?>
                            <div class="marquee__image swiper-slide" <?php echo $has_tooltip ? 'data-tooltip-content="' . $tooltip_content . '"' : ''; ?>>
                                <?php if ($logo): ?>
                                    <img src="<?php echo esc_url($logo['url']); ?>"
                                        alt="<?php echo esc_attr($logo['alt'] ?: 'Логотип клиента'); ?>">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>