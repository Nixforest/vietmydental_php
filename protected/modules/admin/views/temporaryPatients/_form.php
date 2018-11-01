<?php
/* @var $this TemporaryPatientsController */
/* @var $model TemporaryPatients */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'temporary-patients-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'name'); ?>
            <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
            <?php echo $form->error($model, 'name'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'phone'); ?>
            <?php echo $form->textField($model, 'phone', array('size' => 60, 'maxlength' => 200)); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'book_date'); ?>
            <?php
            if (!isset($model->isNewRecord)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            } else {
                $date = CommonProcess::convertDateTime($model->book_date, DomainConst::DATE_FORMAT_DB, DomainConst::DATE_FORMAT_BACK_END);
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
        <div class="col-md-6">
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
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'source_id'); ?>
            <?php echo $form->dropDownList($model,'source_id', SourceInformations::loadItems()); ?>
            <?php echo $form->error($model,'source_id'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'receptionist_id'); ?>
            <?php echo $form->hiddenField($model, 'receptionist_id', array('class' => '')); ?>
            <?php
                $userName = isset($model->rReceptionist) ? $model->rReceptionist->getAutoCompleteUserName() : '';
                $aData = array(
                    'model'             => $model,
                    'field_id'          => 'receptionist_id',
                    'update_value'      => $userName,
                    'ClassAdd'          => 'w-350',
                    'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchUser'),
                    'field_autocomplete_name' => 'autocomplete_user',
                );
                $this->widget('ext.AutocompleteExt.AutocompleteExt',
                        array('data' => $aData));
            ?>
            <?php echo $form->error($model, 'receptionist_id'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <?php echo $form->labelEx($model, 'content'); ?>
            <?php echo $form->textArea($model, 'content', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'content'); ?>
        </div>
    </div>
    
    <?php
        $count = 0;
    ?>
    <?php foreach (SocialNetworks::TYPE_NETWORKS as $key => $value): ?>
        <?php
            $id = "TemporaryPatients_social_network_$key";
            $name = "TemporaryPatients[social_network_$key]";
        ?>
        <?php if ($count % 2 == 0): ?>
        <div class="row">
        <?php endif; // end if ($count % 2 == 0) ?>

            <div class="col-md-6">
                <label for="<?php echo $id; ?>"><?php echo $value; ?></label>
                <input size="60" maxlength="255" name="<?php echo $name; ?>"
                       id="<?php echo $id; ?>" type="text" placeholder="<?php echo $value ?>"
                       value="<?php echo $model->getSocialNetwork($key); ?>">
            </div>

        <?php if ($count % 2 != 0): ?>
        </div>
        <?php endif; // end if ($count % 2 != 0) ?>
        <?php
            $count++;
        ?>
    <?php endforeach; // end foreach (SocialNetworks::TYPE_NETWORKS as $network) ?>

    <?php if ($count % 2 != 0): ?>
    </div>
    <?php endif; // end if ($count % 2 == 0) ?>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <div class="col-md-12">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $form->dropDownList($model, 'status', ProductOrders::getArrayStatus()); ?>
            <?php echo $form->error($model, 'status'); ?>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->