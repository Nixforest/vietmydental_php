<?php
/* @var $this ReceptionistController */
/* @var $schedule TreatmentSchedules */
/* @var $detail TreatmentScheduleDetails */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'schedules-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($schedule); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($schedule, 'time_id'); ?>
            <?php echo $form->dropDownList($schedule, 'time_id', ScheduleTimes::loadItems()); ?>
            <?php echo $form->error($schedule, 'time_id'); ?>
        </div>
        <div class="col-md-6">
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <label for="TreatmentSchedules_start_date"><?php echo DomainConst::CONTENT00442; ?></label>
            <?php
            if (!isset($schedule->start_date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
            } else {
                $date = CommonProcess::convertDateTime($schedule->start_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_3);
                if (empty($date)) {
                    $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
                }
            }
            $this->widget('DatePickerWidget', array(
                'model' => $schedule,
                'field' => 'start_date',
                'value' => $date,
            ));
            ?>
            <?php echo $form->error($schedule, 'start_date'); ?>
        </div>
        <div class="col-md-6">
            <!--//++ BUG0067-IMT (DuongNV 20180831) Add 6 month book schedule btn-->
            <label for="TreatmentSchedules_next">Hẹn vào</label>
            <div class="btn btn-primary btn-xs plus-3-month">+3 Tháng</div>
            <div class="btn btn-primary btn-xs plus-6-month">+6 Tháng</div>
            <!--//-- BUG0067-IMT (DuongNV 20180831) Add 6 month book schedule btn-->
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($schedule, 'doctor_id'); ?>
            <?php
            echo $form->dropDownList($schedule, 'doctor_id', Users::getListUser(
                            Roles::getRoleByName(Roles::ROLE_DOCTOR)->id, Yii::app()->user->agent_id)
            );
            ?>
            <?php echo $form->error($schedule, 'doctor_id'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($schedule, 'insurrance'); ?>
            <?php echo $form->textField($schedule, 'insurrance', array('size' => 10, 'maxlength' => 10)); ?>
            <?php echo $form->error($schedule, 'insurrance'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php echo $form->labelEx($detail, 'description'); ?>
            <?php echo $form->textArea($detail, 'description', array('rows' => 6, 'cols' => 500)); ?>
            <?php echo $form->error($detail, 'description'); ?>
        </div>
    </div>

    <div class="row buttons">
        <?php
        echo CHtml::submitButton($schedule->isNewRecord ? DomainConst::CONTENT00179 : 'Save', array(
            'name' => 'submit',
        ));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/autoNumeric/autoNumeric.js'); ?>

<script>
    $(document).ready(function () {
        $('#TreatmentSchedules_insurrance').autoNumeric('init', {lZero: "deny", aPad: false});
    });
</script>