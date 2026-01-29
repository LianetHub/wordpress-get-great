<?php

/**
 * Template for the main landing page (Home)
 */
?>

<?php get_header(); ?>

<?php require_once(TEMPLATE_PATH . '_promo.php'); ?>
<?php require_once(TEMPLATE_PATH . '_clients-marquee.php'); ?>
<section class="cases">
    <div class="container">
        <div class="cases__header">
            <div class="cases__hint hint">портфолио</div>
            <h2 class="cases__title title">Наши кейсы</h2>
            <div class="cases__subtitle subtitle">Мы знаем, что такое брендбук, стиль, первые лица, «надо вчера»</div>
        </div>
        <ul class="cases__list">
            <li class="cases__item">
                <a href="" class="case-card">
                    <span class="case-card__image">
                        <img src="https://developer.gektor-studio.com/backend4/get-great/wp-content/uploads/2026/01/brending-wrapper.jpg" alt="Фото кейса">
                    </span>
                    <span class="case-card__content">
                        <span class="case-card__labels">
                            <span class="case-card__label">Выставочные стенды</span>
                        </span>
                        <span class="case-card__footer">
                            <span class="case-card__name">
                                Выставочный стенд на «Здравоохранении - 2022»
                            </span>
                            <span class="case-card__client">
                                <span class="case-card__client-caption">Клиент:</span>
                                <span class="case-card__client-details">
                                    Компания Medical System&Technology (ООО «МСТ»)
                                </span>
                            </span>
                        </span>
                    </span>
                </a>
            </li>
        </ul>
        <a href="" class="cases__more btn btn-primary">Смотреть все 96 кейсов</a>
    </div>
</section>

<?php
while (have_posts()) :
    the_post();
    the_content();
endwhile;
?>



<?php get_footer(); ?>