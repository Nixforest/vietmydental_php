<?php
/* @var $this HrDebtsController */
/* @var $model HrDebts */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'hr-debts-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'user_id'); ?>
        <?php echo $form->hiddenField($model, 'user_id', array('class' => '')); ?>
        <?php
            $userName = isset($model->rUser) ? $model->rUser->getAutoCompleteUserName() : '';
            $aData = array(
                'model'             => $model,
                'field_id'          => 'user_id',
                'update_value'      => $userName,
                'ClassAdd'          => 'w-400',
                'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchUser'),
                'field_autocomplete_name' => 'autocomplete_user',
            );
            $this->widget('ext.AutocompleteExt.AutocompleteExt',
                    array('data' => $aData));
        ?>
        <?php echo $form->error($model, 'user_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'amount'); ?>
        <?php echo $form->textField($model, 'amount', array('size' => 11, 'maxlength' => 11)); ?>
        <?php echo $form->error($model, 'amount'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'reason'); ?>
        <?php echo $form->textArea($model, 'reason', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'reason'); ?>
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
            'model' => $model,
            'field' => 'month',
            'value' => $month,
            'isReadOnly'    => false,
            'format'    => DomainConst::DATE_FORMAT_14,
        ));
        ?>
        <?php echo $form->error($model, 'month'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php echo $form->dropDownList($model, 'type', HrDebts::getArrayTypes()); ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'relate_id'); ?>
        <?php echo $form->textField($model, 'relate_id', array('size' => 11, 'maxlength' => 11)); ?>
        <?php echo $form->error($model, 'relate_id'); ?>
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
        $('#HrDebts_amount').autoNumeric('init', {lZero:"deny", aPad: false} ); 
    });
</script>