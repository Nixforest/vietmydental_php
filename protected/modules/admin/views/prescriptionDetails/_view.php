<?php
/* @var $this PrescriptionDetailsController */
/* @var $data PrescriptionDetails */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('prescription_id')); ?>:</b>
	<?php echo CHtml::encode($data->prescription_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('medicine_id')); ?>:</b>
	<?php echo CHtml::encode($data->medicine_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity')); ?>:</b>
	<?php echo CHtml::encode($data->quantity); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity1')); ?>:</b>
	<?php echo CHtml::encode($data->quantity1); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity2')); ?>:</b>
	<?php echo CHtml::encode($data->quantity2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity3')); ?>:</b>
	<?php echo CHtml::encode($data->quantity3); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('quantity4')); ?>:</b>
	<?php echo CHtml::encode($data->quantity4); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('note')); ?>:</b>
	<?php echo CHtml::encode($data->note); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	*/ ?>

</div>