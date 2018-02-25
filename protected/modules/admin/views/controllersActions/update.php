<?php
/* @var $this ControllersActionsController */
/* @var $model ControllersActions */

//$this->breadcrumbs=array(
//	'Controllers Actions'=>array('index'),
//	$model->name=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List ControllersActions', 'url'=>array('index')),
//	array('label'=>'Create ControllersActions', 'url'=>array('create')),
//	array('label'=>'View ControllersActions', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage ControllersActions', 'url'=>array('admin')),
//);
$this->createMenu('update', $model);
?>

<!--<h1>Update ControllersActions <?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>