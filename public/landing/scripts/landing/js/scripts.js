( function( $ ) {
    'use strict';

    $('.woocommerce-form-coupon-toggle .showcoupon').on("click", function(){
        $(this).toggleClass( "active" );
        if ($(this).hasClass( "active" )) {
            $('.woocommerce-form-coupon').stop(true, true).slideDown();
        }else{
            $('.woocommerce-form-coupon').stop(true, true).slideUp();
        }
    });

    /* rtl check */
	function rtl_owl(){
	if ($('body').hasClass("rtl")) {
		return true;
	} else {
		return false;
	}};

	function rtl_isotop(){
        if ($('body').hasClass("rtl")) {
            return false;
        } else {
            return true;
    }};

	/* --------------------------------------------------
    * preloader
    * --------------------------------------------------*/
	if ( $('#royal_preloader').length ) {
		var $selector       = $('#royal_preloader'),
			$width          = $selector.data('width'),
			$height         = $selector.data('height'),
			$color          = $selector.data('color'),
			$bgcolor        = $selector.data('bgcolor'),
			$logourl        = $selector.data('url');
		
		Royal_Preloader.config({
			mode           : 'logo',
			logo           : $logourl,
			logo_size      : [$width, $height],
			showProgress   : true,
			showPercentage : true,
			text_colour: $color,
			background:  $bgcolor,
		});        
	};

    /* --------------------------------------------------
    * sticky header
    * --------------------------------------------------*/
	$('.header-static .is-fixed').parent().append('<div class="header-clone"></div>');
	$('.header-clone').height($('#site-header .is-fixed').outerHeight());
	$('.header-static .header-clone').hide();	
	$(window).on("scroll", function(){
		var site_header = $('#site-header').outerHeight() + 1;	
			
		if ($(window).scrollTop() >= site_header) {	    	
			$('.site-header .is-fixed').addClass('is-stuck');	
			$('.header-static .header-clone').show();	
		}else {
			$('.site-header .is-fixed').removeClass('is-stuck');		              
			$('.header-static .header-clone').hide();
		}
	});

    /* --------------------------------------------------
    * mobile menu
    * --------------------------------------------------*/
    $('.mmenu_wrapper li:has(ul)').prepend('<span class="arrow"><svg viewBox="0 0 448 448" xmlns="http://www.w3.org/2000/svg"><path d="m272 184c-4.417969 0-8-3.582031-8-8v-176h-80v176c0 4.417969-3.582031 8-8 8h-176v80h176c4.417969 0 8 3.582031 8 8v176h80v-176c0-4.417969 3.582031-8 8-8h176v-80zm0 0"/></svg></span>');
    $(".mmenu_wrapper .mobile_mainmenu > li span.arrow").on('click',function() {
        $(this).parent().find("> ul").stop(true, true).slideToggle()
        $(this).toggleClass( "active" ); 
    });
	
	$( "#mmenu_toggle" ).on('click', function() {
		$(this).toggleClass( "active" );
		$(this).parents('.header_mobile').toggleClass( "open" );
		if ($(this).hasClass( "active" )) {
			$('.mobile_nav').stop(true, true).slideDown(100);
		}else{
			$('.mobile_nav').stop(true, true).slideUp(100);
		}		
	});

    $('.menu-hamburger-toggle').each( function(){
        var selector         = $(this),
            menuHamburger    = selector.next('.octf-menu-hamburger'),
            mainNav          = menuHamburger.find('.main-navigation'),
            btnClose         = menuHamburger.find('#menu-hamburger-close');
        selector.on('click', function() {
            menuHamburger.addClass('open-menu');
        });
        btnClose.on('click', function() {
            menuHamburger.removeClass('open-menu');
        });
        document.addEventListener('keydown', function(event){
            if(event.key === "Escape"){
                menuHamburger.removeClass('open-menu');
            }
        });
    });

    var navInneer = $(".one-nav");
    if( navInneer.length > 0 ){
    navInneer.singlePageNav({
        
        updateHash: false,
        filter: 'a[href^="#"]',
        offset: 0,
        speed: 600,
        currentClass: "current",
        easing: "swing"
        
    });
    };

    $('.octf-search').each( function(){
        var btn = $(this).find('.toggle_search'),
        form = $(this).find('.h-search-form-field');
        function search_handler() {
            var isActive = !btn.hasClass('active');

            btn.toggleClass('active', isActive);
            form.toggleClass('show', isActive);
            return false;
        }
        $('.search-overlay, .h-search-form-inner > i, .toggle_search').on('click', search_handler);
    });

    var element = $('#panel-btn'),
    sidebar = $('#side-panel');
  
    function panel_handler() {
        var isActive = !element.hasClass('active');
  
        element.toggleClass('active', isActive);
        sidebar.toggleClass('side-panel-open', isActive);
        $('body').toggleClass('side-panel-active', isActive);
        return false;
    }
  
    $('#panel-btn, .side-panel-close, .panel-overlay').on('click', panel_handler);


    var element = $('#mmenu-toggle'),
        mmenu   = $('#mmenu-wrapper');

    function mmenu_handler() {
        var isActive = !element.hasClass('active');

        element.toggleClass('active', isActive);
        mmenu.toggleClass('mmenu-open', isActive);
        $('body').toggleClass('mmenu-active', isActive);
        return false;
    }

    $('#mmenu-toggle, .mmenu-close, .mmenu-overlay').on('click', mmenu_handler);

    $('.mmenu-wrapper li:has(ul)').prepend('<span class="arrow">+</span>');
    $(".mmenu-wrapper .mobile_mainmenu > li span.arrow").on('click',function() {
        $(this).parent().find("> ul").stop(true, true).slideToggle()
        $(this).toggleClass( "active" ); 
    });

    /* --------------------------------------------------
    * accordions
    * --------------------------------------------------*/
    $('.ot-accordions-wrapper').each( function () {
        var selector = $(this),
            content = selector.find('.ot-acc-item__content'),
            header  = selector.find('.ot-acc-item__title');

        header.off("click");

        header.each(function(){
            if ($(this).data('default') == 'yes') {
                $(this).next().addClass('active').slideDown(300);
                $(this).parent().addClass('current');
            }
        });

        header.on('click', function(e){
            e.preventDefault();
            var $this = $(this);

            $this.next().toggleClass('active').slideToggle(300);
            $this.parent().toggleClass('current');
            content.not($this.next()).slideUp(300);
            header.not($this).parent().removeClass('current');
        });
    });

    $('.ot-accordions-schedule').each( function () {
        var selector = $(this),
            content = selector.find('.schedule-detail'),
            title  = selector.find('.schedule-title');

        title.off("click");

        title.each(function(){
            if ($(this).data('default') == 'yes') {
                $(this).siblings('.schedule-detail').addClass('active').slideDown(300);
                $(this).parents('.schedule-item').addClass('current');
            }
        });

        title.on('click', function(e){
            e.preventDefault();
            var $this = $(this);

            $this.siblings('.schedule-detail').toggleClass('active').slideToggle(300);
            $this.parents('.schedule-item').toggleClass('current');
            content.not($this.siblings('.schedule-detail')).slideUp(300);
            title.not($this).parents('.schedule-item').removeClass('current');
        });
    });

    $('.ot-tabs').each(function() {
        var selector = $(this),
            tabs     = selector.find('.ot-tabs__heading li'),
            content  = selector.find('.ot-tabs__content');
        tabs.first().addClass('current');
        content.first().addClass('current');

        tabs.on( 'click', function(){
            var tab_id = $(this).attr('data-tab');
            $(this).siblings().removeClass('current');
            $(this).parents('.ot-tabs').find('.ot-tabs__content').removeClass('current');
            $(this).addClass('current');
            $("#"+tab_id).addClass('current');
        });
    });

    $('.ot-tab-schedule').each(function() {
        var selector = $(this),
            tabItem  = selector.find('.ot-tab-schedule__item');

        tabItem.on( 'click', function(){
            tabItem.removeClass('active');
            tabItem.each(function() {
                $($(this).data('link')).hide();
            });
            $(this).addClass('active');
            $($(this).data('link')).show();
        });
        tabItem.first().trigger('click');
    });

    $('.ot-countdown').each( function(){
        var selector = $(this),
            date     = selector.data('date'),
            zone     = selector.data('zone'),
            day      = selector.data('day'),
            days     = selector.data('days'),
            hour     = selector.data('hour'),
            hours    = selector.data('hours'),
            min      = selector.data('min'),
            mins     = selector.data('mins'),
            second   = selector.data('second'),
            seconds  = selector.data('seconds');
        selector.countdown({
            date: date,
            offset: zone,
            day: day,
            days: days,
            hour: hour,
            hours: hours,
            minute: min,
            minutes: mins,
            second: second,
            seconds: seconds
        }, function () {
            alert('Done!');
        });
    });

    $($(".ot-cpt-heading")[0]).addClass("active");
    $(".ot-cpt-wrapper > ul").on("click", "li", function () {
        var pos = $(this).index() + 2;
        $("tr").find('td:not(:eq(0))').hide();
        $('td:nth-child(' + pos + ')').css('display', 'table-cell');
        $("tr").find('th:not(:eq(0))').hide();
        $('li').removeClass('active');
        $(this).addClass('active');
    });

    $('.ot-switcher').each( function () {
        var selector  = $(this);
        selector.find('span').on( 'click', function() {
            var parent = $(this).parents('section');
            selector.find('span').removeClass('active');
            $(this).addClass('active');
            if( $(this).hasClass('l-switch') ){
                parent.find('.yearly').hide();
                parent.find('.monthly').show();
            }else{
                parent.find('.monthly').hide();
                parent.find('.yearly').show();
            }
        });
    });

    $('.ot-borow-lend').each(function() {
        var selector = $(this),
            tabs     = selector.find('.asset-heading li'),
            content  = selector.find('.asset-info-wrapper');
        tabs.first().addClass('current');
        content.first().addClass('current');

        tabs.on( 'mouseenter mouseleave', function(){
            var tab_id = $(this).attr('data-tab');
            $(this).siblings().removeClass('current');
            $(this).parents('.ot-borow-lend').find('.asset-info-wrapper').removeClass('current');
            $(this).addClass('current');
            $("#"+tab_id).addClass('current');
        });
    });

    $(window).on('scroll', function() {

        $('.ot-counter').each( function () {
            var scrollTop   = $(document).scrollTop() + $(window).height();
            var counter     = $(this).find('span.ot-counter__num'),
                countTo     = counter.attr('data-to'),
                during      = parseInt( counter.attr('data-time') );

            if ( scrollTop > counter.offset().top + counter.height() ) {
                $(this).removeAttr('data-counter');
                $({
                    countNum: counter.text()
                }).animate({
                    countNum: countTo
                },
                {
                    duration: during,
                    easing: 'swing',
                    step: function() {
                        counter.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        counter.text(this.countNum);
                    }
                });
            }
        });

        $('.ot-progress-line:not([data-processed])').each(function() {
            var bar = $(this),
                line = bar.find(".progress-bar"),
                progressEnd = bar.data('percent'),
                percent = bar.find('.ppercent');
            var scrollTop = $(document).scrollTop() + $(window).height();

            if ( scrollTop >  bar.offset().top +  bar.height() ) {
                bar.attr("data-processed", "true");
                line.css("width", (bar.outerWidth() * (progressEnd / 100)) + "px");

                for (var i = 0; i <= 50; i++) {
                    (function (count) {
                        setTimeout(function () {
                            percent.html(Math.round((progressEnd / 50) * count) + "%");
                        }, 30 * count);
                    })(i);
                }
            }
        });
        $('.ot-progress-line[data-processed]').each(function () {
            var bar = $(this);
            var line = bar.find(".progress-bar");
            var progressEnd = parseInt(bar.data('percent'));

            line.css("width", (bar.outerWidth() * (progressEnd / 100)) + "px");
        });
        $('.ot-progress-circle:not([data-processed])').each(function() {
            var circle    = $(this),
                bar_color = circle.data('color'),
                bar_hei   = circle.data('height'),
                bar_size  = circle.data('size');
            var scrollTop = $(document).scrollTop() + $(window).height();
            if ( scrollTop >  circle.offset().top +  circle.height() ) {
                circle.attr("data-processed", "true");
                circle.find('.ot-progress-circle__inner').easyPieChart({
                    barColor: bar_color,
                    trackColor: false,
                    scaleColor: false,
                    lineCap: 'square',
                    lineWidth: bar_hei,
                    size: bar_size,
                    animate: 1000,
                    onStart: $.noop,
                    onStop: $.noop,
                    /*easing: 'easeInOut',*/
                    onStep: function(from, to, percent) {
                        $(this.el).find('.percent').text(Math.round(percent) + '%');
                    }
                });
            }
        });
    });
	/* --------------------------------------------------
    * gallery post
    * --------------------------------------------------*/
	$('.gallery-post').each( function () {
		var selector = $(this);
		selector.owlCarousel({
			rtl: rtl_owl(),
			loop:true,
			margin:0,
			responsiveClass:true,
			items:1,
			dots:false,
			nav:true,
			navText:['<i class="ot-flaticon-left-arrow"></i>', '<i class="ot-flaticon-right-arrow"></i>']
		});
	});

    /* --------------------------------------------------
     * Image Carousel
     * --------------------------------------------------*/
    $(".ot-image-slider").owlCarousel({
        rtl: rtl_owl(),
        autoplay: false,
        loop: true,
        center: true,
        responsiveClass:true,
        dotsClass: 'owl-dots ot-custom-dots',
        dots: false,
        nav: true,
        navText:['<i class="ot-flaticon-left-arrow"></i>', '<i class="ot-flaticon-right-arrow"></i>'],
        responsive : {
            0 : {
                items: 1,
                margin: 30,
            },
            768 : {
                items: 1,
                margin: 30,
            },
            1024 : {
                items: 1,
                margin: 30,
            }
        }
    });

    $(".ot-image-slider-h5").owlCarousel({
        rtl: rtl_owl(),
        autoplay: false,
        loop: true,
        center: true,
        responsiveClass:true,
        dotsClass: 'owl-dots ot-custom-dots',
        dots: true,
        nav: false,
        navText:['<i class="ot-flaticon-left-arrow"></i>', '<i class="ot-flaticon-right-arrow"></i>'],
        responsive : {
            0 : {
                items: 1,
                margin: 30,
            },
            768 : {
                items: 1,
                margin: 30,
            },
            1024 : {
                items: 1,
                margin: 30,
            }
        }
    });

    $(".ot-image-slider-h7").owlCarousel({
        rtl: rtl_owl(),
        autoplay: false,
        loop: true,
        responsiveClass:true,
        dotsClass: 'owl-dots ot-custom-dots',
        dots: false,
        nav: true,
        navText:['<i class="ot-flaticon-left-arrow"></i>', '<i class="ot-flaticon-right-arrow"></i>'],
        responsive : {
            0 : {
                items: 1,
                margin: 30,
            },
            768 : {
                items: 1,
                margin: 50,
            },
            1024 : {
                items: 1,
                margin: 70,
            }
        }
    });

    $(".ot-image-slider-h13").owlCarousel({
        rtl: rtl_owl(),
        autoplay: false,
        loop: true,
        responsiveClass:true,
        dotsClass: 'owl-dots ot-custom-dots text-center text-lg-right pr-xl-5',
        dots: true,
        nav: false,
        navText:['<i class="ot-flaticon-left-arrow"></i>', '<i class="ot-flaticon-right-arrow"></i>'],
        responsive : {
            0 : {
                items: 2,
                margin: 30,
            },
            768 : {
                items: 3,
                margin: 50,
            },
            1024 : {
                items: 3,
                margin: 150,
            }
        }
    });

    $(".ot-client-logo-slider").owlCarousel({
        rtl: rtl_owl(),
        autoplay: false,
        loop: false,
        responsiveClass:true,
        dotsClass: 'owl-dots ot-custom-dots',
        dots: false,
        nav: false,
        navText:['<i class="ot-flaticon-left-arrow"></i>', '<i class="ot-flaticon-right-arrow"></i>'],
        responsive : {
            0 : {
                items: 2,
                margin: 80,
            },
            768 : {
                items: 3,
                margin: 80,
            },
            1024 : {
                items: 4,
                margin: 86,
            },
            1200 : {
                items: 5,
                margin: 86,
            }
        }
    });

     $(".ot-testimonial-s1").owlCarousel({
        rtl: rtl_owl(),
        autoplay: false,
        loop: true,
        responsiveClass:true,
        dotsClass: 'owl-dots ot-custom-dots',
        dots: true,
        nav: false,
        navText:['<i class="ot-flaticon-left-arrow"></i>', '<i class="ot-flaticon-right-arrow"></i>'],
        responsive : {
            0 : {
                items: 1,
                margin: 30,
            },
            768 : {
                items: 2,
                margin: 30,
            },
            1024 : {
                items: 3,
                margin: 30,
            }
        }
    });

     $(".ot-testimonial-s2").owlCarousel({
        rtl: rtl_owl(),
        autoplay: false,
        loop: true,
        responsiveClass:true,
        dotsClass: 'owl-dots ot-custom-dots',
        dots: false,
        nav: true,
        navText:['<i class="ot-flaticon-left-arrow"></i>', '<i class="ot-flaticon-right-arrow"></i>'],
        responsive : {
            0 : {
                items: 1,
                margin: 30,
            },
            768 : {
                items: 1,
                margin: 30,
            },
            1024 : {
                items: 1,
                margin: 30,
            }
        }
    });

     $(".ot-testimonial-s3").owlCarousel({
        rtl: rtl_owl(),
        autoplay: false,
        loop: true,
        responsiveClass:true,
        dotsClass: 'owl-dots ot-custom-dots text-left',
        dots: true,
        nav: false,
        navText:['<i class="ot-flaticon-left-arrow"></i>', '<i class="ot-flaticon-right-arrow"></i>'],
        responsive : {
            0 : {
                items: 1,
                margin: 30,
            },
            768 : {
                items: 1,
                margin: 30,
            },
            1024 : {
                items: 1,
                margin: 30,
            }
        }
    });

     $(".ot-testimonial-slider-crypto").owlCarousel({
        rtl: rtl_owl(),
        autoplay: false,
        loop: true,
        responsiveClass:true,
        dotsClass: 'owl-dots ot-custom-dots',
        dots: true,
        nav: false,
        navText:['<i class="ot-flaticon-left-arrow"></i>', '<i class="ot-flaticon-right-arrow"></i>'],
        responsive : {
            0 : {
                items: 1,
                margin: 30,
            },
            768 : {
                items: 1,
                margin: 30,
            },
            1024 : {
                items: 2,
                margin: 30,
            }
        }
    });

     $(".ot-project-slider-h1").owlCarousel({
        rtl: rtl_owl(),
        autoplay: true,
        loop: true,
        responsiveClass:true,
        dotsClass: 'owl-dots ot-custom-dots',
        dots: true,
        nav: false,
        navText:['<i class="ot-flaticon-left-arrow"></i>', '<i class="ot-flaticon-right-arrow"></i>'],
        responsive : {
            0 : {
                items: 1,
                margin: 30,
            },
            768 : {
                items: 2,
                margin: 30,
            },
            1024 : {
                items: 3,
                margin: 30,
            }
        }
    });

    $('.ot-project-slider-h3').each( function () {
        var selector       = $(this);

        selector.find('.owl-carousel').owlCarousel({
            rtl: rtl_owl(),
            autoplay: false,
            loop: false,
            responsiveClass:true,
            dotsClass: 'owl-dots ot-custom-dots',
            dots: false,
            responsive : {
                0 : {
                    items: 1,
                    margin: 30,
                },
                768 : {
                    items: 2,
                    margin: 30,
                },
                1024 : {
                    items: 3,
                    margin: 30,
                }
            }
        });
        
        /* Custom Navigation Events */ 
        customNav(selector);
    });

    $('.ot-image-slider-h6').each( function () {
        var selector       = $(this);

        selector.find('.owl-carousel').owlCarousel({
            rtl: rtl_owl(),
            autoplay: false,
            loop: false,
            responsiveClass:true,
            dotsClass: 'owl-dots ot-custom-dots',
            dots: false,
            responsive : {
                0 : {
                    items: 1,
                    margin: 30,
                },
                768 : {
                    items: 2,
                    margin: 60,
                },
                1024 : {
                    items: 2,
                    margin: 130,
                }
            }
        });

        /* Custom Navigation Events */ 
        customNav(selector);

    });

    $('.ot-image-slider-sync-tab').each( function () {
        var selector     = $(this),
            selectorSlider = selector.find('.part-image-slider'),
            selectorTab = selector.find('.part-tab'),
            tabs     = selectorTab.find('.ot-tabs').find('.ot-tabs__heading li'),
            content  = selectorTab.find('.ot-tabs').find('.ot-tabs__content');

        /* Slider */
        selectorSlider.find('.owl-carousel').owlCarousel({
            rtl: rtl_owl(),
            items: 1,
            autoplay: false,
            loop: false,
            dots: true,
            nav: false,
            dotsClass: 'owl-dots ot-custom-dots',
            responsive : {}
        }).on('changed.owl.carousel', function(e) {
            tabs.eq(e.item.index).trigger('click');
        });
        customNav(selector);

        /* Tabs */
        tabs.first().addClass('current');
        content.first().addClass('current');

        tabs.on( 'click', function(){
            var tab_id = $(this).attr('data-tab');
            $(this).siblings().removeClass('current');
            $(this).parents('.ot-tabs').find('.ot-tabs__content').removeClass('current');
            $(this).addClass('current');
            $("#"+tab_id).addClass('current');
            
            selectorSlider.find('.owl-carousel').owlCarousel({
                rtl: rtl_owl(),
                items: 1,
                autoplay: false,
                loop: false,
                dots: true,
                nav: false,
                dotsClass: 'owl-dots ot-custom-dots',
                responsive : {}
            }).trigger('to.owl.carousel', [$(this).index(), 300]);
        });
    });

    $('.ot-project-slider.with-title').each( function () {
        var selector       = $(this);

        selector.find('.owl-carousel').owlCarousel({
            rtl: rtl_owl(),
            autoplay: false,
            loop: false,
            responsiveClass:true,
            dotsClass: 'owl-dots ot-custom-dots',
            dots: false,
            responsive : {
                0 : {
                    items: 1,
                    margin: 30,
                },
                768 : {
                    items: 2,
                    margin: 60,
                },
                1024 : {
                    items: 2,
                    margin: 130,
                }
            }
        });

        /* Custom Navigation Events */ 
        customNav(selector);

        /* popup gallery */
        if( selector.hasClass('img-popup') ){
            $('.img-popup').lightGallery({
                selector: '.projects-thumbnail',
                share: false,
                pager: false,
                thumbnail: false
            });
        }
    });

    function customNav(selector){
        var customNav   = selector.find('.custom-nav'),
            otOwl       = selector.find('.owl-carousel');
        if( customNav.length > 0 ){
            /* Go to the next item */
            customNav.find('.owl-next').on("click", function () {
                otOwl.trigger('next.owl.carousel', [300]);
            });
            /* Go to the previous item */
            customNav.find('.owl-prev').on("click", function () {
                otOwl.trigger('prev.owl.carousel', [300]);
            });  
        }
        return false;
    }


    /* --------------------------------------------------
    * related projects
    * --------------------------------------------------*/
     $(".portfolio-related-posts").owlCarousel({
            rtl: rtl_owl(),
            autoplay: true,
            loop: false,
            dotsClass: 'owl-dots ot-custom-dots',
            dots: false,
            nav: false,
            navText:['<i class="ot-flaticon-left-arrow"></i>', '<i class="ot-flaticon-right-arrow"></i>'],
            responsive : {
                0 : {
                    items: 1,
                    margin: 0,
                },
                768 : {
                    items: 2,
                    margin: 30,
                },
                1024 : {
                    items: 3,
                    margin: 30,
                }
            }
        });

    /* popup gallery */
    if( $(".portfolio-related-posts").hasClass('img-popup') ){
        $('.img-popup').lightGallery({
            selector: '.projects-thumbnail',
            share: false,
            pager: false,
            thumbnail: false
        });
    }

        /* product */
     $('.single-product').owlCarousel({
        items: 1,
        loop: true,
        dots: false,
        callbacks: true,
        URLhashListener: true,
        autoplayHoverPause: true,
        startPosition: 'URLHash'
    });

    $('.single-product').lightGallery({
        selector: '.link-image-action',
        share: false,
        pager: false,
        thumbnail: false
    });

	/* --------------------------------------------------
    * popup video
    * --------------------------------------------------*/
  	var video_popup = $('.video-popup');
   	if (video_popup.length > 0 ) {
	   	video_popup.each( function(){
		   	$(this).lightGallery({
			   selector: '.btn-play',
		   	});
	   	});
   	};

    /* --------------------------------------------------
    * back to top
    * --------------------------------------------------*/
    if ($('#back-to-top').length) {
	    var scrollTrigger = 500, // px
	        backToTop = function () {
	            var scrollTop = $(window).scrollTop();
	            if (scrollTop > scrollTrigger) {
	                $('#back-to-top').addClass('show');
	            } else {
	                $('#back-to-top').removeClass('show');
	            }
	        };
	    backToTop();
	    $(window).on('scroll', function () {
	        backToTop();
	    });
	    $('#back-to-top').on('click', function (e) {
	        e.preventDefault();
	        $('html,body').animate({
	            scrollTop: 0
	        }, 700);
	    });	
	}

    /* Particles */
    $(window).load( function () {
        $('.particles-js').each(function () {
            var s_id = $( this ).data('id'),
                s_color = $( this ).data('color'),
                s_color = s_color.replace(/\s/g, ''),
                e = $('<div class="progrisaas-particles"></div>');
            $( this ).append(e);    
            e.attr('id', 'particles-' + s_id );

            var id = 'particles-' + s_id;
            var color_type = 'random_colors';
            var color = s_color;
            var color_line = '#fff';
            var number = 8;
            var lines = false;
            if (color_type == 'random_colors') {
                color = color.split(',');
                color_line = color[0]
            }
            
            particlesJS(
                id, {
                    "particles":{
                        "number":{
                            "value":number,
                            "density":{
                                "enable":true,
                                "value_area":800
                            }
                        },
                        "color":{
                            "value": color
                        },
                        "shape":{
                            "type":'circle',
                            "polygon":{
                                "nb_sides":6
                            },
                        },
                        "opacity":{
                            "value":1,
                            "random":true,
                            "anim":{
                                "enable":false,
                                "speed":1,
                                "opacity_min":1,
                                "sync":false
                            }
                        },
                        "size":{
                            "value":5,
                            "random":true,
                            "anim":{
                                "enable":false,
                                "speed":30,
                                "size_min": 1,
                                "sync":false
                            }
                        },
                        "line_linked":{
                            "enable":false,
                            "distance":150,
                            "color":color_line,
                            "opacity":0,
                            "width":1
                        },
                        "move":{
                            "enable":true,
                            "speed":2,
                            "direction":"none",
                            "random":false,
                            "straight":false,
                            "out_mode":"out",
                            "bounce":false,
                            "attract":{
                                "enable":false,
                                "rotateX":600,
                                "rotateY":1200
                            }
                        }
                    },
                    "interactivity":{
                        "detect_on":"canvas",
                        "events":{
                            "onhover":{
                                "enable":true,
                                "mode":'grab'
                            },
                            "onclick":{
                                "enable":true,
                                "mode":"push"
                            },
                            "resize":true
                        },
                        "modes":{
                            "grab":{
                                "distance":150,
                                "line_linked":{
                                    "opacity":1
                                }
                            },
                            "bubble":{
                                "distance":200,
                                "size":3.2,
                                "duration":20,
                                "opacity":1,
                                "speed":30
                            },
                            "repulse":{
                                "distance":80,
                                "duration":0.4
                            },
                            "push":{"particles_nb":4},
                            "remove":{"particles_nb":2}
                        }
                    },
                    "retina_detect":true
                });
            var update;
            update = function() {
                requestAnimationFrame(update); 
            }; 
            requestAnimationFrame(update);
        });
    });


    /* --------------------------------------------------
    * filter projects
    * --------------------------------------------------*/
	function updateFilter() {
    $(window).load( function () {
		$('.project_filters a').each(function() {
			var data_filter = this.getAttribute('data-filter');
			var num = $(this)
				.closest('.project-filter-wrapper')
				.find('.project-item')
				.filter(data_filter).length;
			$(this)
				.find('.filter-count')
				.text( num );
			if ( num != 0 && $(this).hasClass('empty') ) {
				$(this).removeClass('empty');
			}
		});
    });
	}

    $(window).load( function () {
    $('.project-filter-wrapper').each( function(){
		var $container = $(this).find('.projects-grid'); 
		$container.isotope({ 
			itemSelector : '.project-item', 
			animationEngine : 'css',
			masonry: {
				columnWidth: '.grid-sizer'
			},
			isOriginLeft: rtl_isotop(),
		});

		var $optionSets  = $(this).find('.project_filters'),
			$optionLinks = $optionSets.find('a');

		$optionLinks.on('click', function(){
			var $this = $(this);

			if ( $this.hasClass('selected') ) {
				return false;
			}
			var $optionSet = $this.parents('.project_filters');
				$optionSet.find('.selected').removeClass('selected');
				$this.addClass('selected');

			var selector = $(this).attr('data-filter');
				$container.isotope({ 
					filter: selector 
				});
			return false;
		});
        /* popup gallery */
        if( $container.hasClass('img-popup') ){
            $('.img-popup').lightGallery({
                selector: '.projects-thumbnail',
                share: false,
                pager: false,
                thumbnail: false
            });
        }
		/* count filters */
		updateFilter();
	});
    });

	/* load more button */    
	$('#btn-loadmore').on('click',function(){
		var btn		= $(this),
			grid    = $(this).parents('.project-filter-wrapper').find('.projects-grid'),
			offset  = grid.find('.project-item').length,
			more    = grid.data('load'),
			loaded  = $(this).data('loaded'),
			loading = $(this).data('loading'),
			cat 	= $(this).data('category'),
			count   = grid.data('count');
		$.ajax({
			url : progrisaas_loadmore_params.ajaxurl, // AJAX handler
			data : {
				'action': 'loadmore', // the parameter for admin-ajax.php
				'ppp'	: more,
				'cat'	: cat,
				'offset': offset,
			},
			type : 'POST',
			beforeSend : function ( xhr ) {
				btn.text(loading).append('<i class="ot-flaticon-refresh fas fa-spin"></i>'); // some type of preloader
			},
			success : function( data ){
				if( data ) {
					var items = $(data);
					btn.text(loaded);
					grid.append(items).isotope('appended', items); // insert new posts
					updateFilter();
				} else {
					btn.hide(); // if no data, HIDE the button as well
				}
			}
		});
		offset += more;
		if( count <= offset ){
			btn.fadeOut(1000);
		}
		return false;
	});

} )( jQuery );



