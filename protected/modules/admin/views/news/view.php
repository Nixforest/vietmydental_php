<?php
/* @var $this NewsController */
/* @var $model News */

//$this->breadcrumbs=array(
//	'News'=>array('index'),
//	$model->id,
//);
//
//$this->menu=array(
//	array('label'=>'List News', 'url'=>array('index')),
//	array('label'=>'Create News', 'url'=>array('create')),
//	array('label'=>'Update News', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete News', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage News', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle.' '. $model->id;?></h1>

<?php // $this->widget('zii.widgets.CDetailView', array(
//	'data'=>$model,
//	'attributes'=>array(
//		'id',
//		'content',
//		'status',
//		'created_date',
//		'created_by',
//	),
//)); ?>
<?php echo $model->content; ?>