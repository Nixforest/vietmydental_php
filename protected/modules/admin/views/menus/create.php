<?php
/* @var $this MenusController */
/* @var $model Menus */

//$this->breadcrumbs=array(
//	'Menuses'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List Menus', 'url'=>array('index')),
//	array('label'=>'Manage Menus', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<!--<h1>Create Menus</h1>-->
<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>