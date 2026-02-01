<?php
$hero_class = has_post_thumbnail() ? ' hero--has-poster' : '';
?>

<section class="hero<?php echo $hero_class; ?>">
    <div class="container">
        <div class="hero__content">
            <?php
            require_once(TEMPLATE_PATH . '/components/breadcrumbs.php');
            ?>

            <h1 class="hero__title title-md">
                <?php
                if (is_singular()) {
                    the_title();
                } else {
                    the_archive_title();
                }
                ?>
            </h1>

            <?php if (has_post_thumbnail()) : ?>
                <div class="hero__image">
                    <img
                        src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>"
                        alt="<?php the_title_attribute(); ?>"
                        class="cover-image">
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>