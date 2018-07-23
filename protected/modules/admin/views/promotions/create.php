<?php
/* @var $this PromotionsController */
/* @var $model Promotions */

//$this->breadcrumbs=array(
//	'Promotions'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List Promotions', 'url'=>array('index')),
//	array('label'=>'Manage Promotions', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>