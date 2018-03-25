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
                                <th><?php echo DomainConst::CONTENT00254; ?></th>
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
                </div>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'id'=>'receipts-grid',
                        'dataProvider'=>$models->search(),
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
                                array(
                                    'name' => DomainConst::CONTENT00100,
                                    'value' => '($data->getCustomer() !== NULL) ? $data->getCustomer()->name : ""',
                                ),
                                array(
                                    'name' => DomainConst::CONTENT00170,
                                    'value' => '($data->getCustomer() !== NULL) ? $data->getCustomer()->phone : ""',
                                ),
                                array(
                                    'name' => DomainConst::CONTENT00255,
                                    'value' => '($data->getTreatmentType() !== NULL) ? $data->getTreatmentType()->name : ""',
                                ),
                                array(
                                    'name' => DomainConst::CONTENT00254,
                                    'value' => '($data->getTreatmentType() !== NULL) ? CommonProcess::formatCurrency($data->getTreatmentType()->price - $data->discount) : ""',
                                ),
//                                'process_date',
//                                'discount',
//                                'need_approve',
//                                'customer_confirm',
//                                'receiptionist_id',
//                                'status',
//                                array(
//                                        'class'=>'CButtonColumn',
//                                ),
                                array(
                                    'header' => 'Actions',
                                    'class'=>'CButtonColumn',
                                    'template'=> $this->createActionButtons(['update']),
                                    'buttons'=>array(
                                        'update'=>array(
                                            'visible'=> '$data->canUpdate()',
                                        ),
                                    ),
                                ),
                        ),
                )); ?>
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
                "<?php echo Yii::app()->createAbsoluteUrl('admin/ajax/getReceiptInfo'); ?>",
                "#right-content",
                "#right_page_title",
                "<?php echo DomainConst::CONTENT00256 ?>",
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