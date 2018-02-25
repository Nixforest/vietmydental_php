<?php
/* @var $this TreatmentScheduleProcessController */
/* @var $data TreatmentScheduleProcess */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('detail_id')); ?>:</b>
	<?php echo CHtml::encode($data->detail_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('process_date')); ?>:</b>
	<?php echo CHtml::encode($data->process_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('teeth_id')); ?>:</b>
	<?php echo CHtml::encode($data->teeth_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('doctor_id')); ?>:</b>
	<?php echo CHtml::encode($data->doctor_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>