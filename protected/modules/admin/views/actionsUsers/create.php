<?php
/* @var $this ActionsUsersController */
/* @var $model ActionsUsers */

//$this->breadcrumbs=array(
//	'Actions Users'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List ActionsUsers', 'url'=>array('index')),
//	array('label'=>'Manage ActionsUsers', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<!--<h1>Create ActionsUsers</h1>-->
<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>