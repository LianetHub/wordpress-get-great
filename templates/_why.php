<?php
$source = get_field('why_source') ?: 'global';
$selector = ($source === 'global') ? 'option' : get_the_ID();

$data = [
    'show'     => get_field('why_show', $selector),
    'hint'     => get_field('why_hint', $selector),
    'title'    => get_field('why_title', $selector),
    'subtitle' => get_field('why_subtitle', $selector),
    'items'    => get_field('why_list', $selector),
    'btn_data' => get_field('why_btn', $selector)['btn'] ?? null,
];

if (!$data['show']) return;

$hint     = $data['hint'];
$title    = $data['title'];
$subtitle = $data['subtitle'];
$items    = $data['items'];
$btn_data = $data['btn_data'];
?>

<section class="why">
    <div class="why__content">
        <div class="container">
            <div class="why__header">
                <?php if ($hint): ?>
                    <div class="why__hint hint"><?php echo esc_html($hint); ?></div>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h2 class="why__title title-lg"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if ($subtitle): ?>
                    <p class="why__subtitle subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>
            <div class="why__body">

                <?php if ($items): ?>
                    <ul class="why__cards">
                        <?php foreach ($items as $item): ?>
                            <li class="why__card">
                                <div class="why__card-icon">
                                    <?php
                                    $icon = $item['card_icon'];
                                    if ($icon):
                                        $icon_id = is_array($icon) ? $icon['id'] : $icon;
                                        $icon_path = get_attached_file($icon_id);
                                        if ($icon_path && file_exists($icon_path) && pathinfo($icon_path, PATHINFO_EXTENSION) === 'svg'):
                                            echo file_get_contents($icon_path);
                                        else: ?>
                                            <img src="<?php echo esc_url(is_array($icon) ? $icon['url'] : wp_get_attachment_url($icon)); ?>" alt="">
                                    <?php endif;
                                    endif; ?>
                                </div>

                                <?php if ($item['card_title']): ?>
                                    <div class="why__card-title"><?php echo esc_html($item['card_title']); ?></div>
                                <?php endif; ?>

                                <?php if ($item['card_desc']): ?>
                                    <div class="why__card-desc"><?php echo esc_html($item['card_desc']); ?></div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>

                <?php
                if ($btn_data):
                    get_template_part('templates/components/button', null, [
                        'data'  => $btn_data,
                        'class' => 'why__btn',
                    ]);
                endif;
                ?>
            </div>
        </div>
    </div>
</section>