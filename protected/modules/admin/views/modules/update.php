<?php
/* @var $this ModulesController */
/* @var $model Modules */

//$this->breadcrumbs=array(
//	'Modules'=>array('index'),
//	$model->name=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List Modules', 'url'=>array('index')),
//	array('label'=>'Create Modules', 'url'=>array('create')),
//	array('label'=>'View Modules', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage Modules', 'url'=>array('admin')),
//);
$this->createMenu('update', $model);
?>

<!--<h1>Update Modules <?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>