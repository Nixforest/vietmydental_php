<?php
/* @var $this ControllersActionsController */
/* @var $model ControllersActions */

//$this->breadcrumbs=array(
//	'Controllers Actions'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List ControllersActions', 'url'=>array('index')),
//	array('label'=>'Manage ControllersActions', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<!--<h1>Create ControllersActions</h1>-->
<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>