<div class="header__main">
    <a href="/" class="header__logo">

    </a>
    <div class="header__menu menu">
        <button type="button" class="menu__icon icon-menu">
            <span></span>
        </button>
        <!-- <nav class="menu__body">
            <ul class="menu__list">
                <li class="menu__item"><a href="" class="menu__link"></a></li>
            </ul>
        </nav> -->
        <?php
        wp_nav_menu([
            'theme_location' => 'primary_menu',
            'container'      => 'nav',
            'menu_class'     => 'main-nav-list',
        ]);
        ?>
    </div>
    <div class="header__contatcs"></div>
</div>