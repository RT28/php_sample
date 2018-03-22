
<?php
    $selectedState = null;
    if(isset($params['state'])) {
        $selectedState = $params['state'];
    }
?>
<?php foreach($states as $state): ?>
   <li class="option"><div class="checkbox"> <label>
        
            <?php if($state->id == $selectedState): ?>
                <input type="checkbox" value="<?= $state->id; ?>" id="state-<?= $state->id;?>" data-key="state" checked>
            <?php else: ?>
                <input type="checkbox" value="<?= $state->id; ?>" id="state-<?= $state->id;?>" data-key="state">
            <?php endif; ?>
            <span><?= $state->name; ?></span>
        
    </label></div></li>
<?php endforeach; ?>