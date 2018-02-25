<?php
/* @var $this MedicalRecordsController */
/* @var $model MedicalRecords */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		array(
                   'name'=>'customer_id',
                   'value'=> isset($model->rCustomer) ? $model->rCustomer->name : '',
                ),
		'record_number',
		array(
                    'label' => DomainConst::CONTENT00137,
                    'type'=>'html',
                    'value'=> isset($model->rJoinPathological) ? $model->generateMedicalHistory() : '',
                ),
		'created_date',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
