<?php
/* @var $this ReceptionistController */
/* @var $model TreatmentScheduleDetails */
/* @var $customer Customers */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'prescription-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($customer, 'name'); ?>
            <?php echo $form->textField($customer, 'name',
                    array(
                        'readonly'  => 'readonly',
                        )); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($customer, 'id'); ?>
            <?php echo $form->textField($customer, 'id',
                    array(
                        'readonly'  => 'readonly',
                        'value'     => $customer->getId(),
                    )); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($customer, 'year_of_birth'); ?>
            <?php echo $form->textField($customer, 'year_of_birth',
                    array(
                        'readonly'  => 'readonly',
                        'value'     => $customer->getBirthYear(),
                        )); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($customer, 'gender'); ?>
            <?php echo $form->textField($customer, 'gender',
                    array(
                        'readonly'  => 'readonly',
                        'value'     => CommonProcess::getGender()[$customer->gender],
                        )); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php echo $form->labelEx($customer, 'address'); ?>
            <?php echo $form->textField($customer, 'address',
                    array(
                        'readonly'  => 'readonly',
                        'cold'      => 50,
                        )); ?>
        </div>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'created_date'); ?>
        <?php
        if ($model->isNewRecord) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
        } else {
            $date = CommonProcess::convertDateTime($model->created_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_3);
        }
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'created_date',
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat' => DomainConst::DATE_FORMAT_2,
                'changeMonth' => true,
                'changeYear' => true,
                'showOn' => 'button',
                'buttonImage' => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                'buttonImageOnly' => true,
            ),
            'htmlOptions' => array(
                'class' => 'w-16',
                'readonly' => 'readonly',
                'value' => $date,
            ),
        ));
        ?>
        <?php echo $form->error($model, 'created_date'); ?>
    </div>

    <div class="row">
<?php echo $form->labelEx($model, 'doctor_id'); ?>
        <?php // echo $form->hiddenField($model, 'doctor_id', array('class' => ''));  ?>
        <?php
//                    $userName = isset($model->rDoctor) ? $model->rDoctor->getAutoCompleteUserName() : '';
//                    $url = Yii::app()->createAbsoluteUrl('admin/ajax/searchUser',
//                            array('role'=> Roles::getRoleByName('ROLE_DOCTOR')->id));
//                    $aData = ['model'             => $model,
//                        'field_id'          => 'doctor_id',
//                        'update_value'      => $userName,
//                        'ClassAdd'          => 'w-350',
//                        'url'               => $url,
//                        'field_autocomplete_name' => 'autocomplete_name_doctor',
//                       ];
//                    $this->widget('ext.AutocompleteExt.AutocompleteExt',
//                            array('data' => $aData));
        echo $form->dropDownList($model, 'doctor_id', Users::getListUser(
                        Roles::getRoleByName(Roles::ROLE_DOCTOR)->id, Yii::app()->user->agent_id)
        );
        ?>
        <?php echo $form->error($model, 'doctor_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'note'); ?>
<?php echo $form->textArea($model, 'note', array('rows' => 6, 'cols' => 50)); ?>
<?php echo $form->error($model, 'note'); ?>
    </div>

        <?php echo DomainConst::CONTENT00081; ?>

    <div class="row buttons">
    <?php
    echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : 'Save', array(
        'name' => 'submit',
    ));
    ?>
    </div>

        <?php $this->endWidget(); ?>

</div><!-- form -->