<?php
/* @var $this CitiesController */
/* @var $model Cities */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cities-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

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
       $("#Cities_name").change(function() {
           var nameValue = $("#Cities_name").val();
           var short = getShortString(nameValue);
           var slug = getSlugString(nameValue);
           $("#Cities_short_name").val(short);
           $("#Cities_slug").val(slug);
       });
    });
</script>