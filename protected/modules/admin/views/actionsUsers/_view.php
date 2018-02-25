<?php
/* @var $this ActionsUsersController */
/* @var $data ActionsUsers */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('controller_id')); ?>:</b>
	<?php echo CHtml::encode($data->controller_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('actions')); ?>:</b>
	<?php echo CHtml::encode($data->actions); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('can_access')); ?>:</b>
	<?php echo CHtml::encode($data->can_access); ?>
	<br />


</div>