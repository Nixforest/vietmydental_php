<?php
/* @var $this DailyReportsController */
/* @var $model DailyReports */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'daily-reports-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'receipt_customer_total'); ?>
		<?php echo $form->textField($model,'receipt_customer_total'); ?>
		<?php echo $form->error($model,'receipt_customer_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receipt_total_total'); ?>
		<?php echo $form->textField($model,'receipt_total_total'); ?>
		<?php echo $form->error($model,'receipt_total_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receipt_discount_total'); ?>
		<?php echo $form->textField($model,'receipt_discount_total'); ?>
		<?php echo $form->error($model,'receipt_discount_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receipt_final_total'); ?>
		<?php echo $form->textField($model,'receipt_final_total'); ?>
		<?php echo $form->error($model,'receipt_final_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'receipt_debit_total'); ?>
		<?php echo $form->textField($model,'receipt_debit_total'); ?>
		<?php echo $form->error($model,'receipt_debit_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_customer_total'); ?>
		<?php echo $form->textField($model,'new_customer_total'); ?>
		<?php echo $form->error($model,'new_customer_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_total_total'); ?>
		<?php echo $form->textField($model,'new_total_total'); ?>
		<?php echo $form->error($model,'new_total_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_discount_total'); ?>
		<?php echo $form->textField($model,'new_discount_total'); ?>
		<?php echo $form->error($model,'new_discount_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_final_total'); ?>
		<?php echo $form->textField($model,'new_final_total'); ?>
		<?php echo $form->error($model,'new_final_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'new_debit_total'); ?>
		<?php echo $form->textField($model,'new_debit_total'); ?>
		<?php echo $form->error($model,'new_debit_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'approve_id'); ?>
		<?php echo $form->textField($model,'approve_id',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'approve_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->