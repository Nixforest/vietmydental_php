<?php

/* @var $this ReceptionistController */
/* @var $schedule TreatmentSchedules */
/* @var $detail TreatmentScheduleDetails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'schedules-form',
	'enableAjaxValidation'=>false,
)); ?>

    <?php echo DomainConst::CONTENT00081; ?>

    <?php echo $form->errorSummary($schedule); ?>

    <div class="row">
        <label for="TreatmentSchedules_start_date" class="required"><?php echo DomainConst::CONTENT00208; ?> <span class="required">*</span></label>
        <?php // echo $form->labelEx($schedule,'start_date'); ?>
        <?php echo $form->dropDownList($schedule,'time_id', ScheduleTimes::loadItems()); ?>
        <?php echo $form->error($schedule,'time_id'); ?>
        <?php echo $form->dateField($schedule, 'start_date'); ?>
        <?php
//        Yii::import('application.extensions.CJuiDateTimePicker.CJuiDateTimePicker');
//            $this->widget('CJuiDateTimePicker',array(
//                'model'=>$schedule, //Model object
//                'attribute'=>'start_date', //attribute name
//                'mode'=>'datetime', //use "time","date" or "datetime" (default)
//                'language'=>'en-GB',
//                'options'=>array(
//                    'showAnim'=>'fold',
//                    'showButtonPanel'=>true,
//                    'autoSize'=>true,
//                    'dateFormat'=>'dd-mm-yy',
//                    'timeFormat'=>'hh:mm:ss',
//                    'width'=>'120',
//                    'separator'=>' ',
//                    'showOn' => 'button',
//                    'buttonImage'=> Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
//                    'buttonImageOnly'=> true,
//                    'changeMonth' => true,
//                    'changeYear' => true,
//                    //                'regional' => 'en-GB'
//                ),
//                'htmlOptions' => array(
//                    'style' => 'width:148px;',
//                ),
//            ));
            ?>
        <?php echo $form->error($schedule,'start_date'); ?>
    </div>

<!--    <div class="row">
        <?php echo $form->labelEx($schedule,'end_date'); ?>
        <?php echo $form->dateField($schedule, 'end_date'); ?>
        <?php echo $form->error($schedule,'end_date'); ?>
    </div>-->

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

<!--    <div class="row">
        <?php echo $form->labelEx($detail,'type_schedule'); ?>
        <?php echo $form->textArea($detail,'type_schedule',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($detail,'type_schedule'); ?>
    </div>-->

    <div class="row">
        <?php echo $form->labelEx($detail,'description'); ?>
        <?php echo $form->textArea($detail,'description',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($detail,'description'); ?>
    </div>

    <div class="row buttons">
            <?php echo CHtml::submitButton($schedule->isNewRecord ? DomainConst::CONTENT00179 : 'Save',
                    array(
                        'name'  => 'submit',
                    )); ?>
    </div>
<?php $this->endWidget(); ?>
</div><!-- form -->
