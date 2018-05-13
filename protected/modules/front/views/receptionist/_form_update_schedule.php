<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
 ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'treatment-schedule-details-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>
        <div class="row">
            <label for="TreatmentScheduleDetails_start_date" class="required"><?php echo DomainConst::CONTENT00208; ?> <span class="required">*</span></label>
            <?php // echo $form->labelEx($model,'start_date'); ?>
            <?php echo $form->dropDownList($model,'time_id', ScheduleTimes::loadItems(true)); ?>
            <?php echo $form->error($model,'time_id'); ?>
            <?php echo $form->dateField($model, 'start_date'); ?>
            <?php echo $form->error($model,'start_date'); ?>
        </div>
    <div class="row">
        <?php echo $form->labelEx($schedule,'doctor_id'); ?>
        <?php echo $form->dropDownList($schedule,'doctor_id',
                Users::getListUser(
                        Roles::getRoleByName(Roles::ROLE_DOCTOR)->id,
                        Yii::app()->user->agent_id)
                ); ?>
        <?php echo $form->error($schedule,'doctor_id'); ?>
    </div>

    <div class="row">
            <?php echo $form->labelEx($schedule,'insurrance'); ?>
            <?php echo $form->textField($schedule,'insurrance',array('size'=>10,'maxlength'=>10)); ?>
            <?php echo $form->error($schedule,'insurrance'); ?>
    </div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'type_schedule'); ?>
		<?php echo $form->textArea($model,'type_schedule',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'type_schedule'); ?>
	</div>-->

        <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
