<?php
$source = get_field('services_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_block = get_field('show_services', $prefix);

if (!$show_block) {
    if (is_admin()) render_global_block_notice('Наши услуги (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Наши услуги');
    return;
}

$hint = get_field('services_hint', $prefix) ?: "что мы делаем";
$title = get_field('services_title', $prefix) ?: "Наши услуги";
$subtitle = get_field('services_subtitle', $prefix);

$services_list = get_field('services_list', $prefix);
$show_services_button = get_field('show_services_button', $prefix);

if ($services_list) :
    $all_items = [];
    $total_count = count($services_list);

    $manual_active_index = -1;
    foreach ($services_list as $index => $item) {
        if (!empty($item['is_active_service'])) {
            $manual_active_index = $index;
            break;
        }
    }

    foreach ($services_list as $index => $item) {
        $unique_id = 'service_' . $index;
        $img = $item['project_image'];
        $img_url = is_array($img) ? $img['url'] : $img;

        $is_active = ($manual_active_index !== -1) ? ($index === $manual_active_index) : ($index === 0);

        $all_items[] = [
            'id'           => $unique_id,
            'name'         => $item['service_name'],
            'description'  => $item['service_description'],
            'active'       => $is_active ? 'active' : '',
            'project'      => [
                'title'    => $item['project_title'],
                'text'     => $item['project_text'],
                'btn_data' => $item['project_button'],
                'img'      => $img_url,
            ]
        ];
    }

    $left_column = [];
    $right_column = [];

    foreach ($all_items as $index => $item) {
        $number = $index + 1;
        if ($total_count % 2 !== 0 && $number === $total_count) {
            $right_column[] = $item;
        } elseif ($number % 2 !== 0) {
            $left_column[] = $item;
        } else {
            $right_column[] = $item;
        }
    }
?>

    <section class="services">
        <div class="services__wrapper">
            <div class="container">
                <div class="services__header">
                    <?php if ($hint): echo '<div class="services__hint hint">' . esc_html($hint) . '</div>';
                    endif; ?>
                    <?php if ($title): echo '<h2 class="services__title title-lg">' . esc_html($title) . '</h2>';
                    endif; ?>
                    <?php if ($subtitle): echo '<p class="services__subtitle subtitle">' . esc_html($subtitle) . '</p>';
                    endif; ?>
                </div>

                <div class="services__content">
                    <div class="services__column">
                        <div class="services__items">
                            <?php foreach ($left_column as $item) : ?>
                                <button type="button" data-da=".services__slider-wrapper, 1199.98" class="services__item swiper-slide <?php echo $item['active']; ?>" data-project-id="<?php echo $item['id']; ?>">
                                    <span class="services__item-caption icon-arrow-right"><?php echo esc_html($item['name']); ?></span>
                                    <span class="services__item-desc"><?php echo esc_html($item['description']); ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                        <?php if ($show_services_button): ?>
                            <div class="services__column-bottom" data-da=".services__bottom, 1199.98">
                                <?php
                                $btn_field = get_field('services_button', $prefix);
                                if ($btn_field && !empty($btn_field['btn'])):
                                    get_template_part('templates/components/button', null, [
                                        'data'  => $btn_field['btn'],
                                        'class' => 'services__btn',
                                    ]);
                                endif;
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="services__projects">
                        <?php foreach ($all_items as $item) :
                            $proj = $item['project'];
                            if (empty($proj['title'])) continue;
                        ?>
                            <div class="services__project <?php echo $item['active']; ?>" data-project-target="<?php echo $item['id']; ?>">
                                <span class="services__project-image">
                                    <?php if ($proj['img']): ?>
                                        <img src="<?php echo esc_url($proj['img']); ?>" alt="<?php echo esc_attr($proj['title']); ?>">
                                    <?php endif; ?>
                                </span>
                                <div class="services__project-info">
                                    <div class="services__project-name"><?php echo esc_html($proj['title']); ?></div>
                                    <div class="services__project-desc"><?php echo esc_html($proj['text']); ?></div>
                                    <?php if (!empty($proj['btn_data'])): ?>
                                        <?php
                                        get_template_part('templates/components/button', null, [
                                            'data'  => $proj['btn_data']['btn'],
                                            'class' => 'services__project-btn',
                                        ]);
                                        ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="services__column">
                        <div class="services__items">
                            <?php foreach ($right_column as $item) : ?>
                                <button type="button" data-da=".services__slider-wrapper, 1199.98" class="services__item swiper-slide <?php echo $item['active']; ?>" data-project-id="<?php echo $item['id']; ?>">
                                    <span class="services__item-caption icon-arrow-left"><?php echo esc_html($item['name']); ?></span>
                                    <span class="services__item-desc"><?php echo esc_html($item['description']); ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="services__bottom">
                    <div class="services__slider swiper">
                        <div class="services__slider-wrapper swiper-wrapper"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>