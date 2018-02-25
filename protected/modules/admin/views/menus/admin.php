<?php
/* @var $this MenusController */
/* @var $model Menus */

$this->breadcrumbs=array(
	'Menuses'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Menus', 'url'=>array('index')),
	array('label'=>'Create Menus', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#menus-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Menuses</h1>

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
	'id'=>'menus-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'name',
		'link',
		'module_id',
		'controller_id',
		'action',
		/*
		'display_order',
		'show_in_menu',
		'place_holder_id',
		'application_id',
		'parent_id',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
