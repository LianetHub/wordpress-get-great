</main>

<footer class="footer">
    <div class="container">
        <?php if (have_rows('social_links', 'option')): ?>
            <div class="social-block">
                <?php while (have_rows('social_links', 'option')): the_row();
                    $icon = get_sub_field('icon');
                    $link = get_sub_field('link');
                    $hover_color = get_sub_field('hover_color');
                ?>
                    <a href="<?php echo esc_url($link); ?>"
                        class="social-item"
                        style="--hover-bg: <?php echo esc_attr($hover_color); ?>;"
                        target="_blank"
                        rel="nofollow">
                        <?php if ($icon): ?>
                            <img src="<?php echo esc_url($icon['url']); ?>" alt="<?php echo esc_attr($icon['alt']); ?>">
                        <?php endif; ?>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
    </div>
</footer>
</div>

<?php wp_footer(); ?>
</body>

</html>