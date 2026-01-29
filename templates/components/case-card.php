<?php
$post_id = get_the_ID();
$client_name = get_field('client_name', $post_id);
$thumb_url = get_the_post_thumbnail_url($post_id, 'large');
$terms = get_the_terms($post_id, 'portfolio_cat');
$logo = get_field('logo', 'option');
?>

<a href="<?php the_permalink(); ?>" class="case-card">
    <span class="case-card__image <?php echo !$thumb_url ? 'case-card__image--placeholder' : ''; ?>">
        <?php if ($thumb_url): ?>
            <img src="<?php echo esc_url($thumb_url); ?>"
                class="cover-image"
                alt="<?php echo esc_attr(get_the_title()); ?>">
        <?php elseif (!empty($logo['url'])): ?>
            <img src="<?php echo esc_url($logo['url']); ?>"
                class="placeholder-logo"
                alt="<?php echo esc_attr($logo['alt'] ?: get_the_title()); ?>">
        <?php endif; ?>
    </span>
    <span class="case-card__content">
        <?php if ($terms && !is_wp_error($terms)): ?>
            <span class="case-card__labels">
                <?php foreach ($terms as $term): ?>
                    <span class="case-card__label"><?php echo esc_html($term->name); ?></span>
                <?php endforeach; ?>
            </span>
        <?php endif; ?>

        <span class="case-card__footer">
            <span class="case-card__name">
                <?php the_title(); ?>
            </span>

            <?php if ($client_name): ?>
                <span class="case-card__more">
                    <span class="case-card__client">
                        <span class="case-card__client-caption">Клиент:</span>
                        <span class="case-card__client-details">
                            <?php echo esc_html($client_name); ?>
                        </span>
                    </span>
                </span>
            <?php endif; ?>
        </span>
    </span>
</a>