<?php if (have_rows('article_items')) : ?>
    <?php
    $view_type = get_field('article_items_view');
    ?>

    <div class="article__items <?php echo ($view_type == 1) ? 'article__items--cols' : ''; ?>">
        <?php while (have_rows('article_items')) : the_row(); ?>
            <?php
            $ic = get_sub_field('ic');
            $txt = get_sub_field('txt');
            $column_size = get_sub_field('column_size');
            $bg_color = get_sub_field('background-color');
            $bg_decor = get_sub_field('background-decor');

            $item_class = 'article__item';
            $styles = [];
            $icon_color = '#FF4405';

            if ($bg_color) {
                $contrast = get_contrast_color($bg_color);
                $styles[] = 'background-color: ' . $bg_color;
                $styles[] = 'color: ' . $contrast;

                if ($contrast === '#ffffff') {
                    $item_class .= ' is-dark';
                    $icon_color = '#ffffff';
                } else {
                    $item_class .= ' is-light';
                }
            }

            if ($view_type == 1 && $column_size) {
                $item_class .= ' article__item--' . $column_size;
            }
            if ($bg_decor) {
                $item_class .= ' article__item--decor';
            }

            $style_attr = !empty($styles) ? 'style="' . implode('; ', $styles) . ';"' : '';
            ?>

            <div class="<?php echo esc_attr($item_class); ?>" <?php echo $style_attr; ?>>
                <?php if ($ic) : ?>
                    <div class="article__item-ic">
                        <?php
                        $extension = pathinfo($ic, PATHINFO_EXTENSION);
                        if ($extension === 'svg') {
                            echo get_processed_svg($ic, $icon_color);
                        } else {
                            echo '<img src="' . esc_url($ic) . '" alt="">';
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <?php if ($txt) : ?>
                    <div class="article__item-txt">
                        <?php echo $txt; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>