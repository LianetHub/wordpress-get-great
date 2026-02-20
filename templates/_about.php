<?php
$source = get_field('about_source') ?: 'global';
$prefix = ($source === 'global') ? 'option' : $block['id'];

$show_about = get_field('show_about', $prefix);

if (!$show_about) {
    if (is_admin()) render_global_block_notice('О компании (Скрыто)');
    return;
}

if (is_admin() && $source === 'global' && get_current_screen()->base !== 'toplevel_page_theme-general-settings2') {
    render_global_block_notice('О компании');
    return;
}

$hint     = get_field('about_hint', $prefix);
$title    = get_field('about_title', $prefix);
$tabs     = get_field('about_tabs', $prefix);
$bg_color = get_field('about_bg_color', $prefix);
$tabs_count = $tabs ? count($tabs) : 0;

$tag = $title ? 'section' : 'div';
$has_wrapper = ($bg_color === 'blue');

$is_service = (get_post_type() === 'services');
?>

<<?php echo $tag; ?> class="about">
    <?php if ($has_wrapper): ?>
        <div class="about__wrapper">
        <?php endif; ?>

        <div class="container">
            <div class="about__body">
                <div class="about__visual">
                    <?php if (have_rows('about_tabs', $prefix)): ?>
                        <div class="about__images">
                            <?php $i = 0;
                            while (have_rows('about_tabs', $prefix)): the_row();
                                $img = get_sub_field('tab_image');
                            ?>
                                <div class="about__image <?php echo ($i === 0) ? 'active' : ''; ?>">
                                    <?php if ($img): ?>
                                        <img src="<?php echo esc_url($img['url']); ?>"
                                            class="cover-image"
                                            alt="<?php echo esc_attr($img['alt']); ?>">
                                    <?php endif; ?>
                                </div>
                            <?php $i++;
                            endwhile; ?>
                        </div>
                    <?php endif; ?>

                    <svg class="about__mask hidden">
                        <defs>
                            <clipPath id="about-mask" clipPathUnits="objectBoundingBox">
                                <?php if ($is_service): ?>
                                    <path transform="scale(0.00131579, 0.00149254)" d="M564.47 60C564.47 73.2548 575.215 84 588.47 84H736C749.255 84 760 94.7452 760 108V646C760 659.255 749.255 670 736 670H190.36C177.105 670 166.36 659.255 166.36 646V609C166.36 595.745 155.615 585 142.36 585H24C10.7452 585 0 574.255 0 561V111.011C0 102.385 4.62918 94.423 12.1254 90.155L164.951 3.14352C168.57 1.08333 172.662 0 176.826 0H540.47C553.725 0 564.47 10.7452 564.47 24V60Z" />
                                <?php else: ?>
                                    <path transform="scale(0.00135135, 0.00129533)" d="M562.841 0C567.008 0 571.103 1.08483 574.723 3.14776L727.882 90.4211C735.374 94.6902 740 102.65 740 111.273V669C740 682.255 729.255 693 716 693H601.365C588.11 693 577.365 703.745 577.365 717V748C577.365 761.255 566.62 772 553.365 772H24C10.7452 772 0 761.255 0 748V108C0 94.7452 10.7452 84 24 84H125.627C138.882 84 149.627 73.2548 149.627 60V24C149.627 10.7452 160.372 0 173.627 0H562.841Z" />
                                <?php endif; ?>
                            </clipPath>
                        </defs>
                    </svg>
                </div>

                <div class="about__content">
                    <?php if ($hint): ?>
                        <div class="about__hint hint"><?php echo esc_html($hint); ?></div>
                    <?php endif; ?>

                    <?php if ($title): ?>
                        <h2 class="about__title title"><?php echo $title; ?></h2>
                    <?php endif; ?>

                    <?php if (have_rows('about_tabs', $prefix)): ?>
                        <?php if ($tabs_count > 1): ?>
                            <div class="about__tabs">
                                <?php $i = 0;
                                while (have_rows('about_tabs', $prefix)): the_row(); ?>
                                    <button class="about__tab btn btn-secondary <?php echo ($i === 0) ? 'active' : ''; ?>">
                                        <?php the_sub_field('tab_name'); ?>
                                    </button>
                                <?php $i++;
                                endwhile; ?>
                            </div>
                        <?php endif; ?>

                        <div class="about__tabs-wrapper">
                            <?php $i = 0;
                            while (have_rows('about_tabs', $prefix)): the_row(); ?>
                                <div class="about__tab-content <?php echo ($i === 0) ? 'active' : ''; ?>">
                                    <div class="about__text typography-block">
                                        <?php the_sub_field('tab_text'); ?>
                                    </div>
                                </div>
                            <?php $i++;
                            endwhile; ?>
                        </div>
                    <?php endif; ?>

                    <?php
                    $btn_field = get_field('about_btn', $prefix);

                    if ($btn_field):
                        get_template_part('templates/components/button', null, [
                            'data'  => $btn_field['btn'],
                            'class' => 'about__btn',
                        ]);
                    endif;
                    ?>
                </div>
            </div>
        </div>

        <?php if ($has_wrapper): ?>
        </div>
    <?php endif; ?>
</<?php echo $tag; ?>>