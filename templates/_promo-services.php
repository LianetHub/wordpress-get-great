<?php
$promo_slides = get_field('promo_slides');
?>

<section class="promo promo--services">
    <div class="promo__top">
        <div class="container">
            <?php require(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>
        </div>
    </div>
    <div class="promo__slider swiper">
        <div class="swiper-wrapper">
            <?php if ($promo_slides) : ?>
                <?php foreach ($promo_slides as $slide) : ?>
                    <?php
                    $slide_img = $slide['slide_image'];
                    $slide_video = $slide['slide_video'];
                    $poster_url = $slide_img ? $slide_img['url'] : '';

                    $bg_style = '';
                    if ($slide_img && empty($slide_video)) {
                        $bg_style = ' style="background-image: url(' . esc_url($poster_url) . '); background-size: cover; background-position: center;"';
                    }
                    ?>
                    <div class="promo__slide swiper-slide" <?php echo $bg_style; ?>>
                        <?php if (!empty($slide_video)) : ?>
                            <video class="promo__video" playsinline autoplay muted loop poster="<?php echo esc_url($poster_url); ?>">
                                <source src="<?php echo esc_url($slide_video['url']); ?>" type="video/mp4">
                            </video>
                        <?php endif; ?>

                        <div class="container">
                            <div class="promo__content">


                                <div class="promo__offer">
                                    <h1 class="promo__title title">
                                        <?php echo wp_kses($slide['title'], ['br' => []]); ?>
                                    </h1>

                                    <?php if ($slide['subtitle']) : ?>
                                        <p class="promo__subtitle"><?php echo esc_html($slide['subtitle']); ?></p>
                                    <?php endif; ?>

                                    <?php
                                    $slide_btns = $slide['btns'];
                                    if (!empty($slide_btns)) : ?>
                                        <div class="promo__btns">
                                            <?php
                                            foreach ($slide_btns as $btn_item) :
                                                $btn_data = $btn_item['btn'];
                                                if (!empty($btn_data)) {
                                                    get_template_part('templates/components/button', null, [
                                                        'data'  => $btn_data,
                                                        'class' => 'promo__btn',
                                                    ]);
                                                }
                                            endforeach;
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="promo__slide swiper-slide promo__slide--default">
                    <div class="container">
                        <div class="promo__offer">
                            <h1 class="promo__title title"><?php the_title(); ?></h1>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if ($promo_slides && count($promo_slides) > 1) : ?>
        <div class="promo__actions">
            <div class="container">
                <div class="promo__side">
                    <div class="promo__controls">
                        <div class="promo__pagination swiper-pagination"></div>
                        <div class="promo__controls-btns">
                            <div class="promo__prev swiper-button-prev"></div>
                            <div class="promo__next swiper-button-next"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>