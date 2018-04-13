<?php
/* @var $this CustomersController */
/* @var $model Customers */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'customers-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
            </div>            
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model,'gender', CommonProcess::getGender()); ?>
		<?php echo $form->error($model,'gender'); ?>
            </div>
	</div>

	<div class="row">
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'date_of_birth'); ?>
		<?php
                if ($model->isNewRecord) {
                    $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
                } else {
                    $date = CommonProcess::convertDateTime($model->date_of_birth,
                            DomainConst::DATE_FORMAT_4,
                            DomainConst::DATE_FORMAT_3);
                }
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'     => $model,
                    'attribute' => 'date_of_birth',
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
                                'class'=>'w-16',
//                                'style'=>'height:20px;width:166px;',
                                'readonly'=>'readonly',
                                'value' => $date,
                            ),
                ));
                ?>
		<?php echo $form->error($model,'date_of_birth'); ?>
            </div>
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'phone'); ?>
            </div>
	</div>

	<div class="row">
            <div class="col-md-6">
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
            
            <div class="col-md-6">
                <?php echo $form->labelEx($model,'characteristics'); ?>
		<?php echo $form->textArea($model,'characteristics',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'characteristics'); ?>
            </div>
	</div>

	<div class="row">            
            <div class="col-md-6">
                <?php echo $form->labelEx($model,'house_numbers'); ?>
		<?php echo $form->textField($model,'house_numbers',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'house_numbers'); ?>
            </div>
            
            <div class="col-md-6">
                <?php echo $form->labelEx($model,'city_id'); ?>
		<?php echo $form->dropDownList($model,'city_id', Cities::loadItems(), array('class'=>'','empty'=>'Select')); ?>
		<?php echo $form->error($model,'city_id'); ?>
            </div>
	</div>

	<div class="row">
            <div class="col-md-6">
                <?php echo $form->labelEx($model,'district_id'); ?>
		<?php echo $form->dropDownList($model,'district_id', Districts::loadItems($model->city_id), array('class'=>'','empty'=>'Select')); ?>
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
		<?php echo $form->labelEx($model,'user_id'); ?>
		<?php echo $form->hiddenField($model, 'user_id', array('class' => '')); ?>
                <?php
                    $userName = isset($model->rUser) ? $model->rUser->getAutoCompleteUserName() : '';
                    $aData = array(
                        'model'             => $model,
                        'field_id'          => 'user_id',
                        'update_value'      => $userName,
                        'ClassAdd'          => 'w-350',
                        'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchUser'),
                        'field_autocomplete_name' => 'autocomplete_name_user',
                    );
                    $this->widget('ext.AutocompleteExt.AutocompleteExt',
                            array('data' => $aData));
                ?>
		<?php echo $form->error($model,'user_id'); ?>
            </div>
            <div class="col-md-6" style="display: none">
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
	</div>

	<div class="row">
            <div class="col-md-6">
		<?php echo $form->labelEx($model,'type_id'); ?>
		<?php echo $form->dropDownList($model,'type_id', CustomerTypes::loadItems()); ?>
		<?php echo $form->error($model,'type_id'); ?>
            </div>
            <div class="col-md-6">
                <?php echo $form->labelEx($model,'career_id'); ?>
		<?php echo $form->dropDownList($model,'career_id', Careers::loadItems()); ?>
		<?php echo $form->error($model,'career_id'); ?>
            </div>
	</div>
    
<!--	<div class="row">		
            <div class="col-md-6">
                <?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',
                        array(
                            'rows'=>6,
                            'cols'=>50,
                            'readonly' => true,
                        )); ?>
		<?php echo $form->error($model,'address'); ?>
            </div>
	</div>-->

<!--	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>-->

<!--	<div class="row">
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
            <div class="col-md-6">
		<?php echo $form->labelEx($model, 'referCode') ?>
                <?php if (!isset($model->rReferCode)): ?>
                    <?php echo $form->hiddenField($model, 'referCode', array('class' => '')); ?>
                    <?php
                        $referCode = isset($model->rReferCode) ? $model->rReferCode->code : '';
                        $aData = array(
                            'model'             => $model,
                            'field_id'          => 'referCode',
                            'update_value'      => $referCode,
                            'ClassAdd'          => 'w-350',
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
                        $model->referCode = isset($model->rReferCode) ? $model->rReferCode->code : '';
                        echo $form->textField($model,'referCode', array(
                            'size'=>11,'maxlength'=>11,
                            'readonly' => 'true',
                        ));
                    ?>
                <?php endif; // end if ($model->isNewRecord) ?>
                <?php echo $form->error($model,'referCode'); ?>
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
<script>
    $(function(){
        fnBindChangeCity(
            '#Customers_city_id',
            '#Customers_district_id',
            "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchDistrictsByCity'); ?>");
        fnBindChangeDistrict(
            '#Customers_district_id',
            '#Customers_ward_id',
            "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchWardsByDistrict'); ?>");
    });
</script>