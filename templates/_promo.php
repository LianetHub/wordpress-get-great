<?php
$privacy_txt = get_field('privacy_txt', 'option');
$promo_slides = get_field('promo_slides');
$form_caption = get_field('form_caption');
$form_text = get_field('form_text');

$promo_form_title = get_field('promo_form_title', 'option');
$promo_form_subtitle = get_field('promo_form_subtitle', 'option');
$promo_form_btn = get_field('promo_form_btn', 'option') ?? "Отправить";

$has_h1 = false;
?>

<section class="promo">
    <div class="promo__slider swiper">
        <div class="swiper-wrapper">
            <?php if ($promo_slides) : ?>
                <?php foreach ($promo_slides as $slide) : ?>
                    <?php
                    $slide_img = $slide['slide_image'];
                    $slide_video = $slide['slide_video'];
                    $title_tag = $slide['title_tag'] ?: 'div';

                    if ($title_tag === 'h1') {
                        if ($has_h1) {
                            $title_tag = 'div';
                        } else {
                            $has_h1 = true;
                        }
                    }

                    $poster_url = '';
                    if ($slide_img) {
                        $poster_url = $slide_img['url'];
                    }

                    $bg_style = '';
                    if ($slide_img && empty($slide_video)) {
                        $bg_style = ' style="background-image: url(' . esc_url($poster_url) . '); background-size: cover; background-position: center;"';
                    }
                    ?>
                    <div class="promo__slide swiper-slide" <?php echo $bg_style; ?> data-title="<?php echo esc_attr($slide['tab_text']); ?>">
                        <?php if (!empty($slide_video)) : ?>
                            <video class="promo__video" playsinline autoplay muted loop poster="<?php echo esc_url($poster_url); ?>">
                                <source src="<?php echo esc_url($slide_video['url']); ?>" type="video/mp4">
                            </video>
                        <?php endif; ?>
                        <div class="container">
                            <div class="promo__offer">
                                <<?php echo $title_tag; ?> class="promo__title">
                                    <?php echo wp_kses($slide['title'], ['br' => []]); ?>
                                </<?php echo $title_tag; ?>>

                                <?php if ($slide['subtitle']) : ?>
                                    <p class="promo__subtitle"><?php echo esc_html($slide['subtitle']); ?></p>
                                <?php endif; ?>

                                <div class="promo__btns">
                                    <?php
                                    $slide_btns = $slide['btns'];
                                    if ($slide_btns) :
                                        foreach ($slide_btns as $btn_item) :

                                            $btn_data = $btn_item['btn'];

                                            if (!empty($btn_data)) {
                                                get_template_part('templates/components/button', null, [
                                                    'data'  => $btn_data,
                                                    'class' => 'promo__btn',
                                                ]);
                                            }
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="promo__actions">
        <div class="container">
            <div class="promo__side">
                <div class="promo__tabs">
                    <?php if ($promo_slides) : ?>
                        <?php foreach ($promo_slides as $index => $slide) : ?>
                            <button type="button" class="promo__tab-btn<?php echo $index === 0 ? ' active' : ''; ?>">
                                <span class="promo__tab-text"><?php echo esc_html($slide['tab_text']); ?></span>
                                <span class="promo__tab-icon">
                                    <?php
                                    if (!empty($slide['tab_icon'])) {
                                        $icon_id = is_array($slide['tab_icon']) ? $slide['tab_icon']['id'] : $slide['tab_icon'];
                                        $icon_path = get_attached_file($icon_id);
                                        if ($icon_path && file_exists($icon_path)) {
                                            echo file_get_contents($icon_path);
                                        }
                                    }
                                    ?>
                                </span>
                                <svg class="promo__tab-border" width="100%" height="100%">
                                    <rect x="0" y="0" fill="none" rx="0" ry="0" />
                                </svg>
                            </button>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="promo__form form">
                    <input type="hidden" name="action" value="send_contact_form">
                    <input type="hidden" name="promo_slide_source" class="js-slide-source" value="">
                    <div class="promo__form-header">
                        <?php if ($promo_form_title): ?>
                            <div class="promo__form-caption title-xs"><?php echo esc_html($promo_form_title); ?></div>
                        <?php endif; ?>
                        <?php if ($promo_form_subtitle): ?>
                            <div class="promo__form-text"><?php echo esc_html($promo_form_subtitle); ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="promo__form-fields">
                        <label class="promo__form-field form__field">
                            <span class="form__field-label form__field-label--required">Ваше имя</span>
                            <input type="text" name="username" data-required class="form__control" placeholder="Введите имя">
                        </label>
                        <label class="promo__form-field form__field">
                            <span class="form__field-label form__field-label--required">Ваш телефон</span>
                            <input type="tel" name="phone" data-required class="form__control" placeholder="+7 (___) ___-__-__">
                        </label>
                    </div>
                    <div class="promo__form-footer">
                        <button type="submit" class="form__btn btn btn-primary btn-sm"><?php echo esc_html($promo_form_btn); ?></button>
                        <?php if ($privacy_txt): ?>
                            <div class="form__policy">
                                <?php echo wp_kses_post($privacy_txt) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>