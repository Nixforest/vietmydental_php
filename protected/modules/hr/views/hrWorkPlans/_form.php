<?php
/* @var $this HrWorkPlansController */
/* @var $model HrWorkPlans */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'hr-work-plans-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'approved'); ?>
        <?php echo $form->hiddenField($model, 'approved', array('class' => '')); ?>
        <?php
            $userName = isset($model->rApproved) ? $model->rApproved->getAutoCompleteUserName() : '';
            Loggers::info('Approver', $userName, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $aData = array(
                'model'             => $model,
                'field_id'          => 'approved',
                'update_value'      => $userName,
                'ClassAdd'          => 'w-400',
                'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchUser'),
                'field_autocomplete_name' => 'autocomplete_user',
            );
            $this->widget('ext.AutocompleteExt.AutocompleteExt',
                    array('data' => $aData));
        ?>
        <?php echo $form->error($model, 'approved'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'approved_date'); ?>
        <?php
        if (!isset($model->approved_date)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
        } else {
            $date = CommonProcess::convertDateTime($model->approved_date,
                        DomainConst::DATE_FORMAT_1,
                        DomainConst::DATE_FORMAT_BACK_END);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model'         => $model,
            'field'         => 'approved_date',
            'value'         => $date,
            'isReadOnly'    => false,
        ));
        ?>
        <?php echo $form->error($model, 'approved_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'notify'); ?>
        <?php echo $form->textArea($model, 'notify', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'notify'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'role_id'); ?>
        <?php echo $form->dropdownlist($model, 'role_id', Roles::loadItems()); ?>
        <?php echo $form->error($model, 'role_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'date_from'); ?>
        <?php
        if (!isset($model->isNewRecord)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
        } else {
            $date = CommonProcess::convertDateTime($model->date_from,
                        DomainConst::DATE_FORMAT_4,
                        DomainConst::DATE_FORMAT_BACK_END);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model'         => $model,
            'field'         => 'date_from',
            'value'         => $date,
            'isReadOnly'    => false,
        ));
        ?>
        <?php echo $form->error($model, 'date_from'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'date_to'); ?>
        <?php
        if (!isset($model->isNewRecord)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
        } else {
            $date = CommonProcess::convertDateTime($model->date_to,
                        DomainConst::DATE_FORMAT_4,
                        DomainConst::DATE_FORMAT_BACK_END);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_BACK_END);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model'         => $model,
            'field'         => 'date_to',
            'value'         => $date,
            'isReadOnly'    => false,
        ));
        ?>
        <?php echo $form->error($model, 'date_to'); ?>
    </div>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropdownlist($model, 'status', HrWorkShifts::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
    <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->