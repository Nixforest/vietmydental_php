<?php
/* @var $this ReceptionistController */
/* @var $model List receipts model */

?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'medical-records-form',
	'enableAjaxValidation'=>false,
)); ?>
    
<div class="maincontent clearfix">
    <div class="left-page">
        <div class="title-1">
           <?php echo DomainConst::CONTENT00253; ?>
        </div>
        <div class="info-content">
            <div id="left-content">
                <div class="scroll-table">
                    <table id="customer-info" style="display: none;">
                        <thead>
                            <tr>
                                <th><?php echo DomainConst::CONTENT00100; ?></th>
                                <th><?php echo DomainConst::CONTENT00170; ?></th>
                                <th><?php echo DomainConst::CONTENT00255; ?></th>
                                <th><?php echo DomainConst::CONTENT00259; ?></th>
                                <th><?php echo DomainConst::CONTENT00026; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($arrModels as $model) :?>
                                <?php
                                $mCustomer = $model->getCustomer();
                                $mTreatmentType = $model->getTreatmentType();
                                ?>
                                <?php if (isset($mCustomer) && isset($mTreatmentType)) :?>
                                    <tr id="<?php echo $model->id; ?>" class="customer-info-tr">
                                        <td><?php echo $mCustomer->name ?></td>
                                        <td><?php echo $mCustomer->phone ?></td>
                                        <td><?php echo $mTreatmentType->name; ?></td>
                                        <td><?php echo CommonProcess::formatCurrency($mTreatmentType->price - $model->discount); ?></td>
                                        <td><?php echo $model->getCurrentStatus(); ?></td>
                                    </tr>
                                <?php endif;?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <table id="customer-info">
                        <thead>
                            <tr>
                                <th><?php echo DomainConst::CONTENT00254; ?></th>
                                <th><?php echo DomainConst::CONTENT00335; ?></th>
                                <th><?php echo DomainConst::CONTENT00336; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $total = 0;
                                $totalCollected = 0;
                                $totalDebit = 0;
                            ?>
                            <?php foreach ($arrModels as $model) :?>
                                <?php
                                $total += $model->final;
                                if ($model->status == Receipts::STATUS_RECEIPTIONIST) {
                                    $totalCollected += $model->final;
                                } else {
                                    $totalDebit += $model->final;
                                }
                                ?>
                                <?php if (isset($mCustomer) && isset($mTreatmentType)) :?>
                                    
                                <?php endif;?>
                            <?php endforeach; ?>
                            <tr>
                                <td style="text-align: right"><?php echo CommonProcess::formatCurrency($total); ?></td>
                                <td style="text-align: right"><?php echo CommonProcess::formatCurrency($totalCollected); ?></td>
                                <td style="text-align: right"><?php echo CommonProcess::formatCurrency($totalDebit); ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'id'=>'receipts-grid',
                        'dataProvider'=>$models,
//                        'filter'=>$models,
                        'summaryText'=>'Đang hiển thị {start} - {end} trên {count} kết quả', 
                        'selectableRows'=>1,
                        'selectionChanged'=>'function(id){
                                        fnShowCustomerInfo(
                                        "' . Yii::app()->createAbsoluteUrl('admin/ajax/getReceiptInfo') . '",
                                        "#right-content",
                                        "#right_page_title",
                                        "' . DomainConst::CONTENT00256 . '",
                                        $.fn.yiiGridView.getSelection(id));
                        }',
                        'columns'=>array(
                                array(
                                    'header' => DomainConst::CONTENT00034,
                                    'type' => 'raw',
                                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                                    'headerHtmlOptions' => array('width' => '30px','style' => 'text-align:center;'),
                                    'htmlOptions' => array('style' => 'text-align:center;')
                                ),
                                'process_date',
                                array(
                                    'name' => DomainConst::CONTENT00100,
                                    'value' => '($data->getCustomer() !== NULL) ? $data->getCustomer()->name."<br>".$data->getCustomer()->phone : ""',
                                    'type' => 'html',
                                ),
                                array(
                                    'name' => DomainConst::CONTENT00255,
                                    'value' => '($data->getTreatmentType() !== NULL) ? $data->getTreatmentType()->name : ""',
                                ),
                                array(
                                    'name' => DomainConst::CONTENT00259,
                                    'htmlOptions' => array('style' => 'text-align:right;'),
                                    'value' => '($data->getTreatmentType() !== NULL) ? CommonProcess::formatCurrency($data->final) : ""',
                                ),
//                                'discount',
//                                'need_approve',
//                                'customer_confirm',
//                                'receiptionist_id',
//                                'status',
//                                array(
//                                        'class'=>'CButtonColumn',
//                                ),
                                array(
                                    'header' => DomainConst::CONTENT00026,
//                                    'value' => '($data->status == Receipts::STATUS_RECEIPTIONIST) ? DomainConst::CONTENT00266 : DomainConst::CONTENT00267',
                                    'value' => '$data->getReceptionistStatus()',
                                ),
//                                array(
//                                    'header' => 'Actions',
//                                    'class'=>'CButtonColumn',
//                                    'template'=> $this->createActionButtons(['update']),
//                                    'buttons'=>array(
//                                        'update'=>array(
//                                            'visible'=> '$data->canUpdate()',
//                                        ),
//                                    ),
//                                ),
                        ),
                )); ?>
                <?php if ($isToday == true): ?>
                <?php // echo HtmlHandler::createButton(Yii::app()->createAbsoluteUrl('front/receptionist/receiptOld'), DomainConst::CONTENT00360) ?>
                <?php echo HtmlHandler::createButtonWithImage(Yii::app()->createAbsoluteUrl('front/receptionist/receiptOld'),
                        DomainConst::CONTENT00360,
                        DomainConst::IMG_RECEIPT_ICON) ?>
                <?php endif; // end if (condition) ?>
            </div>
        </div>
    </div>
    <div class="right-page">
        <div class="title-1" id="right_page_title">
            <?php echo DomainConst::CONTENT00256; ?>
        </div>
        <div class="info-content">
            <div id="right-content">
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
</div><!-- form -->


<!-- Select print dialog -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'    => 'dialogPrintReceipt',
        'options' => array(
            'title' => DomainConst::CONTENT00374,
            'autoOpen'  => false,
            'modal'     => true,
            'position'  => array(
                'my'    => 'top',
                'at'    => 'top',
            ),
            'width'     => 700,
            'heigh'     => 470,
            'close'     => 'js:function() { }',
        ),
    ));
?>
<div class="divForForm"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>

<script>
    $(function(){
        fnHandleTextChange(
                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchCustomerReception'); ?>",
                "#right-content",
                "#right_page_title",
                "<?php echo DomainConst::CONTENT00171 ?>");
    });
    $("body").on("click", "#receipts-grid tbody tr", function() {
//        fnShowCustomerInfo(
//                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/getReceiptInfo'); ?>",
//                "#right-content",
//                "#right_page_title",
//                "<?php echo DomainConst::CONTENT00256 ?>",
//                $(this).attr('id'));
    });
    $("body").on("click", "#receipts-grid-old tbody tr", function() {
//        fnShowCustomerInfo(
//                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/getReceiptInfo'); ?>",
//                "#right-content",
//                "#right_page_title",
//                "<?php echo DomainConst::CONTENT00256 ?>",
//                $(this).attr('id'));
//        alert($(this).attr('id'));
    });
</script>
<script type="text/javascript">
    /**
     * Create print dialog
     * @returns {Boolean}
     */
    function createPrintDialog() {
        alert("<?php echo DomainConst::CONTENT00375; ?>");
//        $("<link/>", {
//            id: "form_ccs",
//            rel: "stylesheet",
//            type: "text/css",
//            href: "<?php echo Yii::app()->theme->baseUrl . '/css/form.css'; ?>"
//         }).appendTo("head");
//        <?php
//        echo CHtml::ajax(array(
//            'url' => Yii::app()->createAbsoluteUrl('front/receptionist/printMore'),
//            'data' => "js:$(this).serialize()",
//            'type' => 'post',
//            'dataType' => 'json',
//            'success' => "function(data)
//                    {
//                        if (data.status == 'failure')
//                        {
//                            $('#dialog div.divForForm').html(data.div);
//                                  // Here is the trick: on submit-> once again this function!
//                            $('#dialog div.divForForm form').submit(createPrintDialog);
//                        }
//                        else
//                        {
//                            $('#dialog div.divForForm').html(data.div);
//                            setTimeout(\"$('#dialog').dialog('close') \",1000);
//                        }
//
//                    } ",
//        ))
        ?>;
//        return false;
    }
</script>