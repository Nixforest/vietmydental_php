<?php
/* @var $this ReceiptsController */
/* @var $model Receipts */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'detail_id',
		'process_date',
		'discount',
		'need_approve',
		'customer_confirm',
		'description',
		'created_date',
		'created_by',
		'receiptionist_id',
                array(
                    'name'  => DomainConst::CONTENT00026,
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value' => Receipts::getStatus()[$model->status],
                ),
	),
)); ?>
