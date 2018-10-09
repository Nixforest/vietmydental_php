<?php
/* @var $this HrSalaryReportsController */
/* @var $model HrSalaryReports */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'hr-salary-reports-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'start_date'); ?>
        <?php
        if (!isset($model->start_date)) {
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

    <div class="row">
        <?php echo $form->labelEx($model, 'end_date'); ?>
        <?php
        if (!isset($model->end_date)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
        } else {
            $date = CommonProcess::convertDateTime($model->end_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_3);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model' => $model,
            'field' => 'end_date',
            'value' => $date,
        ));
        ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'role_id'); ?>
        <?php echo $form->dropdownlist($model, 'role_id', Roles::getRoleArrayForSalary()); ?>
        <?php echo $form->error($model, 'role_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type_id'); ?>
        <?php echo $form->dropdownlist($model, 'type_id', HrFunctionTypes::loadItems()); ?>
        <?php echo $form->error($model, 'type_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'data'); ?>
        <?php echo $form->textArea($model, 'data', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'data'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'approved'); ?>
        <?php echo $form->hiddenField($model, 'approved', array('class' => '')); ?>
        <?php
            $userName = isset($model->rApproved) ? $model->rApproved->getAutoCompleteUserName() : '';
            Loggers::info('Approver', $userName, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $aData = array(
                'model'             => $model,
                'field_id'          => 'approved',
                'update_value'      => $userName,
                'ClassAdd'          => 'w-400',
                'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchUser'),
                'field_autocomplete_name' => 'autocomplete_user',
            );
            $this->widget('ext.AutocompleteExt.AutocompleteExt',
                    array('data' => $aData));
        ?>
        <?php echo $form->error($model, 'approved'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'approved_date'); ?>
        <?php
        if (!isset($model->approved_date)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
        } else {
            $date = CommonProcess::convertDateTime($model->approved_date,
                        DomainConst::DATE_FORMAT_1,
                        DomainConst::DATE_FORMAT_BACK_END);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model'         => $model,
            'field'         => 'approved_date',
            'value'         => $date,
            'isReadOnly'    => false,
        ));
        ?>
        <?php echo $form->error($model, 'approved_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'notify'); ?>
        <?php echo $form->textArea($model, 'notify', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'notify'); ?>
    </div>
    
    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', HrHolidayPlans::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->