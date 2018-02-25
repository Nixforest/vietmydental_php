<?php
/* @var $this MoneyAccountController */
/* @var $model MoneyAccount */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

<!--	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>32,'maxlength'=>32)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'owner_id'); ?>
		<?php echo $form->hiddenField($model, 'owner_id', array('class' => '')); ?>
                <?php
                    $userName = isset($model->rUser) ? $model->rUser->getAutoCompleteUserName() : '';
                    $aData = array(
                        'model'             => $model,
                        'field_id'          => 'owner_id',
                        'update_value'      => $userName,
                        'ClassAdd'          => 'w-400',
                        'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchUser'),
                        'field_autocomplete_name' => 'autocomplete_name_owner',
                    );
                    $this->widget('ext.AutocompleteExt.AutocompleteExt',
                            array('data' => $aData));
                ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'balance'); ?>
		<?php echo $form->textField($model,'balance',array('size'=>11,'maxlength'=>11)); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->label($model,'created_date'); ?>
		<?php echo $form->textField($model,'created_date'); ?>
	</div>-->

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', CommonProcess::getDefaultStatus()); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->