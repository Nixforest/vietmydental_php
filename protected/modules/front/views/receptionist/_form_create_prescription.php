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
                        'style'      => 'width: 75%;',
                        )); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
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
//                    'readonly' => 'readonly',
                    'value' => $date,
                ),
            ));
            ?>
            <?php echo $form->error($model, 'created_date'); ?>
        </div>
        <div class="col-md-6">
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
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($model, 'note'); ?>
            <?php echo $form->textArea($model, 'note', array('rows' => 6, 'cols' => 50)); ?>
            <?php echo $form->error($model, 'note'); ?>
        </div>
        <div class="col-md-6">
        </div>
    </div>

    <div class="row">
        <div class="table-responsive">
            <table class="table" id="prescriptions-table" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <th class="col-md-2">Tên thuốc</th>
                        <th class="col-md-2">Đơn vị</th>
                        <th class="col-md-1">Số lượng</th>
                        <th class="col-md-2">Sáng, Trưa, Chiều, Tối</th>
                        <th class="col-md-2">Cách dùng</th>
                        <th class="col-md-2">Lưu ý</th>
                        <th class="col-md-1">Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <?php echo $form->textField($model, 'note', array('style'=>'width: 99%')); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($model, 'doctor_id', Users::getListUser(
                                Roles::getRoleByName(Roles::ROLE_DOCTOR)->id, Yii::app()->user->agent_id), array('style'=>'width: 99%')) ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'note', array('style'=>'width: 99%')); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'note', array('style'=>'width: 99%')); ?>
                        </td>
                        <td>
                            <?php echo $form->dropDownList($model, 'doctor_id', Users::getListUser(
                                Roles::getRoleByName(Roles::ROLE_DOCTOR)->id, Yii::app()->user->agent_id), array('style'=>'width: 99%')) ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'note', array('style'=>'width: 99%')); ?>
                        </td>
                        <td style="text-align: center">
                            <h6 class="delete-btn glyphicon glyphicon-remove btn-danger" style="padding:4px;border-radius: 50%;margin:5px;"></h6>
                        </td>
                    </tr>
                </tbody>
            </table>
            <h5 class="new-row-btn glyphicon glyphicon-plus btn-success" style="padding: 4px; border-radius: 50%;"></h5>
        </div>
    </div>

    <div class="row buttons">
    <?php
    echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : 'Save', array(
        'name' => 'submit',
    ));
    ?>
    </div>

        <?php $this->endWidget(); ?>

</div><!-- form -->
<script>
$(function(){
    $(document).on('click', '.delete-btn',function(){
        $(this).closest('tr').remove();
    })
    $('.new-row-btn').on('click', function(){
        var row = '<tr>'+
                        '<td>'+
                            '<?php echo $form->textField($model, 'note', array('style'=>'width: 99%')); ?>'+
                        '</td>'+
                        '<td>'+
                            '<?php echo str_replace(array(
                                html_entity_decode('<option'),
                                html_entity_decode('/option>'),
                                html_entity_decode('Prescriptions_doctor_id">'),
                                html_entity_decode('</select>')),
                                                    array(
                                                        "'<option",
                                                        "/option>'+",
                                                        "Prescriptions_doctor_id>'+",
                                                        "'</select>"),
                                $form->dropDownList($model, 'doctor_id', Users::getListUser(Roles::getRoleByName(Roles::ROLE_DOCTOR)->id, Yii::app()->user->agent_id), array('style'=>'width: 99%'))) ?>'+
                        '</td>'+
                        '<td>'+
                            '<?php echo $form->textField($model, 'note', array('style'=>'width: 99%')); ?>'+
                        '</td>'+
                        '<td>'+
                            '<?php echo $form->textField($model, 'note', array('style'=>'width: 99%')); ?>'+
                        '</td>'+
                        '<td>'+
                            '<?php echo str_replace(array(
                                html_entity_decode('<option'),
                                html_entity_decode('/option>'),
                                html_entity_decode('Prescriptions_doctor_id">'),
                                html_entity_decode('</select>')),
                                                    array(
                                                        "'<option",
                                                        "/option>'+",
                                                        "Prescriptions_doctor_id>'+",
                                                        "'</select>"),
                                $form->dropDownList($model, 'doctor_id', Users::getListUser(Roles::getRoleByName(Roles::ROLE_DOCTOR)->id, Yii::app()->user->agent_id), array('style'=>'width: 99%'))) ?>'+
                        '</td>'+
                        '<td>'+
                            '<?php echo $form->textField($model, 'note', array('style'=>'width: 99%')); ?>'+
                        '</td>'+
                        '<td style="text-align: center">'+
                            '<h6 class="delete-btn glyphicon glyphicon-remove btn-danger" style="padding:4px;border-radius: 50%;margin:5px;"></h6>'+
                        '</td>'+
                    '</tr>';
            console.log(row);
        $('#prescriptions-table tbody').append(row);
    })
})
</script>