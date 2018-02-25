<?php
/* @var $this TreatmentSchedulesController */
/* @var $model TreatmentSchedules */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'record_id'); ?>
		<?php echo $form->textField($model,'record_id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'start_date'); ?>
		<?php echo $form->textField($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'end_date'); ?>
		<?php echo $form->textField($model,'end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'diagnosis_id'); ?>
		<?php echo $form->textField($model,'diagnosis_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pathological_id'); ?>
		<?php echo $form->textField($model,'pathological_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'doctor_id'); ?>
		<?php echo $form->textField($model,'doctor_id',array('size'=>11,'maxlength'=>11)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->