<?php
/* @var $this ModulesController */
/* @var $model Modules */

$this->breadcrumbs=array(
	'Modules'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Modules', 'url'=>array('index')),
	array('label'=>'Manage Modules', 'url'=>array('admin')),
);
$this->createMenu('create', $model);
?>

<!--<h1>Create Modules</h1>-->
<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>