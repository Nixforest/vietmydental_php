<?php
/* @var $this DistrictsController */
/* @var $model Districts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'districts-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
		<?php echo $form->dropDownList($model,'city_id', Cities::loadItems()); ?>
		<?php echo $form->error($model,'city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'short_name'); ?>
		<?php
                 echo $form->textField(
                        $model,
                         'short_name',
                         array(
                             'size' => 60,
                             'maxlength' => 150,
                             'readonly' => true
                             )
                         );
                ?>
		<?php echo $form->error($model,'short_name'); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php
                 echo $form->textField(
                        $model,
                         'slug',
                         array(
                             'size' => 60,
                             'maxlength' => 150,
                             'readonly' => true
                             )
                         );
                ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $(document).ready(function() {
       $("#Districts_name").change(function() {
           var nameValue = $("#Districts_name").val();
           var short = getShortString(nameValue);
           var slug = getSlugString(nameValue);
           $("#Districts_short_name").val(short);
           $("#Districts_slug").val(slug);
       });
    });
</script>