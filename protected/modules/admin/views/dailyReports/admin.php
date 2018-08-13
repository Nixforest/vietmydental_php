<?php
/* @var $this DailyReportsController */
/* @var $model DailyReports */

$this->breadcrumbs=array(
	'Daily Reports'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List DailyReports', 'url'=>array('index')),
	array('label'=>'Create DailyReports', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#daily-reports-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Daily Reports</h1>

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
	'id'=>'daily-reports-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'receipt_customer_total',
		'receipt_total_total',
		'receipt_discount_total',
		'receipt_final_total',
		'receipt_debit_total',
		/*
		'new_customer_total',
		'new_total_total',
		'new_discount_total',
		'new_final_total',
		'new_debit_total',
		'approve_id',
		'status',
		'created_by',
		'created_date',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
