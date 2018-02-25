<?php
/* @var $this RolesController */
/* @var $model Roles */

//$this->breadcrumbs=array(
//	'Roles'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List Roles', 'url'=>array('index')),
//	array('label'=>'Create Roles', 'url'=>array('create')),
//	array('label'=>'View Roles', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage Roles', 'url'=>array('admin')),
//);
$this->createMenu('update', $model);
?>

<!--<h1>Update Roles <?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>