<?php
/* @var $this LaboRequestsController */
/* @var $model LaboRequests */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'labo-requests-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'treatment_detail_id'); ?>
        <?php echo $form->textField($model, 'treatment_detail_id', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'treatment_detail_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'service_id'); ?>
        <?php echo $form->textField($model, 'service_id', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'service_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'date_request'); ?>
        <?php echo $form->textField($model, 'date_request'); ?>
        <?php echo $form->error($model, 'date_request'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'date_receive'); ?>
        <?php echo $form->textField($model, 'date_receive'); ?>
        <?php echo $form->error($model, 'date_receive'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'date_test'); ?>
        <?php echo $form->textField($model, 'date_test'); ?>
        <?php echo $form->error($model, 'date_test'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'tooth_color'); ?>
        <?php echo $form->textField($model, 'tooth_color', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'tooth_color'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textField($model, 'description', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'price'); ?>
        <?php echo $form->textField($model, 'price'); ?>
        <?php echo $form->error($model, 'price'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->textField($model, 'status'); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'created_date'); ?>
        <?php echo $form->textField($model, 'created_date'); ?>
        <?php echo $form->error($model, 'created_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'created_by'); ?>
        <?php echo $form->textField($model, 'created_by', array('size' => 10, 'maxlength' => 10)); ?>
        <?php echo $form->error($model, 'created_by'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->