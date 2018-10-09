<?php
/* @var $this HrFunctionsController */
/* @var $model HrFunctions */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'hr-functions-form',
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
        <?php echo $form->labelEx($model, 'function'); ?>
        <?php echo $form->textArea($model, 'function', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'function'); ?>
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
        <?php echo $form->labelEx($model, 'is_per_day'); ?>
        <?php echo $form->dropdownlist($model, 'is_per_day', HrFunctions::getArrIsPerDayText()); ?>
        <?php echo $form->error($model, 'is_per_day'); ?>
    </div>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', HrParameters::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->