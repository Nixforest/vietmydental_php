<?php
/* @var $this InsuranceCompaniesController */
/* @var $model InsuranceCompanies */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'name',
		'description',
	),
)); ?>
