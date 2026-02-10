<?php
$gutten_blockquote = get_field('gutten_blockquote');
if ($gutten_blockquote) : ?>
    <div class="article__blockquote">
        <blockquote class="article__blockquote-text">«<?php echo $gutten_blockquote; ?>»</blockquote>

        <div class="article__author">
            <?php $gutten_blockquote_author_img = get_field('gutten_blockquote_author_img'); ?>
            <?php if ($gutten_blockquote_author_img): ?>
                <div class="article__author-thumb">
                    <img
                        src="<?php echo esc_url($gutten_blockquote_author_img['url']); ?>"
                        alt="<?php echo esc_attr($gutten_blockquote_author_img['alt']); ?>"
                        class="cover-image">
                </div>
            <?php endif; ?>
            <div class="article__author-body">
                <?php if (get_field('gutten_blockquote_author_name')): ?>
                    <div class="article__author-name">
                        <?php the_field('gutten_blockquote_author_name'); ?>
                    </div>
                <?php endif; ?>
                <?php if (get_field('gutten_blockquote_author_pos')): ?>
                    <div class="article__author-info"><?php the_field('gutten_blockquote_author_pos'); ?></div>
                <?php endif; ?>
            </div>
        </div>

    </div>
<?php endif; ?>