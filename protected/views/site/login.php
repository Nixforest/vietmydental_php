<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - ' . DomainConst::CONTENT00068;
$this->breadcrumbs=array(
	DomainConst::CONTENT00068,
);
?>

<h1><?php echo DomainConst::CONTENT00068; ?></h1>

<!--<p>Please fill out the following form with your login credentials:</p>-->

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Dòng có dấu <span class="required">*</span> là bắt buộc.</p>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username'); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'password'); ?>
		<?php echo $form->passwordField($model,'password'); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

        <div class="row rememberMe">
		<?php echo $form->checkBox($model,'rememberMe'); ?>
		<?php echo $form->label($model,'rememberMe', array(
                    'style' => 'width: 200px; padding-left: 5px; padding-top: 0px',
                )); ?>
		<?php echo $form->error($model,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(DomainConst::CONTENT00068); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
