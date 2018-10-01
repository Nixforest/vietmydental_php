<?php
/* @var $this HrHolidaysController */
/* @var $model HrHolidays */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'hr-holidays-form',
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
        <?php echo $form->labelEx($model, 'date'); ?>
        <?php
        if (!isset($model->isNewRecord)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
        } else {
            $date = CommonProcess::convertDateTime($model->date,
                        DomainConst::DATE_FORMAT_4,
                        DomainConst::DATE_FORMAT_BACK_END);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model'         => $model,
            'field'         => 'date',
            'value'         => $date,
            'isReadOnly'    => false,
        ));
        ?>
        <?php echo $form->error($model, 'date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type_id'); ?>
        <?php echo $form->dropdownlist($model, 'type_id', HrHolidayTypes::loadItems()); ?>
        <?php echo $form->error($model, 'type_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'compensatory_date'); ?>
        <?php
        if (!isset($model->isNewRecord)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
        } else {
            $date = CommonProcess::convertDateTime($model->compensatory_date,
                        DomainConst::DATE_FORMAT_4,
                        DomainConst::DATE_FORMAT_BACK_END);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model'         => $model,
            'field'         => 'compensatory_date',
            'value'         => $date,
            'isReadOnly'    => false,
        ));
        ?>
        <?php echo $form->error($model, 'compensatory_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', HrHolidays::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->