<?php
/* @var $this NewsController */
/* @var $model News */
/* @var $form CActiveForm */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/themes/ckeditor/ckeditor.js');
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'news-form',
	'enableAjaxValidation'=>false,
)); ?>

        <?php echo DomainConst::CONTENT00081; ?>

        <div class="row">
            <?php echo $form->labelEx($model,'category_id'); ?>
            <?php echo $form->dropDownList($model,'category_id', NewsCategories::loadItems(), array('class'=>'','empty'=>'Select')); ?>
            <?php echo $form->error($model,'category_id'); ?>
	</div>

	<?php echo $form->errorSummary($model); ?>

        <div class="row">
            <?php echo $form->labelEx($model,'status'); ?>
            <?php echo $form->dropDownList($model,'status', $model->getArrayStatus(), array('class'=>'','empty'=>'Select')); ?>
            <?php echo $form->error($model,'status'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50,'style'=>'width:500px;')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
        
	<div class="row">
            <?php echo $form->labelEx($model,'content'); ?>
            <?php echo $form->error($model,'content'); ?>
	</div>
        <div class="row">
            <?php echo $form->textArea($model,'content',array('rows'=>6, 'cols'=>50,'style'=>'width:500px;')); ?>
        </div>
	
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    CKEDITOR.replace( 'News_content' );
</script>