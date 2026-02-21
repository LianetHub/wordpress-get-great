<?php

/**
 * Template Name: Portfolio Single
 * Post Type: portfolio
 */

get_header();
require_once(get_template_directory() . '/templates/_hero.php');
?>

<div class="case-detail">
    <div class="container">
        <div class="case-detail__body">
            <button type="button"
                class="case-detail__back back-button icon-arrow-left btn btn-secondary">
                Назад
            </button>
            <div class="case-detail__main">
                <div class="case-detail__header">
                    <div class="case-detail__type hint">КЕЙС</div>
                    <?php
                    $terms = get_the_terms(get_the_ID(), 'portfolio_cat');
                    if ($terms && !is_wp_error($terms)) :
                        foreach ($terms as $term) : ?>
                            <a href="<?php echo esc_url(get_term_link($term)); ?>" class="case-detail__category articles__tag">
                                <?php echo esc_html($term->name); ?>
                            </a>
                    <?php endforeach;
                    endif;
                    ?>
                </div>
                <div class="case-detail__content typography-block">
                    <?php the_content(); ?>
                </div>
                <div class="case-detail__banner">
                    <div class="case-detail__banner-text">Понравился наш кейс? Давайте обсудим ваш проект, оставьте заявку и мы с вами свяжемся</div>
                    <a href="#discuss-project" data-fancybox class="btn btn-primary">Обсудить проект</a>
                </div>
                <div class="case-detail__more">
                    <div class="case-detail__more-hint hint">другие кейсы</div>
                    <div class="case-detail__other other-services__grid">
                        <?php
                        $current_id = get_the_ID();
                        $terms = get_the_terms($current_id, 'portfolio_cat');

                        $args = [
                            'post_type'      => 'portfolio',
                            'posts_per_page' => 4,
                            'post__not_in'   => [$current_id],
                            'orderby'        => 'rand',
                        ];


                        if ($terms && !is_wp_error($terms)) {
                            $term_ids = wp_list_pluck($terms, 'term_id');
                            $args['tax_query'] = [
                                [
                                    'taxonomy' => 'portfolio_cat',
                                    'field'    => 'term_id',
                                    'terms'    => $term_ids,
                                ],
                            ];
                        }

                        $query = new WP_Query($args);

                        if ($query->have_posts()) :
                            while ($query->have_posts()) : $query->the_post(); ?>
                                <a href="<?php the_permalink(); ?>" class="other-services__item icon-chevron-right">
                                    <span><?php the_title(); ?></span>
                                </a>
                            <?php endwhile;
                            wp_reset_postdata();
                        else : ?>
                            <p>Других кейсов пока нет</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once(TEMPLATE_PATH . '_presentation.php'); ?>

<?php get_footer(); ?>