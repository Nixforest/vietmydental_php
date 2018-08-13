<?php
/* @var $this LaboRequestsController */
/* @var $model LaboRequests */

//$this->breadcrumbs=array(
//	'Labo Requests'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List LaboRequests', 'url'=>array('index')),
//	array('label'=>'Manage LaboRequests', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<h1><?php echo $this->pageTitle;?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>