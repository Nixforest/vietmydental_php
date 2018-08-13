<?php
/* @var $this DailyReportsController */
/* @var $data DailyReports */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receipt_customer_total')); ?>:</b>
	<?php echo CHtml::encode($data->receipt_customer_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receipt_total_total')); ?>:</b>
	<?php echo CHtml::encode($data->receipt_total_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receipt_discount_total')); ?>:</b>
	<?php echo CHtml::encode($data->receipt_discount_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receipt_final_total')); ?>:</b>
	<?php echo CHtml::encode($data->receipt_final_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('receipt_debit_total')); ?>:</b>
	<?php echo CHtml::encode($data->receipt_debit_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('new_customer_total')); ?>:</b>
	<?php echo CHtml::encode($data->new_customer_total); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('new_total_total')); ?>:</b>
	<?php echo CHtml::encode($data->new_total_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('new_discount_total')); ?>:</b>
	<?php echo CHtml::encode($data->new_discount_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('new_final_total')); ?>:</b>
	<?php echo CHtml::encode($data->new_final_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('new_debit_total')); ?>:</b>
	<?php echo CHtml::encode($data->new_debit_total); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('approve_id')); ?>:</b>
	<?php echo CHtml::encode($data->approve_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_by')); ?>:</b>
	<?php echo CHtml::encode($data->created_by); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	*/ ?>

</div>