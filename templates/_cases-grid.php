<section class="cases">
    <div class="container">
        <div class="articles__tags">

            <?php
            $current_term = get_queried_object();
            $is_all = is_post_type_archive('portfolio');
            $taxonomy = 'portfolio_cat';

            $terms = get_terms([
                'taxonomy'   => $taxonomy,
                'hide_empty' => 0,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ]);
            ?>

            <a href="<?php echo get_post_type_archive_link('portfolio'); ?>" class="articles__tag <?php echo $is_all ? 'active' : ''; ?>">
                Все проекты
            </a>

            <?php if (!empty($terms) && !is_wp_error($terms)) : ?>
                <?php foreach ($terms as $term) :
                    $active_class = (isset($current_term->term_id) && $current_term->term_id === $term->term_id) ? 'active' : '';
                ?>
                    <a href="<?php echo get_term_link($term); ?>" class="articles__tag <?php echo $active_class; ?>">
                        <?php echo esc_html($term->name); ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
        <?php if (have_posts()) : ?>
            <ul class="cases__list">
                <?php while (have_posts()) : the_post(); ?>
                    <li class="cases__item">
                        <?php get_template_part('templates/components/case-card'); ?>
                    </li>
                <?php endwhile; ?>
            </ul>

            <?php
            the_posts_pagination([
                'prev_text' => '<span class="screen-reader-text">Предыдущая</span>',
                'next_text' => '<span class="screen-reader-text">Следующая</span>',
            ]);
            ?>
        <?php else : ?>
            <p>Проектов не найдено.</p>
        <?php endif; ?>
    </div>
</section>