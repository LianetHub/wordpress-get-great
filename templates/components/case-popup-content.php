<?php
$data = get_query_var('case_popup_data');
$post_id = $data['post_id'];
?>

<div class="case-popup">
    <div class="case-popup__left">
        <div class="case-popup__header">
            <div class="case-popup__type hint">КЕЙС</div>
            <?php if ($data['terms'] && !is_wp_error($data['terms'])): ?>
                <div class="case-popup__labels">
                    <?php foreach ($data['terms'] as $term): ?>
                        <a
                            href="<?php echo esc_url(get_term_link($term)); ?>"
                            class="case-popup__label articles__tag">
                            <?php echo esc_html($term->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <h2 class="case-popup__title title-sm">
            <?php echo esc_html($data['client_name'] ?: get_the_title($post_id)); ?>
        </h2>

        <div class="case-popup__info typography-block">
            <?php echo $data['left']; ?>
        </div>

        <div class="case-popup__actions">
            <a href="#discuss-project" data-fancybox class="btn btn-primary">Обсудить проект</a>
            <a href="<?php echo get_permalink($post_id); ?>" class="btn btn-secondary">Подробнее</a>
        </div>
    </div>

    <div class="case-popup__right">
        <div class="case-popup__media typography-block">
            <?php if ($data['right']): ?>
                <?php echo $data['right']; ?>
            <?php else: ?>
                <?php echo get_the_post_thumbnail($post_id, 'full', ['class' => 'cover-image']); ?>
            <?php endif; ?>
        </div>
    </div>
</div>