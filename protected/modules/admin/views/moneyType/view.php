<?php
/* @var $this MoneyTypeController */
/* @var $model MoneyType */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'name',
		array(
                   'name'=>'isIncomming',
                   'value'=> CommonProcess::getTypeOfMoney()[$model->isIncomming],
                ),
                array(
                    'name' => 'amount',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'value' => CommonProcess::formatCurrency($model->amount),
                ),
		'description',
		'created_date',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
