<?php
if (is_admin()) {
    if (function_exists('render_global_block_notice')) {
        render_global_block_notice('Благодарности');
    }
    return;
}

$show_gratitudes = get_field('show_gratitudes', 'option');

if (!$show_gratitudes) return;

$hint = get_field('gratitudes_hint', 'option') ?: 'Благодарности';
$title = get_field('gratitudes_title', 'option') ?: 'Благодарности клиентов';
$title_slider = get_field('gratitudes_title_slider', 'option') ?: 'Количество';
$gallery = get_field('gratitudes_gallery', 'option');

if (!$gallery) return;

$count = count($gallery);
?>

<section class="gratitudes">
    <div class="gratitudes__body">
        <div class="container">
            <div class="gratitudes__header">
                <div class="gratitudes__hint hint"><?php echo esc_html($hint); ?></div>
                <h2 class="gratitudes__title title-lg"><?php echo esc_html($title); ?></h2>
            </div>
            <div class="gratitudes__content">
                <div class="gratitudes__caption">
                    <div class="gratitudes__details title-xs">
                        <?php echo $title_slider; ?>
                        <span class="quantity-count">
                            <?php echo $count; ?>
                        </span>
                    </div>
                    <div class="gratitudes__controls">
                        <div class="gratitudes__pagination swiper-pagination"></div>
                        <div class="gratitudes__btns">
                            <button class="gratitudes__prev swiper-button-prev"></button>
                            <button class="gratitudes__next swiper-button-next"></button>
                        </div>
                    </div>
                </div>
                <div class="gratitudes__slider swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($gallery as $image): ?>
                            <a href="<?php echo esc_url($image['url']); ?>"
                                data-fancybox="gratitudes"
                                class="gratitudes__slide swiper-slide">
                                <img src="<?php echo esc_url($image['url']); ?>"
                                    alt="<?php echo esc_attr($image['alt']); ?>"
                                    loading="lazy">
                                <span class="swiper-lazy-preloader"></span>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>