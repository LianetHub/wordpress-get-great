<?php

$source = get_field('faq_source');

if (!$source) $source = 'global';

$data = [];

if ($source === 'global') {

    $data['show']     = get_field('show_faq', 'option');
    $data['title']    = get_field('faq_title', 'option');
    $data['hint']     = get_field('faq_hint', 'option');
    $data['subtitle'] = get_field('faq_subtitle', 'option');
    $data['items']    = get_field('faq_list', 'option');
} else {

    $data['show']     = get_field('show_faq');
    $data['title']    = get_field('faq_title');
    $data['hint']     = get_field('faq_hint');
    $data['subtitle'] = get_field('faq_subtitle');
    $data['items']    = get_field('faq_list');
}


$show     = $data['show'];
$title    = $data['title'];
$hint     = $data['hint'];
$subtitle = $data['subtitle'];
$items    = $data['items'];


if ($show): ?>
    <section class="faq">
        <div class="container">
            <div class="faq__header">
                <?php if ($hint): ?>
                    <div class="faq__hint hint"><?php echo esc_html($hint); ?></div>
                <?php endif; ?>
                <?php if ($title): ?>
                    <h2 class="faq__title title"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($subtitle): ?>
                    <p class="faq__subtitle subtitle"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>

            <?php if ($items):
                $left_column = [];
                $right_column = [];

                foreach ($items as $index => $item) {
                    if (($index + 1) % 2 !== 0) {
                        $left_column[] = $item;
                    } else {
                        $right_column[] = $item;
                    }
                }

                $columns = [$left_column, $right_column];
            ?>
                <div class="faq__content" data-spollers>
                    <?php foreach ($columns as $column_items): ?>
                        <?php if (!empty($column_items)): ?>
                            <div class="faq__column">
                                <?php foreach ($column_items as $item): ?>
                                    <div class="faq__item">
                                        <div class="faq__item-question" data-spoller>
                                            <?php echo esc_html($item['faq_question']); ?>
                                        </div>
                                        <div class="faq__item-answer typography-block">
                                            <?php echo wp_kses_post($item['faq_answer']); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>