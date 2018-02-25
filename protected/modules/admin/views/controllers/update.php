<?php
/* @var $this ControllersController */
/* @var $model Controllers */

//$this->breadcrumbs=array(
//	'Controllers'=>array('index'),
//	$model->name=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List Controllers', 'url'=>array('index')),
//	array('label'=>'Create Controllers', 'url'=>array('create')),
//	array('label'=>'View Controllers', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage Controllers', 'url'=>array('admin')),
//);
$this->createMenu('update', $model);
?>

<!--<h1>Update Controllers <?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>