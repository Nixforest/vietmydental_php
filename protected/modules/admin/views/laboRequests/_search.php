<?php
/* @var $this LaboRequestsController */
/* @var $model LaboRequests */
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
		<?php echo $form->label($model,'treatment_detail_id'); ?>
		<?php echo $form->textField($model,'treatment_detail_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'service_id'); ?>
		<?php echo $form->textField($model,'service_id',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_request'); ?>
		<?php echo $form->textField($model,'date_request'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_receive'); ?>
		<?php echo $form->textField($model,'date_receive'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_test'); ?>
		<?php echo $form->textField($model,'date_test'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tooth_color'); ?>
		<?php echo $form->textField($model,'tooth_color',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'teeths'); ?>
		<?php echo $form->textArea($model,'teeths',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>10,'maxlength'=>10)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->