<?php
/* @var $this DailyReportsController */
/* @var $model DailyReports */

//$this->breadcrumbs=array(
//	'Daily Reports'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List DailyReports', 'url'=>array('index')),
//	array('label'=>'Manage DailyReports', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<h1><?php echo $this->pageTitle;?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>