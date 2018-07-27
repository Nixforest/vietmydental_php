<?php
/* @var $this PromotionsDetailController */
/* @var $model PromotionsDetail */

$this->breadcrumbs=array(
	'Promotions Details'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PromotionsDetail', 'url'=>array('index')),
	array('label'=>'Create PromotionsDetail', 'url'=>array('create')),
	array('label'=>'View PromotionsDetail', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PromotionsDetail', 'url'=>array('admin')),
);
?>

<h1>Update PromotionsDetail <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>