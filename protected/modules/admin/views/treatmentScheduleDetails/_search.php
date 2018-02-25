<?php
/* @var $this TreatmentScheduleDetailsController */
/* @var $model TreatmentScheduleDetails */
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
		<?php echo $form->label($model,'schedule_id'); ?>
		<?php echo $form->textField($model,'schedule_id',array('size'=>11,'maxlength'=>11)); ?>
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
		<?php echo $form->label($model,'teeth_id'); ?>
		<?php echo $form->textField($model,'teeth_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'diagnosis_id'); ?>
		<?php echo $form->textField($model,'diagnosis_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'treatment_type_id'); ?>
		<?php echo $form->textField($model,'treatment_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type_schedule'); ?>
		<?php echo $form->textArea($model,'type_schedule',array('rows'=>6, 'cols'=>50)); ?>
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