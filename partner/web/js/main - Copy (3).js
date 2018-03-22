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
        };
        // button click slider
        $('.pricing .group-btn-slider .btn-prev').on('click', function(){
            $('.pricing-wrapper .owl-prev').click();
        });
        $('.pricing .group-btn-slider .btn-next').on('click', function(){
            $('.pricing-wrapper .owl-next').click();
        });

        // Responsive for Progress bar when screen < 767
        if ($(window).width() <= 767){
            $('.progress-bar-wrapper .content').owlCarousel({
                margin: 0,
                loop: true,
                nav: false,
                responsiveClass: true,
                smartSpeed: 1000,
                responsive: {
                    0: {
                        items: 2,
                        margin: 15,
                    },
                    480: {
                        items: 2,
                        margin: 15,
                    },
                    600: {
                        items: 3
                    },
                    767: {
                        items: 3
                    }
                }
            });
        };
        // button click slider
        $('.progress-bars .group-btn-slider .btn-prev').on('click', function(){
            $('.progress-bars .owl-prev').click();
        });
        $('.progress-bars .group-btn-slider .btn-next').on('click', function(){
            $('.progress-bars .owl-next').click();
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

    $(window).load(function() {
        shw_slider_carousel();
        shw_responsive_table();

    });

    $(window).resize(function() {
        shw_set_height_width();
    });

})(jQuery);

$(document).ready(function() {
        //shw_set_height_width();
            // -------------------------------------//
        // SET WIDTH - HEIGHT FOR LOADING
        $('.body-2').width($(window).width());
        $('.body-2').height($(window).height());
        // LOADING FOR HOMEPAGE
        $('.body-2').removeClass('loading');
        $('.body-2').addClass('loaded');

    if($('.consultant-student-view').length > 0) {
       // $('.btn-associate-disconnect').click(disconnectAssociate);
       // $('.btn-associate-connect').click(connectAssociate);
        $('.btn-change-limit').click(changePackageLimit);
    }

    if($('.consultant-dashboard-index').length > 0) {
        $('.btn-disconnect-consultant').click(disconnectConsulant);
    }
	
	 if($('.taskgrid').length > 0) {
        $('.send-reminder').click(sendTaskReminder);
    }
    
     if(initCalendar) {
         initCalendar();
     }
    
    if(establishSockets) {
        establishSockets();
    }
    /*if(initVideo) {
        initVideo();
    }*/
});

function loadPreviewInfoOfPartner(universityId) {
	 var params = {};
	 params['university_id']=universityId;
    $('#partnerPagePreview').load('http://gotouniversity.com/frontend/web/index.php?r=university/preview', params, function(responseText, status, xhr){
        if(status !== 'success') {
            // TODO error handling.
        }
    });
}
function loadTaskView(id) {
	 var params = {};
	 params['id']=id;
    $('#taskPreview').load('http://gotouniversity.com/partner/web/index.php?r=consultant/tasks/view', params, function(responseText, status, xhr){
        if(status !== 'success') {
            // TODO error handling.
        }
    });
}

function loadTaskUpdate(id) {
	
	$.ajax({
             url: '?r=consultant/tasks/update&id='+id,
            method: 'GET', 
            success: function( data) {  
                $('#taskUpdate').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        });  
}

function loadTaskAdd(url) {
	$.ajax({
            url: url,
            method: 'POST',
            success: function( data) {  
                $('#AddTaskPreview').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}


function sendTaskReminder(id) {
	$('#taskreminder'+id).html('<img src="./images/loading.gif"  />'); 
	$.ajax({
             url: '?r=consultant/tasks/reminder&id='+id,
            method: 'GET', 
            success: function(response, data) {
				response = JSON.parse(response); 				
                $('#taskreminder'+id).html(response.message); 
            },
            error: function(error) {
                console.log(error);
            }
        });  
}


function loadAssignSubConsultant(url) {
	$.ajax({
            url: url,
            method: 'POST',
            success: function( data) {  
                $('#SubConsultantPreview').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}

function loadSubConUpdate(id) { 
	
	$.ajax({
             url: '?r=consultant/subconsultant/update&id='+id,
            method: 'GET', 
            success: function( data) {  
                $('#subconsultantUpdate').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        });  
}


function loadassignemployee(url) {
	 
	$.ajax({
            url: url,
            method: 'POST',
            success: function( data) { 
                $('#EmployeePreview').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}

function loadEmployeeUpdate(id) { 
 
	$.ajax({
             url: '?r=consultant/assignemployee/update&id='+id,
            method: 'GET', 
            success: function( data) {   
                $('#employeeUpdate').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        });  
}

function loadAssoEmployeeUpdate(id) { 
 
	$.ajax({
             url: '?r=employee/assignemployee/update&id='+id,
            method: 'GET', 
            success: function( data) {   
                $('#employeeUpdate').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        });  
}

function assignConsultant(url) {
	$.ajax({
            url: url,
            method: 'POST',
            success: function( data) {  
                $('#studentList').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}

/*script for invoice ajax pages author@roan*/
function pendingInvoice(id,task_id){
    var url = "http://localhost/gotouniversity/partner/web/index.php?r=consultant/invoice/create";
    $.ajax({
            url: url,
            method: 'POST',
            data : {id : id , task_id : task_id},
            success: function( data) {
                $('#AddInvoicePreview').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
function loadInvoiceAdd(url) {
    $.ajax({
            url: url,
            method: 'POST',
            success: function( data) {   
                $('#AddInvoicePreview').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
function loadInvoiceUpdate(id) {
    $.ajax({
             url: '?r=consultant/invoice/update&id='+id,
            method: 'GET', 
            success: function( data) {  
                $('#invoiceUpdate').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        });  
}
function loadInvoiceView(id) {
     var params = {};
     params['id']=id;
    $('#taskPreview').load('http://localhost/gotouniversity/partner/web/index.php?r=consultant/invoice/view', params, function(responseText, status, xhr){
        if(status !== 'success') {
            // TODO error handling.
        }
    });
}
/*new followup*/
function loadFollowupView(id) {
     var params = {};
     params['id']=id;
    $('#taskPreview').load('http://localhost/gotouniversity/partner/web/index.php?r=consultant/lead-followup/view', params, function(responseText, status, xhr){
        if(status !== 'success') {
            // TODO error handling.
        }
    });
}

function loadTaskUpdatelead(id) {
    
    $.ajax({
             url: '?r=consultant/lead-followup/update&id='+id,
            method: 'GET', 
            success: function( data) {  
                $('#taskUpdate').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        });  
}

function loadTaskAdd(url) {  
    $.ajax({
            url: url,
            method: 'POST',
            success: function( data) {  
                $('#AddTaskPreview').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
/*end new followup*/
/*univ faq*/
function loadQuestionAdd(url) {
    $.ajax({
            url: url,
            method: 'POST',
            success: function( data) {
                $('#AddInvoicePreview').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
function loadQuestionUpdate(id) {
    $.ajax({
             url: '?r=consultant/universityinfo/update&id='+id,
            method: 'GET', 
            success: function( data) {  
                $('#invoiceUpdate').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        });  
}
function loadFollowupAdd(url) {
    $.ajax({
            url: url,
            method: 'POST',
            success: function( data) {
                $('.modal-body').show();
                $('#AddInvoicePreview').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
function loadEmailenquiryform(url) { alert("fds");
    $.ajax({
            url: url,
            method: 'POST',
            success: function( data) {
                $('#AddInvoicePreview').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
function loadEmailenquiryupdate(url) {
    $.ajax({
            url: '?r=consultant/universityinfo/update&id='+id,
            method: 'GET', 
            success: function( data) {  
                $('#invoiceUpdate').html(data); 
            },
            error: function(error) {
                console.log(error);
            }
        }); 
}
/*script ends------------------------------*/

window.onload = function() {
    
    // student profile
    if ($('.student-profile-main').length > 0) { 
        $('.btn-update').click(onBtnUpdateClick);
    }
	
	  if($('.consultant-student-view').length > 0) {
        $('.btn-add-document').click(onShowDocumentsModalClick);
        $('.btn-download-all').click(onBtnDownloadAllClick);
    }
 
}

function onBtnUpdateClick(e) { 
    var container = $(this).attr('data-container');
    var url = $(this).attr('href');
     
    $('#' + container).load(url,function(response, status, xhr){
        if(status !== 'success') {
            alert('errror');
            console.log(status);
        }
    });

    return false;
} 

function termpopup() {	 	
	$.ajax({		
		url: '?r=site/term',		
		method: 'GET', 		
		success: function( data) {  			
			$('#termscontent').html(data); 					
		},		
			error: function(error) {			
			console.log(error);		
		}	
	});  
}