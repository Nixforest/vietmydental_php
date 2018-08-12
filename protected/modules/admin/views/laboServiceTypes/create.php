<?php
/* @var $this LaboServiceTypesController */
/* @var $model LaboServiceTypes */
//
//$this->breadcrumbs=array(
//	'Labo Service Types'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List LaboServiceTypes', 'url'=>array('index')),
//	array('label'=>'Manage LaboServiceTypes', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<h1><?php echo $this->pageTitle;?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>