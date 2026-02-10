<?php if (have_rows('accordion_article')) : ?>
    <div class="article__accordion" data-spollers>
        <?php while (have_rows('accordion_article')) : the_row(); ?>
            <div class="faq__item">
                <div class="faq__item-question" data-spoller>
                    <?php the_sub_field('question'); ?>
                </div>
                <div class="faq__item-answer typography-block">
                    <?php the_sub_field('answer'); ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>