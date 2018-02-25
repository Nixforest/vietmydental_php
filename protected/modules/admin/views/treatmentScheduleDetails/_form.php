<?php
/* @var $this TreatmentScheduleDetailsController */
/* @var $model TreatmentScheduleDetails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'treatment-schedule-details-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

<!--	<div class="row">
            <label for="pathological"><?php echo DomainConst::CONTENT00138; ?></label>
            <input id="TreatmentScheduleDetails_record_id" class="TreatmentScheduleDetails[record_id]" type="hidden">
            <?php
                    $medicalRecord = isset($model->rSchedule)
                            ? (isset($model->rSchedule->rMedicalRecord)
                                ? $model->rSchedule->rMedicalRecord->getAutoCompleteMedicalRecord()
                                : '')
                            : '';
                    $aData = array(
                        'model'             => $model,
                        'field_id'          => 'record_id',
                        'update_value'      => $medicalRecord,
                        'ClassAdd'          => 'w-350',
                        'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchMedicalRecord'),
                        'field_autocomplete_name' => 'autocomplete_medical_record',
                    );
                    $this->widget('ext.AutocompleteExt.AutocompleteExt',
                            array('data' => $aData));
                ?>
        </div>-->
	<div class="row">
		<?php echo $form->labelEx($model,'schedule_id'); ?>
		<?php echo $form->dropDownList($model,'schedule_id', TreatmentSchedules::loadItems()); ?>
		<?php echo $form->error($model,'schedule_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php
                if ($model->isNewRecord) {
                    $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
                } else {
                    $date = CommonProcess::convertDateTime($model->start_date,
                            DomainConst::DATE_FORMAT_1,
                            DomainConst::DATE_FORMAT_3);
                }
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'     => $model,
                    'attribute' => 'start_date',
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
		<?php echo $form->error($model,'start_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php
                if ($model->isNewRecord) {
                    $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
                } else {
                    $date = CommonProcess::convertDateTime($model->end_date,
                            DomainConst::DATE_FORMAT_1,
                            DomainConst::DATE_FORMAT_3);
                }
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'     => $model,
                    'attribute' => 'end_date',
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
		<?php echo $form->error($model,'end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'teeth_id'); ?>
		<?php echo $form->dropDownList($model,'teeth_id', CommonProcess::getListTeeth()); ?>
		<?php echo $form->error($model,'teeth_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'diagnosis_id'); ?>
		<?php echo $form->dropDownList($model,'diagnosis_id', Diagnosis::loadChildItems(true)); ?>
		<?php echo $form->error($model,'diagnosis_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'treatment_type_id'); ?>
		<?php echo $form->dropDownList($model,'treatment_type_id', TreatmentTypes::loadItems(true)); ?>
		<?php echo $form->error($model,'treatment_type_id'); ?>
	</div>

        <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_schedule'); ?>
		<?php echo $form->textArea($model,'type_schedule',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'type_schedule'); ?>
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