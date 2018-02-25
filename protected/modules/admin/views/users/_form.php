<?php
/* @var $this UsersController */
/* @var $model Users */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'users-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
));
?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">          
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'first_name'); ?>
            </div>
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',
                        array(
                            'size'=>50,'maxlength'=>50,
                            'readonly' => true,
                        )); ?>
		<?php echo $form->error($model,'username'); ?>
            </div> 
	</div>

	<div class="row">
            <div class="col-md-6">		
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'phone'); ?>
            </div>            
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php
//                echo $form->emailField($model, 'email', array(
//                    'size' => 60,
//                    'maxlength' => 80,
//                    'oninvalid' => "this.setCustomValidity('". DomainConst::CONTENT00066 ."')",
//                ));
                ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'email'); ?>
            </div>
	</div>

        <div class="row" <?php echo $model->isNewRecord ? '' : 'style="display: none;"' ?>>
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'password_hash'); ?>
		<?php echo $form->passwordField($model,'password_hash',
                        array(
                            'size'=>50,'maxlength'=>50,
                            'readonly' => $model->isNewRecord ? '' : 'readonly',
                        )); ?>
		<?php echo $form->error($model,'password_hash'); ?>
            </div>            
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'temp_password'); ?>
		<?php echo $form->passwordField($model,'temp_password',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'temp_password'); ?>
            </div>
	</div>

	<div class="row">            
            <div class="col-md-6">
                <?php echo $form->labelEx($model,'house_numbers'); ?>
		<?php echo $form->textField($model,'house_numbers',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'house_numbers'); ?>
            </div>
            
            <div class="col-md-6">
                <?php echo $form->labelEx($model,'province_id'); ?>
		<?php echo $form->dropDownList($model,'province_id', Cities::loadItems(), array('class'=>'','empty'=>'Select')); ?>
		<?php echo $form->error($model,'province_id'); ?>
            </div>
	</div>

	<div class="row">
            <div class="col-md-6">
                <?php echo $form->labelEx($model,'district_id'); ?>
		<?php echo $form->dropDownList($model,'district_id', Districts::loadItems($model->province_id), array('class'=>'','empty'=>'Select')); ?>
		<?php echo $form->error($model,'district_id'); ?>
            </div>
            
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'ward_id'); ?>
		<?php echo $form->dropDownList($model,'ward_id', Wards::loadItems($model->district_id), array('class'=>'','empty'=>'Select')); ?>
		<?php echo $form->error($model,'ward_id'); ?>
            </div>
	</div>

	<div class="row">
            <div class="col-md-6">
                <?php echo $form->labelEx($model,'street_id'); ?>
		<?php echo $form->hiddenField($model, 'street_id', array('class' => '')); ?>
                <?php
                    $streetName = isset($model->rStreet) ? $model->rStreet->getAutoCompleteStreet() : '';
                    $aData = array(
                        'model'             => $model,
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
		<?php echo $form->error($model,'street_id'); ?>
            </div>
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'code_account'); ?>
		<?php echo $form->textField($model,'code_account',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'code_account'); ?>
            </div>
	</div>
<!--

        <div class="row" style="display: none;">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'address_vi'); ?>
		<?php echo $form->textField($model,'address_vi',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'address_vi'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'house_numbers'); ?>
		<?php echo $form->textArea($model,'house_numbers',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'house_numbers'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'province_id'); ?>
		<?php echo $form->textField($model,'province_id'); ?>
		<?php echo $form->error($model,'province_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'district_id'); ?>
		<?php echo $form->textField($model,'district_id'); ?>
		<?php echo $form->error($model,'district_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ward_id'); ?>
		<?php echo $form->textField($model,'ward_id'); ?>
		<?php echo $form->error($model,'ward_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'street_id'); ?>
		<?php echo $form->textField($model,'street_id'); ?>
		<?php echo $form->error($model,'street_id'); ?>
	</div>-->

<!--	<div class="row">
		<?php echo $form->labelEx($model,'login_attemp'); ?>
		<?php echo $form->textField($model,'login_attemp'); ?>
		<?php echo $form->error($model,'login_attemp'); ?>
	</div>-->

        <div class="row" style="display: none">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php
                echo $form->textField(
                        $model, 'created_date', array(
                            'value' => date(DomainConst::DATE_FORMAT_1),
                            'readonly' => 'true',
                        )
                );
                ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'last_logged_in'); ?>
		<?php echo $form->textField($model,'last_logged_in'); ?>
		<?php echo $form->error($model,'last_logged_in'); ?>
	</div>-->

	<div class="row" style="display: none">
		<?php echo $form->labelEx($model,'ip_address'); ?>
		<?php
                echo $form->textField(
                        $model, 'ip_address', array(
                            'value' => DomainConst::DEFAULT_IP_ADDRESS,
                            'readonly' => 'true',
                        )
                );
                ?>
		<?php echo $form->error($model,'ip_address'); ?>
	</div>

	<div class="row">
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'role_id'); ?>
                <?php echo $form->dropDownList($model,'role_id', Roles::loadItems()); ?>
		<?php echo $form->error($model,'role_id'); ?>
            </div>
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model,'gender', CommonProcess::getGender()); ?>
		<?php echo $form->error($model,'gender'); ?>
            </div>
	</div>

	<div class="row" style="display: none">
		<?php echo $form->labelEx($model,'application_id'); ?>
                <?php echo $form->dropDownList($model,'application_id', Applications::loadItems()); ?>
		<?php echo $form->error($model,'application_id'); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
                <?php echo $form->dropDownList($model,'status', CommonProcess::getDefaultStatus()); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>-->

<!--	<div class="row">
		<?php echo $form->labelEx($model,'verify_code'); ?>
		<?php echo $form->textField($model,'verify_code',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'verify_code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'slug'); ?>
		<?php echo $form->textField($model,'slug',array('size'=>60,'maxlength'=>300)); ?>
		<?php echo $form->error($model,'slug'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address_temp'); ?>
		<?php echo $form->textArea($model,'address_temp',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address_temp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>-->

        <div class="row">
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'agent'); ?>
                <?php echo $form->dropDownList($model,'agent', Agents::loadItems(true)); ?>
		<?php echo $form->error($model,'agent'); ?>
            </div>
        </div>

	<div class="row buttons">
            <div class="col-md-6">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',
                        array(
                            'name'  => 'submit',
                        )); ?>
            </div>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $(document).ready(function() {
       $("#Users_first_name").change(function() {
           var nameValue = $("#Users_first_name").val();
           var username = getUserFromFullName(nameValue);
           $("#Users_username").val(username);
       });
       $("#Users_temp_password").change(function() {
           var password = $("#Users_password_hash").val();
           var retypePass = $("#Users_temp_password").val();
           if (!isEmptyString(password)) {
            if (retypePass !== password) {
                alert("Mật khẩu không khớp");
             }    
            }
       });
       $("#Users_password_hash").change(function() {
           var password = $("#Users_password_hash").val();
           var retypePass = $("#Users_temp_password").val();
           if (!isEmptyString(retypePass)) {
            if (retypePass !== password) {
                alert("Mật khẩu không khớp");
             }    
            }
       });
    });
    $(function(){
        fnBindChangeCity(
            '#Users_province_id',
            '#Users_district_id',
            "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchDistrictsByCity'); ?>");
        fnBindChangeDistrict(
            '#Users_district_id',
            '#Users_ward_id',
            "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchWardsByDistrict'); ?>");
    });
</script>
<!--<script>
    $(function(){
        fnBindChangeCity(
            '#Customers_province_id',
            '#Customers_district_id',
            "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchDistrictsByCity'); ?>");
        fnBindChangeDistrict(
            '#Customers_district_id',
            '#Customers_ward_id',
            "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchWardsByDistrict'); ?>");
    });
</script>-->