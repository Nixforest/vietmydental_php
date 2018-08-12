<?php
/* @var $this LaboRequestsController */
/* @var $model LaboRequests */

$this->breadcrumbs=array(
	'Labo Requests'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List LaboRequests', 'url'=>array('index')),
	array('label'=>'Create LaboRequests', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#labo-requests-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Labo Requests</h1>

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
	'id'=>'labo-requests-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'treatment_detail_id',
		'service_id',
		'date_request',
		'date_receive',
		'date_test',
		/*
		'tooth_color',
		'teeths',
		'description',
		'price',
		'total',
		'status',
		'created_date',
		'created_by',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
