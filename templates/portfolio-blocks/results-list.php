<?php
$title = get_field('title') ?: 'Что было сделано:';
if (have_rows('list')): ?>
    <div class="case-block case-block--results">
        <h3 class="case-block__title"><?php echo esc_html($title); ?></h3>
        <ul class="case-block__list">
            <?php while (have_rows('list')): the_row(); ?>
                <li class="case-block__list-item">
                    <?php the_sub_field('text'); ?>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>
<?php elseif (is_admin()): ?>
    <div style="color:red;">Добавьте хотя бы один результат</div>
<?php endif; ?>