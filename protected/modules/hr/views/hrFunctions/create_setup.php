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
<!--<div class="search-form" style="<?php // echo (empty($model->role_id) && empty($model->type_id) ? '' : "display: none;");       ?>">-->
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
        'selectableRows' => 1,
        'columns' => array(
            array(
                'header' => DomainConst::CONTENT00034,
                'type' => 'raw',
                'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
                'htmlOptions' => array('style' => 'text-align:center;')
            ),
            array(
                'class'                 => 'DataColumn',
                'header'                => DomainConst::CONTENT00545,
                'value'                 => '$data->getParametersHtml()',
                'type'                  => 'raw',
                'evaluateHtmlOptions'   => true,
                'htmlOptions'           => array(
                    'class'         => '"fnc_param_container"',
                    'data-current'  => '"{$data->id}"',
                ),
            ),
            array(
                'class'                 => 'DataColumn',
                'header'                => DomainConst::CONTENT00496,
                'value'                 => '$data->getCoefficientsHtml()',
                'type'                  => 'raw',
                'evaluateHtmlOptions'   => true,
                'htmlOptions'           => array(
                    'class'         => '"fnc_coeff_container"',
                    'data-current'  => '"{$data->id}"',
                ),
            ),
            array(
                'name' => 'function',
                'value' => 'CHtml::activeTextArea($data, "[$data->id]function")',
                'type' => 'raw',
            ),
            array(
                'name' => 'name',
                'value' => 'CHtml::activeTextField($data, "[$data->id]name")',
                'type' => 'raw',
            ),
            array(
                'name' => 'role_id',
                'value' => 'CHtml::activeTextField($data, "[$data->id]role_id")',
                'type' => 'raw',
                'htmlOptions' => array(
                    'style' => 'display:none;'
                ),
                'headerHtmlOptions' => array(
                    'style' => 'display:none;'
                ),
            ),
            array(
                'name' => 'type_id',
                'value' => 'CHtml::activeTextField($data, "[$data->id]type_id")',
                'type' => 'raw',
                'htmlOptions' => array(
                    'style' => 'display:none;'
                ),
                'headerHtmlOptions' => array(
                    'style' => 'display:none;'
                ),
            ),
            array(
                'name' => 'is_per_day',
                'value' => 'CHtml::activeCheckBox($data, "[$data->id]is_per_day")',
                'type' => 'raw',
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
        echo CHtml::ajaxSubmitButton(DomainConst::CONTENT00549, Yii::app()->createUrl('hr/hrFunctions/ajaxCreateNewRow'), array(
            'type' => 'post',
            'success' => 'js:reloadGrid',
            'update' => '#data',
            'data' => "js:{role_id: $('#HrFunctions_role_id').val(), type_id: $('#HrFunctions_type_id').val()}"
        ));
        echo CHtml::ajaxSubmitButton(DomainConst::CONTENT00548, Yii::app()->createUrl('hr/hrFunctions/ajaxCloneRow'), array(
            'type' => 'post',
            'data' => "js:{id : $.fn.yiiGridView.getSelection('hr-functions-grid')}",
            'success' => 'js:reloadGrid',
        ));
        ?>
    </div>


    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    function reloadGrid(data) {
        $.fn.yiiGridView.update('hr-functions-grid');
    }
    
    $(document).ready(function() {
        allowDrag("param_container", "fnc_param_container", "id");
        allowDrag("coeff_container", "fnc_coeff_container", "id");
    });
</script>