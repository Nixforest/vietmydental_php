<?php
/* @var $this HrWorkShiftsController */
/* @var $model HrWorkShifts */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'hr-work-shifts-form',
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
        <?php echo $form->labelEx($model, 'from_id'); ?>
        <?php echo $form->dropdownlist($model, 'from_id', ScheduleTimes::loadItems()); ?>
        <?php echo $form->error($model, 'from_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'to_id'); ?>
        <?php echo $form->dropdownlist($model, 'to_id', ScheduleTimes::loadItems()); ?>
        <?php echo $form->error($model, 'to_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'role_id'); ?>
        <?php echo $form->dropdownlist($model, 'role_id', Roles::getRoleArrayForSalary()); ?>
        <?php echo $form->error($model, 'role_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->dropdownlist($model, 'type', HrWorkShifts::getArrayTypes()); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'factor'); ?>
        <?php echo $form->textField($model, 'factor'); ?>
        <?php echo $form->error($model, 'factor'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'color'); ?>
        <?php
        // echo $form->textField($model, 'color'); 
        $this->widget('application.extensions.colorpicker.EColorPicker', array(
            'name'      => 'HrWorkShifts[color]',
            'mode'      => 'textfield',
            'fade'      => false,
            'slide'     => false,
            'curtain'   => true,
            'value'     => $model->color,
        ));
        ?>

        <?php echo $form->error($model, 'color'); ?>
    </div>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropdownlist($model, 'status', HrWorkShifts::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->