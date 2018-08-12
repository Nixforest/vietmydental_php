<?php
/* @var $this LaboRequestsController */
/* @var $model LaboRequests */

$this->breadcrumbs=array(
	'Labo Requests'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List LaboRequests', 'url'=>array('index')),
	array('label'=>'Manage LaboRequests', 'url'=>array('admin')),
);
?>

<h1>Create LaboRequests</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>