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
                
            </div>
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