<?php
/* @var $this ProductStoresDetailsController */
/* @var $model ProductStoresDetails */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-stores-details-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'store_id'); ?>
        <?php echo $form->dropDownList($model, 'store_id', ProductStores::loadItems()); ?>
        <?php echo $form->error($model, 'store_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'product_id'); ?>
        <?php echo $form->dropDownList($model, 'product_id', Products::loadItems()); ?>
        <?php echo $form->error($model, 'product_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'qty'); ?>
        <?php echo $form->textField($model, 'qty', array('size' => 11, 'maxlength' => 11)); ?>
        <?php echo $form->error($model, 'qty'); ?>
    </div>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', ProductStoresDetails::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/autoNumeric/autoNumeric.js'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#ProductStoreDetails_qty').autoNumeric('init', {lZero:"deny", aPad: false} ); 
    });
</script>