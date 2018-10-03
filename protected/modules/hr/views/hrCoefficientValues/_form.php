<?php
/* @var $this HrCoefficientValuesController */
/* @var $model HrCoefficientValues */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'hr-coefficient-values-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'coefficient_id'); ?>
        <?php echo $form->dropdownlist($model, 'coefficient_id', HrCoefficients::loadItems()); ?>
        <?php echo $form->error($model, 'coefficient_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'value'); ?>
        <?php echo $form->textField($model, 'value'); ?>
        <?php echo $form->error($model, 'value'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'month'); ?>
        <?php
        if (!isset($model->isNewRecord)) {
            $month = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_13);
        } else {
            $month = CommonProcess::convertDateTime($model->month,
                        DomainConst::DATE_FORMAT_4,
                        DomainConst::DATE_FORMAT_13);
            if (empty($month)) {
                $month = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_13);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model'         => $model,
            'field'         => 'month',
            'value'         => $month,
            'isReadOnly'    => false,
            'format'        => DomainConst::DATE_FORMAT_14,
        ));
        ?>
        <?php echo $form->error($model, 'month'); ?>
    </div>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', HrDebts::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/autoNumeric/autoNumeric.js'); ?>
<script>
    $(document).ready(function(){
//        $('#HrCoefficientValues_value').autoNumeric('init', {lZero:"deny", aPad: false, vMin:'0.00000'} ); 
    });
</script>