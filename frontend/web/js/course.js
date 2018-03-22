var countries = [];
function onBtnCourseReviewClick() {
    $('#login-modal').modal('show');
    $('#modal-container').load($(this).attr('href'));
    return false;
}

function onBtnCourseRatingClick() {
    $('#login-modal').modal('show');
    $('#modal-container').load($(this).attr('href'));
    return false;
}

function onBtnCourseFavouriteClick() {
    var src = $(this).find('span').html();
    var anchor = $(this);    
    var href = $(this).attr('href');
    if(href.search('site/login') > -1){
        $('#login-modal').modal('show');
        $('#modal-container').load($(this).attr('href'));
    } else {
        var favourite = 0;
        if(src.toLowerCase() == 'follow') {
            favourite = 1;
        }
        $.ajax({
            url: '/course/favourite',
            method: 'POST',
            data: {
                favourite: favourite,
                university: $('#university').val(),
                course: $('#course-id').val(),
            },
            success: function(response, data) {
                response = JSON.parse(response);
                if(response.status == 'success') {
                    if (response.favourite == 1) {
                        anchor.find('span').html('Unfollow');
                        anchor.find('img').attr('src', 'images/unfollow-white.png');
                    }
                    if (response.favourite == 0) {
                        anchor.find('span').html('Follow');
                        anchor.find('img').attr('src', 'images/follow-blue.png');
                    }
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }    
    return false;
}

function onBtnSubmitCourseReviewClick() {
    $.ajax({
        url: '/course/submit-review',
        method: 'POST',
        data: {
            university: $('#university').val(),
            review: $('#review').val(),
            rating: $('#rating').val(),
            course: $('#course').val()
        },
        success: function(response, data) {
            response = JSON.parse(response);
            if(response.status == 'success') {
                $('#login-modal').modal('hide');    
            } else {
                $('#modal-error-container').show();
                $('#modal-error').html('Some error occured');
                setTimeout(function(){
                    $('#modal-error-container').hide();
                }, 3000);
            }           
        },
        error: function(error) {
            console.log(error);
            $('#modal-error-container').show();
            $('#modal-error').html('Some error occured');
            setTimeout(function(){
                $('#modal-error-container').hide();
            }, 3000);
        }
    });
    return false;
}

function onBtnCourseApplyClick(e) { 
    var anchor = $(this);
    var href = $(this).val();
    var course_id = $(this).attr('data-course');
    if(href.search('site/login') > -1){
        oLoaddiv='<div class="loading" style="width: auto; height: auto;"><div class="dots-loader"></div></div>';
        $('#modal-container').html(oLoaddiv);
        $('#login-modal').modal('show');
        $('#modal-container').load($(this).val());
    } else if(href.search('course/shortlist') > -1) {
        $.ajax({
            url: '/course/shortlist',
            method: 'POST',
            success: function (data) {
                
                var response = JSON.parse(data);
                if(response.status == 'success') {
                    anchor.removeClass('add-button');
                    anchor.addClass('added-button');
                    anchor.attr('data-action_val', '1');
                    //$('#hv'+course_id).after('Shortlisted');
                    //button.html('Shortlisted');
                    //button.html('Shortlisted');
                    //$('#icn_pl'+course_id).removeClass('fa-plus');
                    //$('#icn_pl'+course_id).addClass('fa-minus');
                    //button.removeClass('btn-info');
                    //button.addClass('btn-success');
                    //button.attr('href', 'index.php?r=student/student-shortlisted-courses');
                } else if(response.status == 'removed') {
                    anchor.removeClass('added-button');
                    anchor.addClass('add-button');
                    anchor.attr('data-action_val', '0');
                } else {
                    alert(response.message);
                }
            },
            error: function(error) {
                console.log(error);
            },
            data: {
                'course': $(this).attr('data-course'),
                'university': $(this).attr('data-university'),
                'action_val': $(this).attr('data-action_val'),
            },
            cache: false,
        });
    } else {
        return true;
    }
    return false;
}

function onUniversityFilterFormClick(e){
    if(e.target.tagName === 'INPUT' || onUniversityFilterFormClick.filterCleared === true) {
        $('.body-3').removeClass('loaded');
        $('.body-3').addClass('loading');
        delete onUniversityFilterFormClick.filterCleared;
        $('.search-keywords label span').remove();
        
		
        var checked = $('#university-filter-form input:checked');
		
        var params = {};

        var degree = $('.filter-select:checked').val();
        //console.log('degree='+params);
        //console.log('discipline='+degree);
        if(degree != -1) {
            params['degree'] = [degree];
            $('.search-keywords label').append('<span id="span-degree">'+ $('.filter-select option:selected').text() + '<i class="fa fa-times" aria-hidden="true" data-id="degree"></i></span>');
        } else {
            $('#span-degree').remove();
        }

        $.each(checked, function(index, input){
		  // alert(index);
           //alert(input);
		   $('.search-keywords label').append('<span>'+ $(input).siblings().html() + '<i class="fa fa-times" aria-hidden="true" data-id="' + $(input).attr('id') + '"></i></span>');
            var key = $(input).attr('data-key');
			//alert('key part ='+key);
            if(params.hasOwnProperty(key)) {
                params[key].push($(input).val());
            } else {
                params[key] = [$(input).val()];
            }
				console.log(params);
        });

		/**********************
		  @Created By : Pankaj 
		  @use:- search keyword text box append in fillter
		 **************************/
				
				var searchbykeyword = $('#searchbykeyword').val();
				
				if(searchbykeyword != ''){
					params['searchbykeyword'] = [searchbykeyword];	
					$('.search-keywords label').append('<span id="span-searchbykeyword">'+ searchbykeyword + '<i class="fa fa-times" aria-hidden="true" data-id="searchbykeyword"></i></span>');
				}else{
					$('#span-searchbykeyword').remove();
				}
			
		//console.log(params);
		/*end */
        if(params.hasOwnProperty('country') && params['country'].sort().join() != countries) {
            $('#states').load('/course/dependent-states', {countries: params['country']}, function(responseText, status, xhr){
                if(status !== 'success') {
                    // TODO error handling.
                } else {
                    countries = params['country'].sort().join();
                }
                loadCourseList(params);
            });
        } else {
            if(!params.hasOwnProperty('country')) {
                $('#states').empty();
                countries = undefined;
            }
            loadCourseList(params);
        }
			
    }
}

function loadCourseList(params) {
	$('#course-list').html('<div class="body-3 filter-loader"><div class="dots-loader"></div></div>');
    $('#pagin_count').before("<img id='loading' src='images/ajax-loader.gif'/>");
    $('#course-list').load('/course/index', params, function(responseText, status, xhr){

        if(status !== 'success') {
            // TODO error handling.
			$('.course-apply').click(onBtnCourseApplyClick);
        } else {

            $('html, body').animate({scrollTop:$('#set_todiv').position().top}, 'slow');
        }
    });
}

function onFilterLabelsClick(e) {
    if(e.target.tagName === 'I') {
        var id = $(e.target).attr('data-id');
		
		console.log(id);
        if(id.includes('degree')) {
            //$('.filter-select').val(-1);
			 $('label.filter-option').parent().parent().removeClass('checked');
			 $('#' + id).attr('checked', false);
        } else {
            $('#' + id).attr('checked', false);
        }
		if(id === 'searchbykeyword') {
            $('#searchbykeyword').val('');
        } 
        onUniversityFilterFormClick.filterCleared = true;
        $('#university-filter-form').trigger('click', [true]);
    }
}

function onDegreeChange(e) {
    if($(this).val() == -1 ) {
        $('#majors').empty();
    } else {
        $('#majors').load('/course/dependent-majors', {degree: $(this).val()}, function(response, status, xhr){
            if(status !== 'success') {
                // TODO error handling.
            }
        });
    }
    onUniversityFilterFormClick.filterCleared = true;
    $('#university-filter-form').trigger('click', [true]);
}



function loadInitialFilters() {
    var list = $('#university-filter-form input:checked[data-key=country]');
    $.each(list, function(index, input){
        countries.push($(input).val());
    });

    countries = countries.sort().join();
    
    $('.search-keywords label span').remove();
    var checked = $('#university-filter-form input:checked');

    $.each(checked, function(index, input){
        $('.search-keywords label').append('<span>'+ $(input).siblings().html() + '<i class="fa fa-times" aria-hidden="true" data-id="' + $(input).attr('id') + '"></i></span>');
    });

    var degrees = $('.filter-select option:selected');
    $.each(degrees, function(index, option){
        if($(option).val() != -1) {
            $('.search-keywords label').append('<span>'+ $(option).html() + '<i class="fa fa-times" aria-hidden="true" data-id="' + $(option).attr('id') + '"></i></span>');
        }
    });
}

function onProgramTitleClick(e) {
    var arrow = $(this).find('span.toggle-details');
    if(arrow.length > 0) {
        if($(arrow).hasClass('fa-chevron-down')) {
            $(arrow).removeClass('fa-chevron-down');
            $(arrow).addClass('fa-chevron-up');
            $(this).find('.toggle-title').attr('title', 'Collapse');
        } else {
            $(arrow).removeClass('fa-chevron-up');
            $(arrow).addClass('fa-chevron-down');
            $(this).find('.toggle-title').attr('title', 'Expand');
        }
    }
    return true;
}

function pagingcustom(page){
	
	var checked = $('#university-filter-form input:checked');
		console.log(checked);
        var params = {};
        $('body').scrollTop(10);
        $('.body-3').removeClass('loaded');
        $('.body-3').addClass('loading');
        $.each(checked, function(index, input){
            var key = $(input).attr('data-key');
			//alert('key part ='+key);
            if(params.hasOwnProperty(key)) {
                params[key].push($(input).val());
            } else {
                params[key] = [$(input).val()];
            }	
        });
		var degree = $('.filter-select:checked').val();
        if(degree != -1) {
            params['degree'] = [degree];
        }
		/**********************
		  @Created By : Pankaj 
		  @use:- search keyword text box append in fillter
		 **************************/
				
		var searchbykeyword = $('#searchbykeyword').val();
		
		if(searchbykeyword != ''){
			params['searchbykeyword'] = [searchbykeyword];	
		}	
		
		params['page']=page;
		
		
		loadCourseList(params);
		
  console.log(params);
	
	
}