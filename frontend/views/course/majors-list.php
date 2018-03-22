<?php 
$selectedmajor = null;
if(isset($majorparam)) {
$selectedmajor =  $majorparam;
} 
?>


<?php foreach($majors as $major): ?>
    <li class="option">
    <div class="checkbox">
        <label>
            <input type="checkbox" value="<?= $major->id; ?>" id="major-<?= $major->id;?>" data-key="major" <?php if($major->id == $selectedmajor){ echo 'checked';} ?> >
            <span><?= $major->name; ?></span>
        </label>
        </div>
    </li>
<?php endforeach; ?>