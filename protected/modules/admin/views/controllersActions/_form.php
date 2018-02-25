<?php
/* @var $this ControllersActionsController */
/* @var $model ControllersActions */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'controllers-actions-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'controller_id'); ?>
		<?php echo $form->dropDownList($model, 'controller_id', Controllers::loadItems(false)); ?>
		<?php echo $form->error($model,'controller_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'action'); ?>
                <?php // echo $form->dropDownList($model,'action', CommonProcess::getListActions()); ?>
                <?php echo $form->textField($model,'action',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'action'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textArea($model,'name',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->