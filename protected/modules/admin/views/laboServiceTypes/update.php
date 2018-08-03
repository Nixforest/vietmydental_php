<?php
/* @var $this LaboServiceTypesController */
/* @var $model LaboServiceTypes */

$this->breadcrumbs=array(
	'Labo Service Types'=>array('index'),
	$model->name=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List LaboServiceTypes', 'url'=>array('index')),
	array('label'=>'Create LaboServiceTypes', 'url'=>array('create')),
	array('label'=>'View LaboServiceTypes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage LaboServiceTypes', 'url'=>array('admin')),
);
?>

<h1>Update LaboServiceTypes <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>