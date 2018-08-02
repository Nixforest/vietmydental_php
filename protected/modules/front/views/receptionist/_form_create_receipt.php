<?php

/* @var $this ReceptionistController */
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
        <!--//++ BUG0043-IMT (DuongNV 20180730) Show tooth in receipt screen-->
        <!--<label for="teeth"><?php // echo $detail->generateTeethInfo(", "); ?> </label>-->
        <?php 
        $aData = array(
                'model' => $model->rTreatmentScheduleDetail
                );
        $this->widget('ext.SelectToothExt.SelectToothExt',
                    array('data' => $aData));
        ?>
        <!--//-- BUG0043-IMT (DuongNV 20180730) Show tooth in receipt screen-->
    </div>
    <div class="row">
        <label for="price">Đơn giá </label>
        <label for="price"><?php echo $detail->getTreatmentPriceText(); ?> </label>
    </div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'total'); ?>
                <!--//++ BUG0045-IMT  (DuongNV 201807) Format currency when input-->
		<?php
                echo $form->textField($model, 'total', array(
                    'size' => 11,
                    'maxlength' => 11,
                    'value' => $total,
                    'class' => 'format-currency number_only',
                    ));
                ?>
                <h4>&#8363;</h4><!--VND Sign-->
                <!--<input size="11" maxlength="11" value="" id="Receipts_total_view" type="text" readonly="true">-->
                <!--//-- BUG0045-IMT  (DuongNV 201807) Format currency when input-->
		<?php echo $form->error($model,'total'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'discount'); ?>
                <!--//++ BUG0045-IMT  (DuongNV 201807) Format currency when input-->
		<?php echo $form->textField($model,'discount',array('size'=>11,'maxlength'=>11, 'class'=>'format-currency number_only')); ?>
                <h4>&#8363;</h4><!--VND Sign-->
                <!--<input size="11" maxlength="11" value="" id="Receipts_discount_view" type="text" readonly="true">-->
                <!--//-- BUG0045-IMT  (DuongNV 201807) Format currency when input-->
		<?php echo $form->error($model,'discount'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'final'); ?>
                <!--//++ BUG0045-IMT  (DuongNV 201807) Format currency when input-->
		<?php echo $form->textField($model,'final',array('size'=>10,'maxlength'=>11, 'class'=>'format-currency number_only')); ?>
                <h4>&#8363;</h4><!--VND Sign-->
                <!--<input size="11" maxlength="11" value="" id="Receipts_final_view" type="text" readonly="true">-->
                <!--//-- BUG0045-IMT  (DuongNV 201807) Format currency when input-->
		<?php echo $form->error($model,'final'); ?>
	</div>

	<div class="row">
		<label for="debit">Bệnh nhân còn nợ</label>
                <input size="11" maxlength="11" value="<?php echo $customer->getDebt() ?>" id="Receipts_debit" type="text" readonly="true">
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'process_date'); ?>
		<?php
                if ($model->isNewRecord) {
                    $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
                } else {
                    $date = CommonProcess::convertDateTime($model->process_date,
                            DomainConst::DATE_FORMAT_4,
                            DomainConst::DATE_FORMAT_3);
                }
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'     => $model,
                    'attribute' => 'process_date',
                    'options'   => array(
                        'showAnim'      => 'fold',
                        'dateFormat'    => DomainConst::DATE_FORMAT_2,
                        'maxDate'       => '0',
                        'changeMonth'   => true,
                        'changeYear'    => true,
                        'showOn'        => 'button',
                        'buttonImage'   => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                        'buttonImageOnly' => true,
                    ),
                    'htmlOptions'=>array(
                                'class'=>'w-16',
//                                'style'=>'height:20px;width:166px;',
                                'readonly'=>'readonly',
                                'value' => $date,
                            ),
                ));
                ?>
		<?php echo $form->error($model,'process_date'); ?>
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
		<?php echo CHtml::submitButton(DomainConst::CONTENT00377,
                        array(
                            'name'  => 'submit',
                        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $(document).ready(function() {
        //++ BUG0043-IMT (DuongNV 20180730) Show tooth in receipt screen
        var style = '<style>'+
                    '.select-gr-tooth{display: none!important;}'+
                    '.portlet-content{text-align: left;}'+
                    '</style>';
        $('head').append(style);
        //-- BUG0043-IMT (DuongNV 20180730) Show tooth in receipt screen
        formatNumber("#Receipts_total");
        formatNumber("#Receipts_discount");
        formatNumber("#Receipts_final");
        
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
    //++ BUG0045-IMT  (DuongNV 201807) Format currency when input
    $(document).on('input', '.format-currency', function(){
        var t = $(this).val();
        t = t.replace(/[,]/g,'');
        t = t.replace(/[.]/g,'');
        $(this).val(fnFormatNumber(t));
    });
    
    function formatNumber(_id) {
        var t = $(_id).val();
        t = t.replace(/[,]/g,'');
        t = t.replace(/[.]/g,'');
        $(_id).val(fnFormatNumber(t));
    };
    $(document).on('input', '#Receipts_total, #Receipts_discount', function(){
        var total = $('#Receipts_total').val();
        total = total.replace(/[,]/g,'');
        total = total.replace(/[.]/g,'');
        var discount = $('#Receipts_discount').val();
        discount = discount.replace(/[,]/g,'');
        discount = discount.replace(/[.]/g,'');
        $('#Receipts_final').val(fnFormatNumber(total-discount));
    });
    fnNumberOnly();
    //-- BUG0045-IMT  (DuongNV 201807) Format currency when input
</script>