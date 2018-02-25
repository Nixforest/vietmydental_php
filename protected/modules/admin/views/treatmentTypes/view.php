<?php
/* @var $this TreatmentTypesController */
/* @var $model TreatmentTypes */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'name',
		'description',
		'price',
		'material_price',
		'labo_price',
		array(
                   'name'=>'group_id',
                   'value'=> isset($model->rGroup) ? $model->rGroup->name : '',
                ),
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
