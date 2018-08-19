<?php
/* @var $this LaboRequestsController */
/* @var $model LaboRequests */

//$this->breadcrumbs=array(
//	'Labo Requests'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List LaboRequests', 'url'=>array('index')),
//	array('label'=>'Create LaboRequests', 'url'=>array('create')),
//	array('label'=>'View LaboRequests', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage LaboRequests', 'url'=>array('admin')),
//);
$this->createMenu('', $model);
?>

<h1><?php echo $this->pageTitle .' '. $model->id; ?></h1>

<?php echo $this->renderPartial('_form_ajax', array('model'=>$model)); ?>