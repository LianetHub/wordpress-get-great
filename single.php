<?php

/**
 * The template for displaying a single blog post
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post();
        $categories = get_the_category();
        $main_cat = !empty($categories) ? $categories[0] : null;
        $reading_time = get_field('reading_time') ?: '5 мин.';
        $author_id = get_post_field('post_author', get_the_ID());
?>

        <section class="article">
            <div class="container">
                <div class="article__breadcrumbs">
                    <?php
                    require_once(TEMPLATE_PATH . '/components/breadcrumbs.php');
                    ?>
                </div>

                <div class="article__main">
                    <a href="<?php echo get_post_type_archive_link('post'); ?>" class="article__back icon-prev">
                        Назад
                    </a>

                    <article class="article__content">
                        <div class="article__header">
                            <div class="article__info">
                                <?php if ($main_cat) : ?>
                                    <div class="articles__tag">
                                        <?php echo esc_html($main_cat->name); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="article__stats">
                                    <div class="article__stat icon-clock"><?php echo esc_html($reading_time); ?> читать</div>

                                    <?php if (function_exists('get_post_likes')) : ?>
                                        <div class="article__stat icon-like"><?php echo get_post_likes(get_the_ID()); ?></div>
                                    <?php endif; ?>

                                    <?php if (function_exists('get_post_views')) : ?>
                                        <div class="article__stat icon-eye"><?php echo get_post_views(get_the_ID()); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <h1 class="article__title title-md"><?php the_title(); ?></h1>

                            <div class="article__author">
                                <div class="article__author-thumb verified">
                                    <?php echo get_avatar($author_id, 96, '', 'Фото автора', ['class' => 'cover-image']); ?>
                                </div>
                                <div class="article__author-body">
                                    <div class="article__author-name"><?php the_author(); ?></div>
                                    <div class="article__author-info"><?php the_author_meta('description'); ?></div>
                                </div>
                            </div>

                            <?php if (has_post_thumbnail()) : ?>
                                <div class="article__header-photo">
                                    <?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="article__body typography-block">
                            <?php the_content(); ?>
                        </div>

                        <div class="article__footer">
                            <div class="article__likes">
                                <div class="article__likes-text">Статья была полезной?</div>
                                <div class="article__likes-btns">
                                    <button type="button" class="article__likes-btn icon-like">Да</button>
                                    <button type="button" class="article__likes-btn icon-dislike">Нет</button>
                                </div>
                            </div>
                            <div class="article__bottom">
                                <div class="article__labels">
                                    <?php
                                    $tags = get_the_tags();
                                    if ($tags) :
                                        foreach ($tags as $tag) : ?>
                                            <a href="<?php echo get_tag_link($tag->term_id); ?>" class="article__label label label--pink">
                                                <?php echo esc_html($tag->name); ?>
                                            </a>
                                    <?php endforeach;
                                    endif; ?>
                                </div>

                                <button class="article__copy icon-copy" data-url="<?php the_permalink(); ?>">Ссылка</button>

                                <div class="article__socials socials">
                                    <a href="https://t.me/share/url?url=<?php the_permalink(); ?>" target="_blank" aria-label="Поделиться в Telegram" class="socials__link icon-telegram"></a>
                                    <a href="https://wa.me/?text=<?php the_permalink(); ?>" target="_blank" aria-label="Поделиться в WhatsApp" class="socials__link icon-whatsapp"></a>
                                    <a href="https://vk.com/share.php?url=<?php the_permalink(); ?>" target="_blank" aria-label="Поделиться в VK" class="socials__link icon-vk"></a>
                                </div>
                            </div>
                        </div>
                    </article>

                    <button type="button" class="article__nav-btn icon-chevron-down">Содержание статьи</button>

                    <aside id="article-nav" class="article__sidebar sidebar">
                        <div class="article__sidebar-header">
                            <div class="article__sidebar-caption">Содержание</div>
                            <button type="button" class="article__sidebar-close icon-cross"></button>
                        </div>
                        <ul class="sidebar__list"></ul>
                    </aside>
                </div>
            </div>
        </section>

<?php endwhile;
endif; ?>

<!-- <section class="blog">
    <div class="container">
        <div class="blog__header">
            <h2 class="blog__title">Полезные статьи <span class="blog__quantity quantity">9</span></h2>
            <div class="blog__controls">
                <button type="button" class="blog__prev swiper-button-prev swiper-button--grey"></button>
                <button type="button" class="blog__next swiper-button-next swiper-button--grey"></button>
            </div>
        </div>
        <div class="blog__slider swiper">
            <ul class="swiper-wrapper">

            </ul>
        </div>
    </div>
</section> -->
<?php require_once(TEMPLATE_PATH . '_presentation.php'); ?>


<?php get_footer(); ?>