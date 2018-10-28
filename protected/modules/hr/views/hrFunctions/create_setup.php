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
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'hr-functions-grid',
        'dataProvider' => $model->search(),
	'selectableRows'=>1,
        'columns' => array(
            array(
                'header' => DomainConst::CONTENT00034,
                'type' => 'raw',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'name' => 'name',
                'value' => 'CHtml::activeTextField($data, "[$row]name")',
                'type'  => 'raw',
            ),
            array(
                'name' => 'function',
                'value' => 'CHtml::activeTextField($data, "[$row]function")',
                'type'  => 'raw',
            ),
            array(
                'header' => DomainConst::CONTENT00545,
                'value' => '',
            ),
            array(
                'header' => DomainConst::CONTENT00496,
                'value' => '',
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
    ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton(DomainConst::CONTENT00377); ?>
        <?php
        echo CHtml::ajaxSubmitButton(DomainConst::CONTENT00549,
                Yii::app()->createUrl('hr/hrFunctions/ajaxCreateNewRow'),
                array(
                    'type'      => 'post',
                    'success'   => 'js:reloadGrid',
                    'update'    => '#data',
                    'data'      => "js:{role_id: $('#HrFunctions_role_id').val(), type_id: $('#HrFunctions_type_id').val()}"
        ));
        echo CHtml::ajaxSubmitButton(DomainConst::CONTENT00548,
                Yii::app()->createUrl('hr/hrFunctions/ajaxCloneRow'),
                array(
                   'type'       =>'post',
                   'data'       => "js:{id : $.fn.yiiGridView.getSelection('hr-functions-grid')}",
                   'success'    => 'js:reloadGrid',
        ));
        ?>
    </div>
    
    
    <?php $this->endWidget(); ?>
</div>

<div id="for-link">
<?php
   
?>
<div>
<script type="text/javascript">
function reloadGrid(data) {
    $.fn.yiiGridView.update('hr-functions-grid');
}
</script>