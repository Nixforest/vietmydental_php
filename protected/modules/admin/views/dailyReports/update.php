<?php
/* @var $this DailyReportsController */
/* @var $model DailyReports */

//$this->breadcrumbs=array(
//	'Daily Reports'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List DailyReports', 'url'=>array('index')),
//	array('label'=>'Create DailyReports', 'url'=>array('create')),
//	array('label'=>'View DailyReports', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage DailyReports', 'url'=>array('admin')),
//);
$this->createMenu('update', $model);
?>

<h1><?php echo $this->pageTitle .' '. $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>