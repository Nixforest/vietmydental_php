<?php
/* @var $this TreatmentScheduleDetailsController */
/* @var $model TreatmentScheduleDetails */

$this->breadcrumbs=array(
	'Treatment Schedule Details'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List TreatmentScheduleDetails', 'url'=>array('index')),
	array('label'=>'Create TreatmentScheduleDetails', 'url'=>array('create')),
);

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

<h1>Manage Treatment Schedule Details</h1>

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
		'id',
		'schedule_id',
		'start_date',
		'end_date',
		'teeth_id',
		'diagnosis_id',
		/*
		'treatment_type_id',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
