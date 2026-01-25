<?php

$privacy_txt = get_field('privacy_txt', 'option');

$callback_form_image = get_field('callback_form_image', 'option');
$callback_form_title = get_field('callback_form_title', 'option');
$callback_form_subtitle = get_field('callback_form_subtitle', 'option');
$callback_form_btn = get_field('callback_form_btn', 'option') ?? "Отправить";

$download_form_image = get_field('download_form_image', 'option');
$download_form_title = get_field('download_form_title', 'option');
$download_form_subtitle = get_field('download_form_subtitle', 'option');
$download_form_btn = get_field('download_form_btn', 'option') ?? "Отправить";

$discuss_form_image = get_field('discuss_form_image', 'option');
$discuss_form_title = get_field('discuss_form_title', 'option');
$discuss_form_subtitle = get_field('discuss_form_subtitle', 'option');
$discuss_form_btn = get_field('discuss_form_btn', 'option') ?? "Отправить";

$visualization_form_image = get_field('visualization_form_image', 'option');
$visualization_form_title = get_field('visualization_form_title', 'option');
$visualization_form_subtitle = get_field('visualization_form_subtitle', 'option');
$visualization_form_btn = get_field('visualization_form_btn', 'option') ?? "Отправить";

$error_title = get_field('error_title', 'option');
$error_subtitle = get_field('error_subtitle', 'option');
$error_close_btn = get_field('error_close_btn', 'option') ?? "ок, закрыть";
$error_icon = get_field('error_icon', 'option');

$success_title = get_field('success_title', 'option');
$success_subtitle = get_field('success_subtitle', 'option');
$success_close_btn = get_field('success_close_btn', 'option') ?? "ок, закрыть";
$success_icon = get_field('success_icon', 'option');

$privacy_policy = get_field('privacy_policy', 'option');

?>


<div class="popup" id="callback">
    <div class="popup__image">
        <?php if ($callback_form_image): ?>
            <img
                src="<?php echo esc_url($callback_form_image['url']); ?>"
                alt="<?php echo esc_attr($callback_form_image['alt']) ?: 'Обложка'; ?>"
                class="cover-image">
        <?php endif; ?>
    </div>
    <div class="popup__content">
        <?php if ($callback_form_title): ?>
            <h3 class="popup__title title-sm"> <?php echo esc_html($callback_form_title) ?></h3>
        <?php endif; ?>
        <?php if ($callback_form_subtitle): ?>
            <p class="popup__subtitle"><?php echo esc_html($callback_form_subtitle) ?></p>
        <?php endif; ?>
        <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="popup__form form">
            <input type="hidden" name="action" value="send_callback_form">
            <label class="popup__form-field form__field">
                <span class="form__field-label form__field-label--required">Ваше имя</span>
                <input type="text" name="username" data-required class="form__control" placeholder="Введите имя">
            </label>
            <label class="popup__form-field form__field">
                <span class="form__field-label form__field-label--required">Ваш телефон</span>
                <input type="tel" name="phone" data-required class="form__control" placeholder="+7 (___) ___-__-__">
            </label>
            <div class="popup__form-footer">
                <button type="submit" class="form__btn btn btn-primary btn-sm">
                    <?php echo esc_html($callback_form_btn) ?>
                </button>
                <div class="form__policy">
                    <?php echo wp_kses_post($privacy_txt) ?>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="popup" id="download-presentation">
    <div class="popup__image">
        <?php if ($download_form_image): ?>
            <img
                src="<?php echo esc_url($download_form_image['url']); ?>"
                alt="<?php echo esc_attr($download_form_image['alt']) ?: 'Обложка'; ?>"
                class="cover-image">
        <?php endif; ?>
    </div>
    <div class="popup__content">
        <?php if ($download_form_title): ?>
            <h3 class="popup__title title-sm"> <?php echo esc_html($download_form_title) ?></h3>
        <?php endif; ?>
        <?php if ($download_form_subtitle): ?>
            <p class="popup__subtitle"><?php echo esc_html($download_form_subtitle) ?></p>
        <?php endif; ?>
        <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="popup__form form">
            <input type="hidden" name="action" value="send_download_form">
            <label class="popup__form-field form__field">
                <span class="form__field-label form__field-label--required">Ваше имя</span>
                <input type="text" name="username" data-required class="form__control" placeholder="Введите имя">
            </label>
            <label class="popup__form-field form__field">
                <span class="form__field-label form__field-label--required">Ваш телефон</span>
                <input type="tel" name="phone" data-required class="form__control" placeholder="+7 (___) ___-__-__">
            </label>
            <label class="popup__form-field form__field">
                <span class="form__field-label form__field-label--required">Ваш e-mail</span>
                <input type="email" name="email" data-required class="form__control" placeholder="Введите e-mail">
            </label>
            <div class="popup__form-footer">
                <button type="submit" class="form__btn btn btn-primary btn-sm">
                    <?php echo esc_html($download_form_btn) ?>
                </button>
                <div class="form__policy">
                    <?php echo wp_kses_post($privacy_txt) ?>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="popup" id="discuss-project">
    <div class="popup__image">
        <?php if ($discuss_form_image): ?>
            <img
                src="<?php echo esc_url($discuss_form_image['url']); ?>"
                alt="<?php echo esc_attr($discuss_form_image['alt']) ?: 'Обложка'; ?>"
                class="cover-image">
        <?php endif; ?>
    </div>
    <div class="popup__content">
        <?php if ($discuss_form_title): ?>
            <h3 class="popup__title title-sm"> <?php echo esc_html($discuss_form_title) ?></h3>
        <?php endif; ?>
        <?php if ($discuss_form_subtitle): ?>
            <p class="popup__subtitle"><?php echo esc_html($discuss_form_subtitle) ?></p>
        <?php endif; ?>
        <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="popup__form form">
            <input type="hidden" name="action" value="send_discuss_form">
            <label class="popup__form-field form__field">
                <span class="form__field-label form__field-label--required">Ваше имя</span>
                <input type="text" name="username" data-required class="form__control" placeholder="Введите имя">
            </label>
            <label class="popup__form-field form__field">
                <span class="form__field-label form__field-label--required">Ваш телефон</span>
                <input type="tel" name="phone" data-required class="form__control" placeholder="+7 (___) ___-__-__">
            </label>
            <label class="contacts__form-field form__field">
                <span class="form__field-label">Ваш проект</span>
                <textarea name="message" class="form__control" placeholder="Опишите кратко, какой вопрос вы бы хотели обсудить..."></textarea>
            </label>
            <div class="form__file">
                <label class="form__file-field">
                    <input type="file" name="file" class="form__file-input hidden" hidden>
                    <span class="form__file-btn icon-clip">Прикрепить (до 10 мб.)</span>
                </label>
            </div>
            <div class="popup__form-footer">
                <button type="submit" class="form__btn btn btn-primary btn-sm">
                    <?php echo esc_html($discuss_form_btn) ?>
                </button>
                <div class="form__policy">
                    <?php echo wp_kses_post($privacy_txt) ?>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="popup" id="visualization">
    <div class="popup__image">
        <?php if ($visualization_form_image): ?>
            <img
                src="<?php echo esc_url($visualization_form_image['url']); ?>"
                alt="<?php echo esc_attr($visualization_form_image['alt']) ?: 'Обложка'; ?>"
                class="cover-image">
        <?php endif; ?>
    </div>
    <div class="popup__content">
        <?php if ($visualization_form_title): ?>
            <h3 class="popup__title title-sm"> <?php echo esc_html($visualization_form_title) ?></h3>
        <?php endif; ?>
        <?php if ($visualization_form_subtitle): ?>
            <p class="popup__subtitle"><?php echo esc_html($visualization_form_subtitle) ?></p>
        <?php endif; ?>
        <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="popup__form form">
            <input type="hidden" name="action" value="send_visualization_form">
            <label class="popup__form-field form__field">
                <span class="form__field-label form__field-label--required">Ваше имя</span>
                <input type="text" name="username" data-required class="form__control" placeholder="Введите имя">
            </label>
            <label class="popup__form-field form__field">
                <span class="form__field-label form__field-label--required">Ваш телефон</span>
                <input type="tel" name="phone" data-required class="form__control" placeholder="+7 (___) ___-__-__">
            </label>
            <label class="contacts__form-field form__field">
                <span class="form__field-label">Ваш проект</span>
                <textarea name="message" class="form__control" placeholder="Опишите кратко, какой вопрос вы бы хотели обсудить..."></textarea>
            </label>
            <div class="form__file">
                <label class="form__file-field">
                    <input type="file" name="file" class="form__file-input hidden" hidden>
                    <span class="form__file-btn icon-clip">Прикрепить (до 10 мб.)</span>
                </label>
            </div>
            <div class="popup__form-footer">
                <button type="submit" class="form__btn btn btn-primary btn-sm">
                    <?php echo esc_html($visualization_form_btn) ?>
                </button>
                <div class="form__policy">
                    <?php echo wp_kses_post($privacy_txt) ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        Fancybox.show([{
            src: '#callback'
        }])
    })
</script> -->

<!--
<div class="popup popup--background-decor" id="error-submitting">
    <?php if ($error_icon): ?>
        <div class="popup__icon">
            <img src="<?php echo esc_url($error_icon['url']); ?>" alt="<?php echo esc_attr($error_icon['alt']) ?: 'Иконка'; ?>">
        </div>
    <?php endif; ?>
    <?php if ($error_title): ?>
        <h3 class="popup__title color-accent title-md">
            <?php echo esc_html($error_title) ?>
        </h3>
    <?php endif; ?>
    <?php if ($error_subtitle): ?>
        <p class="popup__subtitle">
            <?php echo esc_html($error_subtitle) ?>
        </p>
    <?php endif; ?>
    <button type="button" data-fancybox-close class="popup__btn btn btn-primary">
        <?php echo esc_html($error_close_btn) ?>
    </button>
</div>


<div class="popup popup--background-decor" id="success-submitting">
    <?php if ($success_icon): ?>
        <div class="popup__icon">
            <img src="<?php echo esc_url($success_icon['url']); ?>" alt="<?php echo esc_attr($success_icon['alt']) ?: 'Иконка'; ?>">
        </div>
    <?php endif; ?>
    <?php if ($success_title): ?>
        <h3 class="popup__title color-accent title-md">
            <?php echo esc_html($success_title) ?>
        </h3>
    <?php endif; ?>
    <?php if ($success_subtitle): ?>
        <p class="popup__subtitle">
            <?php echo esc_html($success_subtitle) ?>
        </p>
    <?php endif; ?>
    <button type="button" data-fancybox-close class="popup__btn btn btn-primary">
        <?php echo esc_html($success_close_btn) ?>
    </button>
</div> -->