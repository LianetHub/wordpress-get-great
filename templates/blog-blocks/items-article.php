<?php if (have_rows('article_items')) : ?>
    <div class="article__items <?php if (get_field('article_items_view') == 1) : ?>article__items--cols<?php endif; ?>">

        <?php while (have_rows('article_items')) : the_row(); ?>
            <div class="article__item">
                <div class="article__item-ic">
                    <img class="img" src="<?php the_sub_field('ic'); ?>" alt="<?php the_sub_field('txt'); ?>">
                </div>
                <div class="article__item-txt">
                    <?php the_sub_field('txt'); ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
<?php endif; ?>