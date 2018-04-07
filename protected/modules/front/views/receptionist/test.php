<?php
/* @var $this ReceptionistController */

?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'medical-records-form',
	'enableAjaxValidation'=>false,
)); ?>
    
<div class="maincontent clearfix">
    <?php
//     for ($index = 0; $index < 10000; $index++) {
//         Loggers::insertOne("Test message $index", "Test description $index", Loggers::LOG_LEVEL_INFO, get_class());
//     }
//     Loggers::insertOne("Test message", "Test description", Loggers::LOG_LEVEL_INFO, get_class());
//    Loggers::checkLog();
     SMSHandler::sendSMS('smsbrand_gas24h', '147a@258', 'HUONGMINH', 0,
             '84976994876', 'Gas24h', 'bulksms',
             'DH ADMIN TEST. Gia BB: 20,657 - Gia B12: 291,000 INDUSTRIAL001-Cong ty TNHH ',
             0);
    CommonProcess::echoTest("CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4): ", CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4));
    CommonProcess::echoTest("CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_6): ", CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_6));
    // Test username
    $fullName = "Phạm Trung Nguyên";
    $fullName1 = "Ngô Quang Phục";
    // Test generate username
    CommonProcess::echoTest("Username of '$fullName': ", Users::generateUsername($fullName));
    CommonProcess::echoTest("Username of '$fullName1': ", Users::generateUsername($fullName1));
    CommonProcess::echoTest("Username converted from '$fullName': ", CommonProcess::getUsernameFromFullName($fullName));
    CommonProcess::echoTest("Username converted from '$fullName1': ", CommonProcess::getUsernameFromFullName($fullName1));
    // Test compare date
    $date1 = "2018/03/23";
    $date2 = "2018-03-23 23:09:27";
    $date2 = CommonProcess::convertDateTime($date2, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_4);
    CommonProcess::echoTest("Compare date '$date1' - '$date2': ", DateTimeExt::compare($date1, $date2, ''));
    CommonProcess::echoTest("strtotime($date1): ", strtotime($date1));
    CommonProcess::echoTest("strtotime($date2): ", strtotime($date2));
    // Test DirectoryHandler
    CommonProcess::echoTest('Yii::app()->createAbsoluteUrl(DIRECTORY_SEPARATOR): ', Yii::app()->createAbsoluteUrl(DIRECTORY_SEPARATOR));
    CommonProcess::echoTest('Yii::app()->baseUrl: ', Yii::app()->baseUrl);
//    CommonProcess::echoTest('Create path from array: ', DirectoryHandler::createPath(array(
//        DirectoryHandler::getRootPath(),
//        'a',
//        'b',
//        'c'
//    )));
    CommonProcess::echoTest('Yii root path: ', DirectoryHandler::getRootPath());
    CommonProcess::echoTest('Current date time: ', CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3));
    ?>
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
                                  // Here is the trick: on submit-> once again this function!
                            $('#dialogUpdateSchedule div.divForFormUpdateSchedule form').submit(updateSchedule);
                        }
                        else
                        {
                            $('#dialogUpdateSchedule div.divForFormUpdateSchedule').html(data.div);
                            setTimeout(\"$('#dialogUpdateSchedule').dialog('close') \",1000);
                        }

                    } ",
        ))
        ?>;
        return false;
    }
</script>
