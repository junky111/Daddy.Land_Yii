<?php
/* @var $this SiteController */
/* @var $error array */

$this->pageTitle=Yii::app()->name . ' - Error';
$this->breadcrumbs=array(
	'Error',
);
?>
<div class="post">
    <div class="addpost-needauth">
        <?php echo CHtml::encode($message); ?>
        <?php if(Env::getCurrentUser()==null) { ?> Возможно, стоит <a href="<?= Env::getVKAuthLink() ?>">авторизоваться</a>.<?} ?>
    </div>
</div>