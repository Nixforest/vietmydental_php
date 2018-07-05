<?php
/* @var $this ReceptionistController */

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
                    <span class="icon-s" style="top:20px;"></span>
                    <i class="clr-txt-btn search-area glyphicon glyphicon-remove"></i>
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
                        <i class="left-input-icon glyphicon glyphicon-search"></i>
                        <input type="text" class="form-control text-change" placeholder="<?php echo DomainConst::CONTENT00170?>"
                           id="customer_find_phone">
                        <i class="clr-txt-btn as-area glyphicon glyphicon-remove"></i>
                    </div>
                    
                    <div class="form-ctn">
                        <i class="left-input-icon glyphicon glyphicon-home"></i>
                        <input type="text" class="form-control text-change" placeholder="<?php echo DomainConst::CONTENT00045?>"
                           id="customer_find_address">
                        <i class="clr-txt-btn as-area glyphicon glyphicon-remove"></i>
                    </div>
                    
                    <div class="form-ctn">
                        <i class="left-input-icon glyphicon glyphicon-map-marker"></i>
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
                            . ' $("#dialogCreateCustomer").dialog("open");'
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

<!-- Create customer dialog -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'    => 'dialogCreateCustomer',
        'options' => array(
            'title' => DomainConst::CONTENT00176,
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

<!-- Create/Update treatment schedule dialog -->
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'    => 'dialogUpdateSchedule',
        'options' => array(
            'title' => DomainConst::CONTENT00182,
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
<div class="divForFormUpdateSchedule"></div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog');?>

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
        fnShowCustomerInfo(
                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/getCustomerInfo'); ?>",
                "#right-content",
                "#right_page_title",
                "<?php echo DomainConst::CONTENT00172 ?>",
                '');
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
</script>
<script type="text/javascript">
    /**
     * Create customer dialog
     * @returns {Boolean}
     */
    function createCustomer() {
        $("<link/>", {
            id: "form_ccs",
            rel: "stylesheet",
            type: "text/css",
            href: "<?php echo Yii::app()->theme->baseUrl . '/css/form.css'; ?>"
         }).appendTo("head");
        <?php
        echo CHtml::ajax(array(
            'url' => Yii::app()->createAbsoluteUrl('front/receptionist/createCustomer'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
                    {
                        if (data.status == 'failure')
                        {
                            $('#dialogCreateCustomer div.divForForm').html(data.div);
                            $('.ui-dialog-title').html('" . DomainConst::CONTENT00176 . "');
                                  // Here is the trick: on submit-> once again this function!
                            $('#dialogCreateCustomer div.divForForm form').submit(createCustomer);
                        }
                        else
                        {
                            $('#dialogCreateCustomer div.divForForm').html(data.div);
                            $('#right_page_title').html('Thông tin bệnh nhân');
                            $('#right-content').html(data.rightContent);
                            $('.left-page .info-content .info-result .content').html(data.infoSchedule);
                            setTimeout(\"$('#dialogCreateCustomer').dialog('close') \",1000);
                        }

                    } ",
        ))
        ?>;
        return false;
    }
    
    /**
     * Create schedule
     * @returns {Boolean}
     */
    function createSchedule() {
        $("<link/>", {
            id: "form_ccs",
            rel: "stylesheet",
            type: "text/css",
            href: "<?php echo Yii::app()->theme->baseUrl . '/css/form.css'; ?>"
         }).appendTo("head");
         <?php
        echo CHtml::ajax(array(
            'url' => Yii::app()->createAbsoluteUrl('front/receptionist/createSchedule'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
                    {
                        if (data.status == 'failure')
                        {
                            $('#dialogUpdateSchedule div.divForFormUpdateSchedule').html(data.div);
                            $('.ui-dialog-title').html('" . DomainConst::CONTENT00182 . "');
                                  // Here is the trick: on submit-> once again this function!
                            $('#dialogUpdateSchedule div.divForFormUpdateSchedule form').submit(createSchedule);
                        }
                        else
                        {
                            $('#dialogUpdateSchedule div.divForFormUpdateSchedule').html(data.div);
                            $('#right_page_title').html('Thông tin bệnh nhân');
                            $('#right-content').html(data.rightContent);
                            $('.left-page .info-content .info-result .content').html(data.infoSchedule);
                            setTimeout(\"$('#dialogUpdateSchedule').dialog('close') \",1000);
                        }
                    } ",
        ))
        ?>;
        return false;
    }
    
    /**
     * Update treatment schedule
     * @returns {Boolean}
     */
    function updateSchedule() {
        $("<link/>", {
            id: "form_ccs",
            rel: "stylesheet",
            type: "text/css",
            href: "<?php echo Yii::app()->theme->baseUrl . '/css/form.css'; ?>"
         }).appendTo("head");
        <?php
        echo CHtml::ajax(array(
            'url' => Yii::app()->createAbsoluteUrl('front/receptionist/updateSchedule'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
                    {
                        if (data.status == 'failure')
                        {
                            $('#dialogUpdateSchedule div.divForFormUpdateSchedule').html(data.div);
                            $('.ui-dialog-title').html('" . DomainConst::CONTENT00182 . "');
                                  // Here is the trick: on submit-> once again this function!
                            $('#dialogUpdateSchedule div.divForFormUpdateSchedule form').submit(updateSchedule);
                        }
                        else
                        {
                            $('#dialogUpdateSchedule div.divForFormUpdateSchedule').html(data.div);
                            $('#right_page_title').html('Thông tin bệnh nhân');
                            $('#right-content').html(data.rightContent);
                            $('.left-page .info-content .info-result .content').html(data.infoSchedule);
                            setTimeout(\"$('#dialogUpdateSchedule').dialog('close') \",1000);
                        }

                    } ",
        ))
        ?>;
        return false;
    }
    
    /**
     * Create print dialog
     * @returns {Boolean}
     */
    function createPrintDialog() {
        $("<link/>", {
            id: "form_ccs",
            rel: "stylesheet",
            type: "text/css",
            href: "<?php echo Yii::app()->theme->baseUrl . '/css/form.css'; ?>"
         }).appendTo("head");
        <?php
        echo CHtml::ajax(array(
            'url' => Yii::app()->createAbsoluteUrl('front/receptionist/printMore'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
                    {
                        if (data.status == 'failure')
                        {
                            $('#dialogPrintReceipt div.divForForm').html(data.div);
                            $('.ui-dialog-title').html('" . DomainConst::CONTENT00374 . "');
                                  // Here is the trick: on submit-> once again this function!
                            $('#dialogPrintReceipt div.divForForm form').submit(createPrintDialog);
                        }
                        else
                        {
                            $('#dialog div.divForForm').html(data.div);
                            setTimeout(\"$('#dialogPrintReceipt').dialog('close') \",1000);
                        }

                    } ",
        ))
        ?>;
        return false;
    }
    
    /**
     * Create print dialog
     * @returns {Boolean}
     */
    function createPrescriptionDialog() {
        $("<link/>", {
            id: "form_ccs",
            rel: "stylesheet",
            type: "text/css",
            href: "<?php echo Yii::app()->theme->baseUrl . '/css/form.css'; ?>"
         }).appendTo("head");
        <?php
        echo CHtml::ajax(array(
            'url' => Yii::app()->createAbsoluteUrl('front/receptionist/createPrescription'),
            'data' => "js:$(this).serialize()",
            'type' => 'post',
            'dataType' => 'json',
            'success' => "function(data)
                    {
                        if (data.status == 'failure')
                        {
                            $('#dialogPrintReceipt div.divForForm').html(data.div);
                            $('.ui-dialog-title').html('" . DomainConst::CONTENT00379 . "');
                                  // Here is the trick: on submit-> once again this function!
                            $('#dialogPrintReceipt div.divForForm form').submit(createPrescriptionDialog);
                        }
                        else
                        {
                            $('#dialogPrintReceipt div.divForForm').html(data.div);
                            setTimeout(\"$('#dialogPrintReceipt').dialog('close') \",1000);
                        }

                    } ",
        ))
        ?>;
        return false;
    }
    
    
    /*
     * Customer clear text button at search box and advance search
     * DuongNV
     */
    $(document).on('click', '.clr-txt-btn', function(){
        $(this).siblings('input').val("");
    })
    $(document).on('click', '#adv-search-btn', function(){
        var isHidden = $('#adv-search-btn').hasClass('collapsed');
        if(isHidden){
            $('#customer_find_phone').val('');
            $('#customer_find_address').val('');
            $('#customer_find_agent option').eq(0).attr('selected','selectd');
        }
    })
</script>
