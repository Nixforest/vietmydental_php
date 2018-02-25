<?php
$this->createMenu('resetPassword', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->username; ?></h1>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'users-model-form',
        'enableAjaxValidation' => false,
    ));
    ?>
        <?php if (Yii::app()->user->hasFlash(DomainConst::KEY_SUCCESS_UPDATE)): ?>
        <div class="flash-success">
        <?php echo Yii::app()->user->getFlash(DomainConst::KEY_SUCCESS_UPDATE); ?>
        </div>
<?php endif; // end if (Yii::app()->user->hasFlash('successUpdate'))   ?>

    <p class="note">Dòng có dấu <span class="required">*</span> là bắt buộc.</p>

        <?php echo $form->errorSummary($model); ?>

    <div class="row">
<?php echo $form->labelEx($model, 'newpassword', array('style' => 'width:180px;', 'label' => 'Mật Khẩu Mới')); ?>
<?php echo $form->passwordField($model, 'newpassword', array('size' => 38, 'maxlength' => DomainConst::PASSW_LENGTH_MAX)); ?>
    </div>

    <div class="row">
<?php echo $form->labelEx($model, 'password_confirm', array('label' => 'Xác Nhận Mật Khẩu Mới', 'style' => 'width:180px;')); ?>
<?php echo $form->passwordField($model, 'password_confirm', array('size' => 38, 'maxlength' => DomainConst::PASSW_LENGTH_MAX)); ?>
    </div>

    <div class="row buttons" style="padding-left: 135px;padding-top: 15px;">
        <span class="btn-submit"> <?php echo CHtml::submitButton('Save'); ?></span>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
