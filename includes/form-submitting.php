<?php

add_action('phpmailer_init', 'configure_smtp_mailer');

function configure_smtp_mailer($phpmailer)
{
    if (!isset($_ENV['SMTP_HOST']) || !isset($_ENV['SMTP_USERNAME']) || !isset($_ENV['SMTP_PASSWORD'])) {
        return;
    }

    $phpmailer->isSMTP();
    $phpmailer->Host = $_ENV['SMTP_HOST'];
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = 465;
    $phpmailer->Username = $_ENV['SMTP_USERNAME'];
    $phpmailer->Password = $_ENV['SMTP_PASSWORD'];
    $phpmailer->SMTPSecure = 'ssl';
    $phpmailer->SMTPOptions = [
        'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        ]
    ];
}

add_filter('wp_mail_from', 'custom_mail_from_email');
function custom_mail_from_email($original_email)
{
    return $_ENV['SMTP_USERNAME'] ?? 'no-reply@get-great.ru';
}

add_filter('wp_mail_from_name', 'custom_mail_from_name');
function custom_mail_from_name($original_name)
{
    return 'Get Great - Уведомления';
}

function get_form_recipients()
{
    $recipients = [];
    if (function_exists('get_field')) {
        $emails_repeater = get_field('send_email', 'option');
        if (is_array($emails_repeater)) {
            foreach ($emails_repeater as $row) {
                if (!empty($row['email'])) {
                    $recipients[] = sanitize_email($row['email']);
                }
            }
        }
    }
    return empty($recipients) ? get_option('admin_email') : implode(', ', $recipients);
}

$form_actions = [
    'send_callback_form',
    'send_download_form',
    'send_discuss_form',
    'send_visualization_form',
    'send_promo_form',
    'send_contact_form'
];

foreach ($form_actions as $action) {
    add_action("wp_ajax_{$action}", 'handle_universal_form');
    add_action("wp_ajax_nopriv_{$action}", 'handle_universal_form');
}

function handle_universal_form()
{
    $data = $_POST;
    $action = $_POST['action'] ?? '';

    $subjects = [
        'send_callback_form'      => 'Заявка на обратный звонок',
        'send_download_form'      => 'Запрос на скачивание презентации',
        'send_discuss_form'       => 'Обсуждение проекта (попап)',
        'send_visualization_form' => 'Заявка на визуализацию',
        'send_promo_form'         => 'Заявка из промо-блока',
        'send_contact_form'       => 'Сообщение из контактов',
    ];

    $subject = $subjects[$action] ?? 'Новая заявка с сайта';
    $headers = ['Content-Type: text/html; charset=UTF-8'];

    $username = sanitize_text_field($data['username'] ?? '');
    $phone    = sanitize_text_field($data['phone'] ?? '');
    $email    = sanitize_email($data['email'] ?? '');
    $promo_source = sanitize_text_field($data['promo_slide_source'] ?? '');
    $message_text = nl2br(sanitize_textarea_field($data['message'] ?? ''));

    ob_start();
?>
    <div style="font-family: Arial, sans-serif; color: #333; max-width: 600px;">
        <h2 style="border-bottom: 2px solid #eee; padding-bottom: 10px;"><?php echo esc_html($subject); ?></h2>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="padding: 8px 0; width: 150px; border-bottom: 1px solid #f4f4f4;"><strong>Имя:</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #f4f4f4;"><?php echo esc_html($username); ?></td>
            </tr>
            <tr>
                <td style="padding: 8px 0; border-bottom: 1px solid #f4f4f4;"><strong>Телефон:</strong></td>
                <td style="padding: 8px 0; border-bottom: 1px solid #f4f4f4;"><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></td>
            </tr>
            <?php if ($email): ?>
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #f4f4f4;"><strong>Email:</strong></td>
                    <td style="padding: 8px 0; border-bottom: 1px solid #f4f4f4;"><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
                </tr>
            <?php endif; ?>
            <?php if ($promo_source): ?>
                <tr>
                    <td style="padding: 8px 0; border-bottom: 1px solid #f4f4f4;"><strong>Источник (слайд):</strong></td>
                    <td style="padding: 8px 0; border-bottom: 1px solid #f4f4f4;"><?php echo esc_html($promo_source); ?></td>
                </tr>
            <?php endif; ?>
        </table>

        <?php if ($message_text): ?>
            <div style="margin-top: 20px; background: #f9f9f9; padding: 15px; border-radius: 4px;">
                <strong>Сообщение/Проект:</strong><br>
                <div style="margin-top: 10px; line-height: 1.5;"><?php echo $message_text; ?></div>
            </div>
        <?php endif; ?>

        <p style="color: #999; font-size: 12px; margin-top: 30px; border-top: 1px solid #eee; padding-top: 10px;">
            Отправлено с сайта Get Great
        </p>
    </div>
<?php
    $message = ob_get_clean();

    $attachments = [];
    if (!empty($_FILES['file']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploaded_file = $_FILES['file'];
        $upload_overrides = ['test_form' => false];
        $movefile = wp_handle_upload($uploaded_file, $upload_overrides);

        if ($movefile && !isset($movefile['error'])) {
            $attachments[] = $movefile['file'];
        }
    }

    $to = get_form_recipients();
    $mail_sent = wp_mail($to, $subject, $message, $headers, $attachments);

    if (!empty($attachments)) {
        foreach ($attachments as $file) {
            @unlink($file);
        }
    }

    if ($mail_sent) {
        wp_send_json_success(['message' => 'Успешно отправлено']);
    } else {
        wp_send_json_error(['message' => 'Ошибка отправки']);
    }
}
