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

    $(window).on('resize', () => {
        clearTimeout(window.resizeTimer);
        window.resizeTimer = setTimeout(() => {
            getNavigator();
        }, 100);
    });

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

        // tabs on services section
        if ($target.closest('.services__item').length) {
            const $btn = $target.closest('.services__item');
            const projectId = $btn.data('project-id');
            const $parentSection = $btn.closest('.services');

            $parentSection.find('.services__item').removeClass('active');
            $btn.addClass('active');

            $parentSection.find('.services__project').removeClass('active');
            $parentSection.find(`[data-project-target="${projectId}"]`).addClass('active');
        }

        // Load more clients
        if ($target.closest('[data-show-more="clients"]').length) {
            const $btn = $target.closest('[data-show-more="clients"]');
            const $container = $btn.closest('.clients__content');
            const $hiddenItems = $container.find('.clients__item.is-hidden');

            $hiddenItems.addClass('is-animated');

            $hiddenItems.css('display', 'flex').hide().fadeIn(400).removeClass('is-hidden');

            $btn.css('transition', 'all 0.3s ease');
            $btn.css({
                'transform': 'scale(0)',
                'opacity': '0',
                'pointer-events': 'none'
            });
            setTimeout(() => {
                $btn.remove();
            }, 400);
        }


    });


    // sliders
    class MobileSwiper {
        constructor(sliderName, options, condition = 767.98) {
            this.$slider = $(sliderName);
            this.options = options;
            this.init = false;
            this.swiper = null;
            this.condition = condition;

            if (this.$slider.length) {
                this.handleResize();
                $(window).on("resize", () => this.handleResize());
            }
        }

        handleResize() {
            if (window.innerWidth <= this.condition) {
                if (!this.init) {
                    this.init = true;
                    this.swiper = new Swiper(this.$slider[0], this.options);
                }
            } else if (this.init) {
                this.swiper.destroy();
                this.swiper = null;
                this.init = false;
            }
        }
    }


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
            slidesPerView: 1.05,
            spaceBetween: 12,
            lazy: true,
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
                575.98: {
                    slidesPerView: 2,
                    spaceBetween: 16,
                },
                767.98: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                },
                1199.98: {
                    slidesPerView: 4,
                    spaceBetween: 24,
                },
                1709.98: {
                    slidesPerView: 5,
                    spaceBetween: 32,
                }
            }
        });
    }

    $('.marquee__slider').each(function () {
        var $el = $(this);
        var isReverse = $el.attr('data-direction') === 'reverse';
        var hasImages = $el.hasClass('marquee__slider--images');

        let savedTranslate = 0;
        let isPaused = false;

        var swiper = new Swiper(this, {
            loop: true,
            slidesPerView: 'auto',
            observer: true,
            observeParents: true,
            freeMode: true,
            allowTouchMove: true,
            spaceBetween: hasImages ? 32 : 12,
            slideToClickedSlide: true,
            speed: 8000,
            autoplay: {
                delay: 0,
                disableOnInteraction: false,
                pauseOnMouseEnter: false,
                reverseDirection: isReverse
            },
            breakpoints: {
                767.98: {
                    spaceBetween: hasImages ? 64 : 12,
                }
            }
        });

        const removeTooltips = () => {
            $('.tooltip-marquee').remove();
            $('.marquee__image').removeClass('active-tooltip');
        };

        const stopSwiper = () => {
            if (isPaused) return;

            const style = window.getComputedStyle(swiper.wrapperEl);
            const matrix = new WebKitCSSMatrix(style.transform);
            savedTranslate = matrix.m41;

            swiper.autoplay.stop();
            $(swiper.wrapperEl).css('transition', 'none');
            swiper.setTranslate(savedTranslate);
            isPaused = true;
        };

        const startSwiper = () => {
            if (!isPaused) return;

            $(swiper.wrapperEl).css('transition', '');

            swiper.params.freeMode.enabled = false;
            swiper.update();

            swiper.params.freeMode.enabled = true;
            swiper.update();

            swiper.setTranslate(savedTranslate);

            swiper.autoplay.start();
            isPaused = false;
        };

        const showTooltip = ($slide, e) => {
            const content = $slide.attr('data-tooltip-content');
            if (!content) return;

            removeTooltips();
            stopSwiper();

            $slide.addClass('active-tooltip');

            const $tooltip = $('<div class="tooltip tooltip-marquee"></div>').html(content);
            $('body').append($tooltip);

            const rect = $slide[0].getBoundingClientRect();
            const tooltipRect = $tooltip[0].getBoundingClientRect();
            const scrollY = $(window).scrollTop();
            const scrollX = $(window).scrollLeft();

            let top = rect.bottom + scrollY + 16;
            let left = rect.left + scrollX + (rect.width / 2) - (tooltipRect.width / 2);
            let currentDir = 'open-bottom';

            if (top + tooltipRect.height > scrollY + $(window).height()) {
                top = rect.top + scrollY - tooltipRect.height - 16;
                currentDir = 'open-top';
            }

            $tooltip.addClass(currentDir);

            if (left < 10) left = 10;
            if (left + tooltipRect.width > $(window).width() - 10) {
                left = $(window).width() - tooltipRect.width - 10;
            }

            $tooltip.css({
                top: top + 'px',
                left: left + 'px'
            });

            e.stopPropagation();
        };

        $el.on('pointerenter', function (e) {
            if (e.originalEvent.pointerType === 'mouse') stopSwiper();
        });

        $el.on('pointerleave', function (e) {
            if (e.originalEvent.pointerType === 'mouse') {
                removeTooltips();
                startSwiper();
            }
        });

        $el.find('.marquee__image[data-tooltip-content]').each(function () {
            const $slide = $(this);

            $slide.on('pointerenter', function (e) {
                if (e.originalEvent.pointerType === 'mouse') {
                    showTooltip($slide, e);
                }
            });

            $slide.on('click', function (e) {
                stopSwiper();
                showTooltip($slide, e);
            });
        });

        $(document).on('pointerdown', function (e) {
            const $target = $(e.target);
            if (!$target.closest('.marquee__image').length && !$target.closest('.tooltip-marquee').length) {
                removeTooltips();
                const isHoveringSlider = $target.closest('.marquee__slider').length;
                if (!isHoveringSlider) {
                    startSwiper();
                }
            }
        });
    });

    if ($('.services__slider').length) {
        new MobileSwiper('.services__slider', {
            slidesPerView: "auto",
            slideToClickedSlide: true,
            spaceBetween: 12,
        }, 1199.98)
    }



    // Form Controller

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
            const maxSize = 10 * 1024 * 1024;

            $container.find('.form__error').remove();

            if (file && file.size > maxSize) {
                $input.val('');
                $container.append('<span class="form__error">Файл слишком большой. <br> Максимальный размер — 10 МБ.</span>');
                $container.removeClass('uploaded');
                $container.find('.form__file-preview').remove();
                return;
            }

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

    // Spollers
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

    // DynamicAdapt
    class DynamicAdapt {
        constructor(type) {
            this.type = type;
            this.objects = [];
            this.daClassname = "_dynamic_adapt_";
            this.$nodes = $("[data-da]");

            if (this.$nodes.length > 0) {
                this.init();
            }
        }

        init() {
            this.$nodes.each((index, node) => {
                const $node = $(node);
                const data = $node.data("da").trim();
                const dataArray = data.split(",");
                const object = {};

                object.element = $node;
                object.parent = $node.parent();
                object.destination = $(dataArray[0].trim());
                object.breakpoint = dataArray[1] ? dataArray[1].trim() : "767";
                object.place = dataArray[2] ? dataArray[2].trim() : "last";
                object.index = this.indexInParent(object.parent, object.element);
                this.objects.push(object);
            });

            this.arraySort(this.objects);

            this.mediaQueries = this.objects
                .map((item) => {
                    return `(${this.type}-width: ${item.breakpoint}px),${item.breakpoint}`;
                })
                .filter((item, index, self) => {
                    return self.indexOf(item) === index;
                });

            this.mediaQueries.forEach((media) => {
                const mediaSplit = media.split(",");
                const matchMedia = window.matchMedia(mediaSplit[0]);
                const mediaBreakpoint = mediaSplit[1];

                const objectsFilter = this.objects.filter((item) => {
                    return item.breakpoint === mediaBreakpoint;
                });

                matchMedia.addEventListener("change", () => {
                    this.mediaHandler(matchMedia, objectsFilter);
                });
                this.mediaHandler(matchMedia, objectsFilter);
            });
        }

        mediaHandler(matchMedia, objects) {
            if (matchMedia.matches) {
                objects.forEach((object) => {
                    object.index = this.indexInParent(object.parent, object.element);
                    this.moveTo(object.place, object.element, object.destination);
                });
            } else {
                objects.forEach((object) => {
                    if (object.element.hasClass(this.daClassname)) {
                        this.moveBack(object.parent, object.element, object.index);
                    }
                });
            }
        }

        moveTo(place, $element, $destination) {
            $element.addClass(this.daClassname);
            const $children = $destination.children();

            if (place === "last" || place >= $children.length) {
                $destination.append($element);
                return;
            }
            if (place === "first") {
                $destination.prepend($element);
                return;
            }
            $children.eq(place).before($element);
        }

        moveBack($parent, $element, index) {
            $element.removeClass(this.daClassname);
            const $children = $parent.children();

            if ($children.eq(index).length > 0) {
                $children.eq(index).before($element);
            } else {
                $parent.append($element);
            }
        }

        indexInParent($parent, $element) {
            return $parent.children().index($element);
        }

        arraySort(arr) {
            if (this.type === "min") {
                arr.sort((a, b) => {
                    if (a.breakpoint === b.breakpoint) {
                        if (a.place === b.place) return 0;
                        if (a.place === "first" || b.place === "last") return -1;
                        if (a.place === "last" || b.place === "first") return 1;
                        return a.place - b.place;
                    }
                    return a.breakpoint - b.breakpoint;
                });
            } else {
                arr.sort((a, b) => {
                    if (a.breakpoint === b.breakpoint) {
                        if (a.place === b.place) return 0;
                        if (a.place === "first" || b.place === "last") return 1;
                        if (a.place === "last" || b.place === "first") return -1;
                        return b.place - a.place;
                    }
                    return b.breakpoint - a.breakpoint;
                });
            }
        }
    }

    window.dynamicAdapt = new DynamicAdapt("max");


})

