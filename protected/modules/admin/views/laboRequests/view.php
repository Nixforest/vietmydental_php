<?php
/* @var $this LaboRequestsController */
/* @var $model LaboRequests */

//$this->breadcrumbs=array(
//	'Labo Requests'=>array('index'),
//	$model->id,
//);
//
//$this->menu=array(
//	array('label'=>'List LaboRequests', 'url'=>array('index')),
//	array('label'=>'Create LaboRequests', 'url'=>array('create')),
//	array('label'=>'Update LaboRequests', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete LaboRequests', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage LaboRequests', 'url'=>array('admin')),
//);
$this->createMenu('', $model);
?>

<h1><?php echo $this->pageTitle.' '. $model->id;?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
                    'name'      => 'description',
                    'value'     => $model->getField('description'),
                ),
                array(
                    'name'      => DomainConst::CONTENT00414,
                    'value'     => $model->getToothColor(),
                ),
                array(
                    'name'      => DomainConst::CONTENT00129,
                    'value'     => $model->getPrice(),
                ),
                array(
                    'name'      => DomainConst::CONTENT00411,
                    'value'     => $model->getRequestDate(),
                ),
                array(
                    'name'      => DomainConst::CONTENT00412,
                    'value'     => '$model->getReceiveDate()',
                ),
                array(
                    'name'      => DomainConst::CONTENT00413,
                    'value'     => $model->getTestDate(),
                ),
                array(
                    'name'      => DomainConst::CONTENT00010,
                    'value'     => $model->getCreatedDate(),
                ),
                array(
                    'name'      => DomainConst::CONTENT00054,
                    'value'     => $model->getCreatedBy(),
                ),
	),
)); ?>
