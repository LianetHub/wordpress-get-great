<?php
$video_type = get_field('video_type');
$poster = get_field('video_poster');
$final_url = '';

if ($video_type === 'file' || $video_type === true) {
    $video_file = get_field('video_file');
    $final_url = (is_array($video_file) && isset($video_file['url'])) ? $video_file['url'] : '';
} else {
    $final_url = get_field('video_external_url');
}

$has_poster = (!empty($poster) && is_array($poster) && !empty($poster['url']));
$poster_url = $has_poster ? $poster['url'] : get_template_directory_uri() . '/assets/img/logo.svg';
$poster_alt = $has_poster ? ($poster['alt'] ?? '') : '';

$wrapper_classes = ['video-modal-block', 'icon-play'];
if (!$has_poster) {
    $wrapper_classes[] = 'poster-default';
}

if (is_admin() && !$final_url) : ?>
    <div style="padding: 40px; border: 2px dashed #ccc; text-align: center; background: #fafafa;">
        <div style="font-size: 24px; margin-bottom: 10px;">📽️</div>
        <strong>Блок видео</strong><br>
        Выберите тип видео и загрузите файл или вставьте ссылку.
    </div>
<?php
    return;
endif; ?>

<?php if ($final_url) : ?>
    <a href="<?php echo esc_url($final_url); ?>"
        data-fancybox
        class="<?php echo esc_attr(implode(' ', $wrapper_classes)); ?>">
        <img src="<?php echo esc_url($poster_url); ?>"
            alt="<?php echo esc_attr($poster_alt); ?>">
    </a>
<?php endif; ?>