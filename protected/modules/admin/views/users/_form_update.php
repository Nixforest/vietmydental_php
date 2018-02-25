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

	<p class="note">Dòng có dấu <span class="required">*</span> là bắt buộc.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php
                echo $form->emailField($model, 'email', array(
                    'size' => 60,
                    'maxlength' => 80,
                    'oninvalid' => "this.setCustomValidity('". DomainConst::CONTENT00066 ."')",
                ));
                ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

        <div class="row" readonly="readonly">
		<?php echo $form->labelEx($model,'password_hash'); ?>
		<?php echo $form->passwordField($model,'password_hash',array('size'=>50,'maxlength'=>50, 'readonly' => 'readonly')); ?>
		<?php echo $form->error($model,'password_hash'); ?>
	</div>

        <div class="row" style="display: none;">
		<?php echo $form->labelEx($model,'temp_password'); ?>
		<?php echo $form->passwordField($model,'temp_password',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'temp_password'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'last_name'); ?>
		<?php echo $form->textField($model,'last_name',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'last_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'first_name'); ?>
		<?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>150)); ?>
		<?php echo $form->error($model,'first_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'code_account'); ?>
		<?php echo $form->textField($model,'code_account',array('size'=>30,'maxlength'=>30)); ?>
		<?php echo $form->error($model,'code_account'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>
<!--
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
		<?php echo $form->labelEx($model,'role_id'); ?>
                <?php echo $form->dropDownList($model,'role_id', Roles::loadItems()); ?>
		<?php echo $form->error($model,'role_id'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model,'status', CommonProcess::getGender()); ?>
		<?php echo $form->error($model,'gender'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

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

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->