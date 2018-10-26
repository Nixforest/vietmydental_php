<?php
/* @var $this HrWorkPlansController */
/* @var $model HrWorkPlans */
/* @var $form CActiveForm */
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
            <?php echo $form->labelEx($model, 'department_id'); ?>
            <?php echo $form->dropdownlist($model, 'department_id', Departments::loadItems(true)); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'month'); ?>
            <?php
            $month = $model->month;
            if (empty($month)) {
                $month = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_13);
            }
//            $date = CommonProcess::convertDateTime($month, DomainConst::DATE_FORMAT_13, DomainConst::DATE_FORMAT_3);
            $this->widget('DatePickerWidget', array(
                'model'         => $model,
                'field'         => 'month',
                'value'         => $month,
                'isReadOnly'    => false,
                'format'        => DomainConst::DATE_FORMAT_14,
            ));
            ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'agent_id'); ?>
            <?php echo $form->dropdownlist($model, 'agent_id', Agents::loadItems(true)); ?>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search', array(
            'name'  => 'search',
            'style' => 'margin: 10px 10px 10px 154px; background: teal',
        )); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->