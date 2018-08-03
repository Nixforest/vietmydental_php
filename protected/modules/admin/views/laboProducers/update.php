<?php
/* @var $this LaboProducersController */
/* @var $model LaboProducers */

$this->breadcrumbs=array(
	'Labo Producers'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LaboProducers', 'url'=>array('index')),
	array('label'=>'Create LaboProducers', 'url'=>array('create')),
	array('label'=>'View LaboProducers', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LaboProducers', 'url'=>array('admin')),
);
?>

<h1>Update LaboProducers <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>