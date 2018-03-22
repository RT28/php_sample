<?php
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\ models\ Favorites;
use common\models\University;
use common\models\Student;
use common\models\UniversityCourseList;
use yii\widgets\LinkPager;
use common\models\Advertisement;
use common\components\ConnectionSettings;

/* @var $this yii\web\View */
$this->title = 'University List';
$this->context->layout = 'index';

$path= ConnectionSettings::BASE_URL.'backend';
$TodayDate = date('Y-m-d');
$this->registerJs("
jQuery(document).ready(function(){
	$('#searchbykeyword').typeahead({
		ajax: '?r=home-search/search-university'
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
	"
);
?>

<div id="wrapper-content" class="university-index"> 
  <!-- PAGE WRAPPER-->
  <div id="page-wrapper">
    <div class="main-content"> <a class="btn btn-blue visible-xs" role="button" data-toggle="collapse" href="#filter-xs" aria-expanded="false" aria-controls="filter-xs"> Filter </a>
      <div class="collapse" id="filter-xs">
        <div class="">
          <div class="filter-fix">
            <form id="university-filter-form" class="form-inline">
              <div class="keyword-filter">
                <input type="text" class="form-control" name="searchbykeyword" id="searchbykeyword" placeholder="Search by keyword" value="<?php if(isset($params['searchbykeyword'])):  echo $params['searchbykeyword']; endif; ?>" data-key="searchbykeyword"/>
              </div>
              <!--<label for=""> Discipline </label>-->
              <select class="form-control filter-select">
                <option value="-1">Any Discipline</option>
                <?php foreach($degrees as $degree): ?>
                <option value="<?= $degree->id?>">
                <?= $degree->name; ?>
                </option>
                <?php endforeach; ?>
              </select>
              <div class="btn-group"> 
                <!--<label for="dropdown-majors"> Majors </label> -->
                <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-majors" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Select Majors <span class="caret"></span> </button>
                <div class="dropdown-menu">
                  <input id="dd-filter" class="dd-filter-input form-control" type="text" placeholder="Search Majors">
                  <ul class="options-list" aria-labelledby="dropdownMenu1" id="majors">
                  </ul>
                </div>
              </div>
              <div class="btn-group"> 
                <!--<label for="dropdown-degree"> Degree </label> -->
                <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-degree" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Select Degree <span class="caret"></span> </button>
                
                <div class="dropdown-menu">
                  <input id="dd-filter-2" class="dd-filter-input form-control" type="text" placeholder="Search Degree">
                <ul class="options-list-2" aria-labelledby="dropdownMenu1">
                  <?php foreach($degreeLevel as $level): ?>
                  <li class="option">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" value="<?= $level->id; ?>" id="level-<?= $level->id;?>" data-key="level">
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
                <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-country" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Select Country <span class="caret"></span> </button>
                <div class="dropdown-menu">
                <input id="dd-filter-3" class="dd-filter-input form-control" type="text" placeholder="Search Country">
                <ul class="options-list-3" aria-labelledby="dropdownMenu1">
                  <?php
									$filterCountry = isset( $params[ 'country' ] ) ? $params[ 'country' ] : null;
									?>
                  <?php foreach($countries as $country): ?>
                  <li class="option">
                    <div class="checkbox">
                      <label>
                        <?php if($filterCountry == $country->id): ?>
                        <input checked type="checkbox" value="<?= $country->id; ?>" id="country-<?= $country->id;?>" data-key="country">
                        <?php else: ?>
                        <input type="checkbox" value="<?= $country->id; ?>" id="country-<?= $country->id;?>" data-key="country">
                        <?php endif; ?>
                        <span>
                        <?= $country->name; ?>
                        </span> </label>
                    </div>
                  </li>
                  <?php endforeach; ?>
                </ul>
                </div>
              </div>
              <div class="btn-group"> 
                <!--<label for="dropdown-states"> States </label> -->
                <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-states" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Select States <span class="caret"></span> </button>
                <div class="dropdown-menu">
                <input id="dd-filter-4" class="dd-filter-input form-control" type="text" placeholder="Search States">
                <ul class="options-list-4" aria-labelledby="dropdownMenu1" id="states">
                    <?php 
                                                    if(!empty($states)) {
                                                        echo $this->render('state-list', [
                                                            'states' => $states,
                                                            'params' => $params
                                                        ]);
                                                    }
                                                ?>
                </ul>
                </div>
              </div>
              <!-- university select box filter -->
              <div class="btn-group"> 
                <!--<label for="dropdown-university"> University </label> -->
                <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-university" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> Select University <span class="caret"></span> </button>
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
              </div>
              <!-- end university select box filter -->
              <!-- university select box filter -->
              <div class="btn-group"> 
                <input type="checkbox" value="partner" id="partner" data-key="partner">Partner universities
              </div>
              <!-- end university select box filter -->
            </form>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="section-padding university-listing">
        <div class="content">
          <div class="container">
            <div class="row">
              <div class="col-sm-10">
                <div class="search-keywords"> Filters
                  <label></label>
                </div>
                <div id="university-list">
                  <?= $this->render('university-list.php', [
                                        'models' => $models,
                                        'pages'=>$pages,
										'currpage' =>$currpage,
                                        'universityTotalCount'=>$universityTotalCount
                                    ]);?>
                </div>
              </div>
              <div class="col-sm-2 right-side-addblocks">
                <?php 

	$Ads = Advertisement::find()->where(['AND',['=', 'pagename', 'university'],
	['=', 'status',  '1' ],['=', 'section',  'right' ],
	['<=', 'startdate',  $TodayDate], ['>=', 'enddate',  $TodayDate]])->orderBy('rank','ASC')->all();	

	?>
                <div class="ad-blocks">
                  <?php foreach($Ads as $ad): ?>
                  <a href="<?= $ad->redirectlink;?>" target="_blank" title="<?= $ad->imagetitle?>"> <img src="<?php echo $path.'/web/uploads/advertisements/'.$ad->id.'/'.$ad->imageadvert;?>" alt="<?= $ad->imagetitle?>" style="width:<?= $ad->width?>; height:<?= $ad->height?>;"/> </a>
                  <?php   ?>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
$this->registerJsFile( '@web/js/university.js' );
?>
