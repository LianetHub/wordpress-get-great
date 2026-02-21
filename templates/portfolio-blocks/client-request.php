<?php
$text = get_field('text');
if (!$text && is_admin()) echo '<div style="color:red;">Заполните запрос клиента</div>';
if (!$text) return;
?>
<p class="case-block case-block--request">
    <strong class="case-block__title">Запрос клиента:</strong>
    <span class="case-block__content">
        <?php echo $text; ?>
    </span>
</p>