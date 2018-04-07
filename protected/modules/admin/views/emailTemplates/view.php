<?php
/* @var $this EmailTemplatesController */
/* @var $model EmailTemplates */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'subject',
		'body',
		'param_description',
		'type',
	),
)); ?>
