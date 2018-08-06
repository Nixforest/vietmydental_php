<?php
/* @var $this LaboServicesController */
/* @var $model LaboServices */

//$this->breadcrumbs=array(
//	'Labo Services'=>array('index'),
//	$model->name=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List LaboServices', 'url'=>array('index')),
//	array('label'=>'Create LaboServices', 'url'=>array('create')),
//	array('label'=>'View LaboServices', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage LaboServices', 'url'=>array('admin')),
//);
$this->createMenu('update', $model);
?>

<h1><?php echo $this->pageTitle .' '. $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>