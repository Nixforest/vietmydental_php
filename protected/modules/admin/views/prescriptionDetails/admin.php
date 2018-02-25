<?php
/* @var $this PrescriptionDetailsController */
/* @var $model PrescriptionDetails */

$this->breadcrumbs=array(
	'Prescription Details'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List PrescriptionDetails', 'url'=>array('index')),
	array('label'=>'Create PrescriptionDetails', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#prescription-details-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Prescription Details</h1>

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
	'id'=>'prescription-details-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'prescription_id',
		'medicine_id',
		'quantity',
		'quantity1',
		'quantity2',
		/*
		'quantity3',
		'quantity4',
		'note',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
