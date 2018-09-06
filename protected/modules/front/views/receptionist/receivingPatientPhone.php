<?php
/* @var $this ReceptionistController */

?>
<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl . '/js/jquery.colorbox-min.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->theme->baseUrl . '/css/colorbox.css');
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'medical-records-form',
	'enableAjaxValidation'=>false,
)); ?>
    
<div class="maincontent clearfix">
    <div class="left-page">
        <div class="title-1">
            <?php echo DomainConst::CONTENT00363; ?>
        </div>
        <div class="info-content">
            <div class="box-search">
                <form>
                    <span class="icon-s" style="top:0;"></span>
                    <i class="clr-txt-btn search-area glyphicon glyphicon-remove" style="position: absolute; right: 5px; top: 10px;color:red;"></i>
                    <input type="text" class="form-control text-change"  placeholder="<?php echo DomainConst::CONTENT00384?>"
                           id="customer_find">
                </form>
            </div>
            
            <div class="title-2" id="adv-search-btn" data-toggle="collapse" data-target="#advance-search-ctn">
                <?php echo DomainConst::CONTENT00073; ?>
                <i class="glyphicon glyphicon-chevron-down"></i>
            </div>
            <div class="box-search collapse" id="advance-search-ctn" style="text-align: center;">
                <form style="width: 350px; margin: auto; height: 185px;">
                    <div class="form-ctn">
                        <i class="left-input-icon glyphicon glyphicon-search" style="position: relative; right: 150px; top: 30px;"></i>
                        <i class="clr-txt-btn as-area glyphicon glyphicon-remove" style="position: relative; left: 150px; top: 30px;color:red;"></i>
                        <input type="text" class="form-control text-change" placeholder="<?php echo DomainConst::CONTENT00170?>"
                           id="customer_find_phone">
                    </div>
                    
                    <div class="form-ctn">
                        <i class="left-input-icon glyphicon glyphicon-home" style="position: relative; right: 150px; top: 30px;"></i>
                        <i class="clr-txt-btn as-area glyphicon glyphicon-remove" style="position: relative; left: 150px; top: 30px;color:red;"></i>
                        <input type="text" class="form-control text-change" placeholder="<?php echo DomainConst::CONTENT00045?>"
                           id="customer_find_address">
                    </div>
                    
                    <div class="form-ctn">
                        <i class="left-input-icon glyphicon glyphicon-map-marker" style="right:160px; top: 30px;"></i>
                        <select id="customer_find_agent" class="form-control" name="customer_find[agent]" style="width: 350px!important; color: #277aff;">
                            <?php
                            $html = '<option value="" style="color: black">' . DomainConst::CONTENT00385 . '</option>';
                            foreach (Agents::loadItems() as $key => $agent) {
                                $html .= '<option value="' . $key . '"  style="color: black">' . $agent . '</option>';
                            }
                            echo $html;
                            ?>
                        </select>
                    </div>
                </form>
            </div>
            <div id="customer_info_schedule" class="info-result">
                <div class="group-btn" id="create_customer">
                    <?php
                        echo CHtml::link(
//                                '<img src="' . Yii::app()->theme->baseUrl . DomainConst::IMG_BASE_PATH . DomainConst::IMG_ADD_ICON . '"> '
                                '<i class="glyphicon glyphicon-plus" style="margin-right: 5px;"></i>'
                                . DomainConst::CONTENT00176,
                                '#', array(
                            'style' => 'cursor: pointer;',
                            'onclick' =>''
                            . 'createCustomer();'
                            . ' $("#dialogId").dialog(opt).dialog("open");'
                            . ' return false;',
                        ));
                    ?>
                </div>
                <div class="content"></div>
            </div>
        </div>
    </div>
    <div class="right-page">
        <div class="title-1" id="right_page_title">
        </div>
        <div class="info-content">
            <div id="right-content"></div>
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
//            'position'  => array(
//                'my'    => 'top',
//                'at'    => 'top',
//            ),
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
        fnShowCustomerInfo(
                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/getCustomerInfo'); ?>",
                "#right-content",
                "#right_page_title",
                "<?php echo DomainConst::CONTENT00172 ?>",
                '');
        //++ BUG0067-IMT (DuongNV 20180831) Add 6 month book schedule btn
        fnClickPlusMonth();
        //-- BUG0067-IMT (DuongNV 20180831) Add 6 month book schedule btn
    });
    $("body").on("click", "#customer-info tbody tr", function() {
        fnShowCustomerInfo(
                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/getCustomerInfo'); ?>",
                "#right-content",
                "#right_page_title",
                "<?php echo DomainConst::CONTENT00172 ?>",
                $(this).attr('id'));
    });
    $("#customer_find_agent").change(function() {
        fnSearchCustomerReception(
                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/searchCustomerReception'); ?>",
                "#right-content",
                "#right_page_title",
                "<?php echo DomainConst::CONTENT00171 ?>");
    });
    
    /*
     * Customer clear text button at search box and advance search
     * DuongNV
     */
    $(document).on('click', '.clr-txt-btn', function(){
        $(this).siblings('input').val("");
        $(this).css('opacity','0');
    });
    $(document).on('input', '.clr-txt-btn + input', function(){
        if($(this).val() === ''){
            $(this).siblings('i.clr-txt-btn').css('opacity','0');
        } else {
            $(this).siblings('i.clr-txt-btn').css('opacity','1');
        }
    });
    $(document).on('click', '#adv-search-btn', function(){
        var isHidden = $('#adv-search-btn').hasClass('collapsed');
        if(isHidden){
            $('#customer_find_phone').val('');
            $('#customer_find_address').val('');
            $('#customer_find_agent option').eq(0).attr('selected','selectd');
        }
    });
    
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
//        setTimeout("$('#dialogId').parent().dialog(opt).dialog('close'); $('.ui-widget-overlay').remove();", 1000);
        setTimeout("$('.ui-icon.ui-icon-closethick').click()", 1000);
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
    
    //++ BUG0017-IMT (NguyenPT 20170717) Handle update treatment detail status
    /**
     * Update treatment detail status
     * @param {String} _id      Id of treatment schedule detail need update
     * @param {String} _status  Status value
     *                          Cancel      -> 0 - TreatmentScheduleDetails::STATUS_INACTIVE
     *                          Complete    -> 2 - TreatmentScheduleDetails::STATUS_COMPLETED
     *                          New         -> 3 - TreatmentScheduleDetails::STATUS_SCHEDULE
     */
    function fnUpdateTreatmentDetailStatus(_id, _status) {
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl(
                    'front/receptionist/updateTreatmentStatus'); ?>",
            data: {ajax: 1, id: _id, status: _status},
            type: "get",
            dataType: "json",
            success: function (data) {
                if (fnIsDataSuccess(data)) {
                    fnUpdateData(data);
                } else {    // Load first time
                    alert(data["<?php echo DomainConst::KEY_CONTENT; ?>"]);
                }
            }
        });
    }
    
    /**
     * Update customer data after change status
     * @param {Array} data Json data
     */
    function fnUpdateData(data) {
        $('#right-content').html(data['<?php echo DomainConst::KEY_RIGHT_CONTENT; ?>']);
        $('.left-page .info-content .info-result .content').html(data['<?php echo DomainConst::KEY_INFO_SCHEDULE; ?>']);
    }
    //-- BUG0017-IMT (NguyenPT 20170717) Handle update treatment detail status
    
    
    
    /**
     * Open labo request
     * @param {String} _id Id of treatment schedule detail need to create labo request
     * @returns {Boolean}
     */
    function fnOpenLaboRequest(_id = '') {
        createLaboRequestDialog(_id);
        $("#dialogId").dialog(opt).dialog("open");
    }
    
    /**
     * Create labo request dialog
     * @param {String} _id Id of treatment schedule detail need to create labo request
     * @returns {Boolean}
     */
    function createLaboRequestDialog(_id = '') {
        fnLoadFormCSS();
        $.ajax({
            url: "<?php echo Yii::app()->createAbsoluteUrl(
                    'front/receptionist/createLaboRequest'); ?>",
            data: $(this).serialize() + '&id=' + _id,
            type: "post",
            dataType: "json",
            success: function(data) {
                // After submit
                if (fnIsDataSuccess(data)) {
                    fnUpdateCustomerData(data);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                       '<?php echo DomainConst::CONTENT00425; ?>',
                       createLaboRequestDialog);
                }
            },
            cache: false
        });
        return false;
    }
    
    //++ BUG0017-IMT (DuongNV 20180717) Add event to status btn
    $(function(){
        $(document).on('click', '.ts-stt-btn', function(){
            var stt = $(this).data('type'); //0 - new, 1 - complete, 2 - cancel
            switch(stt) {
                case 0:     // New
                    stt = <?php echo TreatmentScheduleDetails::STATUS_SCHEDULE; ?>;
                    break;
                case 1:     // Complete
                    stt = <?php echo TreatmentScheduleDetails::STATUS_COMPLETED; ?>;
                    break;
                case 2:     // Cancel
                    stt = <?php echo TreatmentScheduleDetails::STATUS_INACTIVE; ?>;
                    break;
                default:break;
            }
            var id = $(this).data('id');
            fnUpdateTreatmentDetailStatus(id, stt);
        });
        
        //++ BUG0076-IMT (DuongNV 20180823) Create treatment schedule process
        /**
         * Open create treatment schedule process dialog
         * @param {String} id Id of process
         */
        function fnOpenCreateTreatmentScheduleProcess(id) {
           isCreate = 1;
           createUpdateTreatmentScheduleProcessDialog(id);
           $("#dialogId").dialog(opt).dialog("open");
       }

       /**
        * Create treatment schedule process dialog
        * @returns {Boolean}
        */
//       function createTreatmentScheduleProcess(_id = '') {
//           fnLoadFormCSS();
//           $.ajax({
//                url: "<?php // echo Yii::app()->createAbsoluteUrl(
//                        'front/receptionist/CreateProcess'); ?>//",
//                data: $(this).serialize() + '&id=' + _id,
//                type: "post",
//                dataType: "json",
//                success: function(data) {
//                    // After submit
//                   if (fnIsDataSuccess(data)) {
//                       fnUpdateCustomerData(data);
//                   } else {    // Load first time
//                       fnLoadDialogContent(data,
//                           '<?php // echo DomainConst::CONTENT00233; ?>',
//                           createTreatmentScheduleProcess);
//                   }
//                },
//                cache: false
//            });
//           return false;
//       }
        
        //++ BUG0054-IMT (DuongNV 20180806) Update UI treatment history
        $(document).on('click', '.createProcess', function(){
//            alert('Chức năng đang hoàn thiện, vui lòng thử lại sau');
            var id = $(this).data('id');
            fnOpenCreateTreatmentScheduleProcess(id);
        });
        //-- BUG0076-IMT (DuongNV 20180823) Create treatment schedule process
        //++ BUG0056-IMT (DuongNV 20180811) Update image data treatment
//        $(document).on('click', '.imageCamera', function(){
////            alert('Chức năng đang hoàn thiện, vui lòng thử lại sau');
//            var id = $(this).data('id');
//            $(location).attr('href', '<?php // echo Yii::app()->createAbsoluteUrl(
//                    'admin/treatmentScheduleDetails/updateImageReal',
//                    array('id' => '')) ?>///' + id);
//        });
//        $(document).on('click', '.imageXQuang', function(){
////            alert('Chức năng đang hoàn thiện, vui lòng thử lại sau');
//            var id = $(this).data('id');
//            $(location).attr('href', '<?php // echo Yii::app()->createAbsoluteUrl(
//                    'admin/treatmentScheduleDetails/updateImageXRay',
//                    array('id' => '')) ?>///' + id);
//        });
        
//         $(document).on('click', '.requestRecoveryImage', function(){
//             var id = $(this).data('id');
//             $(location).attr('href', '<?php // echo Yii::app()->createAbsoluteUrl(
//                     'admin/laboRequests/createAjax',
//                     array('id' => '')) ?>///' + id);
//         });
        //-- BUG0056-IMT (DuongNV 20180811) Update image data treatment
        $(document).on('click', '.vm-btn', function(){
            alert('Chức năng đang hoàn thiện, vui lòng thử lại sau');
        });
        //-- BUG0054-IMT (DuongNV 20180806) Update UI treatment history
    });
    //-- BUG0017-IMT (DuongNV 20180717) Add event to status btn
    
    //++ BUG0056-IMT (DuongNV 20180811) Update image data treatment
    /**
    * call colorbox 
    * @returns {undefined}     
    */
//    function afterShowCustomerInfo(){
//        $(".imageXQuang, .imageCamera").colorbox({
//           iframe:true,
//           innerHeight:'600', 
//           innerWidth: '1000',
//           close: "<span title='close'>close</span>"
//       });
//    }
    //-- BUG0056-IMT (DuongNV 20180811) Update image data treatment
    
    //++ BUG0067-IMT (DuongNV 20180831) Add 6 month book schedule btn
    function fnClickPlusMonth(){
        $(document).on('click', '.plus-6-month', function(){
            console.log(1);
            var input = $(this).siblings('input#TreatmentSchedules_start_date');
            var date = input.val().split('/')[0];
            var month = parseInt(input.val().split('/')[1]);
            var year = parseInt(input.val().split('/')[2]);
            var cDate = new Date(year, month-1, date);
            var nDate = new Date(cDate.setMonth(cDate.getMonth() + 6));
            date = ("0" + nDate.getDate()).slice(-2);
            month = ("0" + (nDate.getMonth() + 1)).slice(-2);
            year = nDate.getFullYear();
            input.val(date+'/'+month+'/'+year);
        });
    }
    //-- BUG0067-IMT (DuongNV 20180831) Add 6 month book schedule btn
    
    //++ BUG0056-IMT (DuongNV 20180831) Update image data treatment
    $(document).on('click', '.imageXQuang, .imageCamera', function(){
        $('form#treatment-schedule-details-form').remove();
        $("#dialogId").dialog(opt).dialog("open");
        var id = $(this).data('id');
        ($(this).data('type') === 'xray') ? updateXRayImage(id) : updateCameraImage(id);
    });
    
    /**
     * Update camera image
     * @param {String} _id Id of treatment schedule detail
     * @returns {Boolean}
     */
    function updateCameraImage(_id = '') {
        var data = new FormData($('form#treatment-schedule-details-form')[0]); // Upload file ajax need this (data store in FormData)
        if(typeof _id !== 'object'){
            data.append('id', _id);
        }
        fnLoadFormCSS();
        var title = 'Cập nhật hình ảnh Camera';
        $.ajax({
            url: '<?php echo Yii::app()->createAbsoluteUrl(
                'front/receptionist/updateImageReal'); ?>',
            data: data,
            type: 'post',
            processData: false, // Upload file ajax need this
            contentType: false, // Upload file ajax need this
            dataType: "json",
            success: function(data) {
                // After submit
                if (fnIsDataSuccess(data)) {
                    $('#dialogId div.divForFormClass').html(data['<?php echo DomainConst::KEY_CONTENT; ?>']);
                    setTimeout("$('.ui-icon.ui-icon-closethick').click()", 1000);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                       title,
                       updateCameraImage);
                }
            },
            error: function (request, status, error) {
                console.log('Error response text: '+request.responseText);
                alert('Error in console!');
            },
            cache: false
        });
        return false;
    }
    
    /**
     * Update xray image
     * @param {type} _id  Id of treatment schedule detail
     * @returns {Boolean}     
     */
    function updateXRayImage(_id = '') {
        var data = new FormData($('form#treatment-schedule-details-form')[0]); // Upload file ajax need this (data store in FormData)
        if(typeof _id !== 'object'){
            data.append('id', _id);
        }
        fnLoadFormCSS();
        var title = 'Cập nhật hình ảnh XQuang';
        $.ajax({
            url: '<?php echo Yii::app()->createAbsoluteUrl(
                'front/receptionist/updateImageXRay'); ?>',
            data: data,
            type: 'post',
            processData: false, // Upload file ajax need this
            contentType: false, // Upload file ajax need this
            dataType: "json",
            success: function(data) {
                // After submit
                if (fnIsDataSuccess(data)) {
                    $('#dialogId div.divForFormClass').html(data['<?php echo DomainConst::KEY_CONTENT; ?>']);
                    setTimeout("$('.ui-icon.ui-icon-closethick').click()", 1000);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                       title,
                       updateXRayImage);
                }
            },
            error: function (request, status, error) {
                console.log('Error response text: '+request.responseText);
                alert('Error in console!');
            },
            cache: false
        });
        return false;
    }
    //-- BUG0056-IMT (DuongNV 20180831) Update image data treatment
    
    //++ BUG0079-IMT (DuongNV 20180109) Update and delete treatment process via ajax
    $(document).on('click', '.update-process-btn' , function(){
        var id = $(this).data('id');
        fnUpdateTreatmentScheduleProcess(id);
    });
    
    /**
    * Open update treatment schedule process dialog
     * @param {String} _id Id of treatment schedule process need to update
    * @returns {Boolean}
    */
    function fnUpdateTreatmentScheduleProcess(_id) {
        //++ BUG0084-IMT (DuongNV 20180905) move process, image to front
        isCreate = 0;
        //-- BUG0084-IMT (DuongNV 20180905) move process, image to front
        createUpdateTreatmentScheduleProcessDialog(_id);
        $("#dialogId").dialog(opt).dialog("open");
    }

    //++ BUG0084-IMT (DuongNV 20180905) move process, image to front
    /**
     * Create update treatment schedule process dialog
     * @param {String} _id Id of treatment schedule process need to update
     * @returns {Boolean}
     */
    function createUpdateTreatmentScheduleProcessDialog(_id = '') {
        if(typeof isCreate === 'undefined'){
            isCreate = 0;
        }
        fnLoadFormCSS();
        $.ajax({
             url: "<?php echo Yii::app()->createAbsoluteUrl(
                     'front/receptionist/createUpdateProcess'); ?>",
             data: $(this).serialize() + '&id=' + _id + '&isCreate=' + isCreate,
             type: "post",
             dataType: "json",
             success: function(data) {
                 // After submit
                if (fnIsDataSuccess(data)) {
                    fnUpdateCustomerData(data);
                } else {    // Load first time
                    fnLoadDialogContent(data,
                        '<?php echo DomainConst::CONTENT00233; ?>',
                        createUpdateTreatmentScheduleProcessDialog);
                }
             },
             cache: false
         });
        return false;
    }
    //-- BUG0084-IMT (DuongNV 20180905) move process, image to front
    
    $(document).on('click', '.delete-process-btn' , function(){
        var cf = confirm('<?php echo DomainConst::CONTENT00431; ?>');
        if (cf) {
            var id = $(this).data('id');
            fnDeleteTreatmentScheduleProcess(id);
        }
    });
    
    /**
     * Delete treatment schedule process
     * @param {String} _id Id of treatment schedule process need to update
     * @returns {Boolean}
     */
    function fnDeleteTreatmentScheduleProcess(_id = '') {
        $.ajax({
             url: "<?php echo Yii::app()->createAbsoluteUrl(
                     'front/receptionist/deleteProcess'); ?>" + "/id/" + _id,
             type: "post",
             dataType: "json",
             success: function(data) {
                 // After submit
                fnUpdateCustomerData(data);
             },
             cache: false
         });
        return false;
    }
    //-- BUG0079-IMT (DuongNV 20180109) Update and delete treatment process via ajax
</script>