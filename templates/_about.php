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

$hint  = get_field('about_hint', $prefix);
$title = get_field('about_title', $prefix);
$tabs  = get_field('about_tabs', $prefix);
$tabs_count = $tabs ? count($tabs) : 0;

$tag = $title ? 'section' : 'div';
?>

<<?php echo $tag; ?> class="about">
    <div class="about__wrapper">
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
                                <path transform="scale(0.00135135, 0.00129533)" d="M562.841 0C567.008 0 571.103 1.08483 574.723 3.14776L727.882 90.4211C735.374 94.6902 740 102.65 740 111.273V669C740 682.255 729.255 693 716 693H601.365C588.11 693 577.365 703.745 577.365 717V748C577.365 761.255 566.62 772 553.365 772H24C10.7452 772 0 761.255 0 748V108C0 94.7452 10.7452 84 24 84H125.627C138.882 84 149.627 73.2548 149.627 60V24C149.627 10.7452 160.372 0 173.627 0H562.841Z" />
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
    </div>
</<?php echo $tag; ?>>