<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - ' . DomainConst::CONTENT00068;
$this->breadcrumbs=array(
	DomainConst::CONTENT00068,
);
?>
<!--//++ BUG0039-IMT  (DuongNV 20180724) UI login-->
<h1><?php // echo DomainConst::CONTENT00068; ?></h1>

<!--<p>Please fill out the following form with your login credentials:</p>-->
<div class="row">
    <div class="col-md-4"></div>
    <div class="form login-form col-md-4">
    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'login-form',
            'enableClientValidation'=>true,
            'clientOptions'=>array(
                    'validateOnSubmit'=>true,
            ),
        'htmlOptions'=>array(
            'style'=>'width:100%;'
        ),
    )); ?>
            <h3 style="margin-top: 0"><?php echo DomainConst::CONTENT00068; ?></h3>
            <p class="note">Dòng có dấu <span class="required">*</span> là bắt buộc.</p>

            <div class="row login-row">
                <div class="login-icon">
                    <i class="glyphicon glyphicon-user"></i>
                </div>
                <?php // echo $form->labelEx($model,'username'); ?>
                <?php echo $form->textField($model,'username', array('class'=>'login-input', 'placeholder'=>'Tài khoản')); ?>
                <?php echo $form->error($model,'username', array('class'=>'errorMessage login-error-ms')); ?>
            </div>

            <div class="row login-row">
                <div class="login-icon">
                    <i class="glyphicon glyphicon-lock"></i>
                </div>
                <?php // echo $form->labelEx($model,'password'); ?>
                <?php echo $form->passwordField($model,'password', array('class'=>'login-input', 'placeholder'=>'Mật khẩu')); ?>
                <?php echo $form->error($model,'password', array('class'=>'errorMessage login-error-ms')); ?>
            </div>
            
            <div class="row rememberMe">
                <?php echo $form->checkBox($model,'rememberMe', array('class'=>'login-checkbox')); ?>
                <?php echo $form->label($model,'rememberMe', array(
//                    'style' => 'width: 200px; padding-left: 5px; padding-top: 0px',
                    'style' => 'font-weight:300px; margin-left:5px;',
                )); ?>
                <?php echo $form->error($model,'rememberMe'); ?>
            </div>

            <div class="row buttons login-submit">
                    <?php echo CHtml::submitButton(DomainConst::CONTENT00068); ?>
            </div>

    <?php $this->endWidget(); ?>
    </div><!-- form -->
</div>
<!--//-- BUG0039-IMT  (DuongNV 20180724) UI login-->