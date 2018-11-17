<?php
/* @var $this HrSalaryReportsController */
/* @var $model HrSalaryReports */

$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#hr-salary-reports-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1><?php echo $this->pageTitle; ?></h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'hr-salary-reports-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'header' => DomainConst::CONTENT00034,
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        'name',
        'start_date',
        'end_date',
        array(
            'name' => 'role_id',
            'value' => '$data->getRoleName()',
        ),
        array(
            'name' => 'type_id',
            'value' => '$data->getType()',
        ),
        'data',
        array(
            'name' => 'approved',
            'value' => '$data->getApproverName()',
        ),
        'approved_date',
        'notify',
        array(
            'name' => 'department_id',
            'value' => '$data->getDepartmentName()',
        ),
        array(
            'name' => 'agent_id',
            'value' => '$data->getAgentName()',
        ),
        array(
            'name' => 'status',
            'value' => '$data->getStatus()',
        ),
        'created_date',
        array(
            'name' => 'created_by',
            'value' => '$data->getCreatedBy()',
        ),
        array(
            'header' => DomainConst::CONTENT00239,
            'class'=>'CButtonColumn',
            'template'=> $this->createActionButtons(),
            'afterDelete' => $this->handleAjaxAfterDelete(),
        ),
    ),
));
?>
