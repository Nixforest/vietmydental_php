<?php
/* @var $this CommentsController */
/* @var $model Comments */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'comments-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>
    <div class="row">
        <?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50,'style'=>'width:500px;')); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'relate_id'); ?>
        <?php echo $form->textField($model, 'relate_id'); ?>
        <?php echo $form->error($model, 'relate_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->dropDownList($model, 'type', Comments::getArrayTypes(), array('class' => '', 'empty' => 'Select')); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', Comments::getArrayStatus(), array('class' => '', 'empty' => 'Select')); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    CKEDITOR.replace( 'Comments_content' );
</script>