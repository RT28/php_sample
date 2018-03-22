<?php
/* @var $this yii\web\View */
$this->context->layout = 'admin-dashboard-sidebar';
?>
<h1>test/index</h1>

<?php if(isset($message)): ?>
    <div class="alert " role="alert"><?= print_r($message); ?></div>
<?php endif; ?>