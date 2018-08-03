<?php
/* @var $this LaboServicesController */
/* @var $model LaboServices */

$this->breadcrumbs=array(
	'Labo Services'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LaboServices', 'url'=>array('index')),
	array('label'=>'Manage LaboServices', 'url'=>array('admin')),
);
?>

<h1>Create LaboServices</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>