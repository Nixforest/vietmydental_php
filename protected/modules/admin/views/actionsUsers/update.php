<?php
/* @var $this ActionsUsersController */
/* @var $model ActionsUsers */

//$this->breadcrumbs=array(
//	'Actions Users'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List ActionsUsers', 'url'=>array('index')),
//	array('label'=>'Create ActionsUsers', 'url'=>array('create')),
//	array('label'=>'View ActionsUsers', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage ActionsUsers', 'url'=>array('admin')),
//);
$this->createMenu('update', $model);
?>

<!--<h1>Update ActionsUsers <?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>