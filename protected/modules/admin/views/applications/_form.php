<?php
/* @var $this ApplicationsController */
/* @var $model Applications */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'applications-form',
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
		<?php echo $form->labelEx($model,'short_name'); ?>
		<?php echo $form->textField($model,'short_name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'short_name'); ?>
	</div>
        <div class="row" style="display: none">
		<?php echo $form->labelEx($model,'is_delete'); ?>
		<?php echo $form->textField($model,'is_delete',array(
                    'size' => 60,
                    'value' => DomainConst::NUMBER_ZERO_VALUE,
                    'readonly' => true)); ?>
		<?php echo $form->error($model,'is_delete'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->