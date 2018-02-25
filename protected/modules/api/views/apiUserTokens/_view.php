<?php
/* @var $this ApiUserTokensController */
/* @var $data ApiUserTokens */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type')); ?>:</b>
	<?php echo CHtml::encode($data->type); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('role_id')); ?>:</b>
	<?php echo CHtml::encode($data->role_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('token')); ?>:</b>
	<?php echo CHtml::encode($data->token); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gcm_device_token')); ?>:</b>
	<?php echo CHtml::encode($data->gcm_device_token); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('apns_device_token')); ?>:</b>
	<?php echo CHtml::encode($data->apns_device_token); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_active')); ?>:</b>
	<?php echo CHtml::encode($data->last_active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created_date')); ?>:</b>
	<?php echo CHtml::encode($data->created_date); ?>
	<br />

	*/ ?>

</div>