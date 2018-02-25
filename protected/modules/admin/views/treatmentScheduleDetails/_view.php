<?php
/* @var $this TreatmentScheduleDetailsController */
/* @var $data TreatmentScheduleDetails */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('schedule_id')); ?>:</b>
	<?php echo CHtml::encode($data->schedule_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('start_date')); ?>:</b>
	<?php echo CHtml::encode($data->start_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('end_date')); ?>:</b>
	<?php echo CHtml::encode($data->end_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('teeth_id')); ?>:</b>
	<?php echo CHtml::encode($data->teeth_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('diagnosis_id')); ?>:</b>
	<?php echo CHtml::encode($data->diagnosis_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('treatment_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->treatment_type_id); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_schedule')); ?>:</b>
	<?php echo CHtml::encode($data->type_schedule); ?>
	<br />
        
	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

</div>