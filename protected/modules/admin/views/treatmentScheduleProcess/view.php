<?php
/* @var $this TreatmentScheduleProcessController */
/* @var $model TreatmentScheduleProcess */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'detail_id',
		'process_date',
		'teeth_id',
		'name',
		'description',
		array(
                   'name'=>'doctor_id',
                   'value'=> isset($model->rDoctor) ? $model->rDoctor->getFullName() : '',
                ),
		'note',
		array(
                   'name'=>'status',
                    'value' => TreatmentScheduleProcess::getStatus()[$model->status],
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
