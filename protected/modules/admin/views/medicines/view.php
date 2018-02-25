<?php
/* @var $this MedicinesController */
/* @var $model Medicines */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'name',
		'code',
		'content',
		array(
                   'name'=>'unit_id',
                   'value'=> isset($model->rUnit) ? $model->rUnit->name : '',
                ),
		'active_ingredient',
		array(
                   'name'=>'use_id',
                   'value'=> isset($model->rUse) ? $model->rUse->name : '',
                ),
		'manufacturer',
		array(
                   'name'=>'type_id',
                   'value'=> isset($model->rType) ? $model->rType->name : '',
                ),
		'buy_price',
		'sell_price',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
