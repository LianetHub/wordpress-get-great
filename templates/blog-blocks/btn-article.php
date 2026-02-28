<?php
$btn_data_raw = get_field('article_button');
$alignment = get_field('article_button_alignment') ?: 'left';

if ($btn_data_raw && isset($btn_data_raw['btn'])) :
    $btn_data = $btn_data_raw['btn'];
?>
    <div class="btn-article" style="text-align: <?php echo esc_attr($alignment); ?>;">
        <?php
        get_template_part('templates/components/button', null, [
            'data'  => $btn_data,
            'class' => 'btn-article__item',
        ]);
        ?>
    </div>
<?php endif; ?>