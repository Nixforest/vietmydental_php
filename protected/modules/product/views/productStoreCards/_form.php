<?php
/* @var $this ProductStoreCardsController */
/* @var $model ProductStoreCards */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-store-cards-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'input_date'); ?>
        <?php
        if (!isset($model->isNewRecord)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
        } else {
            $date = CommonProcess::convertDateTime($model->input_date,
                    DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_BACK_END);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model'         => $model,
            'field'         => 'input_date',
            'value'         => $date,
            'isReadOnly'    => false,
        ));
        ?>
        <?php echo $form->error($model, 'input_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'store_id'); ?>
        <?php echo $form->dropDownList($model, 'store_id', ProductStores::loadItems()); ?>
        <?php echo $form->error($model, 'store_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type_id'); ?>
        <?php echo $form->dropDownList($model, 'type_id', ProductStoreCardTypes::loadItems()); ?>
        <?php echo $form->error($model, 'type_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'order_id'); ?>
        <?php echo $form->textField($model, 'order_id'); ?>
        <?php echo $form->error($model, 'order_id'); ?>
    </div>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', ProductStoresDetails::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->