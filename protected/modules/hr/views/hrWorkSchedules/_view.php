<?php
/* @var $this HrWorkSchedulesController */
/* @var $data HrWorkSchedules */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_day')); ?>:</b>
	<?php echo CHtml::encode($data->work_day); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_shift_id')); ?>:</b>
	<?php echo CHtml::encode($data->work_shift_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('work_plan_id')); ?>:</b>
	<?php echo CHtml::encode($data->work_plan_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employee_id')); ?>:</b>
	<?php echo CHtml::encode($data->employee_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	*/ ?>

</div>