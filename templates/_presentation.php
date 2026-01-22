<?php if (get_field('show_pres', 'option')):
    $title = get_field('pres_title', 'option');
    $desc = get_field('pres_desc', 'option');
    $btn_text = get_field('pres_btn_text', 'option') ?: 'Получить презентацию';
    $image = get_field('pres_image', 'option');

    $file_data = get_field('pres_file', 'option');
    $format = '';
    $size = '';

    if ($file_data) {
        $format = pathinfo($file_data['filename'], PATHINFO_EXTENSION);
        $size = size_format($file_data['filesize']);
    }
?>
    <section class="presentation">
        <div class="container">
            <div class="presentation__content">
                <div class="presentation__info">
                    <div class="presentation__hint hint">презентация</div>

                    <?php if ($title): ?>
                        <h2 class="presentation__title title-sm"><?php echo $title; ?></h2>
                    <?php endif; ?>

                    <?php if ($desc): ?>
                        <div class="presentation__desc">
                            <?php echo $desc; ?>
                        </div>
                    <?php endif; ?>

                    <a href="#download-presentation" data-fancybox class="presentation__btn btn btn-primary">
                        <?php echo $btn_text; ?>
                    </a>
                </div>

                <div class="presentation__images">
                    <?php if ($format || $size): ?>
                        <div class="presentation__stats">
                            <?php if ($format): ?>
                                <div class="presentation__stat">
                                    <span class="presentation__stat-item">Формат:</span>
                                    <span class="presentation__stat-value"><?php echo strtoupper($format); ?></span>
                                </div>
                            <?php endif; ?>

                            <?php if ($size): ?>
                                <div class="presentation__stat">
                                    <span class="presentation__stat-item">Размер:</span>
                                    <span class="presentation__stat-value"><?php echo $size; ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($image): ?>
                        <div class="presentation__image">
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>">
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>