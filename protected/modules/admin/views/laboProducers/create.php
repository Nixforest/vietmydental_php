<?php
/* @var $this LaboProducersController */
/* @var $model LaboProducers */

$this->breadcrumbs=array(
	'Labo Producers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LaboProducers', 'url'=>array('index')),
	array('label'=>'Manage LaboProducers', 'url'=>array('admin')),
);
?>

<h1>Create LaboProducers</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>