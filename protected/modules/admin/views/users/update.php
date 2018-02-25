<?php
/* @var $this UsersController */
/* @var $model Users */

//$this->breadcrumbs=array(
//	$this->controllerDescription=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List Users', 'url'=>array('index')),
//	array('label'=>'Create Users', 'url'=>array('create')),
//	array('label'=>'View Users', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage Users', 'url'=>array('admin')),
//);
$this->createMenu('update', $model);
?>

<!--<h1>Update Users <?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>