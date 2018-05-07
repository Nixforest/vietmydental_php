<?php
/* @var $this WarrantiesController */
/* @var $model Warranties */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ': ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		array(
                   'name'=>'customer_id',
                   'value'=> isset($model->rCustomer) ? $model->rCustomer->name : '',
                ),
		array(
                   'name'=>'type_id',
                   'value'=> isset($model->rType) ? $model->rType->name : '',
                ),
		array(
                    'label' => DomainConst::CONTENT00284,
                    'type'=>'html',
                    'value'=> isset($model->rJoinTeeth) ? $model->generateTeethInfo() : '',
                ),
		array(
                   'name'=>'start_date',
                   'value'=> CommonProcess::convertDateTimeWithFormat($model->start_date),
                ),
		array(
                   'name'=>'end_date',
                   'value'=> CommonProcess::convertDateTimeWithFormat($model->end_date),
                ),
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
