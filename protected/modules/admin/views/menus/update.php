<?php
/* @var $this MenusController */
/* @var $model Menus */

//$this->breadcrumbs=array(
//	'Menuses'=>array('index'),
//	$model->name=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List Menus', 'url'=>array('index')),
//	array('label'=>'Create Menus', 'url'=>array('create')),
//	array('label'=>'View Menus', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage Menus', 'url'=>array('admin')),
//);
$this->createMenu('update', $model);
?>

<h1>Update Menus <?php echo $model->id; ?></h1>
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>