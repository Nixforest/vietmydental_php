<?php
/* @var $this ReportsController */

$this->createMenu('revenue', null);
$dateFrom = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
$dateTo = $dateFrom;
if (!empty($from)) {
    $dateFrom = CommonProcess::convertDateTime($from, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END);
}
if (!empty($to)) {
    $dateTo = CommonProcess::convertDateTime($to, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END);
}
?>
<!--//++ BUG0046-IMT (DuongNV 20180803) Update UI reports-->
<!--<h1><?php echo $this->pageTitle . ' ngày: ' . $dateFrom . ' đến ' . $dateTo; ?></h1>-->
<h3><?php echo $this->pageTitle . ' ngày: ' . $dateFrom . ' đến ' . $dateTo; ?></h3>
<!--//-- BUG0046-IMT (DuongNV 20180803) Update UI reports-->

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'revenue-form',
	'enableAjaxValidation'=>false,
)); ?>
    <div class="row">
        <div class="col-md-6">
            <label for="from_date" class="required">Từ </label>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
                            'readonly'=>'readonly',
                        ),
                'value' => $dateFrom,
            ));
            ?>
        </div>
        <div class="col-md-6">
            <label for="to_date" class="required">Đến </label>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
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
                            'readonly'=>'readonly',
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
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px 10px 10px 154px; background: teal',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00359, array(
                    'name' => DomainConst::KEY_SUBMIT_DATE_BEFORE_YESTERDAY,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px; background: #65a5cc',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00357, array(
                    'name' => DomainConst::KEY_SUBMIT_DATE_YESTERDAY,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px; background: #65a5cc',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00358, array(
                    'name' => DomainConst::KEY_SUBMIT_TODATE,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px; background: #65a5cc',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00350, array(
                    'name' => DomainConst::KEY_SUBMIT_MONTH,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px; background: #65a5cc',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00351, array(
                    'name' => DomainConst::KEY_SUBMIT_LAST_MONTH,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px; background: #65a5cc',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00397, array(
                    'name' => DomainConst::KEY_SUBMIT_EXCEL,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px; background: #65a5cc',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
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
            'footer' => OneMany::getReceiptCustomerTotal($receipts->getData()),
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
            'name' => DomainConst::CONTENT00313,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptNumTeeth()',
        ),
        array(
            'name' => DomainConst::CONTENT00315,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptTreatmentTypePriceText()',
//            'footer' => OneMany::getReceiptTreatmentTypePriceTotal($receipts->getData()),
//            'footerHtmlOptions' => array(
//                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00353,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptTotalText()',
            'footer' => OneMany::getReceiptTotalTotal($receipts->getData()),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00317,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptDiscountText()',
            'footer' => OneMany::getReceiptDiscountTotal($receipts->getData()),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00259,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptFinalText()',
            'footer' => OneMany::getReceiptFinalTotal($receipts->getData()),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00300,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptDebitText()',
            'footer' => OneMany::getReceiptDebitTotal($receipts->getData()),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        
    ),
));
?>
<h3><?php echo DomainConst::CONTENT00254; ?></h3>
<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>
                    <?php echo DomainConst::CONTENT00352; ?>
                </th>
                <th>
                    <?php echo DomainConst::CONTENT00353; ?>
                </th>
                <th>
                    <?php echo DomainConst::CONTENT00354; ?>
                </th>
                <th>
                    <?php echo DomainConst::CONTENT00355; ?>
                </th>
                <th>
                    <?php echo DomainConst::CONTENT00356; ?>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="even">
<!--                <td style="text-align:center; font-weight:bold"><?php // echo OneMany::getReceiptCustomerTotal($receipts->rawData); ?></td>
                <td style="text-align:right; font-weight:bold"><?php // echo OneMany::getReceiptTotalTotal($receipts->rawData); ?></td>
                <td style="text-align:right; font-weight:bold"><?php // echo OneMany::getReceiptDiscountTotal($receipts->rawData); ?></td>
                <td style="text-align:right; font-weight:bold"><?php // echo OneMany::getReceiptFinalTotal($receipts->rawData); ?></td>
                <td style="text-align:right; font-weight:bold"><?php // echo OneMany::getReceiptDebitTotal($receipts->rawData); ?></td>-->
                <td style="text-align:center; font-weight:bold"><?php echo OneMany::getReceiptCustomerTotal($allReceipts->getData()); ?></td>
                <td style="text-align:right; font-weight:bold"><?php echo OneMany::getReceiptTotalTotal($allReceipts->getData()); ?></td>
                <td style="text-align:right; font-weight:bold"><?php echo OneMany::getReceiptDiscountTotal($allReceipts->getData()); ?></td>
                <td style="text-align:right; font-weight:bold"><?php echo OneMany::getReceiptFinalTotal($allReceipts->getData()); ?></td>
                <td style="text-align:right; font-weight:bold"><?php echo OneMany::getReceiptDebitTotal($allReceipts->getData()); ?></td>
            </tr>
        </tbody>
    </table>
</div>
<h3><?php echo DomainConst::CONTENT00370; ?></h3>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'new-receipts-grid',
    'dataProvider' => $newReceipts,
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
            'footer' => OneMany::getReceiptCustomerTotal($newReceipts->getData()),
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
            'name' => DomainConst::CONTENT00313,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptNumTeeth()',
        ),
        array(
            'name' => DomainConst::CONTENT00315,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptTreatmentTypePriceText()',
//            'footer' => OneMany::getReceiptTreatmentTypePriceTotal($newReceipts->getData()),
//            'footerHtmlOptions' => array(
//                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00353,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptTotalText()',
            'footer' => OneMany::getReceiptTotalTotal($newReceipts->getData()),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00317,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptDiscountText()',
            'footer' => OneMany::getReceiptDiscountTotal($newReceipts->getData()),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00259,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptFinalText()',
            'footer' => OneMany::getReceiptFinalTotal($newReceipts->getData()),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        array(
            'name' => DomainConst::CONTENT00300,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '$data->getReceiptDebitText()',
            'footer' => OneMany::getReceiptDebitTotal($newReceipts->getData()),
            'footerHtmlOptions' => array(
                'style' => 'text-align:right; font-weight:bold'),
        ),
        
    ),
));
?>
