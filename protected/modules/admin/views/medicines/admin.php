<?php
/* @var $this MedicinesController */
/* @var $model Medicines */

$this->breadcrumbs=array(
	'Medicines'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Medicines', 'url'=>array('index')),
	array('label'=>'Create Medicines', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#medicines-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Medicines</h1>

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
	'id'=>'medicines-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'code',
		'content',
		'unit_id',
		'active_ingredient',
		/*
		'use_id',
		'manufacturer',
		'type_id',
		'buy_price',
		'sell_price',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
