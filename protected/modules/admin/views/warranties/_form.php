<?php
/* @var $this WarrantiesController */
/* @var $model Warranties */
/* @var $form CActiveForm */
?>

<div class="form">
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'warranties-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'customer_id'); ?>
        <?php echo $form->hiddenField($model, 'customer_id', array('class' => '')); ?>
        <?php
        $custName = isset($model->rCustomer) ? $model->rCustomer->getAutoCompleteCustomerName() : '';
        $aData = array(
            'model' => $model,
            'field_id' => 'customer_id',
            'update_value' => $custName,
            'ClassAdd' => 'w-350',
            'url' => Yii::app()->createAbsoluteUrl('admin/ajax/searchCustomer'),
            'field_autocomplete_name' => 'autocomplete_name_customer',
        );
        $this->widget('ext.AutocompleteExt.AutocompleteExt', array('data' => $aData));
        ?>
        <?php echo $form->error($model, 'customer_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type_id'); ?>
        <?php echo $form->dropDownList($model, 'type_id', WarrantyTypes::loadItems()); ?>
        <?php echo $form->error($model, 'type_id'); ?>
    </div>
    <div class="row">
        <label for="teeth"><?php echo DomainConst::CONTENT00284; ?></label>
        <?php
        $arrTeeth = CommonProcess::getListTeeth();
        $rTeeth = array();
        if (isset($model->rJoinTeeth)) {
            foreach ($model->rJoinTeeth as $item) {
                $rTeeth[] = $item->many_id;
            }
        }
        $index = 0;
        ?>
        <table>
            <?php foreach ($arrTeeth as $teeth): ?>
                <?php
                    $inputId = "teeth_" . $index;
                    $inputName = "teeth" . '[' . $index . ']';
                    $checked = "";
                    if (in_array($index, $rTeeth)) {
                        $checked = 'checked="checked"';
                    }
                    $index++;
                ?>
                <tr>
                    <td>
                        <input
                            name="<?php echo $inputName ?>"
                            value="1"
                            type="checkbox"
                            id="<?php echo $inputId ?>"
                            <?php echo $checked; ?>
                            >
                        <label for="<?php echo $inputId ?>" >
                            <?php echo $teeth; ?>
                        </label>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'start_date'); ?>
        <?php
        if ($model->isNewRecord) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
        } else {
            $date = CommonProcess::convertDateTime($model->start_date,
                    DomainConst::DATE_FORMAT_1,
                    DomainConst::DATE_FORMAT_3);
        }
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'     => $model,
            'attribute' => 'start_date',
            'options'   => array(
                'showAnim'      => 'fold',
                'dateFormat'    => DomainConst::DATE_FORMAT_2,
//                        'maxDate'       => '0',
                'changeMonth'   => true,
                'changeYear'    => true,
                'showOn'        => 'button',
                'buttonImage'   => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                'buttonImageOnly' => true,
            ),
            'htmlOptions'=>array(
                        'class'=>'w-16',
//                                'style'=>'height:20px;width:166px;',
                        'readonly'=>'readonly',
                        'value' => $date,
                    ),
        ));
        ?>
        <?php echo $form->error($model, 'start_date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'end_date'); ?>
        <?php
        if ($model->isNewRecord) {
            $date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
        } else {
            $date = CommonProcess::convertDateTime($model->end_date,
                    DomainConst::DATE_FORMAT_1,
                    DomainConst::DATE_FORMAT_3);
        }
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'     => $model,
            'attribute' => 'end_date',
            'options'   => array(
                'showAnim'      => 'fold',
                'dateFormat'    => DomainConst::DATE_FORMAT_2,
//                        'maxDate'       => '0',
                'changeMonth'   => true,
                'changeYear'    => true,
                'showOn'        => 'button',
                'buttonImage'   => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                'buttonImageOnly' => true,
            ),
            'htmlOptions'=>array(
                        'class'=>'w-16',
//                                'style'=>'height:20px;width:166px;',
                        'readonly'=>'readonly',
                        'value' => $date,
                    ),
        ));
        ?>
        <?php echo $form->error($model, 'end_date'); ?>
    </div>

<!--    <div class="row">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->textField($model, 'status'); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>-->

    <div class="row buttons">
<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',
        array(
                            'name'  => 'submit',
                        )); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->