<?php
/* @var $this ApplicationsController */
/* @var $model Applications */

//$this->breadcrumbs=array(
//	'Applications'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List Applications', 'url'=>array('index')),
//	array('label'=>'Manage Applications', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<!--<h1>Create Applications</h1>-->
<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>