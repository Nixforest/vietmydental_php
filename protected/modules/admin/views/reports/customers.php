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
<h1><?php echo $this->pageTitle . ' ngày: ' . $dateFrom . ' đến ' . $dateTo; ?></h1>

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
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00359, array(
                    'name' => DomainConst::KEY_SUBMIT_DATE_BEFORE_YESTERDAY,
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00357, array(
                    'name' => DomainConst::KEY_SUBMIT_DATE_YESTERDAY,
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00358, array(
                    'name' => DomainConst::KEY_SUBMIT_TODATE,
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00350, array(
                    'name' => DomainConst::KEY_SUBMIT_MONTH,
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00351, array(
                    'name' => DomainConst::KEY_SUBMIT_LAST_MONTH,
                ));
                ?>
		<?php
                echo CHtml::submitButton(DomainConst::CONTENT00389, array(
                    'name' => DomainConst::KEY_SUBMIT_EXCEL,
                ));
                ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<!--khách hàng mới-->
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'grid-new',
    'dataProvider' => $new,
//    'filter'    => $model->rProducts,
    'columns' => array(
        array(
            'header' => DomainConst::CONTENT00034,
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'name' => DomainConst::CONTENT00049,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getFieldName(\'name\')',
        ),
        array(
            'name' => DomainConst::CONTENT00387,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getAge()',
        ),
        array(
            'name' => DomainConst::CONTENT00101,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getBirthday()',
        ),
        array(
            'name' => DomainConst::CONTENT00045,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getAddress()',
        ),
        array(
            'name' => DomainConst::CONTENT00099,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getCareer()',
        ),
        array(
            'name' => DomainConst::CONTENT00300,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getDebt()',
        ),
        array(
            'name' => DomainConst::CONTENT00175,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getEmail()',
        ),
        array(
            'name' => DomainConst::CONTENT00307,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getPhone()',
        ),
        array(
            'name' => DomainConst::CONTENT00143,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getScheduleDoctor()',
        ),
        array(
            'name' => DomainConst::CONTENT00388,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getScheduleTime()',
        ),
        
        
    ),
));
?>
<h1><?php echo DomainConst::CONTENT00386; ?></h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'receipts-grid',
    'dataProvider' => $old,
//    'filter'    => $model->rProducts,
    'columns' => array(
        array(
            'header' => DomainConst::CONTENT00034,
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'headerHtmlOptions' => array('width' => '30px', 'style' => 'text-align:center;'),
            'htmlOptions' => array('style' => 'text-align:center;')
        ),
        array(
            'name' => DomainConst::CONTENT00049,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getFieldName(\'name\')',
        ),
        array(
            'name' => DomainConst::CONTENT00387,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getAge()',
        ),
        array(
            'name' => DomainConst::CONTENT00101,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getBirthday()',
        ),
        array(
            'name' => DomainConst::CONTENT00045,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getAddress()',
        ),
        array(
            'name' => DomainConst::CONTENT00099,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getCareer()',
        ),
        array(
            'name' => DomainConst::CONTENT00300,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getDebt()',
        ),
        array(
            'name' => DomainConst::CONTENT00175,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getEmail()',
        ),
        array(
            'name' => DomainConst::CONTENT00307,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getPhone()',
        ),
        array(
            'name' => DomainConst::CONTENT00143,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getScheduleDoctor()',
        ),
        array(
            'name' => DomainConst::CONTENT00388,
//            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => '$data->getScheduleTime()',
        ),
        
        
    ),
));
?>
