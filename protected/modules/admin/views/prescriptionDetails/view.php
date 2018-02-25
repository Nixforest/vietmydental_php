<?php
/* @var $this PrescriptionDetailsController */
/* @var $model PrescriptionDetails */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'prescription_id',
		array(
                   'name'=>'medicine_id',
                   'value'=> isset($model->rMedicine) ? $model->rMedicine->getAutoCompleteMedicine() : '',
                ),
		'quantity',
		'quantity1',
		'quantity2',
		'quantity3',
		'quantity4',
		'note',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
