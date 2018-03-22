<?php
use yii\helpers\Url;
use yii\helpers\Html;
use frontend\models\Favorites;
use common\models\University;
use common\models\Student;
use common\models\UniversityCourseList;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
$this->title = 'Partner Universities List';
$this->context->layout = 'index';
?>

<div id="wrapper-content" class="university-index"><!-- PAGE WRAPPER-->
  <div id="page-wrapper">
    <div class="main-content"> <a class="btn btn-blue visible-xs" role="button" data-toggle="collapse" href="#filter-xs" aria-expanded="false" aria-controls="filter-xs"> Filter </a>
      <div class="collapse" id="filter-xs">
        <div class="">
          <div class="filter-fix">
            <form id="university-filter-form" class="form-inline">
              <label for=""> Keyword Search </label>
                <input type="text" class="form-control" name="" placeholder="Enter Keyword">
            	<label for=""> Discipline </label>
              <select class="form-control filter-select">
                                                <option value="-1">Any Discipline</option>
                                                <?php foreach($degrees as $degree): ?>
                                                    <option value="<?= $degree->id?>"><?= $degree->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <div class="btn-group">
              <label for="dropdown-majors"> Majors </label>
  <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-majors" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Select Majors
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
  <div id="majors"></div>
  </ul>
</div>
<div class="btn-group">
              <label for="dropdown-degree"> Degree </label>
  <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-degree" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Select Degree
    <span class="caret"></span>
  </button>
 
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
 <?php foreach($degreeLevel as $level): ?>
    <li><div class="checkbox">
        <label>
            <input type="checkbox" value="<?= $level->id; ?>" id="level-<?= $level->id;?>" data-key="level">
            <span><?= $level->name; ?></span>
        </label>
    </div></li>
<?php endforeach; ?>
  </ul>
</div>
<div class="btn-group">
              <label for="dropdown-country"> Country </label>
  <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-country" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Select Country
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
  
  <?php
                                                $filterCountry = isset($params['country']) ? $params['country'] : null;
                                            ?>
                                            <?php foreach($countries as $country): ?>
                                            <li>
                                                <div class="checkbox">
                                                    <label>
                                                        <?php if($filterCountry == $country->id): ?>
                                                            <input checked type="checkbox" value="<?= $country->id; ?>" id="country-<?= $country->id;?>" data-key="country">
                                                        <?php else: ?>
                                                            <input type="checkbox" value="<?= $country->id; ?>" id="country-<?= $country->id;?>" data-key="country">
                                                        <?php endif; ?>
                                                        <span><?= $country->name; ?></span>
                                                    </label>
                                                </div>
												</li>
                                            <?php endforeach; ?>

  </ul>
</div>
<div class="btn-group">
              <label for="dropdown-states"> States </label>
  <button class="btn btn-default dropdown-toggle multiselect" type="button" id="dropdown-states" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    Select States
    <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1"><div id="states">
                                                <?php 
                                                    if(!empty($states)) {
                                                        echo $this->render('state-list', [
                                                            'states' => $states,
                                                            'params' => $params
                                                        ]);
                                                    }
                                                ?>
                                            </div>
  </ul>
</div>
            </form>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="section-padding">
        <div class="content">
          <div class="container">
            <div class="row">
              <div class="col-sm-9">
                <div class="search-keywords"> Filters
                  <label></label>
                </div>
                <div id="university-list">
                  <?= $this->render('university-list.php', [
                                        'models' => $models,
                                        'pages'=>$pages,
                                        'universityTotalCount'=>$universityTotalCount
                                    ]);?>
                </div>
              </div>
              <div class="col-sm-3 right-side-addblocks">
                <div class="ad-blocks">
                  <div class="ad-block" style="background-color:#414e57; height:600px; margin-bottom: 40px"> </div>
                  <div class="ad-block" style="background-color:#414e57; height:450px;"> </div>
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
    $this->registerJsFile('@web/js/university.js');
?>
