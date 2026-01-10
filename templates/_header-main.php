<?php
$option_page = 'option';
$logo = get_field('logo', $option_page);
?>


<div class="header__main">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo">
        <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']) ?: 'Логотип '; ?>">
    </a>
    <div class="header__menu menu">
        <button type="button" class="menu__icon icon-menu">
            <span></span>
        </button>
        <nav aria-label="Меню" class="menu__body">
            <?php
            wp_nav_menu([
                'theme_location' => 'primary_menu',
                'container'      => false,
                'menu_class'     => 'menu__list',
                'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                'walker'         => new Menu_Nav_Walker(),
            ]);
            ?>
        </nav>
    </div>
    <div class="header__contatcs"></div>
</div>