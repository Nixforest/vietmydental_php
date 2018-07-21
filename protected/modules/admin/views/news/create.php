<?php
/* @var $this NewsController */
/* @var $model News */

//$this->breadcrumbs=array(
//	'News'=>array('index'),
//	'Create',
//);
//
//$this->menu=array(
//	array('label'=>'List News', 'url'=>array('index')),
//	array('label'=>'Manage News', 'url'=>array('admin')),
//);
$this->createMenu('create', $model);
?>

<h1><?php echo $this->pageTitle;?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>