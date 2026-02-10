<?php
$gutten_rec_article = get_field('gutten_rec_article');
if ($gutten_rec_article) : ?>
    <a href="<?php echo get_permalink($gutten_rec_article->ID); ?>" class="article__more">
        <span class="article__more-label">Статья по теме</span>
        <span class="article__more-name icon-arrow-right"> <?php echo get_the_title($gutten_rec_article->ID); ?></span>
    </a>
<?php endif; ?>