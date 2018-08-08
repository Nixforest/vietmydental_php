<?php
/* @var $this PromotionDetailsController */
/* @var $model PromotionDetails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'promotions-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_types_id'); ?>
                <?php echo $form->dropDownList($model,'customer_types_id', CustomerTypes::loadItems(), array('class'=>'','empty'=>'Select')); ?>
		<?php echo $form->error($model,'customer_types_id'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>3, 'cols'=>50,'style'=>'width:600px;')); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type', $model->getArrayType(), array('class'=>'','empty'=>'Select')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'discount'); ?>
		<?php echo $form->textField($model,'discount',[]); ?>
		<?php echo $form->error($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'treatments'); ?>
                <?php
                   $this->widget('ext.multiselect.JMultiSelect',array(
                         'model'=>$model,
                         'attribute'=>'treatments',
                         'data'=> TreatmentTypes::loadItems(),
                         // additional javascript options for the MultiSelect plugin
                        'options'=>array('selectedList' => 30,),
                         // additional style
                         'htmlOptions'=>array('style' => 'width: 600px;'),
                   ));    
               ?>
		<?php echo $form->error($model,'treatments'); ?>
	</div>
        
        <div class="row" style='display:none;'>
		<?php echo $form->labelEx($model,'status'); ?>
                <?php echo $form->dropDownList($model,'status', $model->getArrayStatus(), array('class'=>'')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php include '_view_list.php'; ?> 		<?php include '_view_list.php'; ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/autoNumeric/autoNumeric.js'); ?>
<script>
    $(document).ready(function(){
        <?php if($model->type == PromotionDetails::TYPE_SERVICE){?> 
            $('#PromotionDetails_discount').autoNumeric('init', {lZero:"deny", aPad: false} ); 
        <?php } ?>
        $('#PromotionDetails_type').on('change',function(){
            $('#PromotionDetails_discount').val('');
            $('#PromotionDetails_discount').autoNumeric('destroy'); 
            $('#PromotionDetails_discount').next('.autoDiscount').remove();
            if($(this).val() == <?php echo PromotionDetails::TYPE_DISCOUNT; ?>){
                $('#PromotionDetails_discount').after('<b class="autoDiscount" style="color:red;font-size:1.2em;margin-left:10px;"><?php echo DomainConst::CONTENT00410; ?><b>');
            }
            if($(this).val() == <?php echo PromotionDetails::TYPE_SERVICE; ?>){
                $('#PromotionDetails_discount').autoNumeric('init', {lZero:"deny", aPad: false} ); 
            }
        });
    });
</script> 