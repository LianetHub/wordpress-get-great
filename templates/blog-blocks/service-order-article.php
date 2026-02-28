<?php
$article_service_order = get_field('article_service_order');
if ($article_service_order) : ?>
    <div class="service-order <?php echo get_field('services_article_order_variant') ?>">
        <div class="service-order__title"><?php echo $article_service_order; ?></div>

        <?php
        $btn_field_raw = get_field('services_article_order_button');

        if ($btn_field_raw && isset($btn_field_raw['btn'])):
            $btn_field = $btn_field_raw['btn'];

            get_template_part('templates/components/button', null, [
                'data'  => $btn_field,
                'class' => 'service-order__btn',
            ]);
        endif;
        ?>
    </div>
<?php endif; ?>