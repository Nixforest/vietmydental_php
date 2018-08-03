<?php
/* @var $this LaboRequestsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Labo Requests',
);

$this->menu=array(
	array('label'=>'Create LaboRequests', 'url'=>array('create')),
	array('label'=>'Manage LaboRequests', 'url'=>array('admin')),
);
?>

<h1>Labo Requests</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
