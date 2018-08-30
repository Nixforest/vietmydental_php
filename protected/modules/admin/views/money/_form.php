<?php
/* @var $this MoneyController */
/* @var $model Money */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'money-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>

    <?php echo $form->errorSummary($model); ?>


    <div class="row">
        <?php echo $form->labelEx($model, 'moneyType'); ?>
        <?php echo $form->dropDownList($model, 'moneyType', MoneyType::loadItems(true)); ?>
        <?php echo $form->error($model, 'moneyType'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textArea($model, 'name', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row" style="display: none">
        <?php echo $form->labelEx($model, 'user_id'); ?>
        <?php echo $form->hiddenField($model, 'user_id', array('class' => '')); ?>
        <?php
        $userName = isset($model->rUser) ? $model->rUser->getAutoCompleteUserName() : '';
        $aData = array(
            'model' => $model,
            'field_id' => 'user_id',
            'update_value' => $userName,
            'ClassAdd' => 'w-400',
            'url' => Yii::app()->createAbsoluteUrl('admin/ajax/searchUser'),
            'field_autocomplete_name' => 'autocomplete_name_user',
        );
        $this->widget('ext.AutocompleteExt.AutocompleteExt', array('data' => $aData));
        ?>
        <?php echo $form->error($model, 'user_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'isIncomming'); ?>
        <?php echo $form->dropDownList($model, 'isIncomming', CommonProcess::getTypeOfMoney()); ?>
        <?php echo $form->error($model, 'isIncomming'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'amount'); ?>
        <?php echo $form->textField($model, 'amount', array('size' => 11, 'maxlength' => 11)); ?>
        <?php echo $form->error($model, 'amount'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'account_id'); ?>
        <?php echo $form->dropDownList($model, 'account_id', MoneyAccount::loadItems()); ?>
        <?php echo $form->error($model, 'account_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'action_date'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model' => $model,
            'attribute' => 'action_date',
            'options' => array(
                'showAnim' => 'fold',
                'dateFormat' => DomainConst::DATE_FORMAT_2,
                'maxDate' => '0',
                'changeMonth' => true,
                'changeYear' => true,
                'showOn' => 'button',
                'buttonImage' => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                'buttonImageOnly' => true,
            ),
            'htmlOptions' => array(
                'class' => 'w-16',
//                                'style'=>'height:20px;width:166px;',
                'readonly' => 'readonly',
                'value' => CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3),
            ),
        ));
        ?>
        <?php echo $form->error($model, 'action_date'); ?>
    </div>

    <div class="row" style="display: none">
        <?php echo $form->labelEx($model, 'created_date'); ?>
        <?php
        echo $form->textField(
                $model, 'created_date', array(
            'value' => date(DomainConst::DATE_FORMAT_1),
            'readonly' => 'true',
                )
        );
        ?>
        <?php echo $form->error($model, 'created_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/autoNumeric/autoNumeric.js'); ?>
<script>

    $(document).ready(function(){
        $('#Money_amount').autoNumeric('init', {lZero:"deny", aPad: false} ); 
    });
    $(function () {
        $('#Money_moneyType').change(function () {
            var type_id = $(this).val();
            $.ajax({
                url: "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/getMoneyTypeInfo'); ?>",
                data: {ajax: 1, term: type_id},
                type: "get",
                dataType: 'json',
                success: function (data) {
                    $('#Money_name').html(data['name']);
                    $('#Money_description').html(data['description']);
//                $('#Money_amount').html(data['amount']);
                    $('#Money_amount').val(data['amount']);
                }
            });
        });
    });
</script>