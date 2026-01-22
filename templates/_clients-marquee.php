<?php
$clients = get_field('clients_list', 'option');

if ($clients): ?>
    <div class="clients">
        <div class="container">
            <div class="clients__marquee marquee">
                <div class="marquee__slider swiper marquee__slider--images">
                    <div class="swiper-wrapper">
                        <?php foreach ($clients as $client):
                            $logo = $client['logo'];
                        ?>
                            <div class="marquee__image swiper-slide">
                                <?php if ($logo): ?>
                                    <img src="<?php echo esc_url($logo['url']); ?>"
                                        alt="<?php echo esc_attr($logo['alt']  ?? 'Логотип клиента'); ?>">
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>