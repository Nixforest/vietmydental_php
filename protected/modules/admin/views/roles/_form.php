<?php
/* @var $this RolesController */
/* @var $model Roles */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'roles-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'role_name'); ?>
        <?php echo $form->textField($model, 'role_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'role_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'role_short_name'); ?>
        <?php echo $form->textField($model, 'role_short_name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'role_short_name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'application_id'); ?>
        <?php echo $form->dropDownList($model, 'application_id', Applications::loadItems()); ?>
        <?php echo $form->error($model, 'application_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'working_type'); ?>
        <?php echo $form->dropDownList($model, 'working_type', Roles::getArrayWorkingType()); ?>
        <?php echo $form->error($model, 'working_type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'isStaff'); ?>
        <?php echo $form->dropDownList($model, 'isStaff', Roles::getArrayIsStaff()); ?>
        <?php echo $form->error($model, 'isStaff'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'weight'); ?>
        <?php echo $form->textField($model,'weight'); ?>
        <?php echo $form->error($model, 'weight'); ?>
    </div>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', CommonProcess::getDefaultStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->