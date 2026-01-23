<?php
if (is_admin()) {
    if (function_exists('render_global_block_notice')) {
        render_global_block_notice('Контакты');
    }
    return;
}

$phones = get_field('header_phones', 'option');
$email  = get_field('header_email', 'option');
?>

<section class="contacts">
    <div class="container">
        <h2>Контакты</h2>
        <?php if ($email): ?>
            <p>Email: <?php echo esc_html($email); ?></p>
        <?php endif; ?>
    </div>
</section>