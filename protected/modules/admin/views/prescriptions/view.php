<?php
/* @var $this PrescriptionsController */
/* @var $model Prescriptions */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'process_id',
		'created_date',
		array(
                   'name'=>'doctor_id',
                   'value'=> isset($model->rDoctor) ? $model->rDoctor->getFullName() : '',
                ),
		'note',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
