<?php
/* @var $this AgentsController */
/* @var $model Agents */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'agents-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'phone'); ?>
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

	<div class="row">
		<?php echo $form->labelEx($model,'foundation_date'); ?>
		<?php
                if ($model->isNewRecord) {
                    $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
                } else {
                    $date = CommonProcess::convertDateTime($model->foundation_date,
                            DomainConst::DATE_FORMAT_4,
                            DomainConst::DATE_FORMAT_3);
                }
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model'     => $model,
                    'attribute' => 'foundation_date',
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
		<?php echo $form->error($model,'foundation_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'city_id'); ?>
		<?php echo $form->dropDownList($model,'city_id', Cities::loadItems(), array('class'=>'','empty'=>'Select')); ?>
		<?php echo $form->error($model,'city_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'district_id'); ?>
		<?php echo $form->dropDownList($model,'district_id', Districts::loadItems($model->city_id), array('class'=>'','empty'=>'Select')); ?>
		<?php echo $form->error($model,'district_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ward_id'); ?>
		<?php echo $form->dropDownList($model,'ward_id', Wards::loadItems($model->district_id), array('class'=>'','empty'=>'Select')); ?>
		<?php echo $form->error($model,'ward_id'); ?>
	</div>

	<div class="row">
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

	<div class="row">
		<?php echo $form->labelEx($model,'house_numbers'); ?>
		<?php echo $form->textField($model,'house_numbers',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'house_numbers'); ?>
	</div>

<!--	<div class="row">
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
		<?php echo $form->labelEx($model,'created_by'); ?>
		<?php echo $form->textField($model,'created_by',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'created_by'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
    $(function(){
        fnBindChangeCity(
            '#Agents_city_id',
            '#Agents_district_id',
            "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchDistrictsByCity'); ?>");
        fnBindChangeDistrict(
            '#Agents_district_id',
            '#Agents_ward_id',
            "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchWardsByDistrict'); ?>");
    });
</script>