<?php
/* @var $this LaboServicesController */
/* @var $model LaboServices */

//$this->breadcrumbs=array(
//	'Labo Services'=>array('index'),
//	$model->name,
//);
//
//$this->menu=array(
//	array('label'=>'List LaboServices', 'url'=>array('index')),
//	array('label'=>'Create LaboServices', 'url'=>array('create')),
//	array('label'=>'Update LaboServices', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete LaboServices', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage LaboServices', 'url'=>array('admin')),
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
                    'name'      => 'description',
                    'value'     => $model->getField('description'),
                ),
                array(
                    'name'      => 'price',
                    'value'     => $model->getPrice(),
                ),
                array(
                    'name'      => 'type_id',
                    'value'     => $model->getType(),
                ),
                array(
                    'name'      => 'producer_id',
                    'value'     => $model->getProducer(),
                ),
                array(
                    'name'      => 'created_date',
                    'value'     => $model->getCreatedDate(),
                ),
                array(
                    'name'      => 'created_by',
                    'value'     => $model->getCreatedBy(),
                ),
	),
)); ?>
