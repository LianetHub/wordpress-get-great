<?php
$images = get_field('slider_images');
?>

<?php if ($images): ?>
    <div class="article__slider swiper">
        <div class="swiper-wrapper">
            <?php foreach ($images as $image): ?>
                <div class="article__slide swiper-slide">
                    <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" class="article__prev swiper-button-prev"></button>
        <button type="button" class="article__next swiper-button-next"></button>
        <div class="article__pagination swiper-pagination"></div>
    </div>
<?php endif; ?>