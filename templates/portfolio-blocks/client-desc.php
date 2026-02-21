<?php
$text = get_field('text');
if (!$text && is_admin()) echo '<div style="color:red;">Заполните описание клиента</div>';
if (!$text) return;
?>
<p class="case-block case-block--client-desc">
    <strong class="case-block__title">Кратко о клиенте:</strong>
    <span class="case-block__content">
        <?php echo $text; ?>
    </span>
</p>