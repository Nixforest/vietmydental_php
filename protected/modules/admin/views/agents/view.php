<?php
/* @var $this AgentsController */
/* @var $model Agents */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ': ' . $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'name',
		'phone',
		'email',
		array(
                   'name'=>'foundation_date',
                   'value'=> CommonProcess::convertDateTime($model->foundation_date,
                            DomainConst::DATE_FORMAT_4,
                            DomainConst::DATE_FORMAT_3),
                ),
//		'city_id',
//		'district_id',  
//		'ward_id',
//		'street_id',
//		'house_numbers',
		'address',
		array(
                   'name'=>'address_vi',
                   'value'=> isset($model->address_vi) ? $model->address_vi : '',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
		array(
                   'name'=>'created_by',
                   'value'=> isset($model->rCreatedBy) ? $model->rCreatedBy->username : '',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
		'created_date',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>


<h1><?php echo DomainConst::CONTENT00337 . ':'; ?></h1>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'users-grid',
    'dataProvider' => $users,
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
            'name' => DomainConst::CONTENT00042,
            'htmlOptions' => array('style' => 'text-align:left;'),
            'value' => 'isset($data->rUser) ? $data->rUser->getFullName() : ""',
        ),
        array(
            'name' => DomainConst::CONTENT00338,
            'htmlOptions' => array('style' => 'text-align:left;'),
            'value' => '!empty($data->rUser->rRole) ? $data->rUser->rRole->role_short_name : ""',
        ),
    ),
));
?>



<h1><?php echo DomainConst::CONTENT00339 . ':'; ?></h1>
<table id="customer-info" class="items">
    <thead>
        <tr>
            <th><?php echo DomainConst::CONTENT00340; ?></th>
            <th><?php // echo DomainConst::CONTENT00341; ?></th>
            <th><?php echo DomainConst::CONTENT00342; ?></th>
        </tr>
    </thead>
    <tbody>
        <?php
            $revenueToday = Receipts::getRevenueToday($model->id);
            $revenueToday = 0;
            $totalCollected = 0;
//            $revenueMonth = Receipts::getRevenueCurrentMonth($model->id);
            $revenueMonth = 0;
        ?>
        <?php // foreach ($arrModels as $model) :?>
            <?php
//            $total += $model->final;
//            if ($model->status == Receipts::STATUS_RECEIPTIONIST) {
//                $totalCollected += $model->final;
//            } else {
//                $totalDebit += $model->final;
//            }
            ?>
            <?php // if (isset($mCustomer) && isset($mTreatmentType)) :?>

            <?php // endif;?>
        <?php // endforeach; ?>
        <tr>
            <td style="text-align: right"><?php echo CommonProcess::formatCurrency($revenueToday); ?></td>
            <td style="text-align: right"><?php // echo CommonProcess::formatCurrency($totalCollected); ?></td>
            <td style="text-align: right"><?php echo CommonProcess::formatCurrency($revenueMonth); ?></td>
        </tr>
    </tbody>
</table>
<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'receipts-grid',
    'dataProvider' => $receipts,
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
            'name' => DomainConst::CONTENT00343,
            'htmlOptions' => array('style' => 'text-align:center;'),
            'value' => 'isset($data->rReceipt) ? $data->rReceipt->getProcessDate() : ""',
        ),
        array(
            'name' => DomainConst::CONTENT00100,
            'htmlOptions' => array('style' => 'text-align:left;'),
            'value' => '$data->getReceiptCustomerName()',
        ),
        array(
            'name' => DomainConst::CONTENT00128,
            'htmlOptions' => array('style' => 'text-align:left;'),
            'value' => '$data->getReceiptTreatmentTypeName()',
        ),
        array(
            'name' => DomainConst::CONTENT00129,
            'htmlOptions' => array('style' => 'text-align:right;'),
            'value' => '(isset($data->rReceipt) && ($data->rReceipt->getTreatmentType() != NULL)) ? $data->rReceipt->getTreatmentType()->getPrice() : DomainConst::CONTENT00345',
        ),
    ),
));
?>