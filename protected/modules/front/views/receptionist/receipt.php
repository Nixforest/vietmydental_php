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
            <!--//++ BUG0037-IMT  (DuongNV 201807) Update UI receipt-->
            <div id="left-content" style="text-align:center">
                <!--<div class="scroll-table">-->
                <div>
                <!--//-- BUG0037-IMT  (DuongNV 201807) Update UI receipt-->
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
                    <!--//++ BUG0037-IMT  (DuongNV 201807) Update UI receipt-->
                    <table id="customer-info" class="table table-striped table-bordered lp-table" style="background:white">
                    <!--//-- BUG0037-IMT  (DuongNV 201807) Update UI receipt-->
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
                        'dataProvider' => $dataProvider,
//                        'dataProvider' => $models,
//                        'filter'=>$dataProvider,
                        'summaryText'=>'Đang hiển thị {start} - {end} trên ' . count($dataProvider->getData()) . ' kết quả', 
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
                <!--//++ BUG0038-IMT  (DuongNV 201807) Update UI receipt-->
                <?php // echo HtmlHandler::createButtonWithImage(Yii::app()->createAbsoluteUrl('front/receptionist/receiptOld'),
//                        DomainConst::CONTENT00360,
//                        DomainConst::IMG_RECEIPT_ICON) ?>
                <?php echo HtmlHandler::createBstButton(Yii::app()->createAbsoluteUrl('front/receptionist/receiptOld'),
                        DomainConst::CONTENT00360,
                        'fas fa-receipt') ?>
                <!--//-- BUG0038-IMT  (DuongNV 201807) Update UI receipt-->
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

<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'    => 'dialogId',
        'options' => array(
            'title' => DomainConst::CONTENT00004,
            'autoOpen'  => false,
            'modal'     => true,
            'position'  => array(
                'my'    => 'top',
                'at'    => 'top',
            ),
            'width'     => 1000,
            'heigh'     => 470,
            'close'     => 'js:function() { $("#form_ccs").remove(); }',
        ),
    ));
?>
<div class="divForFormClass"></div>
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
    /** Dialog option */
    var opt = {
        autoOpen: false,
        modal: true,
        width: 1000,
        height: 1000,
        title: "<?php echo DomainConst::CONTENT00004; ?>",
        close: function() {
            $("#form_ccs").remove();
        }
    };
    
    /**
     * Load from css.
     */
    function fnLoadFormCSS() {
        $("<link/>", {
            id: "form_ccs",
            rel: "stylesheet",
            type: "text/css",
            href: "<?php echo Yii::app()->theme->baseUrl . '/css/form.css'; ?>"
         }).appendTo("head");
    }
    
    /**
     * Check if data is success
     * @param {type} data
     * @returns {Boolean}
     */
    function fnIsDataSuccess(data) {
        return (data["<?php echo DomainConst::KEY_STATUS; ?>"]
                === "<?php echo DomainConst::NUMBER_ONE_VALUE; ?>");
    }
    
    /**
     * Load dialog content
     * @param {Json} data Json data
     * @param {String} title Title of dialog
     * @param {String} fnHandler Function handler
     */
    function fnLoadDialogContent(data, title, fnHandler) {
        // Set content of dialog
        $('#dialogId div.divForFormClass').html(
                data['<?php echo DomainConst::KEY_CONTENT; ?>']);
        // Set title of dialog
        $('.ui-dialog-title').html(title);
        // Here is the trick: on submit-> once again this function!
        $('#dialogId div.divForFormClass form').submit(fnHandler);
    }
    
    /**
     * Open print dialog
     * @param {String} _id Id of customer need to print receipts
     * @returns {Boolean}
     */
    function fnOpenPrintReceipt(_id = '') {
        createPrintDialog(_id);
        $("#dialogId").dialog(opt).dialog("open");
    }
    
    /**
     * Create print dialog
     * @param {String} _id Id of customer need to print receipts
     * @returns {Boolean}
     */
    function createPrintDialog(_id = '') {
        fnLoadFormCSS();
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl(
                    'front/receptionist/printMore'); ?>",
            data: $(this).serialize() + '&id=' + _id,
            type: "post",
            dataType: "json",
            success: function(data) {
                // After submit
                if (fnIsDataSuccess(data)) {
                    setTimeout("$('#dialogId').dialog(opt).dialog('close')", 1000);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                       '<?php echo DomainConst::CONTENT00374; ?>',
                       createPrintDialog);
                }
            },
            cache: false
        });
        return false;
    }
</script>