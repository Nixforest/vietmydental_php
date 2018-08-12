<?php
/* @var $this LaboProducersController */
/* @var $model LaboProducers */

//$this->breadcrumbs=array(
//	'Labo Producers'=>array('index'),
//	$model->name,
//);
//
//$this->menu=array(
//	array('label'=>'List LaboProducers', 'url'=>array('index')),
//	array('label'=>'Create LaboProducers', 'url'=>array('create')),
//	array('label'=>'Update LaboProducers', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete LaboProducers', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage LaboProducers', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<h1><?php echo $this->pageTitle.' '. $model->id;?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
                    'name'      => 'name',
                    'value'     => $model->getField('name'),
                ),
                array(
                    'name'      => 'address',
                    'value'     => $model->getField('address'),
                ),
                array(
                    'name'      => 'phone',
                    'value'     => $model->getField('phone'),
                ),
                array(
                    'name'      => 'admin_id',
                    'value'     => $model->getAdmin(),
                ),
                array(
                    'name'    => 'created_date',
                    'value'     => $model->getCreatedDate(),
                ),
                array(
                    'name'    => 'created_by',
                    'value'     => $model->getCreatedBy(),
                ),
	),
)); ?>
