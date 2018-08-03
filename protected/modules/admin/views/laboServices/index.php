<?php
/* @var $this LaboServicesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Labo Services',
);

$this->menu=array(
	array('label'=>'Create LaboServices', 'url'=>array('create')),
	array('label'=>'Manage LaboServices', 'url'=>array('admin')),
);
?>

<h1>Labo Services</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
