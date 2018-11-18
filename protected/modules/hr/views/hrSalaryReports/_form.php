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
    <div class="row">
        <div class="col-md-12">
            <?php // echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
            <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377, array(
                'name'  => 'submit',
                'style' => 'margin: 10px 10px 10px 154px; background: teal',
            )); ?>
        </div>
    </div>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>


    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'type_id'); ?>
            <?php echo $form->dropdownlist($model, 'type_id', HrFunctionTypes::loadItems()); ?>
            <?php echo $form->error($model, 'type_id'); ?>
        </div>
            
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'start_date'); ?>
            <?php
            if (!isset($model->start_date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
            } else {
                $date = CommonProcess::convertDateTime($model->start_date, DomainConst::DATE_FORMAT_DB, DomainConst::DATE_FORMAT_3);
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
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'end_date'); ?>
            <?php
            if (!isset($model->end_date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
            } else {
                $date = CommonProcess::convertDateTime($model->end_date, DomainConst::DATE_FORMAT_DB, DomainConst::DATE_FORMAT_3);
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
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'approved'); ?>
            <?php echo $form->hiddenField($model, 'approved', array('class' => '')); ?>
            <?php
            $userName = isset($model->rApproved) ? $model->rApproved->getAutoCompleteUserName() : '';
            $aData = array(
                'model' => $model,
                'field_id' => 'approved',
                'update_value' => $userName,
                'ClassAdd' => 'w-400',
                'url' => Yii::app()->createAbsoluteUrl('admin/ajax/searchUser'),
                'field_autocomplete_name' => 'autocomplete_user',
            );
            $this->widget('ext.AutocompleteExt.AutocompleteExt', array('data' => $aData));
            ?>
            <?php echo $form->error($model, 'approved'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'approved_date'); ?>
            <?php
            if (!isset($model->approved_date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            } else {
                $date = CommonProcess::convertDateTime($model->approved_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_BACK_END);
                if (empty($date)) {
                    $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
                }
            }
            $this->widget('DatePickerWidget', array(
                'model' => $model,
                'field' => 'approved_date',
                'value' => $date,
                'isReadOnly' => false,
            ));
            ?>
            <?php echo $form->error($model, 'approved_date'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'notify'); ?>
            <?php echo $form->textArea($model, 'notify', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'notify'); ?>
        </div>
        <div class="col-md-6" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $form->dropDownList($model, 'status', HrHolidayPlans::getArrayStatus()); ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
        <?php
            $this->widget('SearchUserForSalaryWidget', array(
                'model'         => $model,
            ));
        ?>
        </div>
    </div>
    <div>
        <h1><?php echo DomainConst::CONTENT00011; ?></h1>
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'hr-users-grid',
            'dataProvider' => $model->getUserArrayProvider(),
//            'filter' => $model,
            'columns' => $dataColumn,
            ));
        ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->