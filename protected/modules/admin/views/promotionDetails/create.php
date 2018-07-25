<?php
/* @var $this PromotionsDetailController */
/* @var $model PromotionsDetail */

$this->breadcrumbs=array(
	'Promotions Details'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PromotionsDetail', 'url'=>array('index')),
	array('label'=>'Manage PromotionsDetail', 'url'=>array('admin')),
);
?>

<h1>Create PromotionsDetail</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>