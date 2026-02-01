<div class="articles">
    <div class="container">
        <div class="articles__tags">
            <?php
            $current_cat = get_queried_object();
            $is_all = is_home();

            $uncat = get_category_by_slug('uncategorized');
            $exclude_ids = $uncat ? [$uncat->term_id] : [1];

            $categories = get_categories([
                'hide_empty' => 0,
                'orderby'    => 'name',
                'order'      => 'ASC',
                'exclude'    => $exclude_ids
            ]);
            ?>

            <a href="<?php echo get_post_type_archive_link('post'); ?>" class="articles__tag <?php echo $is_all ? 'active' : ''; ?>">Все статьи</a>

            <?php foreach ($categories as $cat) :

                if ($cat->slug === 'uncategorized' || $cat->name === 'Без рубрики') continue;

                $active_class = (isset($current_cat->term_id) && $current_cat->term_id === $cat->term_id) ? 'active' : '';
            ?>
                <a href="<?php echo get_category_link($cat->term_id); ?>" class="articles__tag <?php echo $active_class; ?>">
                    <?php echo esc_html($cat->name); ?>
                </a>
            <?php endforeach; ?>
        </div>

        <?php if (have_posts()) : ?>
            <ul class="articles__list">
                <?php while (have_posts()) : the_post();
                    $cat = get_the_category();
                    $cat_name = $cat ? $cat[0]->name : 'Статья';
                    $reading_time = get_field('reading_time') ?: '5 мин.';

                    $has_thumb = has_post_thumbnail();
                    $placeholder_logo = get_field('logo', 'option');
                    $card_image_class = 'articles__card-image' . (!$has_thumb ? ' is-placeholder' : '');
                ?>
                    <li class="articles__item">
                        <a href="<?php the_permalink(); ?>" class="articles__card">
                            <span class="articles__card-label"><?php echo esc_html($cat_name); ?></span>

                            <span class="<?php echo $card_image_class; ?>">
                                <?php if ($has_thumb) : ?>
                                    <?php the_post_thumbnail('full', ['class' => 'cover-image']); ?>
                                <?php elseif ($placeholder_logo) : ?>
                                    <img src="<?php echo esc_url($placeholder_logo['url']); ?>"
                                        class="placeholder-logo"
                                        alt="<?php echo esc_attr($placeholder_logo['alt'] ?: get_bloginfo('name')); ?>">
                                <?php endif; ?>
                            </span>

                            <span class="articles__card-name"><?php the_title(); ?></span>
                            <span class="articles__card-desc"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></span>

                            <span class="articles__card-bottom">
                                <span class="articles__card-date icon-calendar"><?php echo get_the_date('j F, H:i'); ?></span>
                                <span class="articles__card-read icon-clock"><?php echo esc_html($reading_time); ?> читать</span>
                            </span>
                        </a>
                    </li>
                <?php endwhile; ?>
            </ul>

            <?php
            global $wp_query;

            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $max_pages = $wp_query->max_num_pages;

            if ($max_pages > 1) : ?>
                <div class="articles__pagination pagination">

                    <?php if ($paged > 1) : ?>
                        <?php echo get_previous_posts_link('Назад'); ?>
                    <?php else : ?>
                        <a href="#" class="pagination__prev icon-arrow-left" aria-disabled="true" onclick="return false;">Назад</a>
                    <?php endif; ?>

                    <?php
                    echo paginate_links([
                        'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                        'format'    => '?paged=%#%',
                        'current'   => max(1, get_query_var('paged')),
                        'total'     => $max_pages,
                        'prev_next' => false,
                        'type'      => 'plain',
                        'end_size'  => 1,
                        'mid_size'  => 2,
                    ]);
                    ?>

                    <?php if ($paged < $max_pages) : ?>
                        <?php echo get_next_posts_link('Вперед'); ?>
                    <?php else : ?>
                        <a href="#" class="pagination__next icon-arrow-right" aria-disabled="true" onclick="return false;">Вперед</a>
                    <?php endif; ?>

                </div>
            <?php endif; ?>
        <?php else : ?>
            <br>
            <p>Статей с этой категорией нет.</p>
        <?php endif; ?>
    </div>
</div>