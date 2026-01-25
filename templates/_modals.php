<?php
$option_page = 'option';
$white_logo = get_field('white_logo', $option_page);
$privacy_txt = get_field('privacy_txt', $option_page);

$callback_form_title = get_field('callback_form_title', $option_page);
$callback_form_subtitle = get_field('callback_form_subtitle', $option_page);
$callback_form_btn = get_field('callback_form_btn', $option_page) ?? "Отправить";

$order_form_title = get_field('order_form_title', $option_page);
$order_form_subtitle = get_field('order_form_subtitle', $option_page);
$order_form_btn = get_field('order_form_btn', $option_page) ?? "Отправить";

$error_title = get_field('error_title', $option_page);
$error_subtitle = get_field('error_subtitle', $option_page);
$error_close_btn = get_field('error_close_btn', $option_page) ?? "ок, закрыть";
$error_icon = get_field('error_icon', $option_page);

$error_order_title = get_field('error_order_title', $option_page);
$error_order_subtitle = get_field('error_order_subtitle', $option_page);
$error_order_close_btn = get_field('error_order_close_btn', $option_page) ?? "ок, закрыть";
$error_order_icon = get_field('error_order_icon', $option_page);

$success_title = get_field('success_title', $option_page);
$success_subtitle = get_field('success_subtitle', $option_page);
$success_close_btn = get_field('success_close_btn', $option_page) ?? "ок, закрыть";
$success_icon = get_field('success_icon', $option_page);


$payment_and_delivery_policy = get_field('payment_and_delivery_policy', $option_page);
$data_protection_policy = get_field('data_protection_policy', $option_page);
$privacy_policy = get_field('privacy_policy', $option_page);


?>

<div class="popup" id="callback">

    <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="popup__form form">
        <input type="hidden" name="action" value="send_callback_form">
        <label class="popup__form-field form__field">
            <input type="text" name="username" data-required class="form__control form__control--dark" placeholder="Ваше имя">
        </label>
        <label class="popup__form-field form__field">
            <input type="tel" name="phone" data-required class="form__control form__control--dark" placeholder="Телефон">
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


<div class="popup" id="download-presentation">
    <?php if ($white_logo): ?>
        <div class="popup__logo">
            <img src="<?php echo esc_url($white_logo['url']); ?>" alt="<?php echo esc_attr($white_logo['alt']) ?: 'Логотип «DORNOTT»'; ?>">
        </div>
    <?php endif; ?>
    <?php if ($order_form_title): ?>
        <h3 class="popup__title color-accent title-md">
            <?php echo esc_html($order_form_title) ?>
        </h3>
    <?php endif; ?>
    <?php if ($order_form_subtitle): ?>
        <p class="popup__subtitle">
            <?php echo esc_html($order_form_subtitle) ?>
        </p>
    <?php endif; ?>
    <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="popup__form form">
        <input type="hidden" name="action" value="send_order_form">
        <label class="popup__form-field form__field">
            <input type="text" name="username" data-required class="form__control form__control--dark" placeholder="Ваше имя">
        </label>
        <label class="popup__form-field form__field">
            <input type="tel" name="phone" data-required class="form__control form__control--dark" placeholder="Телефон">
        </label>
        <label class="popup__form-field popup__form-field--large form__field">
            <textarea name="message" class="form__control form__control--dark" placeholder="Если у вас корпоративный заказ, опишите приблизительный объём товаров и сроки..."></textarea>
        </label>
        <div class="popup__form-footer">
            <button type="submit" class="form__btn btn btn-primary btn-sm">
                <?php echo esc_html($order_form_btn) ?>
            </button>
            <div class="form__policy">
                <?php echo wp_kses_post($privacy_txt) ?>
            </div>
        </div>
    </form>
</div>

<div class="popup" id="discuss-project">
    <?php if ($white_logo): ?>
        <div class="popup__logo">
            <img src="<?php echo esc_url($white_logo['url']); ?>" alt="<?php echo esc_attr($white_logo['alt']) ?: 'Логотип «DORNOTT»'; ?>">
        </div>
    <?php endif; ?>
    <?php if ($order_form_title): ?>
        <h3 class="popup__title color-accent title-md">
            <?php echo esc_html($order_form_title) ?>
        </h3>
    <?php endif; ?>
    <?php if ($order_form_subtitle): ?>
        <p class="popup__subtitle">
            <?php echo esc_html($order_form_subtitle) ?>
        </p>
    <?php endif; ?>
    <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="popup__form form">
        <input type="hidden" name="action" value="send_order_form">
        <label class="popup__form-field form__field">
            <input type="text" name="username" data-required class="form__control form__control--dark" placeholder="Ваше имя">
        </label>
        <label class="popup__form-field form__field">
            <input type="tel" name="phone" data-required class="form__control form__control--dark" placeholder="Телефон">
        </label>
        <label class="popup__form-field popup__form-field--large form__field">
            <textarea name="message" class="form__control form__control--dark" placeholder="Если у вас корпоративный заказ, опишите приблизительный объём товаров и сроки..."></textarea>
        </label>
        <div class="popup__form-footer">
            <button type="submit" class="form__btn btn btn-primary btn-sm">
                <?php echo esc_html($order_form_btn) ?>
            </button>
            <div class="form__policy">
                <?php echo wp_kses_post($privacy_txt) ?>
            </div>
        </div>
    </form>
</div>

<div class="popup" id="visualization">
    <?php if ($white_logo): ?>
        <div class="popup__logo">
            <img src="<?php echo esc_url($white_logo['url']); ?>" alt="<?php echo esc_attr($white_logo['alt']) ?: 'Логотип «DORNOTT»'; ?>">
        </div>
    <?php endif; ?>
    <?php if ($order_form_title): ?>
        <h3 class="popup__title color-accent title-md">
            <?php echo esc_html($order_form_title) ?>
        </h3>
    <?php endif; ?>
    <?php if ($order_form_subtitle): ?>
        <p class="popup__subtitle">
            <?php echo esc_html($order_form_subtitle) ?>
        </p>
    <?php endif; ?>
    <form action="<?php echo esc_url(admin_url('admin-ajax.php')); ?>" method="POST" class="popup__form form">
        <input type="hidden" name="action" value="send_order_form">
        <label class="popup__form-field form__field">
            <input type="text" name="username" data-required class="form__control form__control--dark" placeholder="Ваше имя">
        </label>
        <label class="popup__form-field form__field">
            <input type="tel" name="phone" data-required class="form__control form__control--dark" placeholder="Телефон">
        </label>
        <label class="popup__form-field popup__form-field--large form__field">
            <textarea name="message" class="form__control form__control--dark" placeholder="Если у вас корпоративный заказ, опишите приблизительный объём товаров и сроки..."></textarea>
        </label>
        <div class="popup__form-footer">
            <button type="submit" class="form__btn btn btn-primary btn-sm">
                <?php echo esc_html($order_form_btn) ?>
            </button>
            <div class="form__policy">
                <?php echo wp_kses_post($privacy_txt) ?>
            </div>
        </div>
    </form>
</div>


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
</div>