<?php
$title       = get_field('checklist_title');
$description = get_field('checklist_description');
$items       = get_field('checklist_items');
?>

<div class="article__checklist checklist-block">
    <?php if ($title): ?>
        <h2 class="checklist-block__title"><?php echo esc_html($title); ?></h2>
    <?php endif; ?>

    <?php if ($description): ?>
        <p class="checklist-block__description"><?php echo esc_html($description); ?></p>
    <?php endif; ?>

    <?php if ($items): ?>
        <ol class="checklist-block__list">
            <?php foreach ($items as $item): ?>
                <li class="checklist-block__item">
                    <?php echo wp_kses_post($item['text']); ?>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>
</div>