<?php
/* @var $this HrWorkSchedulesController */
/* @var $model HrWorkSchedules */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'hr-work-schedules-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'work_day'); ?>
        <?php
        if (!isset($model->isNewRecord)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
        } else {
            $date = CommonProcess::convertDateTime($model->work_day,
                        DomainConst::DATE_FORMAT_4,
                        DomainConst::DATE_FORMAT_BACK_END);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model'         => $model,
            'field'         => 'work_day',
            'value'         => $date,
            'isReadOnly'    => false,
        ));
        ?>
        <?php echo $form->error($model, 'work_day'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'work_shift_id'); ?>
        <?php echo $form->dropdownlist($model, 'work_shift_id', HrWorkShifts::loadItems()); ?>
        <?php echo $form->error($model, 'work_shift_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'work_plan_id'); ?>
        <?php echo $form->dropdownlist($model, 'work_plan_id', HrWorkPlans::loadItems()); ?>
        <?php echo $form->error($model, 'work_plan_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'employee_id'); ?>
        <?php echo $form->hiddenField($model, 'employee_id', array('class' => '')); ?>
        <?php
            $userName = isset($model->rUser) ? $model->rUser->getAutoCompleteUserName() : '';
            $aData = array(
                'model'             => $model,
                'field_id'          => 'employee_id',
                'update_value'      => $userName,
                'ClassAdd'          => 'w-400',
                'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchUser'),
                'field_autocomplete_name' => 'autocomplete_user',
            );
            $this->widget('ext.AutocompleteExt.AutocompleteExt',
                    array('data' => $aData));
        ?>
        <?php echo $form->error($model, 'employee_id'); ?>
    </div>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', HrWorkSchedules::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->