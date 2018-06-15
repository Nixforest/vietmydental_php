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
<?php if ($customer !== NULL): ?>
<div class="form">
    <h1><?php echo DomainConst::CONTENT00135 . ': ' . $customer->name; ?></h1>
    

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customers-form',
	'enableAjaxValidation'=>false,
));
if (isset($customer->rMedicalRecord)) {
            $recordNumber = $customer->rMedicalRecord->record_number;
        }
?>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($customer,'date_of_birth'); ?>
            <?php echo $form->textField($customer,'date_of_birth', array('size'=>60,'maxlength'=>255, 'readonly' => true)); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($customer,'gender'); ?>
            <?php echo $form->dropDownList($customer,'gender', array(CommonProcess::getGender()[$customer->gender]), array('readonly' => true)); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($customer,'phone'); ?>
            <?php echo $form->textField($customer,'phone', array('readonly' => true)); ?>
        </div>
        <div class="col-md-6">
            <label for="Customers_date_of_birth" class="required"><?php echo DomainConst::CONTENT00136; ?> </label>
            <input size="60" maxlength="255" readonly="readonly" name="Customers[date_of_birth]" id="Customers_date_of_birth" value="<?php echo $recordNumber; ?>" type="text">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $form->labelEx($customer,'address'); ?>
            <?php echo $form->textArea($customer,'address', array('readonly' => true)); ?>
        </div>
    </div>
    
<?php $this->endWidget(); ?>
</div>
<?php endif; // end if (condition) ?>

<?php if ($detail !== NULL): ?>
<div class="form">
    <h1><?php echo DomainConst::CONTENT00146 . ' ngày: ' . $detail->getStartDate(); ?></h1>
    

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customers-form',
	'enableAjaxValidation'=>false,
));
?>
    <div class="row">
<!--        <div class="col-md-6">
            <label for="teeth"><?php echo DomainConst::CONTENT00284; ?></label>
            <?php // echo $detail->generateTeethInfo(", "); ?>
        </div>-->
        <div class="col-md-6">
            <?php echo $form->labelEx($detail,'diagnosis_id'); ?>
            <?php echo $form->dropDownList($detail,'diagnosis_id', array(Diagnosis::loadChildItems(true)[$detail->diagnosis_id]), array('readonly' => true)); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($detail,'treatment_type_id'); ?>
            <?php echo $form->dropDownList($detail,'treatment_type_id', array(TreatmentTypes::loadItems(true)[$detail->treatment_type_id]), array('readonly' => true)); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $form->labelEx($detail,'description'); ?>
            <?php echo $form->textArea($detail,'description', array('readonly' => true)); ?>
        </div>
    </div>
    
<?php $this->endWidget(); ?>
</div>
<?php endif; // end if (condition) ?>
