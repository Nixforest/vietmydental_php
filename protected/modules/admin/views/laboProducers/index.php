<?php
/* @var $this LaboProducersController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Labo Producers',
);

$this->menu=array(
	array('label'=>'Create LaboProducers', 'url'=>array('create')),
	array('label'=>'Manage LaboProducers', 'url'=>array('admin')),
);
?>

<h1>Labo Producers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
