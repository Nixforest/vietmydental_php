<?php
/* @var $this HrFunctionsController */
/* @var $model HrFunctions */

$this->createMenu('createSetup', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
");
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php echo CHtml::link(DomainConst::CONTENT00073, '#', array('class' => 'search-button')); ?>
<div class="search-form" style="<?php echo (empty($model->role_id) && empty($model->type_id) ? '' : "display: none;"); ?>">
    <?php
    $this->renderPartial('_search_setup', array(
        'model' => $model,
        'title' => DomainConst::CONTENT00349,
    ));
    ?>
</div><!-- search-form -->

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>