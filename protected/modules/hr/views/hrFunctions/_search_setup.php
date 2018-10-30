<?php
/* @var $this HrFunctionsController */
/* @var $model HrFunctions */
/* @var $form CActiveForm */
/* @var $title String */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'role_id'); ?>
            <?php echo $form->dropdownlist($model, 'role_id', Roles::getRoleArrayForSalary()); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'type_id'); ?>
            <?php echo $form->dropdownlist($model, 'type_id', HrFunctionTypes::loadItems(true)); ?>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($title, array(
            'name'  => 'search',
            'style' => 'margin: 10px 10px 10px 154px; background: teal',
        )); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->