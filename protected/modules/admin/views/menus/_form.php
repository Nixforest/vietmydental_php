<?php
/* @var $this MenusController */
/* @var $model Menus */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menus-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'module_id'); ?>
                <?php echo $form->dropDownList($model, 'module_id', Modules::loadItems(true)); ?>
		<?php echo $form->error($model,'module_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'controller_id'); ?>
		<?php echo $form->dropDownList($model, 'controller_id', Controllers::loadItems(true)); ?>
		<?php echo $form->error($model,'controller_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'action'); ?>
		<?php echo $form->textField($model,'action',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'action'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'display_order'); ?>
		<?php echo $form->textField($model,'display_order'); ?>
		<?php echo $form->error($model,'display_order'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'show_in_menu'); ?>
		<?php echo $form->textField($model,'show_in_menu'); ?>
		<?php echo $form->error($model,'show_in_menu'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'place_holder_id'); ?>
		<?php echo $form->textField($model,'place_holder_id'); ?>
		<?php echo $form->error($model,'place_holder_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'application_id'); ?>
		<?php echo $form->dropDownList($model,'application_id', Applications::loadItems()); ?>
		<?php echo $form->error($model,'application_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model, 'parent_id', Menus::loadItems(true)); ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->