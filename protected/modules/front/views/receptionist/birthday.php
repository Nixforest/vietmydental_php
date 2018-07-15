<?php
/* @var $this ReceptionistController */

?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'medical-records-form',
	'enableAjaxValidation'=>false,
)); ?>
    
<div class="maincontent clearfix">
<!--    <div class="left-page">
        <div class="title-1">
           Bộ lọc Tìm kiếm
        </div>
        <div class="info-content">
            <div class="box-search">
                <form>
                    <span class="icon-s"></span>
                    <input type="text" class="form-control text-change"  placeholder="Tìm Kiếm Bệnh Nhân"
                           id="customer_find">
                </form>
            </div>
        </div>
    </div>-->
    <div class="right-page">
        <div class="title-1" id="right_page_title">
            Danh sách Bệnh nhân có sinh nhật vào hôm nay
        </div>
        <div class="info-content">
            <div id="right-content">
                <div class="scroll-table">
                    <table id="customer-info">
                        <thead>
                            <tr>
                                <th><?php echo DomainConst::CONTENT00100; ?></th>
                                <th><?php echo DomainConst::CONTENT00170; ?></th>
                                <th><?php echo DomainConst::CONTENT00101; ?></th>
                                <th class="col-4"><?php echo DomainConst::CONTENT00045; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model as $customer) :?>
                            <tr id="<?php echo $customer->id; ?>" class="customer-info-tr">
                                <td><?php echo $customer->name ?></td>
                                <td><?php echo $customer->phone ?></td>
                                <td><?php echo $customer->getBirthday() ?></td>
                                <td><?php echo $customer->address ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
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
    $("body").on("click", "#customer-info tbody tr", function() {
        fnShowCustomerInfo(
                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/getCustomerInfo'); ?>",
                "#right-content",
                "#right_page_title",
                "<?php echo DomainConst::CONTENT00172 ?>",
                $(this).attr('id'));
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
     * Update customer data after do something
     * @param {Json} data Json data
     */
    function fnUpdateCustomerData(data) {
        $('#dialogId div.divForFormClass').html(data['<?php echo DomainConst::KEY_CONTENT; ?>']);
        $('#right_page_title').html('<?php echo DomainConst::CONTENT00172; ?>');
        $('#right-content').html(data['<?php echo DomainConst::KEY_RIGHT_CONTENT; ?>']);
        $('.left-page .info-content .info-result .content').html(data['<?php echo DomainConst::KEY_INFO_SCHEDULE; ?>']);
        setTimeout("$('#dialogId').dialog(opt).dialog('close')", 1000);
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
     * Check if data is success
     * @param {type} data
     * @returns {Boolean}
     */
    function fnIsDataSuccess(data) {
        return (data["<?php echo DomainConst::KEY_STATUS; ?>"]
                === "<?php echo DomainConst::NUMBER_ONE_VALUE; ?>");
    }
    
    /**
     * Open create customer dialog
     */
    function fnOpenCreateCustomer() {
        createCustomer();
        $("#dialogId").dialog(opt).dialog("open");
    }
    
    /**
     * Create customer dialog
     * @returns {Boolean}
     */
    function createCustomer() {
        fnLoadFormCSS();
        $.ajax({
             url: "<?php echo Yii::app()->createAbsoluteUrl(
                     'front/receptionist/createCustomer'); ?>",
             data: $(this).serialize(),
             type: "post",
             dataType: "json",
             success: function(data) {
                 // After submit
                if (fnIsDataSuccess(data)) {
                    fnUpdateCustomerData(data);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                        '<?php echo DomainConst::CONTENT00176; ?>',
                        createCustomer);
                }
             },
             cache: false
         });
        return false;
    }
    
    /**
     * Open update customer dialog
     * @param {String} _id Id of customer need update
     * @returns {Boolean}
     */
    function fnOpenUpdateCustomer(_id = '') {
        updateCustomer(_id);
        $("#dialogId").dialog(opt).dialog("open");
    }
    
    /**
     * Update customer dialog
     * @param {String} _id Id of customer need update
     * @returns {Boolean}
     */
    function updateCustomer(_id = '') {
        fnLoadFormCSS();
        $.ajax({
             url: "<?php echo Yii::app()->createAbsoluteUrl(
                     'front/receptionist/updateCustomer'); ?>",
             data: $(this).serialize() + '&id=' + _id,
             type: "post",
             dataType: "json",
             success: function(data) {
                 // After submit
                if (fnIsDataSuccess(data)) {
                    fnUpdateCustomerData(data);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                        '<?php echo DomainConst::CONTENT00172; ?>',
                        updateCustomer);
                }
             },
             cache: false
         });
        return false;
    }
    
    /**
     * Open create schedule dialog
     * @returns {Boolean}
     */
    function fnOpenCreateSchedule() {
        createSchedule();
        $("#dialogId").dialog(opt).dialog("open");
    }
    
    /**
     * Create schedule
     * @returns {Boolean}
     */
    function createSchedule() {
        fnLoadFormCSS();
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl(
                    'front/receptionist/createSchedule'); ?>",
            data: $(this).serialize(),
            type: "post",
            dataType: "json",
            success: function(data) {
                // After submit
                if (fnIsDataSuccess(data)) {
                    fnUpdateCustomerData(data);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                       '<?php echo DomainConst::CONTENT00182; ?>',
                       createSchedule);
                }
            },
            cache: false
        });
        return false;
    }
    
    /**
     * Open update schedule dialog
     * @param {String} _id Id of treatment schedule need update
     * @returns {Boolean}
     */
    function fnOpenUpdateSchedule(_id = '') {
        updateSchedule(_id);
        $("#dialogId").dialog(opt).dialog("open");
    }
    
    /**
     * Update treatment schedule
     * @param {String} _id Id of treatment schedule need update
     * @returns {Boolean}
     */
    function updateSchedule(_id = '') {
        fnLoadFormCSS();
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl(
                    'front/receptionist/updateSchedule'); ?>",
            data: $(this).serialize() + '&id=' + _id,
            type: "post",
            dataType: "json",
            success: function(data) {
                // After submit
                if (fnIsDataSuccess(data)) {
                    fnUpdateCustomerData(data);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                       '<?php echo DomainConst::CONTENT00182; ?>',
                       updateSchedule);
                }
            },
            cache: false
        });
        return false;
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
                    fnUpdateCustomerData(data);
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
    
    /**
     * Open print dialog
     * @param {String} _id Id of treatment schedule detail need to create prescription
     * @returns {Boolean}
     */
    function fnOpenCreatePrescription(_id = '') {
        createPrescriptionDialog(_id);
        $("#dialogId").dialog(opt).dialog("open");
    }
    
    /**
     * Create print dialog
     * @param {String} _id Id of treatment schedule detail need to create prescription
     * @returns {Boolean}
     */
    function createPrescriptionDialog(_id = '') {
        fnLoadFormCSS();
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl(
                    'front/receptionist/createPrescription'); ?>",
            data: $(this).serialize() + '&id=' + _id,
            type: "post",
            dataType: "json",
            success: function(data) {
                // After submit
                if (fnIsDataSuccess(data)) {
                    fnUpdateCustomerData(data);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                       '<?php echo DomainConst::CONTENT00379; ?>',
                       createPrescriptionDialog);
                }
            },
            cache: false
        });
        return false;
    }
    
    /**
     * Open update treatment dialog
     * @param {String} _id Id of treatment schedule need update
     * @returns {Boolean}
     */
    function fnOpenUpdateTreatment(_id = '') {
        updateTreatment(_id);
        $("#dialogId").dialog(opt).dialog("open");
    }
    
    /**
     * Update treatment
     * @param {String} _id Id of treatment schedule need update
     * @returns {Boolean}
     */
    function updateTreatment(_id = '') {
        fnLoadFormCSS();
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl(
                    'front/receptionist/updateTreatment'); ?>",
            data: $(this).serialize() + '&id=' + _id,
            type: "post",
            dataType: "json",
            success: function(data) {
                // After submit
                if (fnIsDataSuccess(data)) {
                    fnUpdateCustomerData(data);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                       '<?php echo DomainConst::CONTENT00386; ?>',
                       updateTreatment);
                }
            },
            cache: false
        });
        return false;
    }
    
    /**
     * Open create treatment schedule detail dialog
     * @param {String} _id Id of treatment schedule need update
     * @returns {Boolean}
     */
    function fnOpenCreateNewTreatment(_id = '') {
        createNewTreatment(_id);
        $("#dialogId").dialog(opt).dialog("open");
    }
    
    /**
     * Create new treatment schedule detail
     * @param {String} _id Id of treatment schedule need update
     * @returns {Boolean}
     */
    function createNewTreatment(_id = '') {
        fnLoadFormCSS();
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl(
                    'front/receptionist/createNewTreatment'); ?>",
            data: $(this).serialize() + '&id=' + _id,
            type: "post",
            dataType: "json",
            success: function(data) {
                // After submit
                if (fnIsDataSuccess(data)) {
                    fnUpdateCustomerData(data);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                       '<?php echo DomainConst::CONTENT00367; ?>',
                       createNewTreatment);
                }
            },
            cache: false
        });
        return false;
    }
    
    /**
     * Open create receipt dialog
     * @param {String} _id Id of treatment schedule need create receipt
     * @returns {Boolean}
     */
    function fnOpenCreateReceipt(_id = '') {
        createReceipt(_id);
        $("#dialogId").dialog(opt).dialog("open");
    }
    
    /**
     * Update treatment
     * @param {String} _id Id of treatment schedule need update
     * @returns {Boolean}
     */
    function createReceipt(_id = '') {
        fnLoadFormCSS();
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl(
                    'front/receptionist/createReceipt'); ?>",
            data: $(this).serialize() + '&id=' + _id,
            type: "post",
            dataType: "json",
            success: function(data) {
                // After submit
                if (fnIsDataSuccess(data)) {
                    fnUpdateCustomerData(data);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                       '<?php echo DomainConst::CONTENT00256; ?>',
                       createReceipt);
                }
            },
            cache: false
        });
        return false;
    }
</script>
