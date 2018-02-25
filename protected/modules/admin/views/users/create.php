<?php
/* @var $this UsersController */
/* @var $model Users */
//$this->breadcrumbs=array(
//	//'Users'=>array('index'),
//        $this->controllerDescription=>array('index'),
//	$this->pageTitle,
//);
//
//$this->menu=array(
//	array('label'=>'List Users', 'url'=>array('index')),
//	array('label'=>'Manage Users', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>