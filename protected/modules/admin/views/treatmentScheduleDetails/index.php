<?php
/* @var $this TreatmentScheduleDetailsController */
/* @var $model TreatmentScheduleDetails */

$this->createMenu('index', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#treatment-schedule-details-grid').yiiGridView('update', {
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

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'treatment-schedule-details-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
                array(
                    'header' => DomainConst::CONTENT00034,
                    'type' => 'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    'headerHtmlOptions' => array('width' => '30px','style' => 'text-align:center;'),
                    'htmlOptions' => array('style' => 'text-align:center;')
                ),
		'schedule_id',
		'start_date',
		'end_date',
		'teeth_id',
		array(
                    'name'=>'diagnosis_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rDiagnosis) ? $data->rDiagnosis->name : ""',
                    'filter'=>Diagnosis::loadChildItems(),
                ),
		array(
                    'name'=>'treatment_type_id',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value'=> 'isset($data->rTreatmentType) ? $data->rTreatmentType->name : ""',
                    'filter'=>TreatmentTypes::loadItems(),
                ),
                array(
                    'name'=>'status',
                    'value' => 'TreatmentScheduleDetails::getStatus()[$data->status]',
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'visible' => CommonProcess::isUserAdmin(),
                    'filter'=> TreatmentScheduleDetails::getStatus(true),
		),
		'description',
		'type_schedule',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
