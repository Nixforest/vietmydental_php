<?php
/* @var $this NewsController */
/* @var $model News */

//$this->breadcrumbs=array(
//	'News'=>array('index'),
//	$model->id=>array('view','id'=>$model->id),
//	'Update',
//);
//
//$this->menu=array(
//	array('label'=>'List News', 'url'=>array('index')),
//	array('label'=>'Create News', 'url'=>array('create')),
//	array('label'=>'View News', 'url'=>array('view', 'id'=>$model->id)),
//	array('label'=>'Manage News', 'url'=>array('admin')),
//);
$this->createMenu('update', $model);
?>

<h1><?php echo $this->pageTitle .' '. $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>