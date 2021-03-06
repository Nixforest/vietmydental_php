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
                   'value'=>isset($model->rOwner) ? $model->rOwner->getFullName() : '',
                ),
		array(
                   'name'=>'agent_id',
                   'value'=>isset($model->rAgent) ? $model->rAgent->name : '',
                ),
                array(
                    'name' => 'balance',
                    'htmlOptions' => array('style' => 'text-align:right;'),
                    'value' => CommonProcess::formatCurrency($model->balance),
                ),
		'created_date',
//		'status',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
