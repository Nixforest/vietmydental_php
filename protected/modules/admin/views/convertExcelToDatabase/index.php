<?php
$this->createMenu('create', $model);
?>

<h1><?php echo $this->pageTitle; ?></h1>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'promotions-form',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
    
    <div class="row">
        <?php echo $form->label($model,'Name model insert'); ?>
        <?php echo $form->textField($model,'model_name'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'field compare'); ?>
        <?php echo $form->textField($model,'model_field_compare'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'field insert'); ?>
        <?php echo $form->textField($model,'model_field_insert'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'Field id of model parent'); ?>
        <?php echo $form->textField($model,'model_field_insert_parent_id'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'Name of model parent'); ?>
        <?php echo $form->textField($model,'model_name_compare_parent'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'field compare in parent'); ?>
        <?php echo $form->textField($model,'model_field_compare_parent'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model,'Chọn file insert'); ?>
        <?php echo $form->fileField($model,'file_excel'); ?>
    </div>
    <div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->