//constants

var LIMIT_HOURS = 1;

//function initSlick() {
  //  $('.center').slick({
    //    centerMode: true,
      //  slidesToShow: 3,
        //responsive: [{
          //  breakpoint: 768,
            //settings: {
              //  arrows: true,
                //centerMode: true,
                //centerPadding: '40px',
                //slidesToShow: 3
            //}
        //}, {
          //  breakpoint: 480,
           // settings: {
             //   arrows: true,
               // centerMode: true,
                //centerPadding: '40px',
            //slidesToShow: 1
            //}
    //    }]
   // });
//}

function onBtnBuyFreeApplicationPackageClick() {
    var button = $(this);
    var href = $(button).attr('href');

    if(href.indexOf('site/login') > -1) {
        $('#login-modal').modal('show');
        $('#modal-container').load(href);
        return false;
    }
}

function onBuyButtonClick(e) {
    var button = $(this);
    var url = button.attr('data-url');
    var errorContainer = $('.alert-danger');

    if(!errorContainer.hasClass('hidden')) {
        errorContainer.addClass('hidden');
        errorContainer.html('');
    }

    if(url.search('site/login') > -1) {
        $('#login-modal').modal('show');
        $('#modal-container').load(url, function(responseText, status, xhr){
            if(status !== 'success') {
                console.log('Error launching login screen!');
            }
        });
        return;
    }

    var limitType = $('#limit-type').val();
    var limitCount = $('#limit-count').val();

    var selectedOfferings = $('.chk-offering:checked');

    var offerings = [];
    var totalCost = 0;
    var totalTime = 0;

    if(limitType == LIMIT_HOURS) {
        if (selectedOfferings.length == 0) {
            errorContainer.removeClass('hidden');
            errorContainer.html('Please select atleast 1 service.');
            return;
        }
        for(var count = 0; count < selectedOfferings.length; count++) {
            var id = $(selectedOfferings[count]).attr('data-offering');
            var time = $(selectedOfferings[count]).attr('data-time');
            if (time) {
                totalTime += Number(time);
            }
            offerings.push(id);
        }

        var time = totalTime;
        var discountCost = Number($('#five-hour-cost').val());
        var actualCost = Number($('#hour-cost').val());
        while(time >= 5) {
            time = time - 5;
            totalCost += discountCost;
        }
        totalCost += (time * actualCost);
    } else {
        selectedOfferings = $('.chk-offering');
        for(var count = 0; count < selectedOfferings.length; count++) {
            var id = $(selectedOfferings[count]).attr('data-offering');
            offerings.push(id);
        }
        totalTime = 0;
        totalCost = $('#non-hour-cost').val();
    }

    $.ajax({
        url: '/packages/select-package',
        data: {
            offerings: offerings,
            package: $('#package').val(),
            subPackage: $('#sub-package').val(),
            cost: totalCost,
            time: totalTime
        },
        method: 'POST',
        error: function(error) {
            errorContainer.removeClass('hidden');
            errorContainer.html('Error processing request');
        }
    });
}

function onBtnConfirmPackageClick() {
    var button = $(this);
    var errorContainer = $('.alert-danger');
    var selected = $('.rdo-selected:checked');

    if(selected.length == 0) {
        errorContainer.removeClass('hidden');
        errorContainer.html('Please select a consultant');
        return;
    }
    $.ajax({
        url: '/packages/buy',
        data: {
            package: $('#package').val(),
            subPackage: $('#sub-package').val(),
            offerings: $('#offerings').val(),
            cost: $('#total').html(),
            time: $('#time').val(),
            consultant: $(selected).attr('data-consultant')
        },
        method: 'POST',
        error: function(e) {
            errorContainer.removeClass('hidden');
            errorContainer.html('Error processing request');
        },
        success: function(responseText) {
            var response;
            try {
                response = JSON.parse(responseText);
            } catch(e) {
                errorContainer.removeClass('hidden');
                errorContainer.html('Error parsing response.');
            }

            if(response.status === 'success') {
                window.location = '/student/packages';
            } else {
                errorContainer.removeClass('hidden');
                errorContainer.html(response.message);
            }
        }
    });
}