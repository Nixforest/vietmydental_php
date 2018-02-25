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
		'address_vi',
		array(
                   'name'=>'created_by',
                   'value'=> isset($model->rCreatedBy) ? $model->rCreatedBy->username : '',
                ),
		'created_date',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
