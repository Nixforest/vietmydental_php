<?php
/* @var $this ReportsController */

$this->createMenu('revenue', null);
$dateFrom = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
$dateTo = $dateFrom;
if (!empty($from)) {
    $dateFrom = CommonProcess::convertDateTime($from, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END);
}
if (!empty($to)) {
    $dateTo = CommonProcess::convertDateTime($to, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END);
}
?>
<!--//++ BUG0046-IMT (DuongNV 20180803) Update UI reports-->
<h1><?php // echo 'Báo cáo bệnh nhân' . ' ngày: ' . $dateFrom . ' đến ' . $dateTo; ?></h1>
<h2><?php echo 'Báo cáo bệnh nhân' . ' ngày: ' . $dateFrom . ' đến ' . $dateTo; ?></h2>
<!--//-- BUG0046-IMT (DuongNV 20180803) Update UI reports-->

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'grid-old',
	'enableAjaxValidation'=>false,
)); ?>
    <div class="row">
        <div class="col-md-6">
            <label for="from_date" class="required">Từ </label>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'from_date',
                'options'   => array(
                    'showAnim'      => 'fold',
                    'dateFormat'    => DomainConst::DATE_FORMAT_2,
                    'maxDate'       => '0',
                    'changeMonth'   => true,
                    'changeYear'    => true,
                    'showOn'        => 'button',
                    'buttonImage'   => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                    'buttonImageOnly' => true,
                ),
                'htmlOptions'=>array(
                            'class'=>'w-16',
                            'readonly'=>'readonly',
                        ),
                'value' => $dateFrom,
            ));
            ?>
        </div>
        <div class="col-md-6">
            <label for="to_date" class="required">Đến </label>
            <?php
            $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                'name' => 'to_date',
                'options'   => array(
                    'showAnim'      => 'fold',
                    'dateFormat'    => DomainConst::DATE_FORMAT_2,
//                    'maxDate'       => '0',
                    'changeMonth'   => true,
                    'changeYear'    => true,
                    'showOn'        => 'button',
                    'buttonImage'   => Yii::app()->theme->baseUrl . '/img/icon_calendar_r.gif',
                    'buttonImageOnly' => true,
                ),
                'htmlOptions'=>array(
                            'class'=>'w-16',
                            'readonly'=>'readonly',
                        ),
                'value' => $dateTo,
            ));
            ?>
        </div>
    </div>

	<div class="row buttons">
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00349, array(
                    'name' => DomainConst::KEY_SUBMIT,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px 10px 10px 154px; background: teal',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00359, array(
                    'name' => DomainConst::KEY_SUBMIT_DATE_BEFORE_YESTERDAY,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px; background: #65a5cc',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00357, array(
                    'name' => DomainConst::KEY_SUBMIT_DATE_YESTERDAY,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px; background: #65a5cc',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00358, array(
                    'name' => DomainConst::KEY_SUBMIT_TODATE,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px; background: #65a5cc',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00350, array(
                    'name' => DomainConst::KEY_SUBMIT_MONTH,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px; background: #65a5cc',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00351, array(
                    'name' => DomainConst::KEY_SUBMIT_LAST_MONTH,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px; background: #65a5cc',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00397, array(
                    'name' => DomainConst::KEY_SUBMIT_EXCEL,
                    //++ BUG0046-IMT (DuongNV 20180803) Update UI reports
                    'style' => 'margin: 10px; background: #65a5cc',
                    //-- BUG0046-IMT (DuongNV 20180803) Update UI reports
                ));
                ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<!--khách hàng mới-->
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'grid-new',
    'dataProvider' => $model->getCustomers($from, $to)['NEW'],
//    'filter'    => $model,
    'columns' => array(
        array(
            'header' => DomainConst::CONTENT00034,
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => DomainConst::CONTENT00100,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getFieldName(\'name\')',
        ),
        array(
            'header' => DomainConst::CONTENT00395,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getAge()',
        ),
        array(
            'header' => DomainConst::CONTENT00101,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getBirthday()',
        ),
        array(
            'header' => DomainConst::CONTENT00045,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getAddress()',
        ),
        array(
            'header' => DomainConst::CONTENT00099,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getCareer()',
        ),
        array(
            'header' => DomainConst::CONTENT00300,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getDebt()',
        ),
        array(
            'header' => DomainConst::CONTENT00175,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getEmail()',
        ),
        array(
            'header' => DomainConst::CONTENT00307,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getPhone()',
        ),
        array(
            'header' => DomainConst::CONTENT00396,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getScheduleTime()',
        ),
          array(
            'name' => 'doctor_id',
            'header' => DomainConst::CONTENT00143,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getScheduleDoctor()',
        ),
        array(
            'name' => 'created_by',
            'header' => DomainConst::CONTENT00054,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getCreatedBy()',
        ),
        
        
    ),
));
?>
<!--//++ BUG0046-IMT (DuongNV 20180803) Update UI reports-->
<!--<h1><?php  echo DomainConst::CONTENT00394; ?></h1>-->
<h3><?php echo DomainConst::CONTENT00394; ?></h3>
<!--//-- BUG0046-IMT (DuongNV 20180803) Update UI reports-->
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'receipts-grid',
    'dataProvider' => $model->getCustomers($from, $to)['OLD'],
    'filter'    => $model,
    'columns' => array(
        array(
            'header' => DomainConst::CONTENT00034,
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'header' => DomainConst::CONTENT00100,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getFieldName(\'name\')',
        ),
        array(
            'header' => DomainConst::CONTENT00395,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getAge()',
        ),
        array(
            'header' => DomainConst::CONTENT00101,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getBirthday()',
        ),
        array(
            'header' => DomainConst::CONTENT00045,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getAddress()',
        ),
        array(
            'header' => DomainConst::CONTENT00099,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getCareer()',
        ),
        array(
            'header' => DomainConst::CONTENT00300,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getDebt()',
        ),
        array(
            'header' => DomainConst::CONTENT00175,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getEmail()',
        ),
        array(
            'header' => DomainConst::CONTENT00307,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getPhone()',
        ),
        array(
            'header' => DomainConst::CONTENT00396,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getScheduleTime()',
        ),
        array(
            'name' => 'doctor_id',
            'header' => DomainConst::CONTENT00143,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getScheduleDoctor()',
        ),
        array(
            'name' => 'created_by',
            'header' => DomainConst::CONTENT00054,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getCreatedBy()',
        ),
        
    ),
));
?>
<!--//++ BUG0046-IMT (DuongNV 20180803) Update UI reports-->
<!--<h1><?php echo DomainConst::CONTENT00254; ?></h1>-->
<h3><?php echo DomainConst::CONTENT00254; ?></h3>
<!--//-- BUG0046-IMT (DuongNV 20180803) Update UI reports-->
<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>
                    <?php echo DomainConst::CONTENT00254; ?>
                </th>
                <th>
                    <?php echo DomainConst::CONTENT00394; ?>
                </th>
                <th>
                    <?php echo DomainConst::CONTENT00398; ?>
                </th>
                
            </tr>
        </thead>
        <tbody>
            <tr class="even">
                <?php
                $oldSum = !empty($old)  ? $old->getTotalItemCount() : 0;
                $newSum = !empty($new)  ? $new->getTotalItemCount() : 0;
                ?>
                <td style="text-align:center; font-weight:bold"><?php echo $oldSum+$newSum; ?></td>
                <td style="text-align:right; font-weight:bold"><?php echo $oldSum; ?></td>
                <td style="text-align:right; font-weight:bold"><?php echo $newSum; ?></td>
            </tr>
        </tbody>
    </table>
</div>
