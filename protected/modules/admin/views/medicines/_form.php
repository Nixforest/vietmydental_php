<?php
/* @var $this MedicinesController */
/* @var $model Medicines */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'medicines-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php echo $form->textField($model,'content',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit_id'); ?>
		<?php echo $form->dropDownList($model,'unit_id', Units::loadItems()); ?>
		<?php echo $form->error($model,'unit_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active_ingredient'); ?>
		<?php echo $form->textField($model,'active_ingredient',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'active_ingredient'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'use_id'); ?>
		<?php echo $form->dropDownList($model,'use_id', MedicineUses::loadItems()); ?>
		<?php echo $form->error($model,'use_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'manufacturer'); ?>
		<?php echo $form->textField($model,'manufacturer',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'manufacturer'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->dropDownList($model,'type_id', MedicineTypes::loadItems()); ?>
		<?php echo $form->error($model,'type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'buy_price'); ?>
		<?php echo $form->textField($model,'buy_price',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'buy_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sell_price'); ?>
		<?php echo $form->textField($model,'sell_price',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'sell_price'); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->