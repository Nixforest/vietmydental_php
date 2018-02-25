<?php
/* @var $this MoneyController */
/* @var $model Money */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'name',
//		'user_id',
		array(
                   'name'=>'user_id',
                   'value'=> isset($model->rUser) ? $model->rUser->username : '',
                ),
		array(
                   'name'=>'isIncomming',
                   'value'=> CommonProcess::getTypeOfMoney()[$model->isIncomming],
                ),
		'amount',
//		'account_id',
		array(
                   'name'=>'account_id',
                   'value'=> isset($model->rAccount) ? $model->rAccount->name : '',
                ),
		'action_date',
		'created_date',
		'description',
	),
)); ?>
