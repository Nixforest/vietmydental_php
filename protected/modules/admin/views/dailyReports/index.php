<?php
/* @var $this DailyReportsController */
/* @var $dataProvider CActiveDataProvider */

//$this->breadcrumbs=array(
//	'Daily Reports',
//);
//
//$this->menu=array(
//	array('label'=>'Create DailyReports', 'url'=>array('create')),
//	array('label'=>'Manage DailyReports', 'url'=>array('admin')),
//);
$aData  = $model->getDataReport();
$this->createMenu('', $model);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
//$('.search-form form').submit(function(){
//	$('#daily-report-grid').yiiGridView('update', {
//		data: $(this).serialize()
//	});
//	return false;
//});
");
?>

<h1><?php echo $this->pageTitle; ?></h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<h1>Danh sách báo cáo</h1>
<?php
    $approveJs = 'js:function(__event)
    {
        __event.preventDefault(); // disable default action

        var $this = $(this), // link/button
                confirm_message = $this.data("confirm"), // read confirmation message from custom attribute
                url = $this.attr("href"); // read AJAX URL with parameters from HREF attribute on the link

        if(confirm(confirm_message)) // if user confirmed operation, then...
        {
            // perform AJAX request
            $("#dailyreport-grid").yiiGridView("update",
            {
                type	: "POST", // importatnt! we only allow POST in filters()
                dataType    : "json",
                url		: url,
                success	: function(data)
                {
                        $("#dailyreport-grid").yiiGridView("update"); // refresh gridview via AJAX
                },
                error	: function(xhr)
                {
                        console.log("Error:", xhr);
                }
            });
        }
    }';
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'dailyreport-grid',
	'dataProvider'=>$model->search(),
        'afterAjaxUpdate'=>'function(id, data){ fnUpdateColorbox();}',
	'filter'=>$model,
	'columns'=>array(
                array(
                    'header' => DomainConst::CONTENT00034,
                    'type' => 'raw',
                    'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                    'headerHtmlOptions' => array('width' => '30px','style' => 'text-align:center;'),
                    'htmlOptions' => array(
                        'style' => 'text-align:center;'
                    )
                ),
                array(
                    'header'    => 'Người duyệt',
                    'type'      => 'raw',
                    'value'     => '$data->getApprove().$data->canHighLight()',
                ),
                array(
                    'header'    => DomainConst::CONTENT00353,
                    'type'      => 'raw',
                    'value'     => '$data->getReceiptTotal()',
                    'htmlOptions' => array('style' => 'text-align:right;')
                ),
                array(
                    'header'    => 'Tổng tiền xác thực',
                    'type'      => 'raw',
                    'value'     => '$data->getReceiptTotalConfirm()',
                    'htmlOptions' => array('style' => 'text-align:right;')
                ),
                array(
                    'header'    => 'Ngày báo cáo',
                    'type'      => 'raw',
                    'value'     => '$data->getDateReport()',
                ),
                array(
                    'header'    => DomainConst::CONTENT00199,
                    'type'      => 'raw',
                    'value'     => '$data->getAgent()',
                ),
                array(
                    'header'    => DomainConst::CONTENT00026,
                    'type'      => 'raw',
                    'value'     => '$data->getStatus()',
                ),
           
                array(
                    'header' => 'Actions',
                    'class'=>'CButtonColumn',
                    'htmlOptions' => array('style' => 'width:120px;text-align:center;'),
                    'template'=> $this->createActionButtons(array('process','confirm','cancel')),
                    'buttons'=>array(
                        'process'=>array(
                            'click'   => $approveJs,
                            'label'=>'Gửi yêu cầu',
                            'imageUrl'=>Yii::app()->theme->baseUrl . '/img/send.png',
                            'options'=>array(
                                'class'=>'process',
                                'data-confirm' => 'Bạn chắc chắn yêu cầu duyệt?'
                                ),
                            'url'=>'Yii::app()->createAbsoluteUrl("admin/dailyReports/process",
                                array("id"=>$data->id) )',
                            'visible' => '$data->canProcess()',
                        ),
                        'confirm'=>array(
                            'click'   => $approveJs,
                            'label'=>'Xác nhận',
                            'imageUrl'=>Yii::app()->theme->baseUrl . '/img/confirm.gif',
                            'options'=>array(
                                'class'=>'confirm',
                                'data-confirm' => 'Bạn chắc chắn xác nhận?'
                            ),
                            'url'=>'Yii::app()->createAbsoluteUrl("admin/dailyReports/confirm",
                                array("id"=>$data->id) )',
                            'visible' => '$data->canConfirm()',
                        ),
                        'cancel'=>array(
                            'click'   => $approveJs,
                            'label'=>'Không duyệt',
                            'imageUrl'=>Yii::app()->theme->baseUrl . '/img/cancel.png',
                            'options'=>array(
                                'class'=>'cancel',
                                'data-confirm' => 'Bạn chắc chắn không duyệt?'
                            ),
                            'url'=>'Yii::app()->createAbsoluteUrl("admin/dailyReports/cancel",
                                array("id"=>$data->id) )',
                            'visible' => '$data->canCancel()',
                        ),
                    ),
                ),
    ),
)); ?>
<?php if($model->canCreateNew()): ?>

<h1>Danh sách chưa tạo</h1>
<?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'new-form',
            'enableAjaxValidation'=>false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
    )); ?>
    <div id="labo-grid-new" class="grid-view">
        <input style="display: none;" value="<?php echo $model->date_report; ?>" name="DailyReports[date_report]">
        <table class="items">
            <thead>
                <tr>
                    <th style="text-align:center;width:15px;" id="labo-grid_c0"><input type="checkbox" name="" id="DailyReports_all"></th>
                    <th style="text-align:center;" id="labo-grid_c0">Người duyệt</th>
                    <th style="text-align:center;" id="labo-grid_c0"><?php echo DomainConst::CONTENT00353; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($aData['RECEIPT'])): ?>
                    <?php foreach ($aData['RECEIPT'] as $doctor_id => $revenue): ?>
                        <tr>
                            <td style="text-align:center;width:15px;"><input type="checkbox" value="<?php echo $doctor_id; ?>" name="DailyReports[doctors][]"></td>
                            <td style=""><?php echo !empty($aData['DOCTOR'][$doctor_id]) ? $aData['DOCTOR'][$doctor_id] : DomainConst::CONTENT00218; ?></td>
                            <td style="text-align:right;">
                                <input style="display: none;" value="<?php echo $revenue; ?>" name="DailyReports[revenue][<?php echo $doctor_id; ?>]">
                                <?php echo CommonProcess::formatCurrency($revenue) . ' ' . DomainConst::CONTENT00134; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
    <div class="row buttons">
        <?php echo CHtml::submitButton('Submit'); ?>
    </div>
<?php $this->endWidget(); ?>
<script>
//    check all of select
    $("#DailyReports_all").click(function(){
        $('input:checkbox:enabled[name="DailyReports[doctors][]"]').not(this).prop('checked', this.checked);
    });
</script>
<?php endif; ?>
<script>
    function fnUpdateColorbox(){
        $('.highlight').closest('tr').css({"color":"red"});
    }
    $(document).ready(function(){
        fnUpdateColorbox();
    });
</script>
