<?php
/* @var $this ControllersController */
/* @var $model Controllers */

//$this->breadcrumbs=array(
//	'Controllers'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List Controllers', 'url'=>array('index')),
//	array('label'=>'Manage Controllers', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<!--<h1>Create Controllers</h1>-->
<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>