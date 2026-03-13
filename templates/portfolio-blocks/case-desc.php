<?php
$rows = get_field('details');

if (empty($rows) && is_admin()): ?>
    <div style="color:red;">Добавьте хотя бы одну строку в описание кейса</div>
<?php
    return;
endif;

if ($rows): ?>
    <div class="case-block case-block--client-desc">
        <?php foreach ($rows as $row):
            $label = $row['label'];
            $content = $row['content'];
            if (!$label && !$content) continue;
        ?>
            <p>
                <?php if ($label): ?>
                    <strong class="case-block__title">
                        <?php echo esc_html($label); ?>:
                    </strong>
                <?php endif; ?>

                <?php if ($content): ?>
                    <span class="case-block__content">
                        <?php echo esc_html($content); ?>
                    </span>
                <?php endif; ?>
            </p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>