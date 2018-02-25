<?php
/* @var $this SettingsController */
/* @var $model Settings */

//$this->breadcrumbs=array(
//	'Settings'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List Settings', 'url'=>array('index')),
//	array('label'=>'Manage Settings', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<!--<h1>Create Settings</h1>-->
<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>