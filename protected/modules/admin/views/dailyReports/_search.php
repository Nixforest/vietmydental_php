<?php
/* @var $this DailyReportsController */
/* @var $model DailyReports */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'receipt_customer_total'); ?>
		<?php echo $form->textField($model,'receipt_customer_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'receipt_total_total'); ?>
		<?php echo $form->textField($model,'receipt_total_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'receipt_discount_total'); ?>
		<?php echo $form->textField($model,'receipt_discount_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'receipt_final_total'); ?>
		<?php echo $form->textField($model,'receipt_final_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'receipt_debit_total'); ?>
		<?php echo $form->textField($model,'receipt_debit_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'new_customer_total'); ?>
		<?php echo $form->textField($model,'new_customer_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'new_total_total'); ?>
		<?php echo $form->textField($model,'new_total_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'new_discount_total'); ?>
		<?php echo $form->textField($model,'new_discount_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'new_final_total'); ?>
		<?php echo $form->textField($model,'new_final_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'new_debit_total'); ?>
		<?php echo $form->textField($model,'new_debit_total'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'approve_id'); ?>
		<?php echo $form->textField($model,'approve_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->