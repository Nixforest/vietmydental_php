<?php
/* @var $this MenusController */
/* @var $data Menus */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('link')); ?>:</b>
	<?php echo CHtml::encode($data->link); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('module_id')); ?>:</b>
	<?php echo CHtml::encode($data->module_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('controller_id')); ?>:</b>
	<?php echo CHtml::encode($data->controller_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('action')); ?>:</b>
	<?php echo CHtml::encode($data->action); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('display_order')); ?>:</b>
	<?php echo CHtml::encode($data->display_order); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('show_in_menu')); ?>:</b>
	<?php echo CHtml::encode($data->show_in_menu); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('place_holder_id')); ?>:</b>
	<?php echo CHtml::encode($data->place_holder_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('application_id')); ?>:</b>
	<?php echo CHtml::encode($data->application_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('parent_id')); ?>:</b>
	<?php echo CHtml::encode($data->parent_id); ?>
	<br />

	*/ ?>

</div>