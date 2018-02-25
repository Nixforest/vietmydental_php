<?php
/* @var $this ApiUserTokensController */
/* @var $model ApiUserTokens */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'api-user-tokens-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->textField($model,'user_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'user_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role_id'); ?>
		<?php echo $form->textField($model,'role_id'); ?>
		<?php echo $form->error($model,'role_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'token'); ?>
		<?php echo $form->textField($model,'token',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'token'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gcm_device_token'); ?>
		<?php echo $form->textField($model,'gcm_device_token',array('size'=>60,'maxlength'=>350)); ?>
		<?php echo $form->error($model,'gcm_device_token'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'apns_device_token'); ?>
		<?php echo $form->textField($model,'apns_device_token',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'apns_device_token'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_active'); ?>
		<?php echo $form->textField($model,'last_active'); ?>
		<?php echo $form->error($model,'last_active'); ?>
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