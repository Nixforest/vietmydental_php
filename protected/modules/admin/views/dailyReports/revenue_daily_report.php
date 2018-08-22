<?php
/* @var $model model DailyReport */
    $date = CommonProcess::convertDateTime($model->date_report, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END);
    $aData = $model->getDetailReport();
    $this->createMenu('viewDetailReport', null);
?>
<h3><?php echo $this->pageTitle . ' ngày: ' . $date; ?></h3>
<?php if(!empty($aData['PAY'])): 
    $receipts       = $aData['PAY'];
    $allReceipts    = $aData['ALL_PAY'];
?>
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
                <td style="text-align:center; font-weight:bold"><?php echo OneMany::getReceiptCustomerTotal($allReceipts->getData()); ?></td>
                <td style="text-align:right; font-weight:bold"><?php echo OneMany::getReceiptTotalTotal($allReceipts->getData()); ?></td>
                <td style="text-align:right; font-weight:bold"><?php echo OneMany::getReceiptDiscountTotal($allReceipts->getData()); ?></td>
                <td style="text-align:right; font-weight:bold"><?php echo OneMany::getReceiptFinalTotal($allReceipts->getData()); ?></td>
                <td style="text-align:right; font-weight:bold"><?php echo OneMany::getReceiptDebitTotal($allReceipts->getData()); ?></td>
            </tr>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php if(!empty($aData['UN_PAY'])): 
    $newReceipts = $aData['UN_PAY'];
?>
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
<?php endif; ?>

