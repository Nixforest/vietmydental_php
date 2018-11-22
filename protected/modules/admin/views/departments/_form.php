<?php
/* @var $this DepartmentsController */
/* @var $model Departments */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'departments-form',
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
        <?php echo $form->labelEx($model, 'type_id'); ?>
        <?php echo $form->dropdownlist($model, 'type_id', DepartmentTypes::loadItems()); ?>
        <?php echo $form->error($model, 'type_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'company_id'); ?>
        <?php echo $form->dropdownlist($model, 'company_id', Companies::loadItems()); ?>
        <?php echo $form->error($model, 'company_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'manager'); ?>
        <?php echo $form->hiddenField($model, 'manager', array('class' => '')); ?>
        <?php
            $userName = isset($model->rManager) ? $model->rManager->getAutoCompleteUserName() : '';
            $aData = array(
                'model'             => $model,
                'field_id'          => 'manager',
                'update_value'      => $userName,
                'ClassAdd'          => 'w-400',
                'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchUser'),
                'field_autocomplete_name' => 'autocomplete_manager',
            );
            $this->widget('ext.AutocompleteExt.AutocompleteExt',
                    array('data' => $aData));
        ?>
        <?php echo $form->error($model, 'manager'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'sub_manager'); ?>
        <?php echo $form->hiddenField($model, 'sub_manager', array('class' => '')); ?>
        <?php
            $userName = isset($model->rSubManager) ? $model->rSubManager->getAutoCompleteUserName() : '';
            $aData = array(
                'model'             => $model,
                'field_id'          => 'sub_manager',
                'update_value'      => $userName,
                'ClassAdd'          => 'w-400',
                'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchUser'),
                'field_autocomplete_name' => 'autocomplete_sub_manager',
            );
            $this->widget('ext.AutocompleteExt.AutocompleteExt',
                    array('data' => $aData));
        ?>
        <?php echo $form->error($model, 'sub_manager'); ?>
    </div>
    
    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', Departments::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->