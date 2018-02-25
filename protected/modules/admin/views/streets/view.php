<?php
/* @var $this StreetsController */
/* @var $model Streets */

$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle . ': ' . $model->name; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'name',
		'short_name',
		'slug',
		array(
                   'name'=>'status',
                   'type'=>'Status',
                    'visible' => CommonProcess::isUserAdmin(),
                ),
		array(
                   'name'=>'city_id',
                   'value'=> isset($model->rCity) ? $model->rCity->name : '',
                ),
	),
)); ?>
