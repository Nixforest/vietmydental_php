<?php
/* @var $this PrescriptionDetailsController */
/* @var $model PrescriptionDetails */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'prescription-details-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'prescription_id'); ?>
		<?php echo $form->textField($model,'prescription_id',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'prescription_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'medicine_id'); ?>
		<?php echo $form->hiddenField($model, 'medicine_id', array('class' => '')); ?>
                <?php
                    $medicineName = isset($model->rMedicine) ? $model->rMedicine->getAutoCompleteMedicine() : '';
                    $url = Yii::app()->createAbsoluteUrl('admin/ajax/searchMedicine');
                    $aData = ['model'             => $model,
                        'field_id'          => 'medicine_id',
                        'update_value'      => $medicineName,
                        'ClassAdd'          => 'w-350',
                        'url'               => $url,
                        'field_autocomplete_name' => 'autocomplete_name_medicine',
                       ];
                    $this->widget('ext.AutocompleteExt.AutocompleteExt',
                            array('data' => $aData));
                ?>
		<?php echo $form->error($model,'medicine_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity'); ?>
		<?php echo $form->textField($model,'quantity',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'quantity'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity1'); ?>
		<?php echo $form->textField($model,'quantity1',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'quantity1'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity2'); ?>
		<?php echo $form->textField($model,'quantity2',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'quantity2'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity3'); ?>
		<?php echo $form->textField($model,'quantity3',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'quantity3'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'quantity4'); ?>
		<?php echo $form->textField($model,'quantity4',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'quantity4'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->