<?php
/* @var $this ApplicationsController */
/* @var $model Applications */

//$this->breadcrumbs=array(
//	'Applications'=>array('index'),
//	$model->name=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List Applications', 'url'=>array('index')),
//	array('label'=>'Create Applications', 'url'=>array('create')),
//	array('label'=>'View Applications', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage Applications', 'url'=>array('admin')),
//);
$this->createMenu('update', $model);
?>

<!--<h1>Update Applications: <?php echo $model->name; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>