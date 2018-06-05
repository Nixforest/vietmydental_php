<?php
/* @var $this ReceiptsController */
/* @var $model Receipts */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'receipts-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>
        
    <div class="row">
        <label for="teeth">Răng </label>
        <label for="teeth"><?php echo $detail->generateTeethInfo(", "); ?> </label>
    </div>
    <div class="row">
        <label for="price">Đơn giá </label>
        <label for="price"><?php echo $detail->getTreatmentPriceText(); ?> </label>
    </div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'total'); ?>
		<?php
                echo $form->textField($model, 'total', array(
                    'size' => 11,
                    'maxlength' => 11,
                    'value' => $total,
                    ));
                ?>
                <input size="11" maxlength="11" value="" id="Receipts_total_view" type="text" readonly="true">
		<?php echo $form->error($model,'total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount'); ?>
		<?php echo $form->textField($model,'discount',array('size'=>11,'maxlength'=>11)); ?>
                <input size="11" maxlength="11" value="" id="Receipts_discount_view" type="text" readonly="true">
		<?php echo $form->error($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'final'); ?>
		<?php echo $form->textField($model,'final',array('size'=>10,'maxlength'=>10)); ?>
                <input size="11" maxlength="11" value="" id="Receipts_final_view" type="text" readonly="true">
		<?php echo $form->error($model,'final'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row" style="display: none">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php
                echo $form->textField(
                        $model, 'created_date', array(
                            'value' => date(DomainConst::DATE_FORMAT_1),
                            'readonly' => 'true',
                        )
                );
                ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',
                        array(
                            'name'  => 'submit',
                        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $(document).ready(function() {
        fnUpdateValue("#Receipts_total", "#Receipts_total_view");
        fnUpdateValue("#Receipts_discount", "#Receipts_discount_view");
        fnUpdateValue("#Receipts_final", "#Receipts_final_view");
       $("#Receipts_total").change(function() {
           fnUpdateValue("#Receipts_total", "#Receipts_total_view");
       });
       $("#Receipts_discount").change(function() {
           fnUpdateValue("#Receipts_discount", "#Receipts_discount_view");
       });
       $("#Receipts_final").change(function() {
           fnUpdateValue("#Receipts_final", "#Receipts_final_view");
       });
    });
</script>