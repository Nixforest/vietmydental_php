<?php
/* @var $this TreatmentScheduleProcessController */
/* @var $model TreatmentScheduleProcess */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'treatment-schedule-process-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'detail_id'); ?>
		<?php echo $form->textField($model,'detail_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'detail_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'process_date'); ?>
		<?php
                if ($model->isNewRecord) {
                    $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
                } else {
                    $date = CommonProcess::convertDateTime($model->process_date,
                            DomainConst::DATE_FORMAT_4,
                            DomainConst::DATE_FORMAT_3);
                }
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'     => $model,
                    'attribute' => 'process_date',
                    'options'   => array(
                        'showAnim'      => 'fold',
                        'dateFormat'    => DomainConst::DATE_FORMAT_2,
                        'changeMonth'   => true,
                        'changeYear'    => true,
                        'showOn'        => 'button',
                        'buttonImage'   => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                        'buttonImageOnly' => true,
                    ),
                    'htmlOptions'=>array(
                                'class'=>'w-16',
                                'readonly'=>'readonly',
                                'value' => $date,
                            ),
                ));
                ?>
		<?php echo $form->error($model,'process_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'teeth_id'); ?>
		<?php echo $form->dropDownList($model,'teeth_id', CommonProcess::getListTeeth()); ?>
		<?php echo $form->error($model,'teeth_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'doctor_id'); ?>
		<?php echo $form->hiddenField($model, 'doctor_id', array('class' => '')); ?>
                <?php
                    $userName = isset($model->rDoctor) ? $model->rDoctor->getAutoCompleteUserName() : '';
                    $url = Yii::app()->createAbsoluteUrl('admin/ajax/searchUser',
                            array('role'=> Roles::getRoleByName('ROLE_DOCTOR')->id));
                    $aData = ['model'             => $model,
                        'field_id'          => 'doctor_id',
                        'update_value'      => $userName,
                        'ClassAdd'          => 'w-350',
                        'url'               => $url,
                        'field_autocomplete_name' => 'autocomplete_name_doctor',
                       ];
                    $this->widget('ext.AutocompleteExt.AutocompleteExt',
                            array('data' => $aData));
                ?>
		<?php echo $form->error($model,'doctor_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
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