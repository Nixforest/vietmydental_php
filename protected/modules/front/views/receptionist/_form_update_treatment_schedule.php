<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'treatment-schedule-details-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'time_id'); ?>
            <?php echo $form->dropDownList($model, 'time_id', ScheduleTimes::loadItems()); ?>
            <?php echo $form->error($model, 'time_id'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'start_date'); ?>
            <?php
            if ($model->isNewRecord) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
            } else {
                $date = CommonProcess::convertDateTime($model->start_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_3);
                if (empty($date)) {
                    $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
                }
            }
            $this->widget('DatePickerWidget', array(
                'model' => $model,
                'field' => 'start_date',
                'value' => $date,
            ));
            ?>
            <?php echo $form->error($model, 'start_date'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <label for="teeth"><?php echo DomainConst::CONTENT00284; ?></label>
            <?php
            $aData = array(
                'model' => $model
            );
            $this->widget('ext.SelectToothExt.SelectToothExt', array('data' => $aData));
        ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php echo $form->labelEx($model, 'treatment_type_id'); ?>
            <?php // echo $form->dropDownList($model,'treatment_type_id', TreatmentTypes::loadItems(true));  ?>
            <?php echo $form->hiddenField($model, 'treatment_type_id', array('class' => '')); ?>
            <?php
            $treatment = isset($model->rTreatmentType) ?
                    $model->rTreatmentType->getAutoCompleteView() : '';
            $aData = array(
                'model' => $model,
                'field_id' => 'treatment_type_id',
                'update_value' => $treatment,
                'ClassAdd' => 'w-350',
                'url' => Yii::app()->createAbsoluteUrl('admin/ajax/searchTreatmentType'),
                'field_autocomplete_name' => 'autocomplete_treatment',
                'min_length' => 1,
            );
            $this->widget('ext.AutocompleteExt.AutocompleteExt', array('data' => $aData));
            ?>
            <?php echo $form->error($model, 'treatment_type_id'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>
    </div>

    <div class="row buttons">
        <?php // echo CHtml::submitButton($model->isNewRecord ? 'Create' : DomainConst::CONTENT00377);  ?>
        <?php
        if ($model->canUpdate()) {
            echo CHtml::submitButton(DomainConst::CONTENT00377, array(
                'name' => DomainConst::KEY_SUBMIT_SAVE,
            ));
        }
        ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->
