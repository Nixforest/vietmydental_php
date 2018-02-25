<?php
/* @var $this AgentsController */
/* @var $model Agents */

$this->breadcrumbs=array(
	'Agents'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Agents', 'url'=>array('index')),
	array('label'=>'Create Agents', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#agents-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Agents</h1>

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
	'id'=>'agents-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'phone',
		'email',
		'foundation_date',
		'city_id',
		/*
		'district_id',
		'ward_id',
		'street_id',
		'house_numbers',
		'address',
		'address_vi',
		'created_by',
		'created_date',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
