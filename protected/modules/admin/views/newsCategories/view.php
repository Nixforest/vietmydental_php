<?php
/* @var $this NewsCategoriesController */
/* @var $model NewsCategories */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle.' '. $model->id;?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'description',
		'parent_id',
		'status',
		'created_date',
		'created_by',
	),
)); ?>
