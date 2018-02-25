<?php
/* @var $this EmailTemplatesController */
/* @var $model EmailTemplates */

$this->breadcrumbs=array(
	'Email Templates'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List EmailTemplates', 'url'=>array('index')),
	array('label'=>'Manage EmailTemplates', 'url'=>array('admin')),
);
?>

<h1>Create EmailTemplates</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>