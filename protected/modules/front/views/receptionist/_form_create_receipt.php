<?php
/* @var $this ReceptionistController */
/* @var $model Receipts */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'receipts-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>

    <?php echo $form->errorSummary($model); ?>

    <!--<div class="row">-->
    <!--<label for="teeth">Số lượng răng </label>-->
    <!--//++ BUG0043-IMT (DuongNV 20180730) Show tooth in receipt screen-->
    <!--<label for="teeth"><?php // echo $detail->generateTeethInfo(", "); ?> </label>-->
    <?php
//        $aData = array(
//                'model' => $model->rTreatmentScheduleDetail
//                );
//        $this->widget('ext.SelectToothExt.SelectToothExt',
//                    array('data' => $aData));
    ?>
    <!--//-- BUG0043-IMT (DuongNV 20180730) Show tooth in receipt screen-->
    <!--</div>-->
    <div class="row">
        <div class="col-md-6">
            <!--<label for="teeth">Số lượng răng</label>-->
            <!--<label for="teeth"><?php echo $detail->getTeethCount(); ?> </label>-->
            <label for="teeth">SL răng x Đơn giá:</label>
            <label for="teeth"><?php echo $detail->getTeethCount() . ' x ' . $detail->getTreatmentPriceText() . ' ='; ?> </label>
        </div>
        <div class="col-md-6">
            <!--<label for="price">Đơn giá </label>-->
            <!--<label for="price"><?php echo $detail->getTreatmentPriceText(); ?> </label>-->
            <?php echo $form->labelEx($model, 'total'); ?>
            <?php
            echo $form->textField($model, 'total', array(
                'size' => 11,
                'maxlength' => 11,
                'value' => $total,
                'class' => 'format-currency number_only',
                'tabindex' => "1",
            ));
            ?>
            <h4>&#8363;</h4>
            <?php echo $form->error($model, 'total'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php // echo $form->labelEx($model, 'total'); ?>
            <!--//++ BUG0045-IMT  (DuongNV 201807) Format currency when input-->
            <?php
//            echo $form->textField($model, 'total', array(
//                'size' => 11,
//                'maxlength' => 11,
//                'value' => $total,
//                'class' => 'format-currency number_only',
//                'tabindex' => "1",
//            ));
            ?>
            <!--<h4>&#8363;</h4>VND Sign-->
            <!--<input size="11" maxlength="11" value="" id="Receipts_total_view" type="text" readonly="true">-->
            <!--//-- BUG0045-IMT  (DuongNV 201807) Format currency when input-->
            <?php // echo $form->error($model, 'total'); ?>
            <?php echo $form->labelEx($model, 'promotion_id'); ?>
            <?php echo $form->dropDownList($model, 'promotion_id', $model->getArrayDiscount($customer, $detail, true)); ?>
        </div>
        <div class="col-md-6">
            <!--<label for="Receipts_debit_new" title="= Tổng tiền - Giảm - Thực thu">Nợ mới</label>-->
            <!--<input size="11" maxlength="11" value="" id="Receipts_debit_new" type="text" readonly="true" class="format-currency" title="= Tổng tiền - Giảm - Thực thu">-->
            <!--<h4>&#8363;</h4>-->
            <?php echo $form->labelEx($model, 'discount'); ?>
            <?php
            echo $form->textField($model, 'discount', array(
                'size' => 11, 'maxlength' => 11,
                'class' => 'format-currency number_only',
                'tabindex' => "2",
            ));
            ?>
            <h4>&#8363;</h4>
            <?php echo $form->error($model, 'discount'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php // echo $form->labelEx($model, 'discount'); ?>
            <!--//++ BUG0045-IMT  (DuongNV 201807) Format currency when input-->
            <?php
//            echo $form->textField($model, 'discount', array(
//                'size' => 11, 'maxlength' => 11,
//                'class' => 'format-currency number_only',
//                'tabindex' => "2",
//            ));
            ?>
            <!--<h4>&#8363;</h4>VND Sign-->
            <!--<input size="11" maxlength="11" value="" id="Receipts_discount_view" type="text" readonly="true">-->
            <!--//-- BUG0045-IMT  (DuongNV 201807) Format currency when input-->
            <?php // echo $form->error($model, 'discount'); ?>
            <label for="Receipts_total_fee" title="= Tổng tiền - Giảm - Thực thu">Tổng chi phí</label>
            <input size="11" maxlength="11" value="" id="Receipts_total_fee" type="text" readonly="true" class="format-currency" title="= Tổng tiền - Giảm - Thực thu">
            <h4>&#8363;</h4>
        </div>
        <div class="col-md-6">
            <!--<label for="Receipts_debit">Nợ cũ</label>-->
            <!--<input size="11" maxlength="11" value="<?php echo CommonProcess::formatCurrency($customer->debt) ?>" id="Receipts_debit" type="text" readonly="true">-->
            <!--<h4>&#8363;</h4>-->
            <?php echo $form->labelEx($model, 'final'); ?>
            <?php
            echo $form->textField($model, 'final', array(
                'size' => 10, 'maxlength' => 11,
                'class' => 'format-currency number_only',
                'tabindex' => "3",
            ));
            ?>
            <h4>&#8363;</h4>
            <?php echo $form->error($model, 'final'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php // echo $form->labelEx($model, 'promotion_id'); ?>
            <?php // echo $form->radioButtonList($model, 'promotion_id', $model->getArrayDiscount($customer, $detail, true), ['separator' => '<br><br>',]); ?>
            <?php // echo $form->dropDownList($model, 'promotion_id', $model->getArrayDiscount($customer, $detail, true)); ?>
            <label for="Receipts_debit">Công nợ hiện tại</label>
            <input size="11" maxlength="11" value="<?php echo CommonProcess::formatCurrency($customer->debt) ?>" id="Receipts_debit" type="text" readonly="true">
            <h4>&#8363;</h4>
        </div>
        <div class="col-md-6">
            <label for="Receipts_debit_new" title="">Nợ mới</label>
            <input size="11" maxlength="11" value="" id="Receipts_debit_new" type="text" readonly="true" class="format-currency" title="= Tổng tiền - Giảm - Thực thu">
            <h4>&#8363;</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php // echo $form->labelEx($model, 'final'); ?>
            <!--//++ BUG0045-IMT (DuongNV 201807) Format currency when input-->
            <?php
//            echo $form->textField($model, 'final', array(
//                'size' => 10, 'maxlength' => 11,
//                'class' => 'format-currency number_only',
//                'tabindex' => "3",
//            ));
            ?>
            <!--<h4>&#8363;</h4>VND Sign-->
            <!--<input size="11" maxlength="11" value="" id="Receipts_final_view" type="text" readonly="true">-->
            <!--//-- BUG0045-IMT (DuongNV 201807) Format currency when input-->
            <?php // echo $form->error($model, 'final'); ?>
            <?php echo $form->labelEx($model, 'process_date'); ?>
            <?php
            if ($model->isNewRecord) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
            } else {
                $date = CommonProcess::convertDateTime($model->process_date, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3);
            }
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'process_date',
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => DomainConst::DATE_FORMAT_2,
                    'maxDate' => '0',
                    'changeMonth' => true,
                    'changeYear' => true,
                    'showOn' => 'button',
                    'buttonImage' => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                    'buttonImageOnly' => true,
                ),
                'htmlOptions' => array(
                    'class' => 'w-16',
                    'readonly' => 'readonly',
                    'value' => $date,
                ),
            ));
            ?>
            <?php echo $form->error($model, 'process_date'); ?>
        </div>
        <div class="col-md-6" style="<?php echo $model->isCompleted() ? 'display: none;': '';?>">
            <label for="Receipts_debit_total">Tổng nợ</label>
            <input size="11" maxlength="11" value="" id="Receipts_debit_total" type="text" readonly="true">
            <h4>&#8363;</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php // echo $form->labelEx($model, 'process_date'); ?>
            <?php
//            if ($model->isNewRecord) {
//                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
//            } else {
//                $date = CommonProcess::convertDateTime($model->process_date, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3);
//            }
//            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
//                'model' => $model,
//                'attribute' => 'process_date',
//                'options' => array(
//                    'showAnim' => 'fold',
//                    'dateFormat' => DomainConst::DATE_FORMAT_2,
//                    'maxDate' => '0',
//                    'changeMonth' => true,
//                    'changeYear' => true,
//                    'showOn' => 'button',
//                    'buttonImage' => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
//                    'buttonImageOnly' => true,
//                ),
//                'htmlOptions' => array(
//                    'class' => 'w-16',
//                    'readonly' => 'readonly',
//                    'value' => $date,
//                ),
//            ));
            ?>
            <?php // echo $form->error($model, 'process_date'); ?>
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 100)); ?>
            <?php echo $form->error($model, 'description'); ?>
        </div>
        <!--<div class="col-md-6">-->
            <?php // echo $form->labelEx($model, 'description'); ?>
            <?php // echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
            <?php // echo $form->error($model, 'description'); ?>
        <!--</div>-->
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
        <?php
            if ($model->canUpdate()) {
                echo CHtml::submitButton(DomainConst::CONTENT00377, array(
                    'name' => 'submit',
                    'visible' => 'true',
                ));
            }
        
        ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<!--<script type="text/javascript">-->
<script>
    $(function(){
        $('#Receipts_promotion_id').change(function () {
            changeByClickPromotion();
        });
    });
    $(document).ready(function () {
        //++ BUG0043-IMT (DuongNV 20180730) Show tooth in receipt screen
        var style = '<style>' +
                '.select-gr-tooth{display: none!important;}' +
                '.portlet-content{text-align: left;}' +
                '</style>';
        $('head').append(style);
//        alert(fnGetValue('#Receipts_final'));
        //-- BUG0043-IMT (DuongNV 20180730) Show tooth in receipt screen
        formatNumber("#Receipts_total");
        formatNumber("#Receipts_discount");
        formatNumber("#Receipts_final");
        fnCalculateValue();
        <?php if ($model->isNewRecord) : ?>
            changeByClickPromotion();
        <?php endif; ?>
    });
    //++ BUG0045-IMT  (DuongNV 201807) Format currency when input
    $(document).on('input', '.format-currency', function () {
        var t = $(this).val();
        t = t.replace(/[,]/g, '');
        t = t.replace(/[.]/g, '');
        $(this).val(fnFormatNumber(t));
    });
    /**
     * Handle when edit total or discount
     */
    $(document).on('input', '#Receipts_total, #Receipts_discount', function () {
        fnChangeDiscountOrTotal();
    });
    
    function fnChangeDiscountOrTotal() {
        var total       = fnGetValue('#Receipts_total');
        var discount    = fnGetValue('#Receipts_discount');
        $('#Receipts_total_fee').val(fnFormatNumber(total - discount));
        $('#Receipts_final').val(fnFormatNumber(total - discount));
        var oldDebt     = fnGetValue('#Receipts_debit');
        $('#Receipts_debit_new').val(0);
        $('#Receipts_debit_total').val(fnFormatNumber(oldDebt));
    }
    
    /**
     * Handle when edit final
     */
    $(document).on('input', '#Receipts_final', function () {
        fnCalculateValue();
    });
    
    /**
     * Calculate depend values
     */
    function fnCalculateValue() {
        var total       = fnGetValue('#Receipts_total');
        var discount    = fnGetValue('#Receipts_discount');
        var final       = fnGetValue('#Receipts_final');
        var oldDebt     = fnGetValue('#Receipts_debit');
        var debitNew    = total - discount - final;
        var totalDebt   = Number(debitNew) + Number(oldDebt);
        $('#Receipts_total_fee').val(fnFormatNumber(total - discount));
        $('#Receipts_debit_new').val(fnFormatNumber(debitNew));
        $('#Receipts_debit_total').val(fnFormatNumber(totalDebt));
    }

    /**
     * Format number
     * @param {String} _id Id of element
     * @returns {undefined}
     */
    function formatNumber(_id) {
        var t = $(_id).val();
        t = t.replace(/[,]/g, '');
        t = t.replace(/[.]/g, '');
        $(_id).val(fnFormatNumber(t));
    }
    
    /**
     * Get value of element
     * @param {String} _id Id of element
     * @returns {fnGetValue.retVal|jQuery}
     */
    function fnGetValue(_id) {
        var retVal = $(_id).val();
        retVal = retVal.replace(/[,]/g, '');
        retVal = retVal.replace(/[.]/g, '');
        return retVal;
    }
    fnNumberOnly();
    //-- BUG0045-IMT  (DuongNV 201807) Format currency when input
    //++ BUG0024-IMT (NamNH 20180807) add discount-->

    function changeByClickPromotion(){
        var discount_id = $('#Receipts_promotion_id').val();
        $.ajax({
            'url': '<?php echo Yii::app()->createAbsoluteUrl('admin/promotionDetails/getPromotionDetail');?>',
            'data': {'id':discount_id},
            'success':function(data){
                var discountValue = 0;
                var aRes = JSON.parse(data);
                if (typeof aRes['type'] != "undefined" || aRes['type'] != null){
                    var total = $('#Receipts_total').val();
                    total = total.replace(/[,]/g,'');
                    total = total.replace(/[.]/g,'');
                    if(aRes['type'] == <?php echo PromotionDetails::TYPE_DISCOUNT; ?>){
                        discountValue = total / 100 * aRes['value'];
                    }
                    if(aRes['type'] == <?php echo PromotionDetails::TYPE_SERVICE; ?>){
                        discountValue = aRes['value'];
                    }
                }
                $('#Receipts_discount').val(fnFormatNumber(discountValue));
                fnChangeDiscountOrTotal();
            }
        });
    }
    //-- BUG0024-IMT (NamNH 20180807) add discount-->
</script>