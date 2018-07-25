<?php
/* @var $this PromotionsDetailController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Promotions Details',
);

$this->menu=array(
	array('label'=>'Create PromotionsDetail', 'url'=>array('create')),
	array('label'=>'Manage PromotionsDetail', 'url'=>array('admin')),
);
?>

<h1>Promotions Details</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
