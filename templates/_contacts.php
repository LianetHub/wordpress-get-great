<?php
if (is_admin()) {
    if (function_exists('render_global_block_notice')) {
        render_global_block_notice('Контакты');
    }
    return;
}

$section_title = get_field('contacts_section_title') ?: 'Как нас найти';
$section_bg = get_field('contacts_section_bg');

$requisites = get_field('requisites', 'option');
$address = get_field('address', 'option');
$worktime = get_field('worktime', 'option');
$phone = get_field('tel', 'option');
$email  = get_field('email', 'option');
$social_links  = get_field('social_links', 'option');

$contacts_form_title = get_field('contacts_form_title', 'option');
$contacts_form_subtitle = get_field('contacts_form_subtitle', 'option');
$contacts_form_btn = get_field('contacts_form_btn', 'option') ?? "Отправить";
$privacy_txt = get_field('privacy_txt', 'option');

$style = '';
if ($section_bg) {
    $style = ' style="background-image: url(' . esc_url($section_bg['url']) . ');"';
}
?>



<section class="contacts" <?php echo $style; ?>>
    <div class="container">
        <div class="contacts__body">
            <div class="contacts__main">
                <h2 class="contacts__title title-sm"><?php echo esc_html($section_title); ?></h2>
                <ul class="contacts__list">
                    <?php if ($requisites): ?>
                        <li class="contacts__item">
                            <div class="contacts__item-name">Реквизиты:</div>
                            <div class="contacts__item-value">
                                <?php echo $requisites; ?>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if ($address): ?>
                        <li class="contacts__item">
                            <div class="contacts__item-name">Адрес:</div>
                            <div class="contacts__item-value">
                                <?php echo $address; ?>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if ($worktime): ?>
                        <li class="contacts__item">
                            <div class="contacts__item-name">Время работы:</div>
                            <div class="contacts__item-value">
                                <?php echo $worktime; ?>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if ($phone): ?>
                        <li class="contacts__item">
                            <div class="contacts__item-name">Телефон:</div>
                            <div class="contacts__item-value">
                                <a href="tel:<?php echo esc_attr(preg_replace('/[^\d\+]/', '', $phone)); ?>" class="contacts__item-link">
                                    <?php echo esc_html($phone); ?>
                                </a>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if ($email): ?>
                        <li class="contacts__item">
                            <div class="contacts__item-name">Email:</div>
                            <div class="contacts__item-value">
                                <a href="mailto:<?php echo esc_attr($email); ?>" class="contacts__item-link">
                                    <?php echo esc_html($email); ?>
                                </a>
                            </div>
                        </li>
                    <?php endif; ?>
                    <?php if (have_rows('social_links', 'option')): ?>
                        <li class="contacts__item">
                            <div class="contacts__item-name">Соц. сети:</div>
                            <div class="contacts__item-value">
                                <div class="contacts__socials socials">
                                    <?php while (have_rows('social_links', 'option')): the_row();
                                        $icon = get_sub_field('icon');
                                        $link = get_sub_field('link');
                                        $hover_color = get_sub_field('hover_color');
                                    ?>
                                        <a href="<?php echo esc_url($link); ?>"
                                            class="socials__item"
                                            style="--hover-bg: <?php echo esc_attr($hover_color); ?>;"
                                            target="_blank"
                                            rel="nofollow">
                                            <?php if ($icon): ?>
                                                <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
                                            <?php endif; ?>
                                        </a>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="contacts__form form">
                <input type="hidden" name="action" value="send_contact_form">
                <div class="contacts__form-header">
                    <?php if ($contacts_form_title): ?>
                        <div class="contacts__form-caption title-sm"><?php echo esc_html($contacts_form_title); ?></div>
                    <?php endif; ?>
                    <?php if ($contacts_form_subtitle): ?>
                        <div class="contacts__form-text"><?php echo esc_html($contacts_form_subtitle); ?></div>
                    <?php endif; ?>
                </div>
                <div class="contacts__form-fields">
                    <label class="contacts__form-field form__field">
                        <span class="form__field-label form__field-label--required">Ваше имя</span>
                        <input type="text" name="username" data-required class="form__control" placeholder="Введите имя">
                    </label>
                    <label class="contacts__form-field form__field">
                        <span class="form__field-label form__field-label--required">Ваш телефон</span>
                        <input type="tel" name="phone" data-required class="form__control" placeholder="+7 (___) ___-__-__">
                    </label>
                    <label class="contacts__form-field form__field">
                        <span class="form__field-label">Ваш проект</span>
                        <textarea name="message" class="form__control" placeholder="Опишите кратко, какой вопрос вы бы хотели обсудить..."></textarea>
                    </label>
                    <div class="form__file">
                        <label class="form__file-field">
                            <input type="file" name="file" class="form__file-input" hidden>
                            <span class="form__file-btn icon-clip">Прикрепить (до 10 мб.)</span>
                        </label>
                    </div>
                </div>
                <div class="contacts__form-footer">
                    <button type="submit" class="form__btn btn btn-primary btn-sm"><?php echo esc_html($contacts_form_btn); ?></button>
                    <?php if ($privacy_txt): ?>
                        <div class="form__policy">
                            <?php echo wp_kses_post($privacy_txt) ?>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</section>