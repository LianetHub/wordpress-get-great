"use strict";



$(function () {

    // copy
    if ($('.article__copy').length) {

        const copyTooltipManager = new TooltipManager({
            tooltipClass: 'tooltip-copy',
            defaultPosition: 'top',
            offset: 10
        });

        let copyTimeout = null;

        $('.article__copy').on('click', function (e) {
            e.preventDefault();
            const $btn = $(this);
            const url = $btn.attr('data-url');

            if (!url) return;

            navigator.clipboard.writeText(url).then(() => {
                copyTooltipManager.show($btn, 'Скопировано');

                if (copyTimeout) clearTimeout(copyTimeout);

                copyTimeout = setTimeout(() => {
                    copyTooltipManager.hide();
                }, 1500);
            }).catch(err => {
                console.error('Ошибка при копировании: ', err);
            });
        });
    }

    // likes/dislikes
    if ($('.article').length) {
        const $article = $('.article');
        const $yesBtn = $('.article-use__yes');
        const $noBtn = $('.article-use__no');
        const $likesStat = $('.article__stat.icon-like');
        const postId = $article.attr('data-post-id');
        const cookieKey = 'great_liked_' + postId;

        const getCookie = (name) => {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        };

        const setCookie = (name, value, days) => {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
        };

        const removeCookie = (name) => {
            document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;";
        };

        const updateLikes = (actionName) => {
            return $.ajax({
                url: great_ajax.url,
                type: 'POST',
                data: {
                    action: actionName,
                    post_id: postId
                }
            });
        };

        const savedVote = getCookie(cookieKey);
        if (savedVote === 'yes') $yesBtn.addClass('is-active');
        if (savedVote === 'no') $noBtn.addClass('is-active');

        $yesBtn.on('click', function (e) {
            e.preventDefault();
            const currentVote = getCookie(cookieKey);

            if (currentVote === 'yes') {
                updateLikes('get_great_remove_like').done((res) => {
                    if (res.success) {
                        $likesStat.text(res.data.likes);
                        $yesBtn.removeClass('is-active');
                        removeCookie(cookieKey);
                    }
                });
            } else {
                if (currentVote === 'no') {
                    $noBtn.removeClass('is-active');
                }
                updateLikes('get_great_add_like').done((res) => {
                    if (res.success) {
                        $likesStat.text(res.data.likes);
                        $yesBtn.addClass('is-active');
                        setCookie(cookieKey, 'yes', 30);
                    }
                });
            }
        });

        $noBtn.on('click', function (e) {
            e.preventDefault();
            const currentVote = getCookie(cookieKey);

            if (currentVote === 'no') {
                $noBtn.removeClass('is-active');
                removeCookie(cookieKey);
            } else {
                if (currentVote === 'yes') {
                    updateLikes('get_great_remove_like').done((res) => {
                        if (res.success) {
                            $likesStat.text(res.data.likes);
                            $yesBtn.removeClass('is-active');
                            $noBtn.addClass('is-active');
                            setCookie(cookieKey, 'no', 30);
                        }
                    });
                } else {
                    $noBtn.addClass('is-active');
                    setCookie(cookieKey, 'no', 30);
                }
            }
        });
    }

    // views
    if ($('.article').length) {
        const $article = $('.article');
        const postId = $article.attr('data-post-id');
        const viewStorageKey = 'article_viewed_' + postId;
        const now = Date.now();
        const dayInMs = 24 * 60 * 60 * 1000;

        const lastView = localStorage.getItem(viewStorageKey);

        if (!lastView || (now - lastView) > dayInMs) {
            $.ajax({
                url: great_ajax.url,
                type: 'POST',
                data: {
                    action: 'get_great_increment_views',
                    post_id: postId
                },
                success: function (res) {
                    if (res.success) {
                        localStorage.setItem(viewStorageKey, now);
                    }
                }
            });
        }
    }

    // Toc actions
    if ($('.article__sidebar .sidebar__list').length) {
        const $sidebarLinks = $('.sidebar__link');
        const $header = $('.header');
        const $sections = [];

        $('.sidebar__list').on('click', '.sidebar__link', function () {
            if (typeof Fancybox !== "undefined" && Fancybox.getInstance()) {
                Fancybox.close();
            }
        });

        $sidebarLinks.each(function () {
            const id = $(this).attr('href');
            if (id && id.startsWith('#') && id.length > 1) {
                const $target = $(id);
                if ($target.length) {
                    $sections.push({
                        $link: $(this),
                        $target: $target
                    });
                }
            }
        });

        const updateActiveLink = () => {
            const headerHeight = $header.outerHeight() || 0;
            const scrollTop = $(window).scrollTop();
            const scrollPos = scrollTop + headerHeight + 20;

            let activeSection = null;

            $sections.forEach(section => {
                const top = section.$target.offset().top;
                if (scrollPos >= top) {
                    activeSection = section;
                }
            });

            $sidebarLinks.removeClass('is-active');
            if (activeSection) {
                activeSection.$link.addClass('is-active');
            }
        };

        let isScrolling = false;
        $(window).on('scroll.scrollSpy', function () {
            if (!isScrolling) {
                window.requestAnimationFrame(() => {
                    updateActiveLink();
                    isScrolling = false;
                });
                isScrolling = true;
            }
        }).trigger('scroll.scrollSpy');
    }

})

