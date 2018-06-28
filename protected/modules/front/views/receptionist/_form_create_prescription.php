<?php
/* @var $this ReceptionistController */
/* @var $model TreatmentScheduleDetails */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'prescription-form',
        'enableAjaxValidation' => false,
    ));
    ?>

        <?php echo DomainConst::CONTENT00081; ?>

        <div class="row buttons">
            <?php
            echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : 'Save',
                    array(
                        'name' => 'submit',
                    ));
            ?>
        </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->