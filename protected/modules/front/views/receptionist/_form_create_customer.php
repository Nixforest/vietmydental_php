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
            
            <?php echo $form->dateField($customer, 'date_of_birth');
    //        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
    //            'model'     => $customer,
    //            'attribute' => 'date_of_birth',
    //            'language'=>'en-GB',
    //            'options'   => array(
    //                'showAnim'      => 'fold',
    //                'dateFormat'    => DomainConst::DATE_FORMAT_2,
    //                'maxDate'       => '0',
    //                'changeMonth'   => true,
    //                'changeYear'    => true,
    //                'showOn'        => 'button',
    //                'buttonImage'   => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
    //                'buttonImageOnly' => true,
    //            ),
    //            'htmlOptions'=>array(
    //                        'class'=>'w-16',
    ////                                'style'=>'height:20px;width:166px;',
    //                        'readonly'=>'readonly',
    //                        'value' => CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3),
    //                    ),
    //        ));
            ?>
            <?php echo $form->numberField($customer,'year_of_birth',array('size'=>60,'maxlength'=>255, 'placeholder'=>'Năm sinh')); ?>
            <?php echo $form->error($customer,'date_of_birth'); ?>
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
            <?php echo $form->labelEx($customer,'street_id'); ?>
            <?php // echo $form->hiddenField($customer,'street_id', array()); ?>
            <?php echo $form->dropDownList($customer,'street_id', Streets::loadItems(), array('class'=>'','empty'=>'Select')); ?>
            <?php 
                // widget auto complete search user customer and supplier
    //            $aData = array(
    //                'model'=>$customer,
    //                'field_street_id'=>'street_id',
    //                'field_autocomplete_name'=>'autocomplete_name_street',
    //                'url'=> Yii::app()->createAbsoluteUrl('admin/ajax/searchStreet'),
    //                'NameRelation'=>'rStreet',
    //                'ClassAdd' => 'w-400',
    //            );
    //            $this->widget('ext.GasAutoStreet.GasAutoStreet',
    //                array('data'=>$aData));                                        
            ?>
            <?php echo $form->error($customer,'street_id'); ?>
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
    });
</script>