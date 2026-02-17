<?php

/**
 * The template for displaying a single blog post
 */
?>

<?php get_header(); ?>

<?php if (have_posts()) :
    while (have_posts()) :
        the_post();

        $categories = get_the_category();
        $main_cat = !empty($categories) ? $categories[0] : null;
        $reading_time = get_great_reading_time(get_the_ID()) . ' мин. читать';

        $data = get_great_content_with_toc(apply_filters('the_content', get_the_content()));
        $content = $data['content'];
        $toc_list = $data['toc'];

        $blog_authors = get_field('blog_authors');

        if ($blog_authors) {
            $author_name = $blog_authors->post_title;
            $author_info = $blog_authors->post_excerpt;
            $author_img  = get_the_post_thumbnail_url($blog_authors->ID, 'full');
            $is_verified = get_field('is_verified', $blog_authors->ID);
        } else {
            $author_id   = get_post_field('post_author', get_the_ID());
            $author_name = get_the_author();
            $author_info = get_the_author_meta('description');
            $author_img  = get_avatar_url($author_id);
            $is_verified = true;
        }

        $first_letter = mb_substr($author_name, 0, 1);
?>
        <section class="article">
            <div class="container">
                <div class="article__breadcrumbs">
                    <?php require_once(TEMPLATE_PATH . '/components/breadcrumbs.php'); ?>
                </div>

                <div class="article__main">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="article__back icon-arrow-left btn btn-secondary">
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
                                    <div class="article__stat icon-clock"><?php echo $reading_time; ?></div>
                                    <div class="article__stat icon-like"><?php echo (int) get_post_meta(get_the_ID(), 'get_great_likes', true); ?></div>
                                    <div class="article__stat icon-eye"><?php echo get_great_get_post_views(get_the_ID()); ?></div>
                                </div>
                            </div>

                            <h1 class="article__title title-md"><?php the_title(); ?></h1>

                            <div class="article__author">
                                <div class="article__author-thumb <?php echo $is_verified ? 'verified' : ''; ?>">
                                    <?php if ($author_img) : ?>
                                        <img src="<?php echo esc_url($author_img); ?>"
                                            alt="<?php echo esc_attr($author_name); ?>"
                                            class="cover-image">
                                    <?php else : ?>
                                        <div class="article-author__letter"><?php echo esc_html($first_letter); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="article__author-body">
                                    <div class="article__author-name"><?php echo esc_html($author_name); ?></div>
                                    <div class="article__author-info"><?php echo esc_html($author_info); ?></div>
                                </div>
                            </div>

                            <?php if (has_post_thumbnail()) : ?>
                                <div class="article__header-photo">
                                    <?php the_post_thumbnail('full', ['alt' => get_the_title()]); ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="article__body typography-block">
                            <?php echo $content; ?>
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
                                            <span class="article__label"><?php echo esc_html($tag->name); ?></span>
                                    <?php endforeach;
                                    endif;
                                    ?>
                                </div>

                                <button class="article__copy icon-copy" data-url="<?php the_permalink(); ?>">Ссылка</button>

                                <?php
                                $share_url   = urlencode(get_permalink());
                                $share_title = urlencode(get_the_title());
                                ?>
                                <div class="article__socials socials">
                                    <a href="https://api.whatsapp.com/send?text=<?php echo $share_title . ' ' . $share_url; ?>" class="socials__item" style="--hover-bg: #00e510;" target="_blank" rel="nofollow">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/whatsapp.svg" alt="WhatsApp">
                                    </a>
                                    <a href="https://t.me/share/url?url=<?php echo $share_url; ?>&text=<?php echo $share_title; ?>" class="socials__item" style="--hover-bg: #00b0f2;" target="_blank" rel="nofollow">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/telegram.svg" alt="Telegram">
                                    </a>
                                    <a href="https://vk.com/share.php?url=<?php echo $share_url; ?>" class="socials__item" style="--hover-bg: #0077ff;" target="_blank" rel="nofollow">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/vk.svg" alt="VK">
                                    </a>
                                    <a href="https://connect.ok.ru/offer?url=<?php echo $share_url; ?>&title=<?php echo $share_title; ?>" class="socials__item" style="--hover-bg: #ee8208;" target="_blank" rel="nofollow">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/ok.svg" alt="OK">
                                    </a>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $share_url; ?>" class="socials__item" style="--hover-bg: #0866ff;" target="_blank" rel="nofollow">
                                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icons/facebook.svg" alt="Facebook">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </article>

                    <?php if (!empty($toc_list)) : ?>
                        <button type="button" class="article__nav-btn icon-chevron-down">Содержание статьи</button>
                    <?php endif; ?>

                    <aside id="article-nav" class="article__sidebar sidebar">
                        <div class="article__sidebar-header">
                            <div class="article__sidebar-caption">Содержание</div>
                            <button type="button" class="article__sidebar-close icon-cross"></button>
                        </div>
                        <ul class="sidebar__list">
                            <?php echo $toc_list; ?>
                        </ul>
                    </aside>
                </div>
            </div>
        </section>

<?php
    endwhile;
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