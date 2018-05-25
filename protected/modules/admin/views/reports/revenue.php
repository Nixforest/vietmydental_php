<?php
/* @var $this ReportsController */

$this->createMenu('revenue', null);
$date = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3);
?>
<h1><?php echo $this->pageTitle . ' ngày: ' . $date; ?></h1>

    <div class="row">
        <div class="col-md-6">
            <label for="from_date" class="required">Từ </label>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
//                'model'     => null,
//                'attribute' => 'date_of_birth',
                'name' => 'from_date',
                'options'   => array(
                    'showAnim'      => 'fold',
                    'dateFormat'    => DomainConst::DATE_FORMAT_2,
                    'maxDate'       => '0',
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
        </div>
        <div class="col-md-6">
            <label for="to_date" class="required">Đến </label>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
//                'model'     => null,
                'attribute' => 'date_of_birth',
                'name' => 'to_date',
                'options'   => array(
                    'showAnim'      => 'fold',
                    'dateFormat'    => DomainConst::DATE_FORMAT_2,
//                    'maxDate'       => '0',
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
        </div>
    </div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'receipts-grid',
    'dataProvider' => $receipts,
//    'filter'    => $model->rProducts,
    'columns' => array(
        array(
            'header' => DomainConst::CONTENT00034,
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'name' => DomainConst::CONTENT00343,
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => 'isset($data->rReceipt) ? $data->rReceipt->getProcessDate() : ""',
            'footer' => DomainConst::CONTENT00254,
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00138,
            'htmlOptions' => array('style' => 'text-align:left;'),
            'value' => '$data->getReceiptCustomerRecordNumber()',
        ),
        array(
            'name' => DomainConst::CONTENT00100,
            'htmlOptions' => array('style' => 'text-align:left;'),
            'value' => '$data->getReceiptCustomerName()',
            'footer' => OneMany::getReceiptCustomerTotal($receipts),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00128,
            'htmlOptions' => array(
                'style' => 'text-align:left;'),
            'value' => '$data->getReceiptTreatmentTypeName()',
        ),
        array(
            'name' => DomainConst::CONTENT00129,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptTreatmentTypePriceText()',
            'footer' => OneMany::getReceiptTreatmentTypePriceTotal($receipts),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00317,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptDiscountText()',
            'footer' => OneMany::getReceiptDiscountTotal($receipts),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00259,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptFinalText()',
            'footer' => OneMany::getReceiptFinalTotal($receipts),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00300,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptDebitText()',
            'footer' => OneMany::getReceiptDebitTotal($receipts),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        
    ),
));
?>
