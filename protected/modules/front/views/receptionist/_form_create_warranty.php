<?php
/* @var $this ReceptionistController */
/* @var $model Warranties */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'warranties-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>

    <?php echo $form->errorSummary($model, DomainConst::CONTENT00214); ?>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'customer_id'); ?>
            <?php echo $form->hiddenField($model, 'customer_id', array('class' => '')); ?>
            <?php
            $custName = isset($model->rCustomer) ? $model->rCustomer->getAutoCompleteCustomerName() : '';
            $aData = array(
                'model' => $model,
                'field_id' => 'customer_id',
                'update_value' => $custName,
                'url' => Yii::app()->createAbsoluteUrl('admin/ajax/searchCustomer'),
                'field_autocomplete_name' => 'autocomplete_name_customer',
            );
            $this->widget('ext.AutocompleteExt.AutocompleteExt', array('data' => $aData));
            ?>
            <?php echo $form->error($model, 'customer_id'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'type_id'); ?>
            <?php echo $form->dropDownList($model, 'type_id', WarrantyTypes::loadItems()); ?>
            <?php echo $form->error($model, 'type_id'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <label for="teeth"><?php echo DomainConst::CONTENT00284; ?></label>
            <?php
            $this->widget('ext.SelectToothExt.SelectToothExt',
                            array('data' => $aData));
            ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'start_date'); ?>
            <?php
            if ($model->isNewRecord) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
            } else {
                $date = CommonProcess::convertDateTime($model->start_date,
                        DomainConst::DATE_FORMAT_1,
                        DomainConst::DATE_FORMAT_3);
            }
            $this->widget('DatePickerWidget', array(
                'model'         => $model,
                'field'         => 'start_date',
                'value'         => $date,
                'isReadOnly'    => false,
            ));
            ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'end_date'); ?>
            <?php
            if ($model->isNewRecord) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
            } else {
                $date = CommonProcess::convertDateTime($model->end_date,
                        DomainConst::DATE_FORMAT_1,
                        DomainConst::DATE_FORMAT_3);
            }
            $this->widget('DatePickerWidget', array(
                'model'         => $model,
                'field'         => 'end_date',
                'value'         => $date,
                'isReadOnly'    => false,
            ));
            ?>
        </div>
    </div>

    <div class="row buttons">
        <div class="col-md-12">
            <?php
            if ($model->canUpdate()) {
                echo CHtml::submitButton(DomainConst::CONTENT00377, array(
                    'name' => 'submit',
                    'visible' => 'true',
                ));
            }
        ?>
        </div>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->