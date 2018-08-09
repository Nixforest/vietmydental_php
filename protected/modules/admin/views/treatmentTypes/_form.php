<?php
/* @var $this TreatmentTypesController */
/* @var $model TreatmentTypes */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'treatment-types-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php // echo $form->textField($model,'price',array('size'=>11,'maxlength'=>11)); ?>
                <?php echo $form->textField($model, 'price',
                        array(
                            "class" => "ad_fix_currency",
                            'size' => 20,
                            'maxlength' => 12)
                        );
                ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'material_price'); ?>
		<?php echo $form->textField($model,'material_price',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'material_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'labo_price'); ?>
		<?php echo $form->textField($model,'labo_price',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'labo_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'group_id'); ?>
		<?php echo $form->dropDownList($model,'group_id', TreatmentGroup::loadItems()); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>

        <!--//++ BUG0059-IMT (NguyenPT 20180809) Add new status of TreatmentTypes-->
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', TreatmentTypes::getStatus()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
        <!--//-- BUG0059-IMT (NguyenPT 20180809) Add new status of TreatmentTypes-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/autoNumeric/autoNumeric.js"></script>
<script>
//    $(document).ready(function () {
//        fnInitInputCurrency();
//    });
//    
//    function fnInitInputCurrency() {
//        $(".ad_fix_currency").each(function(){
////            $(this).autoNumeric();
//            $(this).autoNumeric('init', {lZero:"deny", aPad: false} ); 
//        });    
//    }
    $(function(){
        $(".ad_fix_currency").each(function(){
            $(this).autoNumeric('init', {lZero:"deny", aPad: false} );
        }
    });
</script>