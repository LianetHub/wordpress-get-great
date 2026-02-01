<?php
$clients = get_field('clients_list', 'option');

if ($clients): ?>
    <div class="clients lients--marquee">
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
                                    $tooltip_content = '<strong>' . esc_attr($client_name) . '</strong><br>' . esc_attr($desc);
                                }
                            }
                        ?>
                            <div class="marquee__image swiper-slide"
                                <?php if ($has_tooltip): ?>
                                data-tooltip-content="<?php echo $tooltip_content; ?>"
                                <?php endif; ?>>
                                <?php if ($logo): ?>
                                    <img src="<?php echo esc_url($logo['url']); ?>"
                                        alt="<?php echo esc_attr($logo['alt'] ?? 'Логотип клиента'); ?>">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>