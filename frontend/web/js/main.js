(function($) {
    "use strict";
    $(function(){
        // BACK TOP
        $('#back-top a').on('click', function () {
            $('body,html').animate({
                scrollTop: 0
            }, 700);
            return false;
        });
        // -------------------------------------//

        // SHOW BUTTON BACK TOP WHEN SCROLL DOWN
        var temp = $(window).height();
        $(window).scroll(function () {
            if ($(window).scrollTop() > (temp / 8)){
                $('#back-top a').addClass('show');
                $('#back-top a').removeClass('hide');
            }
            else {
                $('#back-top a').addClass('hide');
                $('#back-top a').removeClass('show');
            }
        });
        // -------------------------------------//

        // WOW JS
        new WOW().init();
        // -------------------------------------//

        // CHANGE SELECTBOX
        $(".selectbox").selectbox();
        // -------------------------------------//

        // SHOW - HIDE - BOX SEARCH ON MENU
        $('.button-search').on('click', function () {
            $('.nav-search').toggleClass('hide');
        });
        $('.program-tab-trigger').on('click', function () {
            $('#program-tab').toggleClass('view-more');
        });
        $('.univ-description-trigger').on('click', function () {
            $('.univ-description').toggleClass('view-more');
        });
        // HIDE BOX SEARCH WHEN CLICK OUTSIDE
        if ($(window).width() > 767){
            $('body').on('click', function (event) {
                if ($('.button-search').has(event.target).length == 0 && !$('.button-search').is(event.target)
                    && $('.nav-search').has(event.target).length == 0 && !$('.nav-search').is(event.target)) {
                    if ($('.nav-search').hasClass('hide') == false) {
                        $('.nav-search').toggleClass('hide');
                    };
                }
            });
        }
        // -------------------------------------//

        // HEADER FIXED WHEN SCROLL
        if ($('.header-main').hasClass('homepage-01')) {
            if ($(window).width() > 767) {
                var topmenu = $(".header-topbar").height();

                $(window).scroll(function () {
                    if ($(window).scrollTop() > topmenu) {
                        $(".header-main.homepage-01").addClass('header-fixed');
                        $("body").addClass('fix-header');
                    }
                    else {
                        $(".header-main.homepage-01").removeClass('header-fixed');
                        $("body").removeClass('fix-header');
                    };
                });
            }
            else {
                var offset = 117;

                $(window).scroll(function () {
                    if ($(window).scrollTop() > offset) {
                        $(".header-main.homepage-01").addClass('header-fixed');
                    }
                    else {
                        $(".header-main.homepage-01").removeClass('header-fixed');
                    }
                });
            }
        }
        else if ($('.header-main').hasClass('homepage-02')) {
            var $topmenu = $(".choose-course-2"),
                offset = $topmenu.offset();

            $(window).scroll(function () {
                if ($(window).scrollTop() > offset.top - 1) {
                    $(".header-main.homepage-02").addClass('header-fixed');
                }
                else {
                    $(".header-main.homepage-02").removeClass('header-fixed');
                }
            });

            // button scroll
            $('.arrow-down').click(function () {
                $('html, body').animate({
                    scrollTop: $(".choose-course-2").offset().top
                }, 1000);
            });
        }
        else if ($('.header-main').hasClass('homepage-03')) {
            var $topmenu = $(".section.slider-banner-03"),
                offset = $topmenu.offset();

            $(window).scroll(function () {
                if ($(window).scrollTop() > offset.top) {
                    $(".header-main.homepage-03").addClass('header-fixed');
                }
                else {
                    $(".header-main.homepage-03").removeClass('header-fixed');
                }
            });
        }
        // -------------------------------------//

        // SHOW HIDE MENU WHEN SCROLL DOWN - UP
        if ($(window).width() <= 1024) {
            var lastScroll = 50;
            $(window).scroll(function (event) {
                //Sets the current scroll position
                var st = $(this).scrollTop();
                //Determines up-or-down scrolling
                if (st > lastScroll) {
                    //Replace this with your function call for downward-scrolling
                    $('.header-main').addClass('hide-menu');
                }
                else {
                    //Replace this with your function call for upward-scrolling
                    $('.header-main').removeClass('hide-menu');
                }

                if ($(window).scrollTop() == 0 ){
                    $('.header-main').removeClass('.header-fixed').removeClass('hide-menu');
                };
                //Updates scroll position
                lastScroll = st;
            });
        }
        $(window).scroll(function (event) {
            // hide dropdown menu when scroll
            if ($('.navbar-collapse').hasClass('in')) {
                $('.edugate-navbar').click();
            }

            // overflow scroll when screen small
            if ($(window).scrollTop() < 52) {
                var screen_height = $(window).height() - $('.header-main').height() - $('.header-topbar').height(),
                    navigation = $('.navigation').height();
                $('.navigation').css('max-height', screen_height - 20);
                if (navigation > screen_height) {
                    $('.navigation').addClass('scroll-nav');
                }
            }
            else {
                var screen_height = $(window).height() - $('.header-main').height(),
                    navigation = $('.navigation').height();
                $('.navigation').css('max-height', screen_height - 30);
                if (navigation > screen_height) {
                    $('.navigation').addClass('scroll-nav');
                }
            }

            // close dropdown sub menu
            var st2 = $(this).scrollTop();
            if (st2 > 0) {
                //Replace this with your function call for downward-scrolling
                $('.navigation').find('.dropdown').removeClass('open');
            };

      //      var filter = $('.panel-black');
    //        var courseHeaders = $('.course-list-header');
  //          var ads = $('.right-side-addblocks');
//            var courseBody = $('.course-list-body');

            //if($(window).scrollTop() > 100) {
                //filter.addClass('fixed-filter');
                //courseHeaders.addClass('course-header-fixed');
                //courseBody.addClass('course-body-fix');
              //  ads.addClass('ads-fixed');
            //} else {
               // filter.removeClass('fixed-filter');
               // courseHeaders.removeClass('course-header-fixed');
           //     courseBody.removeClass('course-body-fix');
             //   ads.removeClass('ads-fixed');
            //}

        });
        // show hide dropdown menu
        if ($(window).width() <= 767) {
            $('.nav-links>.dropdown>a').on('click', function(){
                if ($(this).parent().find('.edugate-dropdown-menu-1').hasClass('dropdown-focus') == true) {
                    $(this).parent().find('.edugate-dropdown-menu-1').removeClass('dropdown-focus');
                }
                else {
                    $('.nav-links .dropdown .edugate-dropdown-menu-1').removeClass('dropdown-focus');
                    $(this).parent().find('.edugate-dropdown-menu-1').addClass('dropdown-focus');
                }
            });
            $('.edugate-dropdown-menu-1 .dropdown>a').on('click', function(){
                $(this).parent().find('.edugate-dropdown-menu-2:first').toggleClass('dropdown-focus');
            });

            $('body').click(function (event) {
                if ( $('.nav-links').has(event.target).length == 0 && !$('.nav-links').is(event.target)) {
                    if ($('.dropdown-menu').hasClass('dropdown-focus')) {
                        $('.dropdown-menu').removeClass('dropdown-focus');
                    }
                }

                if (
                    $('.edugate-navbar').has(event.target).length == 0 && !$('.edugate-navbar').is(event.target)
                    && $('.navigation').has(event.target).length == 0 && !$('.navigation').is(event.target)
                ) {
                    if ($('.navbar-collapse').hasClass('in')) {
                        $('.edugate-navbar').click();
                    }
                }
            });
        }

        // -------------------------------------//
        // THEME SETTING
        $('.theme-setting > a.btn-theme-setting').on('click', function(){
            if($('.theme-setting').css('left') < '0'){
                $('.theme-setting').css('left', '0');
            } else {
                $('.theme-setting').css('left', '-220px');
            }
        });

        var list_color = $('.theme-setting > .content-theme-setting > ul.color-skins > li');

        var setTheme = function (color) {
            $('#color-skins').attr('href', 'assets/css/'+ color + '.css');
            $('.logo .header-logo img').attr('src', 'assets/images/logo-' + color + '.png');
            setTimeout(function(){
                $('.theme-loading').hide();
            }, 1000);
        };

        list_color.on('click', function() {
            list_color.removeClass("active");
            $(this).addClass("active");
            $('.theme-loading').show();
            setTheme($(this).attr('data-color'));
            Cookies.set('color-skin', $(this).attr('data-color'));
        });
    });

    // set height and width
    var shw_set_height_width = function() {
        // set width for section search
        $('.search-input .form-input').width($('.container').width() - ($('.form-select').width()*3) - 115 );

        if ($(window).width() > 767) {
            // slider banner 1
            $('.slider-banner').height($(window).height() - $('header').height() + 1);
            $('.slider-banner .slider-item').height($(window).height() - $('header').height() + 1);
            // slider banner 3
            $('.slider-banner-03').height($(window).height() - $('header').height() + 1);
        }

        // set height for page 03
        var height_page03 = $('.choose-course-3 .item-course').height();
        $('.choose-course-3').find('.item-course').height( height_page03);

    };

    // owl carousel for ....
    var shw_slider_carousel = function() {
         // owl carousel slider banner
        $('.slider-banner').owlCarousel({
            margin: 0,
            loop: true,
            //lazyLoad: true,
            animateOut: 'fadeOut',
            animateIn: 'fadeIn',
            nav: false,
            responsiveClass: true,
            autoplay:true,
            autoplayTimeout: 7000,
            smartSpeed: 800,
            responsive: {
                0: {
                    items: 1
                },
                1024: {
                    items: 1
                }
            }
        });
        // owl carousel slider artical
        $('.notification-slider').owlCarousel({
            animateIn: 'fadeIn',
            animateOut: 'fadeOut',
            loop: true,
            //lazyLoad: true,
            nav: true,
            responsiveClass: true,
            autoplay:true,
            autoplayTimeout: 10000,
            smartSpeed: 1500,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 1
                },
                1199: {
                    items: 1
                }
            }
        });
        // owl carousel slider artical
        $('.slider-home-artical').owlCarousel({
            margin: 20,
            loop: true,
            animateOut: 'fadeOut',
            animateTimeout: 9000,
            animateIn: 'fadeIn',
            nav: true,
            autoplay:true,
            autoplayTimeout: 7000,
            smartSpeed: 800,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 3
                }
            }
        });
        
        // owl carousel slider artical
        $('.video-slider').owlCarousel({
            margin: 30,
            loop: true,
            animateOut: 'fadeOut',
            animateTimeout: 9000,
            animateIn: 'fadeIn',
            nav: true,
            autoplay:true,
            autoplayTimeout: 7000,
            smartSpeed: 800,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 4
                }
            }
        });
        // owl carousel slider packages
        $('.package-slide').owlCarousel({
            margin: 10,
            loop: true,
            animateOut: 'fadeOut',
            animateTimeout: 9000,
            animateIn: 'fadeIn',
            nav: true,
            autoplay:true,
            autoplayTimeout: 7000,
            smartSpeed: 800,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 3
                }
            }
        });
        // owl carousel slider packages
        $('.other-packages').owlCarousel({
            margin: 20,
            loop: true,
            animateOut: 'fadeOut',
            animateTimeout: 9000,
            animateIn: 'fadeIn',
            nav: true,
            autoplay:true,
            autoplayTimeout: 7000,
            smartSpeed: 800,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 3
                }
            }
        });

         // owl carousel event-detail-list-staff
        $('.event-detail-list-staff').owlCarousel({
            margin: 30,
            loop: true,
            nav: false,
            responsiveClass: true,
            autoplay:true,
            autoplayTimeout: 7000,
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 2
                },
                600: {
                    items: 2
                },
                768: {
                    items: 3,
                    margin: 15
                },
                1024: {
                    items: 3
                }
            }
        });

        // owl carousel top courses
        $('.top-courses-slider').owlCarousel({
            margin: 30,
            loop: true,
            nav: false,
            responsiveClass: true,
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1
                },
                1024: {
                    items: 1
                },
                1025: {
                    items: 2
                }
            }
        });
        // button click slider top courses
        $('.group-btn-top-courses-slider .btn-prev').on('click', function(){
            $('.top-courses-slider .owl-prev').click();
        });
        $('.group-btn-top-courses-slider .btn-next').on('click', function(){
            $('.top-courses-slider .owl-next').click();
        });

        // owl carousel slider logos
        $('.carousel-logos').owlCarousel({
            margin: 115,
            loop: true,
            //lazyLoad: true,
            nav: false,
            autoplay:true,
            autoplayTimeout: 5000,
            smartSpeed: 1500,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                    margin: 30,
                },
                320: {
                    items: 3,
                    margin: 40,
                },
                480: {
                    items: 3,
                    margin: 50,
                },
                600: {
                    items: 4,
                    margin: 90,
                },
                768: {
                    items: 5,
                    margin: 60,
                },
                1024: {
                    items: 5,
                    margin: 90,
                },
                1025: {
                    items: 6
                }
            }
        });

        // owl carousel slider best staff
        $('.best-staff-content').owlCarousel({
            margin: 30,
            loop: true,
            nav: false,
            responsiveClass: true,
            //autoplay:true,
            autoplayTimeout: 5000,
            smartSpeed: 1000,
            responsive: {
                0: {
                    items: 1,
                    margin: 15,
                },
                400: {
                    items: 2,
                    margin: 15,
                },
                768: {
                    items: 3
                },
                1024: {
                    items: 3
                },
                1025: {
                    items: 4
                }
            }
        });
        $('.university-logos-slider').owlCarousel({
                margin: 0,
                loop: true,
                nav: false,
                responsiveClass: true,
                autoplay:true,
                autoplayTimeout: 7000,
                smartSpeed: 800,
                responsive: {
                    0: {
                        items: 3,
                        margin: 0
                    },
                    480: {
                        items: 3,
                        margin: 30,
                    },
                    600: {
                        items: 2,
                        margin: 30,
                    },
                    767: {
                        items: 3,
                        margin: 30,
                    }
                }
                });
        $('.consultants-slider').owlCarousel({
                margin: 0,
                animateIn: 'fadeIn',
                animateOut: 'fadeOut',
                animateTimeout: 5000,
                loop: true,
                nav: true,
                responsiveClass: true,
                autoplay:true,
                autoplayTimeout: 7000,
                smartSpeed: 800,
                responsive: {
                    0: {
                        items: 1
                    },
                    480: {
                        items: 1
                    },
                    600: {
                        items: 1
                    },
                    767: {
                        items: 1
                    }
                }
                });
        // button click slider best staff
        $('.best-staff .group-btn-slider .btn-prev').on('click', function(){
            $('.best-staff .owl-prev').click();
        });
        $('.best-staff .group-btn-slider .btn-next').on('click', function(){
            $('.best-staff .owl-next').click();
        });

        // responsive for section pricing when screen < 768
        if ($(window).width() <= 768){
            $('.pricing-wrapper').owlCarousel({
                margin: 15,
                loop: true,
                nav: false,
                responsiveClass: true,
                smartSpeed: 1000,
                responsive: {
                    0: {
                        items: 1,
                        margin: 0,
                    },
                    636: {
                        items: 2
                    },
                    768: {
                        items: 2
                    }
                }
            });

            $('.event-detail-content .row').owlCarousel({
                margin: 15,
                loop: true,
                nav: false,
                responsiveClass: true,
                smartSpeed: 1000,
                responsive: {
                    0: {
                        items: 1,
                        margin: 0
                    },
                    768: {
                        items: 2
                    }
                }
            });
			$('.package-card-block').owlCarousel({
                margin: 15,
                loop: true,
                nav: false,
                responsiveClass: true,
                smartSpeed: 1000,
                responsive: {
                    0: {
                        items: 1,
                    },
                    768: {
                        items: 1
                    }
                }
            });
        };
        // button click slider
        $('.pricing .group-btn-slider .btn-prev').on('click', function(){
            $('.pricing-wrapper .owl-prev').click();
        });
        $('.pricing .group-btn-slider .btn-next').on('click', function(){
            $('.pricing-wrapper .owl-next').click();
        });

        
    };

    // Responsive for table
    var shw_responsive_table = function() {
        $(".table-body").scroll(function ()
        {
            $(".table-header").offset({ left: -1*this.scrollLeft + 15});
        });

        $(".course-table").height($(".inner-container").height());
        $(".course-table").width($(".inner-container").width());
    };

    $(document).ready(function() {
        shw_set_height_width();

    });

    $(window).load(function() {
        shw_slider_carousel();
        shw_responsive_table();

    });

    $(window).resize(function() {
        shw_set_height_width();
    });

})(jQuery);

window.onload = function() {
    if($('#btn-send-contact-query').length > 0) {
        $('#btn-send-contact-query').click(onBtnSendContactQueryClick);
    }
    // University index page
    if($('.university-index').length > 0) {
        $('#university-filter-form').click(onUniversityFilterFormClick);
        $('.search-keywords label').click(onFilterLabelsClick);
        $('.filter-select').change(onDegreeChange);
        $('#searchbykeyword').change(onUniversityFilterFormClick); /* @created by - Pankaj, for search keyword ****/
         loadInitialFilters();
    }
    // Course index page
    if($('.course-index').length > 0) {
        $('#university-filter-form').click(onUniversityFilterFormClick);
        $('.search-keywords label').click(onFilterLabelsClick);
        $('.filter-select').change(onDegreeChange);
        $('.program-title').click(onProgramTitleClick);
        $('.course-apply').click(onBtnCourseApplyClick);
        $('#searchbykeyword').change(onUniversityFilterFormClick);
        loadInitialFilters();
    }
    // University view page
    if($('.btn-review').length > 0) {
        $('.btn-review').click(onBtnReviewClick);
        $('.btn-rating').click(onBtnRatingClick);
    }
    if($('.btn-favourites').length > 0) {
        $('.btn-favourites').click(onBtnFavourtitesClick);
        $('.program-tabs').on('shown.bs.tab', onProgramTabClick);
    }

    // Course view page
    if($('.btn-course-review').length > 0) {
        $('.btn-course-review').click(onBtnCourseReviewClick);
        $('.btn-course-rating').click(onBtnCourseRatingClick);
        $('.btn-course-favourite').click(onBtnCourseFavouriteClick);

    }

    // student profile
    if ($('.student-profile-main').length > 0) {
        $('.btn-update').click(onBtnUpdateClick);
    }

    //Counselling page
    if($('.counselling-required').length > 0) {
        $('.counselling-required').click(onConsellingSessionChange);
        $('#counsellor').change(onCounsellorChange);
        $('#counsellor_date').on('blur', onCounsellorChange);
        $('#counsellor-time').click(onSlotSelect);
        $('.btn-book').click(onBtnBookClick);
    }

    if($('.skill-content').length > 0) {
        onConsultantProfileLoad();
    }

    $('#login-modal').click(onLoginModalClick);
    $('#login-modal').on('shown.bs.modal', onLoginModalShow);

    if($('.center').length > 0) {
        initSlick();
    }

    //packages view
    if($('.btn-application-buy').length > 0) {
        $('.btn-application-buy').click(onBtnBuyFreeApplicationPackageClick);
    }

    if($('.btn-unlist-course').length > 0) {
        $('.btn-unlist-course').click(removeFromShortlist);
        $('.btn-apply').click(applyToCourseClick);
    }

    if($('.dashboard-checklist .list-group-item.disabled a').length > 0) {
        $('.dashboard-checklist .list-group-item.disabled a').click(function() {
            return false;
        })
    }

    if($('.btn-remove-from-favourites').length > 0) {
        $('.btn-remove-from-favourites').click(removeUniversityFromFavourites);
    }

    if($('.btn-add-document').length > 0) {
        $('.btn-add-document').click(onShowDocumentsModalClick);
        $('.btn-download-all').click(onBtnDownloadAllClick);
    }
    // package offerings page.
    if ($('.package-offerings').length > 0) {
        $('.btn-buy').click(onBuyButtonClick);
    }
    if ($('.package-select-consultant').length > 0) {
        $('.btn-confirm').click(onBtnConfirmPackageClick);
    }
    if(typeof initCalendar !== 'undefined') {
        initCalendar();
    }
    if(typeof establishSockets !== 'undefined') {
        establishSockets();
    }
    if(typeof initVideo !== 'undefined') {
        initVideo();
    }
}

function onLoginModalClick(e) {
    if ($(e.target).hasClass('btn-submit-review')) {
        onBtnSubmitReviewClick(e);
    }
    if ($(e.target).hasClass('btn-submit-course-review')) {
        onBtnSubmitCourseReviewClick(e);
    }
}

$(document).ready(function() {
    $('.btn-login').click(function(){
        $('#modal-container').html('<div class="body-2 loading" style="width: 100%; height: 100%;"><div class="dots-loader"></div></div>');
        $('#modal-container').load($(this).attr('value'));
    });
    $("button.form-tigger").click(function(){
        $(".search-form-univ").addClass("open-form");
        $(".form-tigger-block").addClass("close-tab");
    });

     $('label.radio-banner').click(function () {
        $('label.radio-banner').removeClass('checked');
        $(this).addClass('checked');
    });

    $('label.radio-banner:checked').parent().addClass('checked');
    
    
     $('label.login-radio').click(function () {
        $('label.login-radio').removeClass('active');
        $(this).addClass('active');
    });

    $('label.login-radio:checked').parent().addClass('active');
    
     $('label.filter-option').click(function () {
        $('label.filter-option').parent().parent().removeClass('checked');
        $(this).parent().parent().addClass('checked');
    });

    $('label.filter-option:checked').parent().parent().addClass('checked');

    $(".option :checkbox").on('click', function(){
        $(this).parent().parent().parent().toggleClass("checked");
    });
    $(".option :checkbox").on('click', function(){
        $(this).parent().parent().parent().toggleClass("checked");
    });
    $(".field-userlogin-agree :checkbox").on('click', function(){
        $(this).parent().parent().parent().toggleClass("checked");
    });
    $(".partner-univ-toggle :checkbox").on('click', function(){
        $(this).parent().toggleClass("checked");
    });
     
    
    $('#region').typeahead({
        ajax: '/home-search/search-regions'
    });
    $('#course').typeahead({
        ajax: '/home-search/search-majors'
    });

    $('.banner-search-btn').click(function(e) {
        var region = $('#region').val();
        var course = $('#course').val();
        var degreeLevel = $('input[type="radio"]:checked').val();
        if(region==''&&course==''){
            $('.banner-search-btn').attr('href',encodeURI('/programs/' + degreeLevel.toLowerCase()));
        }else if(course==''){
            if(region==''){
                region = 'all';
            }
            $('.banner-search-btn').attr('href',encodeURI('/programs/' + degreeLevel.toLowerCase() + '/' + region.toLowerCase())); 
        }else{
            if(region==''){
                region = 'all';
            }
            $('.banner-search-btn').attr('href',encodeURI('/programs/' + degreeLevel.toLowerCase() + '/' + region.toLowerCase() + '/' + course.toLowerCase()));            
        }
        return true;
    });
            // -------------------------------------//
        // SET WIDTH - HEIGHT FOR LOADING
        $('.body-2').width($(window).width());
        $('.body-2').height($(window).height());
        // LOADING FOR HOMEPAGE
        $('.body-2').removeClass('loading');
        $('.body-2').addClass('loaded');
});

function onLoginModalShow() {
    var url = $(this).find('#login-redirect-url');
    if(url.length != 0) {
        var str = window.location.search;
        str = str.replace('?r=', '');
        url.val(str);
    }
}

function onConsellingSessionChange(e) {
    $('#consellor-modal').modal('show');
    $('#srm-id').val($(this).attr('data-srm'));
}



function onBtnBookClick(e) {
    var name = $('#srm-id').val();
    var date = $('#counsellor-date').val();
    var time = $('.time-slots.selected').html();

    if(date === '' || date === undefined || date === null) {
        alert('Please select date');
        return false;
    }
    if(time === '' || time === undefined || time === null) {
        alert('Please select time');
        return false;
    }

    $.ajax({
        url: '/site/register-for-free-counselling-session',
        method: 'POST',
        data: {
            'srm-id': name,
            'start': $('.time-slots.selected').attr('data-start'),
            'end': $('.time-slots.selected').attr('data-end'),
            'skype-id': $('#skype-id').val()
        },
        success: function(responseText) {
           var response = JSON.parse(responseText);
           if(response.status === 'success') {
               window.location.reload();
           } else {
               alert('Error');
               console.log(response.error);
           }
        },
        error: function(error) {
            alert('Error');
        }
    })
    $('#consellor-modal').modal('hide');

}

function onCounsellorChange(e) {
    var date = new Date();
    var dateString = $('#counsellor-date').val();
    dateString = dateString.split('-');
    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    date.setDate(Number(dateString[0]));
    date.setMonth(months.indexOf(dateString[1]));
    date.setFullYear(Number(dateString[2]));
    var selected = $('#srm-id').val();
    date = moment(date).utc().format('YYYY-MM-DD HH:mm:ss');
    if(date !== '') {
        $('#counsellor-time-slots').show();
        $('#counsellor-time').load('/site/councellor-times?srm=' + selected + '&date=' + date, function(responseText, status, xhr){
            if(status !== 'success') {
                $('#counsellor-time').html('<span style="color: red;">Error getting time slots</span>');
            }
            var response = JSON.parse(responseText);
            if(response.status !== 'success') {
                $('#counsellor-time').html('<span style="color: red;">Error getting time slots</span>');
            }

            var start = moment(date).utc();
            var end = moment(date).utc();

            var temp = response.start.split(':');
            start.set({
                'hour': Number(temp[0]),
                'minute': Number(temp[1]),
                'second': Number(temp[2])
            });

            var temp = response.end.split(':');
            end.set({
                'hour': Number(temp[0]),
                'minute': Number(temp[1]),
                'second': Number(temp[2])
            });

            start = start.local();
            start = moment(moment.utc(start).toDate()).local();
            end = moment(moment.utc(end).toDate()).local();
            var slots = [];
            temp = start;
            while(temp < end) {
                var startTime = temp.format('HH:mm');
                var s = moment(temp);
                var sUtc = moment(temp).utc();
                var currentDate = moment();
                temp.add(1, 'h');
                var e = moment(temp);
                var eUtc = moment(temp).utc();
                var endTime = temp.format('HH:mm');
                slots.push({
                    'text': startTime + ' - ' + endTime,
                    'start': sUtc.format('Y-M-D HH:mm:ss'),
                    'end' : eUtc.format('Y-M-D HH:mm:ss'),
                    'valid' : moment(currentDate).isBefore(s, 'minute') && validateTimeSlot(s, e, response.invalidTimes)
                });
            }

            var container = $('#counsellor-time');
            for(var count = 0; count < slots.length; count++) {
                var className = 'time-slots-disabled';
                if(slots[count].valid) {
                    className = 'time-slots';
                }
                container.append('<a class="' + className + '" data-start="' + slots[count].start+ '" data-end="' + slots[count].end+ '">' + slots[count].text + '</a>');
            }
        });
    } else {

    }
}

function onSlotSelect(e) {
    $('.time-slots').removeClass('selected');
    if(e.target.tagName == 'A' && $(e.target).hasClass('time-slots')) {
        var start = e.target.getAttribute('data-start');
        $(this).find('a.time-slots[data-start="' + start + '"]').addClass('selected');
    }
}

function validateTimeSlot(start, end, invalidTimes) {
    for(var count = 0; count < invalidTimes.length; count++) {
        var invalidStart = moment(moment.utc(invalidTimes[count].start).toDate()).local();
        var invalidEnd = moment(moment.utc(invalidTimes[count].end).toDate()).local();
        //((start > '$start' AND end > '$end' AND end < '$start') OR (start > '$start' AND end < '$end') OR (start < '$start' AND end > '$end') OR (start < '$start' AND end > '$start' AND end < '$end'))
        if(start.isBetween(invalidStart, invalidEnd, 'minute') || end.isBetween(invalidStart, invalidEnd, 'minute') || start.isSame(invalidStart, 'minute') || start.isSame(invalidEnd, 'minute') || start.isSame(invalidStart, 'minute') || start.isSame(invalidEnd, 'minute')) {
            return false;
        }
    }
    return true;
}



function termpopup() {
     
    $.ajax({
         url: '/site/termandpolicy',
        method: 'GET', 
        success: function( data) {
            $('#termscontent').html(data); 
            
        },
        error: function(error) {
            console.log(error);
        }
    });  
}

