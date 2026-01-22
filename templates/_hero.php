<section class="hero">
    <div class="container">
        <div class="hero__content">
            <?php
            require_once(TEMPLATE_PATH . '/components/breadcrumbs.php');
            ?>

            <h1 class="hero__title title-sm">
                <?php
                if (is_singular()) {
                    the_title();
                } else {
                    the_archive_title();
                }
                ?>
            </h1>
        </div>
    </div>
</section>