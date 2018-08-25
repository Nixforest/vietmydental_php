<?php

/* @var $this ReceptionistController */
/* @var $customer Customers */
/* @var $medicalRecord MedicalRecords */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customers-form',
	'enableAjaxValidation'=>false,
        'focus'=>[$customer,'phone'],
)); ?>

    <?php echo DomainConst::CONTENT00081; ?>

    <?php echo $form->errorSummary($customer); ?>
    <?php echo $form->errorSummary($medicalRecord); ?>
    
    <div class="row">
    <?php
    if (isset($error) && !$customer->hasErrors() && !empty($error)) {
        echo '<div class="errorMessage">' . $error . '</div>';
    } else {
        echo '<div class="errorMessage" style="display: none;">' . $error . '</div>';
    }
    ?>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($customer,'phone'); ?>
            <?php echo $form->textField($customer,'phone',array('size'=>60,'maxlength'=>200, 'placeholder'=>'0123456789')); ?>
            <?php echo $form->error($customer,'phone'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($customer,'name'); ?>
            <?php echo $form->textField($customer,'name',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Họ và tên')); ?>
            <?php echo $form->error($customer,'name'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($customer,'gender'); ?>
            <?php echo $form->dropDownList($customer,'gender', CommonProcess::getGender()); ?>
            <?php echo $form->error($customer,'gender'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($customer,'date_of_birth'); ?>
            <!--<label for="Customers_date_of_birth" class="required">Ngày sinh (m/d/y) <span class="required">*</span></label>-->
            
            <?php // echo $form->dateField($customer, 'date_of_birth');
            if (!isset($customer->date_of_birth)) {
                $date = DomainConst::DATE_FORMAT_3_NULL;
            } else {
                $date = CommonProcess::convertDateTime($customer->date_of_birth,
                            DomainConst::DATE_FORMAT_4,
                            DomainConst::DATE_FORMAT_3);
                if (empty($date)) {
                    $date = DomainConst::DATE_FORMAT_3_NULL;
                }
            }
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model'     => $customer,
                'attribute' => 'date_of_birth',
                'language'=>'en-GB',
                'options'   => array(
                    'showAnim'      => 'fold',
                    'dateFormat'    => DomainConst::DATE_FORMAT_2,
                    'maxDate'       => '0',
                    'changeMonth'   => true,
                    'changeYear'    => true,
                    'showOn'        => 'button',
                    'buttonImage'   => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                    'buttonImageOnly' => true,
                ),
                'htmlOptions'=>array(
                            //++ BUG0066-IMT (DuongNV 20180825) input date create customer
                            'class'=>'w-16 date-input',
                            //-- BUG0066-IMT (DuongNV 20180825) input date create customer
//                            'readonly'=>'readonly',
//                            'value' => CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3),
                            'value' => $date,
                        ),
            ));
            ?>
            <?php echo $form->error($customer,'date_of_birth'); ?>
        </div>
        
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($customer, 'referCode') ?>
            <?php if (!isset($customer->rReferCode)): ?>
                <?php echo $form->hiddenField($customer, 'referCode', array('class' => '')); ?>
                <?php
                    $referCode = isset($customer->rReferCode) ? $customer->rReferCode->code : '';
                    $aData = array(
                        'model'             => $customer,
                        'field_id'          => 'referCode',
                        'update_value'      => $referCode,
                        'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchReferCode'),
                        'field_autocomplete_name' => 'autocomplete_name_refercode',
                        'htmlOptions'=>array(
                                    'readonly'=>'readonly',
                                ),
                    );
                    $this->widget('ext.AutocompleteExt.AutocompleteExt',
                            array('data' => $aData));
                ?>
            <?php else: ?>
                <?php
                    $customer->referCode = isset($customer->rReferCode) ? $customer->rReferCode->code : '';
                    echo $form->textField($customer,'referCode', array(
                        'size'=>11,'maxlength'=>11,
                        'readonly' => 'true',
                    ));
                ?>
            <?php endif; // end if ($model->isNewRecord) ?>
            <?php echo $form->error($customer,'referCode'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($customer,'year_of_birth'); ?>
            <?php echo $form->numberField($customer,'year_of_birth',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Năm sinh')); ?>
            <?php echo $form->error($customer,'year_of_birth'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($customer,'house_numbers'); ?>
            <?php echo $form->textField($customer,'house_numbers',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Số nhà')); ?>
            <?php echo $form->error($customer,'house_numbers'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($medicalRecord,'record_number'); ?>
            <?php echo $form->textField($medicalRecord,'record_number',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Số bệnh án')); ?>
            <?php echo $form->error($medicalRecord,'record_number'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php
            // Setting default value of city
            if ($customer->isNewRecord) {
                // Get agent id of current user
                $agentId = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';
                $agent = Agents::model()->findByPk($agentId);
                if ($agent) {
                    // Set default value of city id
                    $customer->city_id = $agent->city_id;
                }
            }
            ?>
            <?php echo $form->labelEx($customer,'city_id'); ?>
            <?php echo $form->dropDownList($customer,'city_id', Cities::loadItems(), array('class'=>'','empty'=>'Select')); ?>
            <?php echo $form->error($customer,'city_id'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($customer,'district_id'); ?>
            <?php echo $form->dropDownList($customer,'district_id', Districts::loadItems($customer->city_id), array('class'=>'','empty'=>'Select')); ?>
            <?php echo $form->error($customer,'district_id'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?php echo $form->labelEx($customer,'ward_id'); ?>
            <?php echo $form->dropDownList($customer,'ward_id', Wards::loadItems($customer->district_id), array('class'=>'','empty'=>'Select')); ?>
            <?php echo $form->error($customer,'ward_id'); ?>
        </div>
        <div class="col-md-6">
            <?php echo $form->labelEx($customer, 'street_id'); ?>
            <?php echo $form->hiddenField($customer, 'street_id', array()); ?>
            <?php // echo $form->dropDownList($customer,'street_id', Streets::loadItems(), array('class'=>'','empty'=>'Select')); ?>
            <?php
            $streetName = isset($customer->rStreet) ? $customer->rStreet->getAutoCompleteStreet() : '';
            // widget auto complete search
            $aData = array(
                'model'                     => $customer,
                'field_street_id'           => 'street_id',
                'update_value'              => $streetName,
                'field_autocomplete_name'   => 'autocomplete_name_street',
                'url'                       => Yii::app()->createAbsoluteUrl(
                                                'admin/ajax/searchStreet'),
                'placeholder'               => 'Nhập tên đường tiếng việt không dấu.',
            );
            $this->widget('ext.AutocompleteExt.AutocompleteExt', array('data' => $aData));
            ?>
            <?php echo $form->error($customer, 'street_id'); ?>
        </div>
        
    </div>
<!--    <div class="row">
        <?php echo $form->labelEx($customer,'email'); ?>
        <?php echo $form->textField($customer,'email',array('size'=>60,'maxlength'=>80)); ?>
        <?php echo $form->error($customer,'email'); ?>
    </div>-->
    <?php
        $count = 0;
    ?>
    <?php foreach (SocialNetworks::TYPE_NETWORKS as $key => $value): ?>
        <?php
            $id = "Customers_social_network_$key";
            $name = "Customers[social_network_$key]";
        ?>
        <?php if ($count % 2 == 0): ?>
        <div class="row">
        <?php endif; // end if ($count % 2 == 0) ?>

            <div class="col-md-6">
                <label for="<?php echo $id; ?>"><?php echo $value; ?></label>
                <input size="60" maxlength="255" name="<?php echo $name; ?>" id="<?php echo $id; ?>" type="text" placeholder="<?php echo $value ?>" value="<?php echo $customer->getSocialNetwork($key); ?>">
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
<!--    <div class="row">
        <?php echo $form->labelEx($customer,'street_id'); ?>
        <?php echo $form->hiddenField($customer, 'street_id', array('class' => '')); ?>
        <?php
            $streetName = isset($customer->rStreet) ? $customer->rStreet->getAutoCompleteStreet() : '';
            $aData = array(
                'model'             => $customer,
                'field_id'          => 'street_id',
                'update_value'      => $streetName,
                'ClassAdd'          => 'w-350',
                'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchStreet'),
                'field_autocomplete_name' => 'autocomplete_name_street',
                'placeholder'       => 'Nhập tên đường tiếng việt không dấu.',
            );
            $this->widget('ext.AutocompleteExt.AutocompleteExt',
                    array('data' => $aData));
        ?>
        <?php echo $form->error($customer,'street_id'); ?>
    </div>-->

     <div class="row">
        <div class="col-md-6">
                <?php echo $form->labelEx($customer,'type_id'); ?>
                <?php echo $form->dropDownList($customer,'type_id', CustomerTypes::loadItems(), array('class'=>'','empty'=>'Select')); ?>
                <?php echo $form->error($customer,'type_id'); ?>
        </div>
    </div>
    <div class="row buttons">
            <?php echo CHtml::submitButton($customer->isNewRecord ? DomainConst::CONTENT00017 : 'Save',
                    array(
                        'name'  => 'submit',
                    )); ?>
    </div>
<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    $(function(){
        var style = '<style>'+
                        '.form .autocomplete_name_text{padding-left:10px!important;}'+
                    '</style>';
        $('head').append(style);
        fnBindChangeCity(
            '#Customers_city_id',
            '#Customers_district_id',
            "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchDistrictsByCity'); ?>");
        fnBindChangeCityStreet(
            '#Customers_city_id',
            '#Customers_street_id',
            "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchStreetsByCity'); ?>");
        fnBindChangeDistrict(
            '#Customers_district_id',
            '#Customers_ward_id',
            "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchWardsByDistrict'); ?>");
        //++ BUG0066-IMT (DuongNV 20180825) input date create customer
        fnInputDate();
        //-- BUG0066-IMT (DuongNV 20180825) input date create customer
    });
</script>