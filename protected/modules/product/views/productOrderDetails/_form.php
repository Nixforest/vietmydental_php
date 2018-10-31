<?php
/* @var $this ProductOrderDetailsController */
/* @var $model ProductOrderDetails */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'product-order-details-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'order_id'); ?>
        <?php echo $form->dropDownList($model, 'order_id', ProductOrders::loadItems()); ?>
        <?php echo $form->error($model, 'order_id'); ?>
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

    <div class="row">
        <?php echo $form->labelEx($model, 'price'); ?>
        <?php echo $form->textField($model, 'price', array('size' => 11, 'maxlength' => 11)); ?>
        <?php echo $form->error($model, 'price'); ?>
    </div>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', ProductStoreCards::getArrayStatus()); ?>
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
        $('#ProductOrderDetails_qty').autoNumeric('init', {lZero:"deny", aPad: false} ); 
        $('#ProductOrderDetails_price').autoNumeric('init', {lZero:"deny", aPad: false} ); 
    });
</script>