<?php
/* @var $this ReceptionistController */
/* @var $form CActiveForm */
?>

<div class="form">
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'customers-form',
    'enableAjaxValidation' => false,
));
?>
<div>
    <?php echo $customer->name; ?>
    <br>
    <?php echo DomainConst::CONTENT00375; ?>
    <div class="row buttons">
        <?php echo CHtml::submitButton(DomainConst::CONTENT00264,
            array(
                'name'  => DomainConst::KEY_SUBMIT,
            )); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

</div>
<!-- form -->




