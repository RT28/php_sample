var countries = [];

function initMap() {
    var position = {
        lat: Number(document.getElementById('latitude').value),
        lng: Number(document.getElementById('longitude').value)
    };

    var map = new google.maps.Map(document.getElementById('map'), {
        center: position,
        zoom: 15
    });

    var marker = new google.maps.Marker({
        position: position,
        zoom: 15,
        map: map
    });
}

function onBtnReviewClick() {
    oLoaddiv='<div class="loading" style="width: auto; height: auto;"><div class="dots-loader"></div></div>';
    $('#modal-container').html(oLoaddiv);
    $('#login-modal').modal('show');
    $('#modal-container').load($(this).val());
    return false;
}

function onBtnRatingClick() {
    oLoaddiv='<div class="loading" style="width: auto; height: auto;"><div class="dots-loader"></div></div>';
    $('#modal-container').html(oLoaddiv);
    $('#login-modal').modal('show');
    $('#modal-container').load($(this).val());
    return false;
}

function onBtnFavourtitesClick() { 
    var anchor = $(this);
    var href = $(this).val();
    if(href.search('site/login') > -1){
        oLoaddiv='<div class="loading" style="width: auto; height: auto;"><div class="dots-loader"></div></div>';
        $('#modal-container').html(oLoaddiv);
        $('#login-modal').modal('show');
        $('#modal-container').load($(this).val());
    } else {
        var favourite = 0;
        if(anchor.hasClass('add-button')) {
            favourite = 1;
        }
        $.ajax({
            url: '/university/favourite',
            method: 'POST',
            data: {
                favourite: favourite,
                university: $(this).attr('data-university'),
            },
            success: function(response, data) {
                response = JSON.parse(response);
                if(response.status == 'success') {
                    if (response.favourite == 1) {
                        anchor.removeClass('add-button');
                        anchor.addClass('added-button');
                    }
                    if (response.favourite == 0) {
                        anchor.removeClass('added-button');
                        anchor.addClass('add-button');
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

function onBtnSubmitReviewClick() {
    $.ajax({
        url: '/university/submit-review',
        method: 'POST',
        data: {
            university: $('#university').val(),
            review: $('#review').val(),
            rating: $('#rating').val()
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
        function: function(error) {
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

function onUniversityFilterFormClick(e){
	if(e.target.tagName === 'INPUT' || onUniversityFilterFormClick.filterCleared === true) {
        delete onUniversityFilterFormClick.filterCleared;
        $('.search-keywords label span').remove();
        
        var checked = $('#university-filter-form input:checked');
        var params = {};

        $.each(checked, function(index, input){
            $('.search-keywords label').append('<span>'+ $(input).siblings().html() + '<i class="fa fa-times" aria-hidden="true" data-id="' + $(input).attr('id') + '"></i></span>');
            var key = $(input).attr('data-key');
            if(params.hasOwnProperty(key)) {
                params[key].push($(input).val());
            } else {
                params[key] = [$(input).val()];
            }
        });

        var degree = $('.filter-select:checked').val();
        if(degree != -1) {
            params['degree'] = [degree];
            $('.search-keywords label').append('<span id="span-degree">'+ $('.filter-select option:selected').text() + '<i class="fa fa-times" aria-hidden="true" data-id="degree"></i></span>');
        } else {
            $('#span-degree').remove();
        }
		
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

        if(params.hasOwnProperty('country') && params['country'].sort().join() != countries) {
            $('#states').load('/university/dependent-states', {countries: params['country']}, function(responseText, status, xhr){
                if(status !== 'success') {
                    // TODO error handling.
                } else {
                    countries = params['country'].sort().join();
                }
                loadUniversityList(params);
            });
        } else {
            if(!params.hasOwnProperty('country')) {
                $('#states').empty();
                countries = undefined;
            }
            loadUniversityList(params);
        }
    }
}

function loadUniversityList(params) { 
    $('#university-list').html('<div class="body-3 filter-loader"><div class="dots-loader"></div></div>');
    $('#pagin_count').before("<img id='loading' src='images/ajax-loader.gif'/>");
    $('#pt_detail').remove();
    $('#university-list').load('/university/index', params, function(responseText, status, xhr){ 
        
        if(status == 'success') {
           $('html, body').animate({scrollTop:$('#set_todiv').position().top}, 'slow');
            if ($("#partner_list").hasClass("checked")) {
            $('.search-keywords').after("<div id='pt_detail'>Our expert consultant team provides free admission councelling service for the followup university.</div>");
            } else {
                $('#pt_detail').remove();
                $("#partner_list").removeClass("checked");
            }
        }
        /*if(status !== 'success') {
            // TODO error handling.
        }*/
    });
}

function onFilterLabelsClick(e) {
    if(e.target.tagName === 'I') {
        var id = $(e.target).attr('data-id');
        if(id.includes('degree')) {
            //$('.filter-select').val(-1);
			 $('label.filter-option').parent().parent().removeClass('checked');
			 $('#' + id).attr('checked', false);
        } else {
            $('#' + id).attr('checked', false);
        }
        if(id.includes('partner')) {
            //$('.filter-select').val(-1);
             $("#partner_list").removeClass("checked");
             $('#pt_detail').remove();
        } else {
            $('#pt_detail').remove();
        }
        onUniversityFilterFormClick.filterCleared = true;
        $('#university-filter-form').trigger('click', [true]);
    }
    
    
}

function onDegreeChange(e) {
    if($(this).val() == -1 ) {
        $('#majors').empty();
    } else {
        $('#majors').load('/university/dependent-majors', {degree: $(this).val()}, function(response, status, xhr){
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
}

function onProgramTabClick(e) {
    e.preventDefault();
    var degree = $(this).attr('data-degree');
    var container = '#tab-' + degree;
    var button = $(this);
    var university = $(this).attr('data-university');
    var url = '/university/courses&university=' + university + '&degree=' + degree;
    $(container).load(url, function(responseText, status, xhr){
        if(status !== 'success') {
            alert('Error loading programs for discipline ' + $(button).html);
        }
    });
    $(this).tab('show');    
}

function removeUniversityFromFavourites() {
    var button = $(this);

    var university = $(button).attr('data-university');

    $.ajax({
        url: '/favourite-universities/remove',
        method: 'POST',
        data: {
            university: university
        },
        success: function(responseText) {
            var response = JSON.parse(responseText);

            if(response.status === 'success') {
                window.location.reload();
            } else {
                $('.remove-message').removeClass('hidden');
                $('.remove-message').html(response.message);

            }
        },
        error: function() {
            $('.remove-message').removeClass('hidden');
            $('.remove-message').html('Error removing university from favourites!');
        }
    })
}

/*********************************
 @Created By :- Pankaj
 @Use:- Use for custom pagination
***********************************/

function pagingcustom(page){ 
	
	var checked = $('#university-filter-form input:checked');
        
		console.log(checked);
		$('body').scrollTop(10);
        $('.body-3').removeClass('loaded');
        $('.body-3').addClass('loading');
		var params = {};
	
        $.each(checked, function(index, input){
          
            var key = $(input).attr('data-key');
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
			
		loadUniversityList(params);
	
	
	console.log(params);
}