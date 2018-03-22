<?php
use yii\helpers\Url;
use yii\helpers\Html;
use common\models\University;
use common\models\Student;
use common\models\UniversityCourseList;
use common\models\Advertisement;
use common\components\ConnectionSettings;
use common\models\FreeCounsellingSessions;

/* @var $this yii\web\View */
$this->title = 'Course List';
$this->context->layout = 'index';

$path= ConnectionSettings::BASE_URL.'backend';
$TodayDate = date('Y-m-d');
$this->registerJs("
jQuery(document).ready(function(){
	$('#searchbykeyword').typeahead({
		ajax: '/home-search/search-regions'
    });
}) ;"
);


$this->registerJs("
function noaccent(myString) {
        temp = myString.replace(/[àâä]/g, 'a');
        temp = temp.replace(/[éèêë]/g, 'e');
        temp = temp.replace(/[îï]/g, 'i');
        temp = temp.replace(/[ôö]/g, 'o');
        temp = temp.replace(/[ùûü]/g, 'u');
        temp = myString.replace(/[ÀÂÄ]/g, 'A');
        temp = temp.replace(/[ÉÈÊË]/g, 'E');
        temp = temp.replace(/[ÎÏ]/g, 'I');
        temp = temp.replace(/[ÔÖ]/g, 'O');
        temp = temp.replace(/[ÙÛÜ]/g, 'U');

        return temp;
    }

    $('#dd-filter').keyup(

    function () {
        var filter = noaccent($(this).val()),
            count = 0;
        $('.options-list li.option').each(

        function () {
            if (noaccent($(this).text()).search(new RegExp(filter, 'i')) < 0) {
                $(this).addClass('no-match');
            } else if (!($(this).hasClass('cacheElement'))) {
                $(this).removeClass('no-match');
                count++;
            }
        });
    });
	
	
	
	function noaccent(myString) {
        temp = myString.replace(/[àâä]/g, 'a');
        temp = temp.replace(/[éèêë]/g, 'e');
        temp = temp.replace(/[îï]/g, 'i');
        temp = temp.replace(/[ôö]/g, 'o');
        temp = temp.replace(/[ùûü]/g, 'u');
        temp = myString.replace(/[ÀÂÄ]/g, 'A');
        temp = temp.replace(/[ÉÈÊË]/g, 'E');
        temp = temp.replace(/[ÎÏ]/g, 'I');
        temp = temp.replace(/[ÔÖ]/g, 'O');
        temp = temp.replace(/[ÙÛÜ]/g, 'U');

        return temp;
    }

    $('#dd-filter-2').keyup(

    function () {
        var filter = noaccent($(this).val()),
            count = 0;
        $('.options-list-2 li.option').each(

        function () {
            if (noaccent($(this).text()).search(new RegExp(filter, 'i')) < 0) {
                $(this).addClass('no-match');
            } else if (!($(this).hasClass('cacheElement'))) {
                $(this).removeClass('no-match');
                count++;
            }
        });
    });
	
	
	
	function noaccent(myString) {
        temp = myString.replace(/[àâä]/g, 'a');
        temp = temp.replace(/[éèêë]/g, 'e');
        temp = temp.replace(/[îï]/g, 'i');
        temp = temp.replace(/[ôö]/g, 'o');
        temp = temp.replace(/[ùûü]/g, 'u');
        temp = myString.replace(/[ÀÂÄ]/g, 'A');
        temp = temp.replace(/[ÉÈÊË]/g, 'E');
        temp = temp.replace(/[ÎÏ]/g, 'I');
        temp = temp.replace(/[ÔÖ]/g, 'O');
        temp = temp.replace(/[ÙÛÜ]/g, 'U');

        return temp;
    }

    $('#dd-filter-3').keyup(

    function () {
        var filter = noaccent($(this).val()),
            count = 0;
        $('.options-list-3 li.option').each(

        function () {
            if (noaccent($(this).text()).search(new RegExp(filter, 'i')) < 0) {
                $(this).addClass('no-match');
            } else if (!($(this).hasClass('cacheElement'))) {
                $(this).removeClass('no-match');
                count++;
            }
        });
    });
	
	
	
	function noaccent(myString) {
        temp = myString.replace(/[àâä]/g, 'a');
        temp = temp.replace(/[éèêë]/g, 'e');
        temp = temp.replace(/[îï]/g, 'i');
        temp = temp.replace(/[ôö]/g, 'o');
        temp = temp.replace(/[ùûü]/g, 'u');
        temp = myString.replace(/[ÀÂÄ]/g, 'A');
        temp = temp.replace(/[ÉÈÊË]/g, 'E');
        temp = temp.replace(/[ÎÏ]/g, 'I');
        temp = temp.replace(/[ÔÖ]/g, 'O');
        temp = temp.replace(/[ÙÛÜ]/g, 'U');

        return temp;
    }

    $('#dd-filter-4').keyup(

    function () {
        var filter = noaccent($(this).val()),
            count = 0;
        $('.options-list-4 li.option').each(

        function () {
            if (noaccent($(this).text()).search(new RegExp(filter, 'i')) < 0) {
                $(this).addClass('no-match');
            } else if (!($(this).hasClass('cacheElement'))) {
                $(this).removeClass('no-match');
                count++;
            }
        });
    });
	
	
	
	function noaccent(myString) {
        temp = myString.replace(/[àâä]/g, 'a');
        temp = temp.replace(/[éèêë]/g, 'e');
        temp = temp.replace(/[îï]/g, 'i');
        temp = temp.replace(/[ôö]/g, 'o');
        temp = temp.replace(/[ùûü]/g, 'u');
        temp = myString.replace(/[ÀÂÄ]/g, 'A');
        temp = temp.replace(/[ÉÈÊË]/g, 'E');
        temp = temp.replace(/[ÎÏ]/g, 'I');
        temp = temp.replace(/[ÔÖ]/g, 'O');
        temp = temp.replace(/[ÙÛÜ]/g, 'U');

        return temp;
    }

    $('#dd-filter-5').keyup(

    function () {
        var filter = noaccent($(this).val()),
            count = 0;
        $('.options-list-5 li.option').each(

        function () {
            if (noaccent($(this).text()).search(new RegExp(filter, 'i')) < 0) {
                $(this).addClass('no-match');
            } else if (!($(this).hasClass('cacheElement'))) {
                $(this).removeClass('no-match');
                count++;
            }
        });
    });
	
	
	
	function noaccent(myString) {
        temp = myString.replace(/[àâä]/g, 'a');
        temp = temp.replace(/[éèêë]/g, 'e');
        temp = temp.replace(/[îï]/g, 'i');
        temp = temp.replace(/[ôö]/g, 'o');
        temp = temp.replace(/[ùûü]/g, 'u');
        temp = myString.replace(/[ÀÂÄ]/g, 'A');
        temp = temp.replace(/[ÉÈÊË]/g, 'E');
        temp = temp.replace(/[ÎÏ]/g, 'I');
        temp = temp.replace(/[ÔÖ]/g, 'O');
        temp = temp.replace(/[ÙÛÜ]/g, 'U');

        return temp;
    }

    $('#dd-filter-6').keyup(

    function () {
        var filter = noaccent($(this).val()),
            count = 0;
        $('.options-list-6 option.option').each(

        function () {
            if (noaccent($(this).text()).search(new RegExp(filter, 'i')) < 0) {
                $(this).addClass('no-match');
            } else if (!($(this).hasClass('cacheElement'))) {
                $(this).removeClass('no-match');
                count++;
            }
        });
    });
	"
);
?>

<div id="wrapper-content" class="course-index"><!-- PAGE WRAPPER-->
  <div id="page-wrapper">
    <div class="main-content"> <a class="btn btn-blue visible-xs" role="button" data-toggle="collapse" href="#filter-xs" aria-expanded="false" aria-controls="filter-xs"> Filter </a>
      <div class="collapse" id="filter-xs">
        <div class="container">
          <div class="filter-fix">
            <form id="university-filter-form" class="form-inline">
              <!--<label for="">Keyword Search </label>-->
              <div class="keyword-filter" style="display: none;">
                <input type="text" class="form-control" name="searchbykeyword" id="searchbykeyword" placeholder="Search by keyword" value="<?php if(isset($params['searchbykeyword'])):  echo $params['searchbykeyword']; endif; ?>"  data-key="searchbykeyword" />
              </div>
              <!--<label for=""> Discipline </label><br> -->




              <div class="btn-group"> 
                <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-discipline" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Discipline <span class="caret-custom"></span> </button>
                
                <div class="dropdown-menu">
                  <input id="dd-filter-2" class="dd-filter-input form-control" type="text" placeholder="Search Discipline">
                <ul class="options-list-2" aria-labelledby="dropdownMenu1">
                <?php foreach($degrees as $degree): ?>
                  <li class="option">
                    <div class="radio">
                      <label class="filter-option">
                        <input class="filter-select" type="radio" name="discipline-radio" value="<?= $degree->id; ?>" id="degree-<?= $degree->id;?>" data-key="discipline">
                        <span>
                        <?= $degree->name; ?>
                        </span> </label>
                    </div>
                  </li>
                  <?php endforeach; ?>
                </ul>
                </div>
              </div>


              <!--<select class="form-control filter-select" id="filter-select" class="selectpicker" data-live-search="true" data-live-search-style="begins" >
                
                <?php foreach($degrees as $degree): ?>
                <?php if(isset($params['degree']) && $params['degree'] == $degree->id): ?>
                <option class="option" value="<?= $degree->id?>" selected>
                <?= $degree->name; ?>
                </option>
                <?php else: ?>
                <option value="<?= $degree->id?>">
                <?= $degree->name; ?>
                </option>
                <?php endif; ?>
                <?php endforeach; ?>
              </select>-->
              <script>
				  //$(document).ready(function () {
					//var mySelect = $('');
					//$('#filter-select').selectpicker({
					 // liveSearch: true,
					 // maxOptions: 1
					//});
				  //});
				</script>
              <div class="btn-group"> 
                <!--<label for="dropdown-majors"> Majors </label> -->
                <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-majors" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">Majors <span class="caret-custom"></span> </button>
                <div class="dropdown-menu">
                  <input id="dd-filter" class="dd-filter-input form-control" type="text" placeholder="Search Majors">
                <ul class="options-list" aria-labelledby="dropdownMenu1" id="majors">
                    <?php if(isset($params['major'])): ?>
                    <?= $this->render('majors-list',[
'majors' => $majors,
'majorparam' =>$params['major']
]);?>
                    <?php endif; ?>
                </ul>
                </div>
              </div>
              <div class="btn-group"> 
                <!--<label for="dropdown-degree"> Degree </label> -->
                <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-degree" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Degree <span class="caret-custom"></span> </button>
                <?php
$selectedDegreeLevel = [];
if(isset($params['degreeLevel'])) {
$selectedDegreeLevel =  $params['degreeLevel'];
}
?>
                <div class="dropdown-menu">
                  <input id="dd-filter-2" class="dd-filter-input form-control" type="text" placeholder="Search Degree">
                <ul class="options-list-2" aria-labelledby="dropdownMenu1">
                  <?php foreach($degreeLevel as $level): ?>
                  <li class="option">
                    <div class="checkbox">
                      <label>
                        <?php if(array_search($level->id, $selectedDegreeLevel) !== false):?>
                        <input type="checkbox" value="<?= $level->id; ?>" id="level-<?= $level->id;?>" data-key="level" checked>
                        <?php else: ?>
                        <input type="checkbox" value="<?= $level->id; ?>" id="level-<?= $level->id;?>" data-key="level">
                        <?php endif; ?>
                        <span>
                        <?= $level->name; ?>
                        </span> </label>
                    </div>
                  </li>
                  <?php endforeach; ?>
                </ul>
                </div>
              </div>
              <div class="btn-group"> 
                <!--<label for="dropdown-country"> Country </label> -->
                <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-country" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Country <span class="caret-custom"></span> </button>
                <?php
$selectedCountry = null;
if(isset($params['country'])) {
$selectedCountry =  $params['country'];
}
?>
                <div class="dropdown-menu">
                  <input id="dd-filter-3" class="dd-filter-input form-control" type="text" placeholder="Search Country">
                <ul class="options-list-3" aria-labelledby="dropdownMenu1">
                  <?php foreach($countries as $country): ?>
                  <li class="option">
                    <div class="checkbox"><label>
                    <?php if($country->id == $selectedCountry): ?>
                    <input type="checkbox" value="<?= $country->id; ?>" id="country-<?= $country->id;?>" data-key="country" checked>
                    <?php else: ?>
                    <input type="checkbox" value="<?= $country->id; ?>" id="country-<?= $country->id;?>" data-key="country">
                    <?php endif; ?>
                    <span>
                    <?= $country->name; ?>
                    </span></label></div> </li>
                  <?php endforeach; ?>
                </ul>
                </div>
              </div>
              <div class="btn-group" style="display:none;"> 
                <!--<label for="dropdown-states"> States </label> -->
                <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-states" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Select States <span class="caret-custom"></span> </button>
                <div class="dropdown-menu">
                  <input id="dd-filter-4" class="dd-filter-input form-control" type="text" placeholder="Search States">
                <ul class="options-list-4" aria-labelledby="dropdownMenu1" id="states">
                    <?php if(isset($params['state'])): ?>
                    <?= $this->render('state-list',[
'states' => $states,
'params' => $params
]);?>
                    <?php endif; ?>
                </ul>
                </div>
              </div>
              <div class="btn-group"> 
                <!--<label for="dropdown-university"> University </label> -->
                <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-university" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> University <span class="caret-custom"></span> </button>
                <?php
$selectedUniversity = null;
if(isset($params['university'])) {
$selectedUniversity =  $params['university'];
}
?>
                <div class="dropdown-menu">
                  <input id="dd-filter-5" class="dd-filter-input form-control" type="text" placeholder="Search University">
                <ul class="options-list-5" aria-labelledby="dropdownMenu1" id="university">
                    <?php
	foreach($university as $resUniver){
		$universityId=$resUniver['id'];
?>
                    <li class="option">
                      <div class="checkbox">
                        <label>
                          <?php if($universityId == $selectedUniversity): ?>
                          <input type="checkbox" value="<?= $universityId; ?>" id="university-<?= $universityId;?>" data-key="university" checked>
                          <?php else: ?>
                          <input type="checkbox" value="<?= $universityId; ?>" id="university-<?= $universityId;?>" data-key="university">
                          <?php endif; ?>
                          <span><?php echo $resUniver['name']; ?></span> </label>
                      </div>
                    </li>
                    <?php } ?>
                </ul>
              </div>
              <?php /*?>
<div id="university">
<?php if(isset($params['university'])): ?>
<?= $this->render('university-list',['university' => $university]);?>
<?php endif; ?>
</div>
<?php */?>
            </form>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      </div>
        <div class="content">
          <div class="container">
            <div class="row">
            <div class="col-sm-12">
                <div class="search-keywords">
                  <label></label>
                </div>
            </div>
              <div class="col-sm-8">
                
                </div>
              <div class="col-sm-4">
              <!--<div class="btn-line-block text-right program-list-tab">
              <?php if(Yii::$app->user->isGuest) {?>
                  <a class="btn btn-blue listing-pwu" href="?r=site/signup">Register for a free counselling session</a>
                  <?php } ?>
                  <?php

$Ads = Advertisement::find()->where(['AND',['=', 'pagename', 'programfinder'],
['=', 'status',  '1' ],['=', 'section',  'right' ],
['<=', 'startdate',  $TodayDate], ['>=', 'enddate',  $TodayDate]])->orderBy('rank','ASC')->all();

?>

              </div>-->
              </div>
              </div>
                <div class="row" id="course-list-main">
              <div class="col-sm-9">
                <div id="course-list">
                  <?= $this->render('course-list.php', [
                    'courses' => $courses,
                    'types' => $types,
                    'languages' => $languages,
                    'pages' => $pages,
                    'currpage' =>$currpage,
                    'totalCourseCount' => $totalCourseCount,
                    'durationType' => $durationType,
                    'shortlisted' => $shortlisted
                    ]);?>
                  <?php
$this->registerJsFile('@web/js/course.js');
?>
                </div>
              </div>
              <div class="col-sm-3 right-side-addblocks">
                <?php 
                $Ads = Advertisement::find()->where(['AND',['=', 'pagename', 'programfinder'],
                ['=', 'status',  '1' ],['=', 'section',  'right' ],
                ['<=', 'startdate',  $TodayDate], ['>=', 'enddate',  $TodayDate]])->orderBy('rank','ASC')->all(); 
                ?>
                <div class="ad-blocks">
                  <?php foreach($Ads as $ad): ?>
                  <a href="<?= $ad->redirectlink;?>" target="_blank" title="<?= $ad->imagetitle?>"> <img src="<?php echo $path.'/web/uploads/advertisements/'.$ad->id.'/'.$ad->imageadvert;?>" alt="<?= $ad->imagetitle?>" style="height: <?= $ad->height;?>px; width: <?= $ad->width;?>px;"/> </a>
                  <p style="height: 8px;">&nbsp;</p>
                  <?php   ?>
                  <?php endforeach; ?>
                </div>
              </div>
        </div>
      </div>
    </div>
</div>
<script >



function CheckSelected(university_id,course_id) {
$.ajax({
url: '/university/mostviewed',
method: 'POST',
data: {
university_id: university_id,
course_id: course_id,
},
success: function(response, data) {
response = JSON.parse(response);
if(response.status == 'success') {
alert(response);
}
},
error: function(error) {
console.log(error);
}
});
}


</script>
<?php
$script = <<< JS
$(document).ready(function(){
	$(window).scroll(function() {
	if ($('.fix-side').offset().top + $('.fix-side').outerHeight() > $('.footer-main').offset().top) {
	$('.fix-side').addClass('side-move');
	} else {
	$('.fix-side').removeClass('side-move');
	}
	});
});


JS;
 $this->registerJs($script);
$this->registerJsFile( '@web/js/bootstrap-select.js' );
$this->registerCssFile( '@web/css/bootstrap-select.css' );
?>
