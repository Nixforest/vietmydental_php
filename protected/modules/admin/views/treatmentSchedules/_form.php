<?php
/* @var $this TreatmentSchedulesController */
/* @var $model TreatmentSchedules */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'treatment-schedules-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'record_id'); ?>
		<?php echo $form->hiddenField($model, 'record_id', array('class' => '')); ?>
                <?php
                    $medicalRecord = isset($model->rMedicalRecord) ?
                            $model->rMedicalRecord->getAutoCompleteMedicalRecord() : '';
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
		<?php echo $form->error($model,'record_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'time_id'); ?>
		<?php echo $form->dropDownList($model,'time_id', ScheduleTimes::loadItems(true)); ?>
		<?php echo $form->error($model,'time_id'); ?>
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
//                        'maxDate'       => '0',
                        'changeMonth'   => true,
                        'changeYear'    => true,
                        'showOn'        => 'button',
                        'buttonImage'   => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                        'buttonImageOnly' => true,
                    ),
                    'htmlOptions'=>array(
                                'class'=>'w-16',
//                                'style'=>'height:20px;width:166px;',
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
//                        'maxDate'       => '0',
                        'changeMonth'   => true,
                        'changeYear'    => true,
                        'showOn'        => 'button',
                        'buttonImage'   => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                        'buttonImageOnly' => true,
                    ),
                    'htmlOptions'=>array(
                                'class'=>'w-16',
//                                'style'=>'height:20px;width:166px;',
                                'readonly'=>'readonly',
                                'value' => $date,
                            ),
                ));
                ?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'diagnosis_id'); ?>
		<?php echo $form->dropDownList($model,'diagnosis_id', Diagnosis::loadChildItems(true)); ?>
		<?php echo $form->error($model,'diagnosis_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pathological_id'); ?>
		<?php echo $form->dropDownList($model,'pathological_id', Pathological::loadItems(true)); ?>
		<?php echo $form->error($model,'pathological_id'); ?>
	</div>

	<div class="row">
            <label for="pathological"><?php echo DomainConst::CONTENT00142; ?></label>
            <table style="">
                <?php
                    $pathologicals = Pathological::loadModels();
                    $rPathological = array();
                    if (isset($model->rJoinPathological)) {
                        foreach ($model->rJoinPathological as $item) {
                            $rPathological[] = $item->rPathological;
                        }
                    }
                ?>
                <?php foreach ($pathologicals as $pathological): ?>
                    <?php
                        $inputId = "pathological_" . $pathological->id;
                        $inputName = "pathological" . '[' . $pathological->id . ']';
                        $checked = "";
                    if (in_array($pathological, $rPathological)) {
                        $checked = 'checked="checked"';
                    }
                    ?>
                    <tr>
                        <td>
                            <input
                                name="<?php echo $inputName ?>"
                                value="1"
                                type="checkbox"
                                id="<?php echo $inputId ?>"
                                <?php echo $checked; ?>
                                >
                            <label for="<?php echo $inputId ?>" >
                                <?php echo $pathological->name; ?>
                            </label>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
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

<!--	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',
                        array(
                            'name'  => 'submit',
                        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<style>
    td label {
        float: none;
        padding-top: 0px;
        padding-left: 20px;
        text-align: left;
        width: 100%;
    }
/*    table, th, td {
        border: 1px solid black;
    }*/
</style>