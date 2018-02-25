<?php
/* @var $this RolesController */
/* @var $model Roles */

//$this->breadcrumbs=array(
//	'Roles'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List Roles', 'url'=>array('index')),
//	array('label'=>'Manage Roles', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<!--<h1>Create Roles</h1>-->
<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>