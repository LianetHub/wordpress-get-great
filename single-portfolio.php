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

            <?php
            if (have_rows('portfolio_content')):
                while (have_rows('portfolio_content')): the_row();
                    $layout = get_row_layout();

                    // --- 1. ОПИСАНИЕ КЛИЕНТА (Обязательный блок) ---
                    if ($layout == 'client_desc'): ?>
                        <div class="case-block case-block--client-desc typography-block">
                            <h3 class="case-block__title hint">О клиенте</h3>
                            <?php the_sub_field('text'); ?>
                        </div>

                    <?php
                    // --- 2. ЗАПРОС КЛИЕНТА (Обязательный блок) ---
                    elseif ($layout == 'client_request'): ?>
                        <div class="case-block case-block--request typography-block">
                            <h3 class="case-block__title hint">Запрос клиента</h3>
                            <?php the_sub_field('text'); ?>
                        </div>

                    <?php
                    // --- 3. СПИСОК РЕЗУЛЬТАТОВ (Обязательный блок) ---
                    elseif ($layout == 'results_list'):
                        $list_title = get_sub_field('title') ?: 'Что было сделано:';
                    ?>
                        <div class="case-block case-block--results">
                            <h3 class="case-block__title"><?php echo esc_html($list_title); ?></h3>
                            <?php if (have_rows('list')): ?>
                                <ul class="case-results-list">
                                    <?php while (have_rows('list')): the_row(); ?>
                                        <li class="case-results-list__item">
                                            <?php echo esc_html(get_sub_field('text')); ?>
                                        </li>
                                    <?php endwhile; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                    <?php
                    // --- 4. ПРОИЗВОЛЬНЫЙ ТЕКСТ (Опциональный блок) ---
                    elseif ($layout == 'text_block'): ?>
                        <div class="case-block case-block--text typography-block">
                            <?php the_sub_field('content'); ?>
                        </div>

                        <?php
                    // --- 5. ПОЛНОЭКРАННОЕ ФОТО ---
                    elseif ($layout == 'full_image'):
                        $img = get_sub_field('image');
                        if ($img): ?>
                            <div class="case-block case-block--full-image">
                                <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
                            </div>
                        <?php endif;

                    // --- 6. ГАЛЕРЕЯ (Сетка) ---
                    elseif ($layout == 'gallery_grid'):
                        $images = get_sub_field('images');
                        if ($images):
                            $count = count($images);
                            $grid_class = ($count > 2) ? 'grid-3' : 'grid-2';
                        ?>
                            <div class="case-block case-block--gallery">
                                <div class="case-gallery <?php echo $grid_class; ?>">
                                    <?php foreach ($images as $img): ?>
                                        <div class="case-gallery__item">
                                            <img src="<?php echo esc_url($img['url']); ?>" alt="<?php echo esc_attr($img['alt']); ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif;

                    // --- 7. ВИДЕО ---
                    elseif ($layout == 'video_block'):
                        $video = get_sub_field('video_url');
                        ?>
                        <div class="case-block case-block--video">
                            <div class="video-responsive">
                                <?php echo $video; ?>
                            </div>
                        </div>

                    <?php
                    // --- 8. CTA BLOCK ---
                    elseif ($layout == 'cta_block'):
                        $cta_text = get_sub_field('text');
                        $cta_btn = get_sub_field('btn_text');
                    ?>
                        <div class="case-cta">
                            <div class="case-cta__text">
                                <?php echo esc_html($cta_text); ?>
                            </div>
                            <button class="btn btn-primary case-cta__btn" data-modal="#discuss-project">
                                <?php echo esc_html($cta_btn); ?>
                            </button>
                        </div>

            <?php endif;
                endwhile;
            endif;
            ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>