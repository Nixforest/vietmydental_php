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
        'id' => 'grid-old',
        'enableAjaxValidation' => false,
    ));
    ?>
    <div class="row">
        <div class="col-md-6">
            <label for="from_date" class="required" style="width: auto; margin: 0 10px 0 111px;">Từ </label>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'from_date',
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
                    'readonly' => 'readonly',
                ),
                'value' => $dateFrom,
            ));
            ?>
        </div>
        <div class="col-md-6">
            <label for="to_date" class="required" style="width: auto; margin-right: 10px;">Đến </label>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'to_date',
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => DomainConst::DATE_FORMAT_2,
                    'changeMonth' => true,
                    'changeYear' => true,
                    'showOn' => 'button',
                    'buttonImage' => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                    'buttonImageOnly' => true,
                ),
                'htmlOptions' => array(
                    'class' => 'w-16',
                    'readonly' => 'readonly',
                ),
                'value' => $dateTo,
            ));
            ?>
        </div>
    </div>

    <div class="row buttons">
        <?php
        echo CHtml::submitButton(DomainConst::CONTENT00349, array(
            'name' => DomainConst::KEY_SUBMIT,
            'style' => 'margin: 10px 10px 10px 154px; background: teal',
        ));
        ?>
        <?php
        echo CHtml::submitButton(DomainConst::CONTENT00397, array(
            'name' => DomainConst::KEY_SUBMIT_EXCEL,
            'style' => 'margin: 10px; background: teal',
        ));
        ?>
        <?php
        echo CHtml::submitButton(DomainConst::CONTENT00359, array(
            'name' => DomainConst::KEY_SUBMIT_DATE_BEFORE_YESTERDAY,
            'style' => 'margin: 10px; background: #2e76a2',
        ));
        ?>
        <?php
        echo CHtml::submitButton(DomainConst::CONTENT00357, array(
            'name' => DomainConst::KEY_SUBMIT_DATE_YESTERDAY,
            'style' => 'margin: 10px; background: #2e76a2',
        ));
        ?>
        <?php
        echo CHtml::submitButton(DomainConst::CONTENT00358, array(
            'name' => DomainConst::KEY_SUBMIT_TODATE,
            'style' => 'margin: 10px; background: #2e76a2',
        ));
        ?>
        <?php
        echo CHtml::submitButton(DomainConst::CONTENT00350, array(
            'name' => DomainConst::KEY_SUBMIT_MONTH,
            'style' => 'margin: 10px; background: #2e76a2',
        ));
        ?>
        <?php
        echo CHtml::submitButton(DomainConst::CONTENT00351, array(
            'name' => DomainConst::KEY_SUBMIT_LAST_MONTH,
            'style' => 'margin: 10px; background: #2e76a2',
        ));
        ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form --> 