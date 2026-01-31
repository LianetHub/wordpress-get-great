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

$terms = get_terms([
    'taxonomy'   => 'service_cat',
    'hide_empty' => false,
    'orderby'    => 'term_order',
    'order'      => 'ASC',
]);

if (!empty($terms) && !is_wp_error($terms)) :
    $all_items = [];
    $all_projects = [];
    $total_count = count($terms);

    foreach ($terms as $index => $term) {
        $project_group = get_field('category_project', 'service_cat_' . $term->term_id);

        $project_data = null;
        if ($project_group && !empty($project_group['project'])) {
            $p_id = $project_group['project'];
            $custom_img = $project_group['image'] ?? null;

            $img_url = '';
            if ($custom_img) {
                $img_url = is_array($custom_img) ? $custom_img['url'] : $custom_img;
            } else {
                $img_url = get_the_post_thumbnail_url($p_id, 'large');
            }

            $project_data = [
                'id'   => $p_id,
                'name' => get_the_title($p_id),
                'desc' => get_the_excerpt($p_id),
                'link' => get_permalink($p_id),
                'img'  => $img_url
            ];
        }

        $all_items[] = [
            'term'    => $term,
            'project' => $project_data,
            'active'  => ($index === 0) ? 'active' : ''
        ];

        if ($project_data) {
            $all_projects[$term->term_id] = $project_data;
        }
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
                    <?php if ($hint): ?>
                        <div class="services__hint hint"><?php echo esc_html($hint); ?></div>
                    <?php endif; ?>
                    <?php if ($title): ?>
                        <h2 class="services__title title-lg"><?php echo esc_html($title); ?></h2>
                    <?php endif; ?>
                    <?php if ($subtitle): ?>
                        <p class="services__subtitle subtitle"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>
                </div>

                <div class="services__content">
                    <div class="services__column">
                        <div class="services__items">
                            <?php foreach ($left_column as $item) : ?>
                                <button type="button" data-da=".services__slider-wrapper, 1199.98" class="services__item swiper-slide <?php echo $item['active']; ?>" data-project-id="<?php echo $item['term']->term_id; ?>">
                                    <span class="services__item-caption icon-arrow-right"><?php echo esc_html($item['term']->name); ?></span>
                                    <span class="services__item-desc"><?php echo esc_html($item['term']->description); ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>
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
                    </div>

                    <div class="services__projects">
                        <?php
                        $p_idx = 0;
                        foreach ($all_projects as $t_id => $proj) : ?>
                            <div class="services__project <?php echo ($p_idx === 0) ? 'active' : ''; ?>" data-project-target="<?php echo $t_id; ?>">
                                <div class="services__project-image">
                                    <?php if ($proj['img']): ?>
                                        <img src="<?php echo esc_url($proj['img']); ?>" alt="<?php echo esc_attr($proj['name']); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="services__project-info">
                                    <div class="services__project-name">
                                        <?php echo esc_html($proj['name']); ?>
                                    </div>
                                    <div class="services__project-desc">
                                        <?php echo esc_html($proj['desc']); ?>
                                    </div>
                                    <a href="<?php echo esc_url($proj['link']); ?>" class="services__project-btn btn btn-secondary">Подробнее</a>
                                </div>
                            </div>
                        <?php
                            $p_idx++;
                        endforeach; ?>
                    </div>

                    <div class="services__column">
                        <div class="services__items">
                            <?php foreach ($right_column as $item) : ?>
                                <button type="button" data-da=".services__slider-wrapper, 1199.98" class="services__item swiper-slide <?php echo $item['active']; ?>" data-project-id="<?php echo $item['term']->term_id; ?>">
                                    <span class="services__item-caption icon-arrow-left"><?php echo esc_html($item['term']->name); ?></span>
                                    <span class="services__item-desc"><?php echo esc_html($item['term']->description); ?></span>
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