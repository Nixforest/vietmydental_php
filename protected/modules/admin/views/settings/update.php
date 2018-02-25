<?php
/* @var $this SettingsController */
/* @var $model Settings */

//$this->breadcrumbs=array(
//	'Settings'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List Settings', 'url'=>array('index')),
//	array('label'=>'Create Settings', 'url'=>array('create')),
//	array('label'=>'View Settings', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage Settings', 'url'=>array('admin')),
//);
$this->createMenu('update', $model);
?>

<!--<h1>Update Settings <?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>