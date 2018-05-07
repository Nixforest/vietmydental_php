<?php
/* @var $this WarrantyTypesController */
/* @var $model WarrantyTypes */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ': ' . $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'name',
		'time',
		'description',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
