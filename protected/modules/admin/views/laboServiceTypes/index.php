<?php
/* @var $this LaboServiceTypesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Labo Service Types',
);

$this->menu=array(
	array('label'=>'Create LaboServiceTypes', 'url'=>array('create')),
	array('label'=>'Manage LaboServiceTypes', 'url'=>array('admin')),
);
?>

<h1>Labo Service Types</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
