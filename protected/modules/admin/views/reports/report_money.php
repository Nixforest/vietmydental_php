<?php
/* @var $this ReportsController */
$this->createMenu('reportMoney', null);
$dateFrom = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
$dateTo = $dateFrom;
if (!empty($from)) {
    $dateFrom = CommonProcess::convertDateTime($from, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END);
}
if (!empty($to)) {
    $dateTo = CommonProcess::convertDateTime($to, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END);
}
?>
<h3><?php echo $this->pageTitle . ' ngày: ' . $dateFrom . ' đến ' . $dateTo; ?></h3>

<!--<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'money-form',
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

</div> form -->
<?php 
 $this->widget('ReportSearchWidget', array('dateFrom' => $dateFrom, 'dateTo' => $dateTo));
 ?>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'grid-new',
    'dataProvider' => new CActiveDataProvider('Careers', array(
        'pagination'=>array(
                        'pageSize'=>10,
        ),
    )),
//    'filter'    => $model,
    'columns' => array(
    ),
    'htmlOptions' => array(
        'style'   => 'display: none;',
    ),
));
?>
<!--Money Import Body-->
<h3><?php echo DomainConst::CONTENT00399; ?></h3>
<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>
                    <?php echo DomainConst::CONTENT00343; ?>
                </th>
                <?php foreach ($aData['DOCTORS'] as $idDoctor => $strFullName) { ?>
                <th>
                    <?php echo $strFullName; ?>
                </th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php $index = 0; ?>
            <?php foreach ($aData['RECEIPT']['DATES'] as $key => $date) { 
                if (empty($aData['RECEIPT']['VALUES'][$date])) {
                    continue;
                }
            ?>
                <tr class="<?php echo (($index++ % 2) == 1) ? 'even' : 'odd'; ?>">
                    <td style="text-align:center;"><?php echo $date; ?></td>
                <?php foreach ($aData['DOCTORS'] as $idDoctor => $strFullName) { ?>
                    <td style="text-align:right;">
                        <?php echo !empty($aData['RECEIPT']['VALUES'][$date][$idDoctor])
                            ? CommonProcess::formatCurrency($aData['RECEIPT']['VALUES'][$date][$idDoctor]) : ''; ?>
                    </td>
                <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<h3><?php echo DomainConst::CONTENT00400; ?></h3>
<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>
                    <?php echo DomainConst::CONTENT00343; ?>
                </th>
                <th>
                    <?php echo DomainConst::CONTENT00062; ?>
                </th>
                <th>
                    <?php echo DomainConst::CONTENT00304; ?>
                </th>
                
            </tr>
        </thead>
        <tbody>
            <?php $index = 0; ?>
            <?php foreach ($aData['EXPORT_DETAIL'] as $key => $valueExport) { ?>
            <?php
            ?>
                <tr class="<?php echo (($index++ % 2) == 1) ? 'even' : 'odd'; ?>">
                    <td style="text-align:center;"><?php echo $valueExport['DATE']; ?></td>
                    <td><?php echo $valueExport['DESCRIPTION']; ?></td>
                    <td style="text-align:right;"><?php echo CommonProcess::formatCurrency($valueExport['MONEY']); ?></td>
                </tr>
            <?php } ?>
            
        </tbody>
    </table>
</div>

<h3><?php echo DomainConst::CONTENT00401; ?></h3>
<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>
                    <?php echo DomainConst::CONTENT00343; ?>
                </th>
                <th>
                    <?php echo DomainConst::CONTENT00001; ?>
                </th>
                <th>
                    <?php echo DomainConst::CONTENT00002; ?>
                </th>
                
            </tr>
        </thead>
        <tbody>
            <?php $index = 0; ?>
            <?php  foreach ($aData['GENERAL']['DATES'] as $key => $date) { ?>
            <tr class="<?php echo (($index++ % 2) == 1) ? 'even' : 'odd'; ?>">
                <td style="text-align:center;"><?php echo $date; ?></td>
                <td style="text-align:right;"><?php echo !empty($aData['GENERAL']['IMPORT'][$date])
                    ? CommonProcess::formatCurrency($aData['GENERAL']['IMPORT'][$date]) : ''; ?></td>
                <td style="text-align:right;"><?php echo !empty($aData['GENERAL']['EXPORT'][$date])
                    ? CommonProcess::formatCurrency($aData['GENERAL']['EXPORT'][$date]) : ''; ?></td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>