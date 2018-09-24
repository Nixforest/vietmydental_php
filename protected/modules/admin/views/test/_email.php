<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'settings-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Send', array(
            'name'  => DomainConst::KEY_SUBMIT,
        )); ?>
        <?php echo CHtml::submitButton('Send Swift Mailer', array(
            'name'  => 'submit_email',
        )); ?>
        <?php echo CHtml::submitButton('Send PA mail handler', array(
            'name'  => 'submit_email_pa',
        )); ?>
        <?php echo CHtml::submitButton('Test fsocket', array(
            'name'  => 'submit_test_fsocket',
        )); ?>
        <?php echo CHtml::submitButton('SendGrid', array(
            'name'  => 'submit_send_grid',
        )); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->