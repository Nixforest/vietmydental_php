<?php
/* @var $this ReportsController */
$dateFrom = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4);
$dateTo = $dateFrom;
if (!empty($from)) {
    $dateFrom = CommonProcess::convertDateTime($from, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END);
}
if (!empty($to)) {
    $dateTo = CommonProcess::convertDateTime($to, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END);
}
?>
<h1><?php echo $this->pageTitle?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'revenue-form',
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
                'id' => 'ahihi'
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
<!--Money Import Body-->
<h1><?php echo DomainConst::CONTENT00391; ?></h1>
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
            <?php foreach ($aData['RECEIPT']['DATES'] as $key => $date) { 
                if (empty($aData['RECEIPT']['VALUES'][$date])) {
                    continue;
                }
            ?>
                <tr class="even">
                    <td><?php echo $date; ?></td>
                <?php foreach ($aData['DOCTORS'] as $idDoctor => $strFullName) { ?>
                    <td><?php echo !empty($aData['RECEIPT']['VALUES'][$date][$idDoctor]) ? $aData['RECEIPT']['VALUES'][$date][$idDoctor] : ''; ?></td>
                <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<h1><?php echo DomainConst::CONTENT00392; ?></h1>
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
            <?php foreach ($aData['EXPORT_DETAIL'] as $key => $valueExport) { ?>
                <tr class="even">
                    <td><?php echo $valueExport['DATE']; ?></td>
                    <td><?php echo $valueExport['DESCRIPTION']; ?></td>
                    <td><?php echo $valueExport['MONEY']; ?></td>
                </tr>
            <?php } ?>
            
        </tbody>
    </table>
</div>

<h1><?php echo DomainConst::CONTENT00393; ?></h1>
<div class="grid-view">
    <table class="items">
        <thead>
            <tr>
                <th>
                    <?php echo DomainConst::CONTENT00343; ?>
                </th>
                <th>
                    <?php echo DomainConst::CONTENT00394; ?>
                </th>
                <th>
                    <?php echo DomainConst::CONTENT00395; ?>
                </th>
                
            </tr>
        </thead>
        <tbody>
            <?php  foreach ($aData['GENERAL']['DATES'] as $key => $date) { ?>
            <tr class="even">
                <td><?php echo $date; ?></td>
                <td><?php echo !empty($aData['GENERAL']['IMPORT'][$date]) ? $aData['GENERAL']['IMPORT'][$date] : ''; ?></td>
                <td><?php echo !empty($aData['GENERAL']['EXPORT'][$date]) ? $aData['GENERAL']['EXPORT'][$date] : ''; ?></td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>