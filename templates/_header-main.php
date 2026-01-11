<?php
$option_page = 'option';
$logo = get_field('logo', $option_page);
$logo_descriptor = get_field('logo_descriptor', $option_page);
$phone = get_field('tel', $option_page);
$email = get_field('email', $option_page);
?>


<div class="header__main">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="header__logo">
        <span class="header__logo-icon">
            <img
                src="<?php echo esc_url($logo['url']); ?>"
                alt="<?php echo esc_attr($logo['alt']) ?: 'Логотип '; ?>">
        </span>
        <?php if ($logo_descriptor): ?>
            <span class="header__logo-descriptor">
                <?php echo esc_html($logo_descriptor); ?>
            </span>
        <?php endif; ?>
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
    <div class="header__contacts">
        <?php if ($phone): ?>
            <a href="tel:<?php echo esc_attr(preg_replace('/[^\d\+]/', '', $phone)); ?>" class="header__contacts-phone"><?php echo esc_html($phone); ?></a>
        <?php endif; ?>
        <?php if ($email): ?>
            <a href="mailto:<?php echo esc_attr($email); ?>" class="header__contacts-email">
                <?php echo esc_html($email); ?>
            </a>
        <?php endif; ?>
    </div>
    <div class="header__socials socials">
        <?php if (have_rows('social_links', $option_page)): ?>
            <?php while (have_rows('social_links', $option_page)): the_row();
                $icon = get_sub_field('icon');
                $link = get_sub_field('link');
                $hover_color = get_sub_field('hover_color');

                $is_whatsapp = strpos($link, 'whatsapp') !== false;
                $is_telegram = strpos($link, 'telegram') !== false || strpos($link, 't.me') !== false;
            ?>
                <?php if ($is_whatsapp || $is_telegram): ?>
                    <a href="<?php echo esc_url($link); ?>"
                        class="socials__item"
                        style="--hover-bg: <?php echo esc_attr($hover_color); ?>;"
                        target="_blank"
                        rel="nofollow">
                        <?php if ($icon): ?>
                            <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
                        <?php endif; ?>
                    </a>
                <?php endif; ?>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
    <a href="#" data-fancybox aria-label="" class="header__callback icon-phone-incoming"></a>
</div>