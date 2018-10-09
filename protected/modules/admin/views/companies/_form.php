<?php
/* @var $this CompaniesController */
/* @var $model Companies */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'companies-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'open_date'); ?>
        <?php
        if (!isset($model->open_date)) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
        } else {
            $date = CommonProcess::convertDateTime($model->open_date, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3);
            if (empty($date)) {
                $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
            }
        }
        $this->widget('DatePickerWidget', array(
            'model' => $model,
            'field' => 'open_date',
            'value' => $date,
        ));
        ?>
        <?php echo $form->error($model, 'open_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'tax_code'); ?>
        <?php echo $form->textField($model, 'tax_code', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'tax_code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'address'); ?>
        <?php echo $form->textField($model, 'address', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'address'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'director'); ?>
        <?php echo $form->hiddenField($model, 'director', array('class' => '')); ?>
        <?php
            $userName = isset($model->rDirector) ? $model->rDirector->getAutoCompleteUserName() : '';
            $aData = array(
                'model'             => $model,
                'field_id'          => 'director',
                'update_value'      => $userName,
                'ClassAdd'          => 'w-400',
                'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchUser'),
                'field_autocomplete_name' => 'autocomplete_user',
            );
            $this->widget('ext.AutocompleteExt.AutocompleteExt',
                    array('data' => $aData));
        ?>
        <?php echo $form->error($model, 'director'); ?>
    </div>
    
    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', HrHolidayPlans::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->