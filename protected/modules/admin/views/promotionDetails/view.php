<?php
/* @var $this PromotionsDetailController */
/* @var $model PromotionsDetail */

$this->breadcrumbs=array(
	'Promotions Details'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PromotionsDetail', 'url'=>array('index')),
	array('label'=>'Create PromotionsDetail', 'url'=>array('create')),
	array('label'=>'Update PromotionsDetail', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PromotionsDetail', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PromotionsDetail', 'url'=>array('admin')),
);
?>

<h1>View PromotionsDetail #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'customer_types_id',
		'discount',
		'description',
	),
)); ?>
