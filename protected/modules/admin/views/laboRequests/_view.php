<?php
/* @var $this LaboRequestsController */
/* @var $data LaboRequests */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('treatment_detail_id')); ?>:</b>
	<?php echo CHtml::encode($data->treatment_detail_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('service_id')); ?>:</b>
	<?php echo CHtml::encode($data->service_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_request')); ?>:</b>
	<?php echo CHtml::encode($data->date_request); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_receive')); ?>:</b>
	<?php echo CHtml::encode($data->date_receive); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_test')); ?>:</b>
	<?php echo CHtml::encode($data->date_test); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tooth_color')); ?>:</b>
	<?php echo CHtml::encode($data->tooth_color); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('teeths')); ?>:</b>
	<?php echo CHtml::encode($data->teeths); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo CHtml::encode($data->price); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('total')); ?>:</b>
	<?php echo CHtml::encode($data->total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	*/ ?>

</div>