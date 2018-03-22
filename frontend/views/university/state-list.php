<?php foreach($states as $state): ?>
	<li class="option">
        <div class="checkbox">
            <label>
                <input <?= (isset($params['state']) && $state->id == $params['state']) ? 'checked' : '' ?> type="checkbox" value="<?= $state->id; ?>" id="state-<?= $state->id;?>" data-key="state">
                <span><?= $state->name; ?></span>
            </label>
        </div>
    </li>
<?php endforeach; ?>