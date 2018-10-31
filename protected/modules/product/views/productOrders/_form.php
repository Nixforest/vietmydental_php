<?php
/* @var $this ProductOrdersController */
/* @var $model ProductOrders */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-orders-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'book_date'); ?>
        <?php
        if (!isset($model->isNewRecord)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
        } else {
            $date = CommonProcess::convertDateTime($model->book_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_BACK_END);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model' => $model,
            'field' => 'book_date',
            'value' => $date,
            'isReadOnly' => false,
        ));
        ?>
        <?php echo $form->error($model, 'book_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'payment_code'); ?>
        <?php echo $form->textField($model, 'payment_code', array('size' => 30, 'maxlength' => 30)); ?>
        <?php echo $form->error($model, 'payment_code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'payment_date'); ?>
        <?php
        if (!isset($model->isNewRecord)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
        } else {
            $date = CommonProcess::convertDateTime($model->payment_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_BACK_END);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model' => $model,
            'field' => 'payment_date',
            'value' => $date,
            'isReadOnly' => false,
        ));
        ?>
        <?php echo $form->error($model, 'payment_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'order_date'); ?>
        <?php
        if (!isset($model->isNewRecord)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
        } else {
            $date = CommonProcess::convertDateTime($model->order_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_BACK_END);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model' => $model,
            'field' => 'order_date',
            'value' => $date,
            'isReadOnly' => false,
        ));
        ?>
        <?php echo $form->error($model, 'order_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'customer_id'); ?>
        <?php echo $form->hiddenField($model, 'customer_id', array('class' => '')); ?>
        <?php
        $custName = isset($model->rCustomer) ? $model->rCustomer->getAutoCompleteCustomerName() : '';
        $aData = array(
            'model'         => $model,
            'field_id'      => 'customer_id',
            'update_value'  => $custName,
            'ClassAdd'      => 'w-350',
            'url'           => Yii::app()->createAbsoluteUrl('admin/ajax/searchCustomer'),
            'field_autocomplete_name' => 'autocomplete_name_customer',
        );
        $this->widget('ext.AutocompleteExt.AutocompleteExt', array('data' => $aData));
        ?>
        <?php echo $form->error($model, 'customer_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'order_type'); ?>
        <?php echo $form->dropDownList($model, 'order_type', CommonProcess::getTypeOfOrder(true)); ?>
        <?php echo $form->error($model, 'order_type'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'note'); ?>
        <?php echo $form->textArea($model, 'note', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'note'); ?>
    </div>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', ProductOrders::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->