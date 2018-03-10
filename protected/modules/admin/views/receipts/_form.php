<?php
/* @var $this ReceiptsController */
/* @var $model Receipts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'receipts-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'detail_id'); ?>
		<?php echo $form->textField($model,'detail_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'detail_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'process_date'); ?>
		<?php echo $form->textField($model,'process_date'); ?>
		<?php echo $form->error($model,'process_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount'); ?>
		<?php echo $form->textField($model,'discount',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'need_approve'); ?>
		<?php echo $form->textField($model,'need_approve'); ?>
		<?php echo $form->error($model,'need_approve'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_confirm'); ?>
		<?php echo $form->textField($model,'customer_confirm'); ?>
		<?php echo $form->error($model,'customer_confirm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->