"use strict";

// preloader
if ($('.preloader').length > 0) {
    let counting = setInterval(function () {
        let loader = $('#percentage');
        let currval = parseInt(loader.text());

        if (currval < 90) {
            loader.text(++currval);
        } else if (currval < 95 && document.readyState === "interactive") {
            loader.text(95);
        } else if (currval < 99 && document.readyState === "complete") {
            loader.text(99);
        }

        if (currval >= 99 && document.readyState === "complete") {
            clearInterval(counting);
            loader.text(100);
            setTimeout(function () {
                $('body').removeClass('preloading').addClass('is-loaded');
            }, 300);
        }
    }, 20);
}

$(function () {

    // Smooth Scroll Anchors
    $('a[href^="#"]').not('[data-fancybox]').on('click', function (event) {
        const href = this.getAttribute('href');

        if (href === '#') return;

        const target = $(href);
        const header = $('.header');

        if (target.length) {
            event.preventDefault();

            const headerHeight = header.outerHeight() || 0;
            const targetPosition = target.offset().top - headerHeight;

            $('html, body').stop().animate({
                scrollTop: targetPosition
            }, 800);
        }
    });

    //  init Fancybox
    if (typeof Fancybox !== "undefined" && Fancybox !== null) {
        Fancybox.bind("[data-fancybox]", {
            dragToClose: false,
            on: {
                ready: (fancyboxRef) => {
                    const slide = fancyboxRef.getSlide();
                    if (slide.src === '#policies') {
                        const $container = $(slide.el);
                        const trigger = slide.triggerEl;

                        if (trigger) {
                            const targetSlug = trigger.getAttribute('href').replace('#', '');
                            const $targetRadio = $container.find(`input[name="policy-type"][value="${targetSlug}"]`);
                            if ($targetRadio.length) {
                                $targetRadio.prop('checked', true).trigger('change');
                            } else {
                                $container.find('input[name="policy-type"]:checked').trigger('change');
                            }
                            setTimeout(() => {
                                if ($targetRadio.length) {
                                    $targetRadio.prop('checked', true).trigger('change');
                                } else {
                                    $container.find('input[name="policy-type"]:checked').trigger('change');
                                }

                            }, 300)
                        }

                    }
                },
                close: (fancyboxRef, event) => {
                    const targetElement = event.target;


                    if (targetElement && targetElement.hasAttribute('data-goto-catalog')) {
                        const target = $('#catalog');
                        const header = $('.header');

                        if (target.length) {
                            const headerHeight = header.outerHeight() || 0;
                            const targetPosition = target.offset().top - headerHeight;

                            $('html, body').stop().animate({
                                scrollTop: targetPosition
                            }, 800);
                        }
                    }


                },
                destroy: (fancyboxRef) => {

                    if (fancyboxRef.getSlide().src === '#cart') {
                        window?.dornottCart.resetInterface()
                    }

                },
            }
        });
    }

    // detect user OS
    const isMobile = {
        Android: () => /Android/i.test(navigator.userAgent),
        BlackBerry: () => /BlackBerry/i.test(navigator.userAgent),
        iOS: () => /iPhone|iPad|iPod/i.test(navigator.userAgent),
        Opera: () => /Opera Mini/i.test(navigator.userAgent),
        Windows: () => /IEMobile/i.test(navigator.userAgent),
        any: function () {
            return this.Android() || this.BlackBerry() || this.iOS() || this.Opera() || this.Windows();
        },
    };

    function getNavigator() {
        if (isMobile.any() || $(window).width() < 992) {
            $('body').removeClass('_pc').addClass('_touch');
        } else {
            $('body').removeClass('_touch').addClass('_pc');
        }
    }

    getNavigator();
    setupStepsHandlers();

    $(window).on('resize', () => {
        clearTimeout(window.resizeTimer);
        window.resizeTimer = setTimeout(() => {
            getNavigator();
            setupStepsHandlers();

        }, 100);
    });

    // steps animation

    function setupStepsHandlers() {
        const $stepsItems = $('.steps__item');

        $stepsItems.off('click mouseenter mouseleave');

        if ($('body').hasClass('_pc')) {
            $stepsItems.on('mouseenter', function () {
                $(this).addClass('active').siblings().removeClass('active');
            });

        } else {
            $stepsItems.on('click', function (e) {
                $(this).addClass('active').siblings().removeClass('active');
            });
        }
    }


    // event handlers
    $(document).on('click', (e) => {
        const $target = $(e.target);


        // Handle submenu logic
        if ($target.closest('.menu__arrow').length) {
            const $parentItem = $target.closest('.menu__arrow').parent();

            if ($parentItem.hasClass('active')) {
                $parentItem.removeClass('active');
            } else {
                $('.menu__item.active').removeClass('active');
                $parentItem.addClass('active');
            }
        }

        // Close all submenus when clicking outside the menu
        if (!$target.closest('.menu__arrow').length && !$target.closest(".menu").length) {
            $('.menu__item.active').removeClass('active');
        }

        // Close all submenus when clicking outside the menu
        if (!$target.closest('.menu').length && !$target.closest('.icon-menu').length) {
            $('.menu__item.active').removeClass('active');
        }

        // Open/close the mobile menu
        if ($target.closest('.icon-menu').length) {
            $('.icon-menu').toggleClass("active");
            $('.menu').toggleClass("menu--open");
            $('body').toggleClass('menu-lock');
        }

        // Correctly close the mobile menu on outside click
        if ($(".menu").hasClass("menu--open") && !$target.closest(".menu").length && !$target.closest(".icon-menu").length) {
            $('.icon-menu').removeClass("active");
            $('.menu').removeClass("menu--open");
            $('body').removeClass('menu-lock');
        }

        if ($(".menu").hasClass("menu--open") && $target.closest(".menu__link").length) {
            $('.icon-menu').removeClass("active");
            $('.menu').removeClass("menu--open");
            $('body').removeClass('menu-lock');
        }

        // toggle active state favorite
        if ($target.closest('.favorite-btn').length) {
            $target.closest('.favorite-btn').toggleClass('active')
        }

        // tabs on about section
        if ($target.closest('.about__tab').length) {
            const $tabsBtn = $target.closest('.about__tab');
            const index = $tabsBtn.index();
            const $parentSection = $tabsBtn.closest('.about');

            $parentSection.find('.about__tab').removeClass('active');
            $tabsBtn.addClass('active');

            $parentSection.find('.about__tab-content').removeClass('active').eq(index).addClass('active');

            $parentSection.find('.about__image').removeClass('active').eq(index).addClass('active');
        }


    });

    // phone input mask

    var phoneInputs = document.querySelectorAll('input[type="tel"]');

    var getInputNumbersValue = function (input) {
        // Return stripped input value — just numbers
        return input.value.replace(/\D/g, '');
    }

    var onPhonePaste = function (e) {
        var input = e.target,
            inputNumbersValue = getInputNumbersValue(input);
        var pasted = e.clipboardData || window.clipboardData;
        if (pasted) {
            var pastedText = pasted.getData('Text');
            if (/\D/g.test(pastedText)) {
                // Attempt to paste non-numeric symbol — remove all non-numeric symbols,
                // formatting will be in onPhoneInput handler
                input.value = inputNumbersValue;
                return;
            }
        }
    }

    var onPhoneInput = function (e) {
        var input = e.target,
            inputNumbersValue = getInputNumbersValue(input),
            selectionStart = input.selectionStart,
            formattedInputValue = "";

        if (!inputNumbersValue) {
            return input.value = "";
        }

        if (input.value.length != selectionStart) {
            // Editing in the middle of input, not last symbol
            if (e.data && /\D/g.test(e.data)) {
                // Attempt to input non-numeric symbol
                input.value = inputNumbersValue;
            }
            return;
        }

        if (["7", "8", "9"].indexOf(inputNumbersValue[0]) > -1) {
            if (inputNumbersValue[0] == "9") inputNumbersValue = "7" + inputNumbersValue;
            var firstSymbols = (inputNumbersValue[0] == "8") ? "8" : "+7";
            formattedInputValue = input.value = firstSymbols + " ";
            if (inputNumbersValue.length > 1) {
                formattedInputValue += '(' + inputNumbersValue.substring(1, 4);
            }
            if (inputNumbersValue.length >= 5) {
                formattedInputValue += ') ' + inputNumbersValue.substring(4, 7);
            }
            if (inputNumbersValue.length >= 8) {
                formattedInputValue += '-' + inputNumbersValue.substring(7, 9);
            }
            if (inputNumbersValue.length >= 10) {
                formattedInputValue += '-' + inputNumbersValue.substring(9, 11);
            }
        } else {
            formattedInputValue = '+' + inputNumbersValue.substring(0, 16);
        }
        input.value = formattedInputValue;
    }

    var onPhoneKeyDown = function (e) {
        // Clear input after remove last symbol
        var inputValue = e.target.value.replace(/\D/g, '');
        if (e.keyCode == 8 && inputValue.length == 1) {
            e.target.value = "";
        }
    }

    for (var phoneInput of phoneInputs) {
        phoneInput.addEventListener('keydown', onPhoneKeyDown);
        phoneInput.addEventListener('input', onPhoneInput, false);
        phoneInput.addEventListener('paste', onPhonePaste, false);
    }


    // sliders
    // const swiperPaginationConfig = {
    //     type: 'fraction',
    //     formatFractionCurrent: (number) => {
    //         return number < 10 ? '0' + number : number;
    //     },
    //     formatFractionTotal: (number) => {
    //         return number < 10 ? '0' + number : number;
    //     },
    //     renderFraction: (currentClass, totalClass) => {
    //         return '<span class="' + currentClass + '"></span>' +
    //             '/' +
    //             '<span class="' + totalClass + '"></span>';
    //     }
    // };

    // if ($('.hero').length) {

    //     const heroImages = $('.hero__images');
    //     const heroOffer = $('.hero__offer-slider');

    //     if (heroImages.length && heroOffer.length) {

    //         const heroImagesSlider = new Swiper(heroImages.get(0), {
    //             loop: true,
    //             effect: 'fade',
    //             fadeEffect: {
    //                 crossFade: true
    //             },
    //             speed: 600,
    //             allowTouchMove: false,

    //             navigation: {
    //                 nextEl: '.hero__next',
    //                 prevEl: '.hero__prev',
    //             },

    //             pagination: {
    //                 el: '.hero__pagination',
    //                 ...swiperPaginationConfig
    //             },
    //         });

    //         const heroOfferSlider = new Swiper(heroOffer.get(0), {
    //             loop: true,
    //             autoHeight: true,
    //             speed: 600,
    //             effect: 'fade',
    //             fadeEffect: {
    //                 crossFade: true
    //             },
    //             controller: {
    //                 control: heroImagesSlider
    //             },
    //             breakpoints: {
    //                 991.98: {
    //                     autoHeight: false

    //                 }
    //             }
    //         });


    //         heroImagesSlider.controller.control = heroOfferSlider;
    //     }
    // }

    // if ($('.reviews').length) {


    //     let reviewsTextSwiper;
    //     const initTextSwiper = () => {
    //         if ($('.reviews__text .reviews__slider').length && !reviewsTextSwiper) {
    //             reviewsTextSwiper = new Swiper('.reviews__text .reviews__slider', {
    //                 slidesPerView: "auto",
    //                 spaceBetween: 12,
    //                 watchOverflow: true,
    //                 navigation: {
    //                     nextEl: '.reviews__controls--text .reviews__next',
    //                     prevEl: '.reviews__controls--text .reviews__prev',
    //                 },
    //                 pagination: {
    //                     el: '.reviews__controls--text .reviews__pagination',
    //                     ...swiperPaginationConfig
    //                 },
    //                 breakpoints: {
    //                     991.98: {
    //                         slidesPerView: 3,
    //                         spaceBetween: 18,
    //                     },
    //                     1399.98: {
    //                         slidesPerView: 4,
    //                         spaceBetween: 24,
    //                     }
    //                 }
    //             });
    //         }
    //     };

    //     let reviewsScreenshotsSwiper;
    //     const initScreenshotsSwiper = () => {
    //         if ($('.reviews__screenshots .reviews__slider').length && !reviewsScreenshotsSwiper) {
    //             reviewsScreenshotsSwiper = new Swiper('.reviews__screenshots .reviews__slider', {
    //                 slidesPerView: "auto",
    //                 spaceBetween: 12,
    //                 watchOverflow: true,
    //                 navigation: {
    //                     nextEl: '.reviews__controls--screenshots .reviews__next',
    //                     prevEl: '.reviews__controls--screenshots .reviews__prev',
    //                 },
    //                 pagination: {
    //                     el: '.reviews__controls--screenshots .reviews__pagination',
    //                     ...swiperPaginationConfig
    //                 },
    //                 breakpoints: {
    //                     991.98: {
    //                         slidesPerView: 4,
    //                         spaceBetween: 18,
    //                     },
    //                     1399.98: {
    //                         slidesPerView: 5,
    //                         spaceBetween: 24,
    //                     }
    //                 },
    //             });
    //         }
    //     };


    //     const $reviewsSection = $('#reviews');
    //     const $switcherInputs = $reviewsSection.find('.reviews__switcher input[name="reviews-type"]');
    //     const $reviewsTextContainer = $reviewsSection.find('.reviews__text');
    //     const $reviewsScreenshotsContainer = $reviewsSection.find('.reviews__screenshots');
    //     const $controlsText = $reviewsSection.find('.reviews__controls--text');
    //     const $controlsScreenshots = $reviewsSection.find('.reviews__controls--screenshots');


    //     if ($switcherInputs.filter(':checked').val() === 'text') {
    //         initTextSwiper();
    //     } else {
    //         initScreenshotsSwiper();
    //     }

    //     $switcherInputs.on('change', function () {
    //         const type = $(this).val();

    //         if (type === 'text') {
    //             $reviewsTextContainer.show();
    //             $reviewsScreenshotsContainer.hide();
    //             $controlsText.show();
    //             $controlsScreenshots.hide();
    //             initTextSwiper();
    //         } else if (type === 'screenshots') {
    //             $reviewsTextContainer.hide();
    //             $reviewsScreenshotsContainer.show();
    //             $controlsText.hide();
    //             $controlsScreenshots.show();
    //             initScreenshotsSwiper();
    //         }

    //         if (reviewsTextSwiper) {
    //             reviewsTextSwiper.update();
    //         }
    //         if (reviewsScreenshotsSwiper) {
    //             reviewsScreenshotsSwiper.update();
    //         }
    //     });
    // }

    // if ($('.nav-slider').length) {

    //     let policiesSlider = new Swiper('.nav-slider', {
    //         slidesPerView: "auto",
    //         spaceBetween: 4,
    //         slideToClickedSlide: true,
    //         initialSlide: $('.nav-slider__item .nav-slider__link.active').parent().index()
    //     })

    //     $(document).on('change', '#policies input[name="policy-type"]', function () {
    //         const $this = $(this);
    //         const $popup = $this.closest('#policies');
    //         const $items = $popup.find('.switcher__item');
    //         const currentIndex = $items.index($this.closest('.switcher__item'));
    //         const $textBlocks = $popup.find('.popup__text');

    //         $textBlocks.hide().eq(currentIndex).show();

    //         if (policiesSlider) {
    //             policiesSlider.slideTo(currentIndex);
    //         }
    //     });
    // }

    if ($('.promo__slider').length) {
        const $tabs = $('.promo__tab-btn');
        const $promoSection = $('.promo');
        const $slideSourceInput = $('.js-slide-source');
        const startSlide = $promoSection.data('initial') || 0;

        const updateSourceInput = (swiper) => {
            const activeSlide = swiper.slides[swiper.realIndex];
            const title = $(activeSlide).attr('data-title') || ('Слайд ' + (swiper.realIndex + 1));
            $slideSourceInput.val(title);
        };

        const promoSlider = new Swiper('.promo__slider', {
            initialSlide: startSlide,
            slidesPerView: 1,
            effect: 'fade',
            fadeEffect: { crossFade: true },
            speed: 800,
            autoplay: {
                delay: 15000,
                disableOnInteraction: false,
                stopOnLastSlide: false
            },
            on: {
                init: function (swiper) {
                    let delay = swiper.params.autoplay.delay;
                    $tabs.css('--counting-speed', delay / 1000 + 's');

                    $tabs.each(function () {
                        const rect = $(this).find('rect')[0];
                        if (rect) {
                            const length = rect.getTotalLength();
                            rect.style.strokeDasharray = length;
                            rect.style.strokeDashoffset = length;
                            rect.style.transition = 'none';
                        }
                    });

                    $tabs.removeClass('active counting');

                    updateSourceInput(swiper);

                    requestAnimationFrame(() => {
                        requestAnimationFrame(() => {
                            const activeIndex = swiper.realIndex;
                            const $activeTab = $tabs.eq(activeIndex);
                            const activeRect = $activeTab.find('rect')[0];

                            if (activeRect) {
                                void $activeTab[0].offsetWidth;
                                activeRect.style.transition = '';
                            }

                            $activeTab.addClass('active counting');
                        });
                    });
                },

                slideChangeTransitionStart: function (swiper) {
                    const activeIndex = swiper.realIndex;
                    let delay = swiper.params.autoplay.delay;
                    let speed = swiper.params.speed;

                    $tabs.css('--counting-speed', (delay + speed) / 1000 + 's');

                    updateSourceInput(swiper);

                    $tabs.each(function () {
                        const rect = $(this).find('rect')[0];
                        if (rect) {
                            const length = rect.getTotalLength();
                            $(this).removeClass('active counting');
                            rect.style.transition = 'none';
                            rect.style.strokeDashoffset = length;
                        }
                    });

                    if (swiper.autoplay.running) {
                        void $tabs[activeIndex].offsetWidth;
                        const activeRect = $tabs.eq(activeIndex).find('rect')[0];
                        if (activeRect) {
                            activeRect.style.transition = '';
                        }
                        $tabs.eq(activeIndex).addClass('active counting');
                    } else {
                        $tabs.eq(activeIndex).addClass('active');
                    }
                }
            },
        });

        $tabs.on('click', function (e) {
            e.preventDefault();
            promoSlider.autoplay.stop();
            $tabs.removeClass('counting');
            const index = $(this).index();
            promoSlider.slideTo(index);
        });
    }

    if ($('.gratitudes__slider').length) {
        new Swiper('.gratitudes__slider', {
            slidesPerView: 3,
            spaceBetween: 32,
            navigation: {
                nextEl: '.gratitudes__next',
                prevEl: '.gratitudes__prev',
            },
            pagination: {
                el: '.gratitudes__pagination',
                type: 'fraction',
                formatFractionCurrent: function (number) {
                    return number < 10 ? '0' + number : number;
                },
                formatFractionTotal: function (number) {
                    return number < 10 ? '0' + number : number;
                },
                renderFraction: function (currentClass, totalClass) {
                    return '<span class="' + currentClass + '"></span>' +
                        ' / ' +
                        '<span class="' + totalClass + '"></span>';
                }
            },
            breakpoints: {
                1199.98: {
                    slidesPerView: 4,
                },
                1709.98: {
                    slidesPerView: 5,
                }
            }
        });
    }

    document.querySelectorAll('.marquee__slider').forEach(function (el) {
        var isReverse = el.getAttribute('data-direction') === 'reverse';
        var hasImages = $(el).hasClass('marquee__slider--images');



        new Swiper(el, {
            loop: true,
            slidesPerView: 'auto',
            observer: true,
            observeParents: true,
            freeMode: true,
            allowTouchMove: false,
            spaceBetween: hasImages ? 64 : 12,
            speed: 24000,
            autoplay: {
                delay: 1,
                disableOnInteraction: false,
                reverseDirection: isReverse
            },
        });
    });


    // header observer
    const headerElement = $('.header');

    const callback = function (entries, observer) {
        if (entries[0].isIntersecting) {
            headerElement.removeClass('scroll');
        } else {
            headerElement.addClass('scroll');
        }
    };

    const headerObserver = new IntersectionObserver(callback);
    headerObserver.observe(headerElement[0]);


    // switcher animation

    $('.switcher').each(function () {
        var $switcher = $(this);
        var $slider = $('<div class="switcher__slider"></div>');
        $switcher.prepend($slider);

        function updateSliderPosition($checkedInput) {
            if (!$switcher.is(':visible')) {
                return;
            }

            var $button = $checkedInput.next('.switcher__btn');
            if (!$button.length) return;

            var width = $button.outerWidth();
            var offsetLeft = $button.offset().left;
            var parentOffsetLeft = $switcher.offset().left;
            var parentPaddingLeft = parseFloat($switcher.css('padding-left'));
            var offset = offsetLeft - parentOffsetLeft - parentPaddingLeft;

            $switcher.css('--active-width', width + 'px');
            $switcher.css('--active-offset', offset + 'px');
        }

        var observer = new ResizeObserver(function (entries) {
            for (var entry of entries) {
                if (entry.contentRect.width > 0 || entry.contentRect.height > 0) {
                    var $initialChecked = $switcher.find('.switcher__input:checked');
                    if ($initialChecked.length) {
                        updateSliderPosition($initialChecked);
                    }
                }
            }
        });

        observer.observe($switcher[0]);

        $switcher.on('change', '.switcher__input', function () {
            updateSliderPosition($(this));
        });

        var resizeTimeout;
        $(window).on('resize', function () {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function () {
                var $currentChecked = $switcher.find('.switcher__input:checked');
                if ($currentChecked.length) {
                    updateSliderPosition($currentChecked);
                }
            }, 150);
        });
    });


    // Contacts Block Map
    function createMap() {

        const $map = $('#map');

        var coordsAddress = $map.data('coords').split('; ');
        var placemarkURL = $map.data('placemark-logo');

        for (var i = 0; i < coordsAddress.length; i++) {
            coordsAddress[i] = coordsAddress[i].split(', ');
            for (var j = 0; j < coordsAddress[i].length; j++) {
                coordsAddress[i][j] = parseFloat(coordsAddress[i][j]);
            }
        }

        var mapCenter = coordsAddress[0].map(function (element) {
            return element;
        });

        ymaps.ready(function () {

            var myMap = new ymaps.Map('map', {
                center: mapCenter,
                zoom: 16,
                controls: [],
            });

            var addressOne = new ymaps.Placemark(coordsAddress[0], {}, {
                iconLayout: 'default#image',
                iconImageHref: placemarkURL,
                iconImageSize: [69, 78],
                iconImageOffset: [-35, -78],
            });


            var zoomControl = new ymaps.control.ZoomControl({
                options: {
                    position: {
                        right: 10,
                        top: 200,
                    },
                },
            });


            myMap.behaviors.disable('scrollZoom');

            myMap.controls.add(zoomControl);

            myMap.geoObjects.add(addressOne);
        });


    }

    var isMapShown = false;
    $(window).scroll(function () {
        let container = $('#map');
        if (!isMapShown && (container.length > 0)) {
            let script = document.createElement("script");
            script.async = true;
            script.defer = true;
            script.src = "https://api-maps.yandex.ru/2.1/?lang=ru_RU";
            let container_pos = container.offset().top;
            let winHeight = $(window).height();
            let scrollToElem = container_pos - winHeight - 200;
            if ($(this).scrollTop() > scrollToElem) {
                document.head.append(script);
                script.onload = function () {
                    createMap();
                };
                isMapShown = true;
            }
        }
    });


    class FormController {
        constructor() {
            this.selectors = {
                field: '.form__field',
                errorClass: '_error',
                loadingClass: '_loading',
                requiredAttr: '[data-required]',
                fileInput: '.form__file-input',
                fileContainer: '.form__file',
                fileRemove: '.form__file-remove',
                submitBtn: '[type="submit"]'
            };
            this.init();
        }

        init() {
            const self = this;

            $('form').each(function () {
                self.bindSubmit($(this));
            });

            $(document).on('input change', this.selectors.requiredAttr, (e) => {
                const $field = $(e.target);
                if ($field.hasClass(this.selectors.errorClass) || $field.closest(this.selectors.field).hasClass(this.selectors.errorClass)) {
                    this.toggleErrorState($field, true);
                }
            });

            $(document).on('keydown', 'input[type="tel"]', (e) => this.onPhoneKeyDown(e));
            $(document).on('input', 'input[type="tel"]', (e) => this.onPhoneInput(e));
            $(document).on('paste', 'input[type="tel"]', (e) => this.onPhonePaste(e));
            $(document).on('focus', 'input[type="tel"]', (e) => {
                if (!e.target.value) {
                    e.target.value = "+7 ";
                }
            });

            $(document).off('change', this.selectors.fileInput).on('change', this.selectors.fileInput, (e) => this.handleFileChange(e));
            $(document).off('click', this.selectors.fileRemove).on('click', this.selectors.fileRemove, (e) => this.handleFileRemove(e));
        }

        bindSubmit($form) {
            $form.on('submit', async (e) => {
                if ($form.attr('id') === 'cart-form') {
                    return;
                }
                e.preventDefault();

                if (this.validateForm($form)) {
                    await this.sendForm($form);
                }
            });
        }

        async sendForm($form, isSilent = false) {
            console.log('submit from form controller');
            const url = $form.attr('action');
            const method = $form.attr('method') || 'POST';
            const formData = new FormData($form[0]);
            const $submitBtn = $form.find(this.selectors.submitBtn);

            $submitBtn.addClass(this.selectors.loadingClass);

            try {
                const response = await fetch(url, {
                    method: method,
                    body: formData
                });

                if (response.ok) {
                    const result = await response.json();

                    if (result.success) {

                        $form[0].reset();
                        $form.find('.form__file-preview').remove();
                        $form.find('.uploaded').removeClass('uploaded');

                        if (window.dornottCart && $form.attr('id') === 'cart-form') {
                            localStorage.removeItem(window.dornottCart.storageKey);
                            window.dornottCart.updateInterface();
                        }

                        if (!isSilent) {

                            const instance = Fancybox.getInstance();
                            if (instance) {
                                instance.destroy();
                            }

                            Fancybox.show([{
                                src: "#success-submitting",
                                type: "inline"
                            }]);

                            if (typeof ym === 'function') {
                                ym(105964434, 'reachGoal', 'sendmail');
                            }
                        }

                    } else {
                        console.error('Ошибка логики сервера:', result.data.message);
                        this.showErrorPopup();
                    }
                } else {
                    console.error('Ошибка сервера (HTTP статус)');
                    this.showErrorPopup();
                }
            } catch (error) {
                console.error('Ошибка сети', error);
                this.showErrorPopup();
            } finally {
                $submitBtn.removeClass(this.selectors.loadingClass);
            }
        }

        showErrorPopup() {
            const instance = Fancybox.getInstance();
            if (instance) {
                instance.destroy();
            }
            Fancybox.show([{
                src: "#error-submitting",
                type: "inline"
            }]);
        }

        validateField($field) {
            if (!$field.is(':visible')) {
                this.toggleErrorState($field, true);
                return true;
            }

            const type = $field.attr('type');
            const name = $field.attr('name');
            const val = $field.val() ? $field.val().trim() : '';
            let isValid = true;

            if (type === 'checkbox') {
                isValid = $field.is(':checked');
            } else if (name === 'username') {
                isValid = /^[^\d]+$/.test(val) && val.length > 1;
            } else if (type === 'tel') {
                const numbers = val.replace(/\D/g, '');
                isValid = numbers.length >= 11;
            } else if (type === 'email') {
                isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val);
            } else if (name === 'city') {
                isValid = val.length >= 2;
            } else if (name === 'address') {
                isValid = val.length >= 5;
            } else {
                isValid = val !== '';
            }

            this.toggleErrorState($field, isValid);
            return isValid;
        }

        toggleErrorState($field, isValid) {
            $field.closest(this.selectors.field).toggleClass(this.selectors.errorClass, !isValid);
            $field.toggleClass(this.selectors.errorClass, !isValid);
        }

        validateForm($form) {
            let isAllValid = true;
            const self = this;

            $form.find(this.selectors.requiredAttr).each(function () {
                if (!self.validateField($(this))) {
                    isAllValid = false;
                }
            });

            return isAllValid;
        }

        handleFileChange(e) {
            const $input = $(e.currentTarget);
            const $container = $input.closest(this.selectors.fileContainer);
            const file = e.target.files[0];

            $container.find('.form__file-preview').remove();
            $container.removeClass('uploaded');

            if (file) {
                const isImage = file.type.match('image.*');
                const reader = new FileReader();

                reader.onload = (event) => {
                    let previewContent = '';
                    if (isImage) {
                        previewContent = `
                        <span class="form__file-image">
                            <img src="${event.target.result}" alt="Превью" class="cover-image">
                        </span>
                    `;
                    }
                    const previewHtml = `
                    <div class="form__file-preview">
                        ${previewContent}
                        <span class="form__file-name">${file.name}</span>
                        <button type="button" aria-label="Удалить" class="form__file-remove icon-cross"></button>
                    </div>
                `;
                    $container.append(previewHtml);
                    $container.addClass('uploaded');
                };
                reader.readAsDataURL(file);
            }
        }

        handleFileRemove(e) {
            e.preventDefault();
            e.stopPropagation();

            const $btn = $(e.currentTarget);
            const $container = $btn.closest(this.selectors.fileContainer);
            const $preview = $btn.closest('.form__file-preview');

            $container.find(this.selectors.fileInput).val('');
            $container.removeClass('uploaded');
            $preview.remove();
        }

        onPhoneInput(e) {
            const input = e.target;
            let inputNumbersValue = input.value.replace(/\D/g, '');
            const selectionStart = input.selectionStart;
            let formattedInputValue = "";

            if (!inputNumbersValue) {
                return input.value = "";
            }

            if (input.value.length != selectionStart) {
                if (e.originalEvent.data && /\D/g.test(e.originalEvent.data)) {
                    input.value = inputNumbersValue;
                }
                return;
            }

            if (inputNumbersValue.length > 11) {
                inputNumbersValue = inputNumbersValue.substring(0, 11);
            }

            formattedInputValue = "+7 (";

            if (inputNumbersValue.length >= 2) {
                formattedInputValue += inputNumbersValue.substring(1, 4);
            }
            if (inputNumbersValue.length >= 5) {
                formattedInputValue += ") " + inputNumbersValue.substring(4, 7);
            }
            if (inputNumbersValue.length >= 8) {
                formattedInputValue += "-" + inputNumbersValue.substring(7, 9);
            }
            if (inputNumbersValue.length >= 10) {
                formattedInputValue += "-" + inputNumbersValue.substring(9, 11);
            }

            input.value = formattedInputValue;
        }

        onPhoneKeyDown(e) {
            const inputValue = e.target.value.replace(/\D/g, '');
            if (e.keyCode == 8 && inputValue.length == 1) {
                e.target.value = "";
            }
        }

        onPhonePaste(e) {
            const input = e.target;
            const inputNumbersValue = input.value.replace(/\D/g, '');
            const pasted = e.originalEvent.clipboardData || window.clipboardData;
            if (pasted) {
                const pastedText = pasted.getData('Text');
                if (/\D/g.test(pastedText)) {
                    input.value = inputNumbersValue;
                }
            }
        }
    }

    window.formController = new FormController();

    class Spollers {
        constructor() {
            this.$spollersArray = $("[data-spollers]");
            if (this.$spollersArray.length > 0) {
                this.init();
            }
        }

        init() {
            const $spollersRegular = this.$spollersArray.filter((index, item) => {
                return !$(item).data("spollers").split(",")[0];
            });

            if ($spollersRegular.length > 0) {
                this.initSpollers($spollersRegular);
            }

            const $spollersMedia = this.$spollersArray.filter((index, item) => {
                return $(item).data("spollers").split(",")[0];
            });

            if ($spollersMedia.length > 0) {
                this.initMediaSpollers($spollersMedia);
            }
        }

        initMediaSpollers($spollersMedia) {
            const breakpointsArray = [];
            $spollersMedia.each(function () {
                const params = $(this).data("spollers");
                const paramsArray = params.split(",");
                breakpointsArray.push({
                    value: paramsArray[0],
                    type: paramsArray[1] ? paramsArray[1].trim() : "max",
                    item: $(this)
                });
            });

            let mediaQueries = breakpointsArray.map((item) => {
                return `(${item.type}-width: ${item.value}px),${item.value},${item.type}`;
            });
            mediaQueries = [...new Set(mediaQueries)];

            mediaQueries.forEach((breakpoint) => {
                const paramsArray = breakpoint.split(",");
                const mediaBreakpoint = paramsArray[1];
                const mediaType = paramsArray[2];
                const matchMedia = window.matchMedia(paramsArray[0]);

                const filteredSpollers = breakpointsArray.filter((item) => {
                    return item.value === mediaBreakpoint && item.type === mediaType;
                });

                matchMedia.addEventListener("change", () => {
                    this.initSpollers(filteredSpollers, matchMedia);
                });
                this.initSpollers(filteredSpollers, matchMedia);
            });
        }

        initSpollers(spollersArray, matchMedia = false) {
            const items = Array.isArray(spollersArray) ? spollersArray : spollersArray.toArray();

            items.forEach((spollerItem) => {
                const $spollersBlock = matchMedia ? spollerItem.item : $(spollerItem);
                if (!matchMedia || matchMedia.matches) {
                    $spollersBlock.addClass("_init");
                    this.initSpollerBody($spollersBlock, true);
                    $spollersBlock.off("click", "[data-spoller]").on("click", "[data-spoller]", (e) => this.setSpollerAction(e));
                } else {
                    $spollersBlock.removeClass("_init");
                    this.initSpollerBody($spollersBlock, false);
                    $spollersBlock.off("click", "[data-spoller]");
                }
            });
        }

        initSpollerBody($spollersBlock, hideSpollerBody = true) {
            const $spollerTitles = $spollersBlock.find("[data-spoller]");
            if ($spollerTitles.length > 0) {
                $spollerTitles.each(function () {
                    const $title = $(this);
                    const $body = $title.next();
                    const $parent = $title.parent();
                    if (hideSpollerBody) {
                        $title.removeAttr("tabindex");
                        if (!$title.hasClass("_active")) {
                            $body.hide();
                            $parent.removeClass("_spoller-open");
                        } else {
                            $parent.addClass("_spoller-open");
                        }
                    } else {
                        $title.attr("tabindex", "-1");
                        $body.show();
                        $parent.removeClass("_spoller-open");
                    }
                });
            }
        }

        setSpollerAction(e) {
            const $el = $(e.target);
            const $spollerTitle = $el.has("[data-spoller]") ? $el : $el.closest("[data-spoller]");
            const $spollersBlock = $spollerTitle.closest("[data-spollers]");
            const isOneSpoller = $spollersBlock.is("[data-one-spoller]");
            const $body = $spollerTitle.next();
            const $parent = $spollerTitle.parent();

            if (!$spollersBlock.find(":animated").length) {
                if (isOneSpoller && !$spollerTitle.hasClass("_active")) {
                    this.hideSpollersBody($spollersBlock);
                }

                $spollerTitle.toggleClass("_active");
                $parent.toggleClass("_spoller-open");
                $body.slideToggle(300);
            }
            e.preventDefault();
        }

        hideSpollersBody($spollersBlock) {
            const $activeTitle = $spollersBlock.find("[data-spoller]._active");
            if ($activeTitle.length) {
                $activeTitle.removeClass("_active");
                $activeTitle.parent().removeClass("_spoller-open");
                $activeTitle.next().slideUp(300);
            }
        }
    }

    window.spollers = new Spollers();


})

