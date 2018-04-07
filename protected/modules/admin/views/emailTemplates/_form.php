<?php
/* @var $this EmailTemplatesController */
/* @var $model EmailTemplates */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'email-templates-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php // echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
                <div style="padding-left:141px;">
                    <?php
                    $this->widget('ext.niceditor.nicEditorWidget', array(
                        "model" => $model, // Data-Model
                        "attribute" => 'body', // Attribute in the Data-Model        
                        "config" => array(
                            "buttonList" => Yii::app()->params['niceditor_list_buttons'],
                        ),
                        "width" => DomainConst::EDITOR_WIDTH,           // Optional default to 100%
                        "height" => DomainConst::EDITOR_HEIGHT,   // Optional default to 150px
                    ));
                    ?>                                
                </div>
		<?php echo $form->error($model,'body'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'param_description'); ?>
		<?php echo $form->textArea($model,'param_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'param_description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->textField($model,'type'); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->