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
<!--<div class="search-form" style="<?php // echo (empty($model->role_id) && empty($model->type_id) ? '' : "display: none;");  ?>">-->
<div class="search-form">
    <?php
    $this->renderPartial('_search_setup', array(
        'model' => $model,
        'title' => DomainConst::CONTENT00349,
    ));
    ?>
</div><!-- search-form -->
<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'sell-form',
        'enableAjaxValidation' => false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));
    ?>

    <?php $this->endWidget(); ?>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'hr-functions-grid',
    'dataProvider' => $model->search(),
    'columns' => array(
        array(
            'header' => DomainConst::CONTENT00034,
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        'name',
        array(
            'name' => 'function',
            'value' => '$data->getUnderstandingFunction()',
        ),
        array(
            'name' => 'is_per_day',
            'value' => '$data->isPerDayText()',
        ),
        array(
            'header' => DomainConst::CONTENT00239,
            'class' => 'CButtonColumn',
            'template' => $this->createActionButtons(),
            'afterDelete' => $this->handleAjaxAfterDelete(),
        ),
    ),
));
