<?php
/* @var $this MoneyAccountController */
/* @var $model MoneyAccount */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'name',
//		'owner_id',
		array(
                   'name'=>'owner_id',
                   'value'=>isset($model->rOwner) ? $model->rOwner->username : '',
                ),
		'balance',
		'created_date',
//		'status',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
