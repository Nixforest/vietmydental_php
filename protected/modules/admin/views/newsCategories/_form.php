<?php
/* @var $this NewsCategoriesController */
/* @var $model NewsCategories */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'news-categories-form',
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
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'parent_id'); ?>
        <?php echo $form->dropDownList($model, 'parent_id', NewsCategories::loadItems(), array('class' => '', 'empty' => 'Select')); ?>
        <?php echo $form->error($model, 'parent_id'); ?>
    </div>

    <div class="row" style="display: none">
        <?php echo $form->labelEx($model, 'created_date'); ?>
        <?php
        echo $form->textField(
                $model, 'created_date', array(
            'value' => date(DomainConst::DATE_FORMAT_1),
            'readonly' => 'true',
                )
        );
        ?>
        <?php echo $form->error($model, 'created_date'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->