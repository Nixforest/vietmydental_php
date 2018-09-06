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
        <!--//++ BUG0080-IMT (DuongNV 20180906) print prescription-->
        <?php if ($canPrint) : ?>
        <div class="col-md-6" style="padding-top: 20px;">
            <label for="Prescriptions_print" class="required">In toa thuốc</label>
            <i class="fas fa-print print-prescription" title="In toa thuốc" style="font-size:30px; color:#2098f3"></i>
        </div>
        <?php endif; ?>
        <!--//-- BUG0080-IMT (DuongNV 20180906) print prescription-->
    </div>

    <div class="row">
        <div class="table-responsive">
            <table class="table table-bordered materials_table" id="prescriptions-table" style="table-layout: fixed;">
                <thead>
                    <tr>
                        <!--<th class="col-md-1"><?php echo DomainConst::CONTENT00034; ?></th>--> 
                        <th class="col-md-5"><?php echo DomainConst::CONTENT00112; ?></th> 
                        <!--<th class="col-md-2"><?php echo DomainConst::CONTENT00114; ?></th>-->
                        <th class="col-md-1"><?php echo DomainConst::CONTENT00313; ?></th>
                        <th class="col-md-2"><?php echo DomainConst::CONTENT00390; ?></th>
                        <!--<th class="col-md-2"><?php echo DomainConst::CONTENT00111; ?></th>-->
                        <th class="col-md-2"><?php echo DomainConst::CONTENT00159; ?></th>
                        <th class="col-md-1"><?php echo DomainConst::CONTENT00296; ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $maxRow = 50;
                        $maxShow = 1;
                        if (count($details) > 1) {
                            $maxShow = count($details);
                        }
                        $aOrderNumber = CommonProcess::buildOrderNumberArray($maxRow);
                        $index = 0;
                        $listDetails = array_reverse($details);
                    ?>
                    <?php foreach ($listDetails as $detail): ?>
                        <tr class="materials_row">
                            <!--<td class="item_c order_no"><?php echo $index; ?></td>-->
                            <td class="item_c">
                                <?php echo $form->hiddenField($detail, "[$index]medicine_id", array('class' => '')); ?>
                                <?php
                                    $medicineName = isset($detail->rMedicine) ? $detail->rMedicine->getAutoCompleteMedicine() : '';
                                    $url = Yii::app()->createAbsoluteUrl('admin/ajax/searchMedicine');
                                    $aData = ['model'             => $detail,
                                        'field_id'          => $index . "_medicine_id",
                                        'update_value'      => $medicineName,
                                        'url'               => $url,
                                        'field_autocomplete_name' => "[$index]autocomplete_id_medicine",
                                        'style'             => 'width: 99%',
                                       ];
                                    $this->widget('ext.AutocompleteExt.AutocompleteExt',
                                            array('data' => $aData));
                                ?>
                            </td>
                            <td class="item_c">
                                <?php echo $form->numberField($detail, "[$index]quantity",
                                        array(
                                            'size'=>11,'maxlength'=>11,
                                            'style'=>'width: 99%',
                                        )); ?>
                            </td>
                            <td class="item_c">
                                <?php echo $form->numberField($detail, "[$index]quantity1",
                                        array(
                                            'size'=>11,'maxlength'=>11,
                                            'style'=>'width: 25%',
                                        )); ?>
                                <?php echo $form->numberField($detail, "[$index]quantity2",
                                        array(
                                            'size'=>11,'maxlength'=>11,
                                            'style'=>'width: 25%',
                                        )); ?>
                                <?php echo $form->numberField($detail, "[$index]quantity3",
                                        array(
                                            'size'=>11,'maxlength'=>11,
                                            'style'=>'width: 25%',
                                        )); ?>
                                <?php echo $form->numberField($detail, "[$index]quantity4",
                                        array(
                                            'size'=>11,'maxlength'=>11,
                                            'style'=>'width: 25%',
                                        )); ?>
                                <?php // echo CHtml::activeTextField($detail, "[$index]quantity4"); ?>
                            </td>
                            <td class="item_c">
                                <?php echo $form->textArea($detail, "[$index]note",
                                        array(
                                            'rows'=>4, 'cols'=>50,
                                            'style'=>'width: 99%'
                                            )); ?>
                            </td>
                            <td style="text-align: center" class="item_c last">
                                <h6 class="delete-btn glyphicon glyphicon-remove btn-danger" style="padding:4px;border-radius: 50%;margin:5px;"></h6>
                            </td>
                        </tr>
                        <?php $index++; ?>
                    <?php endforeach; // end foreach ($_SESSION as $key => $value) ?>
                    <?php for ($i = count($details) + 1; $i <= $maxRow; $i++) : ?>
                        <?php
                        $detail = new PrescriptionDetails();
                        $display = "display_none";
                        ?>
                        <tr class="materials_row <?php echo $display;?>">
                            <!--<td class="item_c order_no"><?php echo $index; ?></td>-->
                            <td class="item_c">
                                <?php echo $form->hiddenField($detail, "[$index]medicine_id", array('class' => '')); ?>
                                <?php
                                    $medicineName = isset($detail->rMedicine) ? $detail->rMedicine->getAutoCompleteMedicine() : '';
                                    $url = Yii::app()->createAbsoluteUrl('admin/ajax/searchMedicine');
                                    $aData = ['model'             => $detail,
                                        'field_id'          => $index . "_medicine_id",
                                        'update_value'      => $medicineName,
                                        'url'               => $url,
                                        'field_autocomplete_name' => "[$index]autocomplete_id_medicine",
                                        'style'             => 'width: 99%',
                                       ];
                                    $this->widget('ext.AutocompleteExt.AutocompleteExt',
                                            array('data' => $aData));
                                ?>
                            </td>
                            <td class="item_c">
                                <?php echo $form->numberField($detail, "[$index]quantity",
                                        array(
                                            'size'=>11,'maxlength'=>11,
                                            'style'=>'width: 99%',
                                        )); ?>
                            </td>
                            <td class="item_c">
                                <?php echo $form->numberField($detail, "[$index]quantity1",
                                        array(
                                            'size'=>11,'maxlength'=>11,
                                            'style'=>'width: 25%',
                                        )); ?>
                                <?php echo $form->numberField($detail, "[$index]quantity2",
                                        array(
                                            'size'=>11,'maxlength'=>11,
                                            'style'=>'width: 25%',
                                        )); ?>
                                <?php echo $form->numberField($detail, "[$index]quantity3",
                                        array(
                                            'size'=>11,'maxlength'=>11,
                                            'style'=>'width: 25%',
                                        )); ?>
                                <?php echo $form->numberField($detail, "[$index]quantity4",
                                        array(
                                            'size'=>11,'maxlength'=>11,
                                            'style'=>'width: 25%',
                                        )); ?>
                            </td>
                            <td class="item_c">
                                <?php echo $form->textArea($detail, "[$index]note",
                                        array(
                                            'rows'=>4, 'cols'=>50,
                                            'style'=>'width: 99%'
                                            )); ?>
                            </td>
                            <td style="text-align: center" class="item_c last">
                                <h6 class="delete-btn glyphicon glyphicon-remove btn-danger" style="padding:4px;border-radius: 50%;margin:5px;"></h6>
                            </td>
                        </tr>
                        <?php $index++; ?>
                    <?php endfor; ?>
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

<!--//++ BUG0080-IMT (DuongNV 20180906) print prescription-->
<?php
$index = 1;
?>
<div id="form-print">
    <?php
        $mAgent = CommonProcess::getUserAgent();
        $address = "128 Huỳnh Tấn Phát P. Phú Mỹ, Quận 7, TP HCM";
        $phone = "028.3785.8989";
        $website = Settings::getDomainSaleWebsite();
        $agentName = "";
        if (isset($mAgent)) {
            $address    = $mAgent->address;
            $phone      = $mAgent->phone;
            $agentName  = $mAgent->getFullName();
        }
    ?>
    <div class="form-print-info-company">
        <h3><b><?php echo $agentName; ?></b></h3>
        <p><?php echo DomainConst::CONTENT00045 . ': ' . $address; ?></p>
        <p><?php echo DomainConst::CONTENT00312 . ': ' . $website; ?></p>
    </div>
    
    <div class="form-print-date-and-no">
        <p><?php echo DomainConst::CONTENT00311 . ': ' . CommonProcess::generateID('TT', $customer->id) ?></p>
        <p><?php echo DomainConst::CONTENT00302 . ' ' . CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3); ?></p>
    </div>
    
    <div class="form-print-title">
        <h1><b><?php echo DomainConst::CONTENT00432; ?></b></h1>
        <h2><b>(Prescription)</b></h2>
    </div>
    
    <div class="form-print-content">    
        <div class="form-print-customer-info">
            <div class="left-content">
                <p><?php echo DomainConst::CONTENT00306 . ' ' . $customer->rMedicalRecord->record_number; ?></p>
                <p><?php echo DomainConst::CONTENT00305 . ' ' . $customer->name; ?></p>
                <p><?php echo DomainConst::CONTENT00308 . ' ' . $customer->address; ?></p>
                <p>Chuẩn đoán / Diagnosis: </p>
            </div>
            <div class="right-content">
                <p><?php echo DomainConst::CONTENT00433 . ': ' . CommonProcess::getGender()[$customer->gender]; ?></p>
                <p><?php echo DomainConst::CONTENT00434 . ': ' . $customer->getBirthYear(); ?></p>
            </div>
            <div class="clrfix"></div>
        </div>
        
        <div class="form-print-medicine">
        <?php 
            if (count($listDetails) > 0) {
            foreach ($listDetails as $detail):
                $medicineName = isset($detail->rMedicine) ? $detail->rMedicine->getAutoCompleteMedicine() : '';
                ?>
            <div class="form-print-medicine-item">
                <div class="left-content">
                    <b><?php echo $index++ . ' ' . $medicineName ; ?></b>
                    <p>
                        <?php
                            if (!empty($detail->quantity1)) {
                                echo 'Sáng (Morning): '.$detail->quantity1;
                            }
                        ?>
                        <?php
                            if (!empty($detail->quantity2)) {
                                echo 'Trưa (Noon): '.$detail->quantity2;
                            }
                        ?>
                    </p>
                    <p>Uống / Drink</p>
                </div>
                <div class="right-content">
                    <b><?php echo $detail->quantity; ?> Viên / Tablet</b>
                    <p>
                        <?php
                            if (!empty($detail->quantity3)) {
                                echo 'Chiều (Afternoon): '.$detail->quantity3;
                            }
                        ?>
                        <?php
                            if (!empty($detail->quantity4)) {
                                echo 'Tối (Evening): '.$detail->quantity4;
                            }
                        ?>
                    </p>
                </div>
                <div class="clrfix"></div>
            </div>
        <?php endforeach;} ?>
        </div>
        
        <div class="form-print-footer">
            <div class="left-content">
                <p><b>Lời dặn của bác sĩ (Doctor's advise)</b></p>
                <p><?php echo $model->note; ?></p>
            </div>
            <div class="right-content" style="padding-right: 80px;">
                <p><b>Bác sĩ</b></p>
                <p><b>(Doctor)</b></p>
            </div>
            <div class="clrfix"></div>
        </div>
    </div>
    
</div>
<!--//-- BUG0080-IMT (DuongNV 20180906) print prescription-->

<script>
$(function(){
    $(document).on('click', '.delete-btn',function(){
        $(this).closest('tr').remove();
    });
    $(document).keydown(function(e) {
        if(e.which === 119) {
            fnBuildRow();
        }
    });
    $('.new-row-btn').on('click', function(){
        $('.materials_table').find('tr:visible:last').next('tr').show();
    });
    
    <!--//++ BUG0080-IMT (DuongNV 20180906) print prescription-->
    var cssLink = '<?php echo Yii::app()->theme->baseUrl; ?>'+'/css/main.css';
    bindPrint('print-prescription', 'form-print', cssLink);
    <!--//--BUG0080-IMT (DuongNV 20180906) print prescription-->
    function fnBuildRow(){
        $('.materials_table').find('tr:visible:last').next('tr').show();
    }
});
</script>