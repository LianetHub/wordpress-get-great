<?php
$source = get_field('mission_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_mission = get_field('show_mission', $prefix);

if (!$show_mission) {
    if (is_admin()) render_global_block_notice('Наша миссия (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('Наша миссия');
    return;
}

$title = get_field('mission_title', $prefix) ?: "Наша миссия";
?>

<section class="mission">
    <div class="container">
        <?php if ($title): ?>
            <h2 class="mission__title title-lg"><?php echo esc_html($title); ?></h2>
        <?php endif; ?>

        <?php if (have_rows('mission_columns', $prefix)): ?>
            <div class="mission__content">
                <?php while (have_rows('mission_columns', $prefix)): the_row(); ?>
                    <div class="mission__column">
                        <?php if (have_rows('column_elements')): ?>
                            <?php while (have_rows('column_elements')): the_row();
                                $layout = get_row_layout(); ?>

                                <?php if ($layout === 'text'): ?>
                                    <?php
                                    $font_size = get_sub_field('text_content_size') ?: '16px';
                                    ?>
                                    <div class="mission__text typography-block" style="font-size: <?php echo esc_attr($font_size); ?>;">
                                        <?php the_sub_field('text_content'); ?>
                                    </div>
                                <?php endif; ?>

                                <?php if ($layout === 'quote'): ?>
                                    <blockquote class="mission__quote">
                                        «<?php the_sub_field('quote_text'); ?>»
                                    </blockquote>
                                <?php endif; ?>

                                <?php if ($layout === 'button'): ?>
                                    <?php
                                    $row = get_row();
                                    unset($row['acf_fc_layout']);

                                    $btn_data_raw = reset($row);

                                    if (is_array($btn_data_raw) && !isset($btn_data_raw['btn_txt'])) {
                                        $first_element = reset($btn_data_raw);
                                        if (is_array($first_element)) {
                                            $btn_data_raw = $first_element;
                                        }
                                    }

                                    $btn_data = [];

                                    if (is_array($btn_data_raw)) {
                                        foreach ($btn_data_raw as $key => $value) {
                                            if (strpos($key, 'field_') === 0) {
                                                $field_object = acf_get_field($key);
                                                if ($field_object && isset($field_object['name'])) {
                                                    $name = $field_object['name'];

                                                    if ($name === 'btn_link' && is_array($value) && isset($value['url'])) {
                                                        $btn_data[$name] = $value['url'];
                                                        $btn_data['btn_target'] = !empty($value['target']) ? $value['target'] : '';
                                                    } else {
                                                        $btn_data[$name] = $value;
                                                    }
                                                }
                                            } else {
                                                $btn_data[$key] = $value;
                                            }
                                        }
                                    }

                                    if (!empty($btn_data['btn_txt'])):
                                        get_template_part('templates/components/button', null, [
                                            'data'  => $btn_data,
                                            'class' => 'mission__btn',
                                        ]);
                                    endif;
                                    ?>
                                <?php endif; ?>

                            <?php endwhile; ?>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</section>