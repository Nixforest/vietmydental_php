<?php
/* @var $this ReferCodesController */
?>

<h1><?php echo $this->pageTitle; ?></h1>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'promotions-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <div class="row">
        <label for="count"><?php echo DomainConst::CONTENT00083; ?></label>
        <input type="text" name="count" id="count" value="1000" />
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',
                array(
                    'name'  => DomainConst::KEY_SUBMIT,
                )); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/autoNumeric/autoNumeric.js'); ?>
<script>
    $(document).ready(function(){
        $('#count').autoNumeric('init', {lZero:"deny", aPad: false} ); 
    });
</script>