<?php
/* @var $this TreatmentScheduleDetailsController */
/* @var $model TreatmentScheduleDetails */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'schedule_id',
		'start_date',
		'end_date',
		'teeth_id',
		array(
                   'name'=>'diagnosis_id',
                   'value'=> isset($model->rDiagnosis) ? $model->rDiagnosis->name : '',
                ),
		array(
                   'name'=>'treatment_type_id',
                   'value'=> isset($model->rTreatmentType) ? $model->rTreatmentType->name : '',
                ),
		'description',
		'type_schedule',
                array(
                    'name'  => DomainConst::CONTENT00026,
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value' => TreatmentScheduleDetails::getStatus()[$model->status],
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
