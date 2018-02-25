<?php
/* @var $this ActionsRolesController */
/* @var $model ActionsRoles */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'actions-roles-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'role_id'); ?>
		<?php echo $form->dropDownList($model, 'role_id', Roles::loadItems(true)); ?>
		<?php echo $form->error($model,'role_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'controller_id'); ?>
		<?php echo $form->dropDownList($model, 'controller_id', Controllers::loadItems(true)); ?>
		<?php echo $form->error($model,'controller_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'actions'); ?>
		<?php echo $form->textArea($model,'actions',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'actions'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'can_access'); ?>
		<?php echo $form->dropDownList($model,'can_access', CommonProcess::getDefaultAccessStatus()); ?>
		<?php echo $form->error($model,'can_access'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->