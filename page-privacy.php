<?php

/**
 * Template Name: Privacy Policy Page
 */
?>

<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_hero.php'); ?>

<section class="policy">
    <div class="container">
        <div class="policy__content">
            <div class="policy__text typography-block">
                <?php
                while (have_posts()) :
                    the_post();
                    the_content();
                endwhile;
                ?>
            </div>
            <aside class="policy__side sidebar">
                <nav aria-label="Меню политик конфиденциальности" class="sidebar__menu">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'menu_policies',
                        'container'      => false,
                        'menu_class'     => 'sidebar__list',
                        'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                    ]);
                    ?>
                </nav>
            </aside>
        </div>
    </div>
</section>


<?php get_footer(); ?>