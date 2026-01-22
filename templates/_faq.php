<?php if (get_field('show_faq', 'option')):
    $title = get_field('faq_title', 'option');
    $subtitle = get_field('faq_subtitle', 'option');
    $items = get_field('faq_list', 'option');
?>
    <section class="faq">
        <div class="container">
            <div class="faq__header">
                <div class="faq__hint hint">F.a.q.</div>
                <?php if ($title): ?>
                    <h2 class="faq__title title"><?php echo $title; ?></h2>
                <?php endif; ?>
                <?php if ($subtitle): ?>
                    <p class="faq__subtitle subtitle"><?php echo $subtitle; ?></p>
                <?php endif; ?>
            </div>

            <?php if ($items):
                $columns = array_chunk($items, ceil(count($items) / 2));
            ?>
                <div class="faq__content" data-spollers>
                    <?php foreach ($columns as $column_items): ?>
                        <div class="faq__column">
                            <?php foreach ($column_items as $item): ?>
                                <div class="faq__item">
                                    <div class="faq__item-question" data-spoller>
                                        <?php echo $item['faq_question']; ?>
                                    </div>
                                    <div class="faq__item-answer typography-block">
                                        <?php echo $item['faq_answer']; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>