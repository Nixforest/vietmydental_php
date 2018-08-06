<?php
/* @var $this LaboServiceTypesController */
/* @var $model LaboServiceTypes */

//$this->breadcrumbs=array(
//	'Labo Service Types'=>array('index'),
//	$model->name,
//);
//
//$this->menu=array(
//	array('label'=>'List LaboServiceTypes', 'url'=>array('index')),
//	array('label'=>'Create LaboServiceTypes', 'url'=>array('create')),
//	array('label'=>'Update LaboServiceTypes', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete LaboServiceTypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage LaboServiceTypes', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<!--<h1>View LaboServiceTypes #<?php // echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle.' '. $model->id;?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
                    'name'    => DomainConst::CONTENT00042,
                    'value'     => $model->getField('name'),
                ),
                array(
                    'name'    => DomainConst::CONTENT00062,
                    'value'     => $model->getField('description'),
                ),
                array(
                    'name'    => DomainConst::CONTENT00054,
                    'value'     => $model->getCreatedBy(),
                ),
                array(
                    'name'    => DomainConst::CONTENT00010,
                    'value'     => $model->getCreatedDate(),
                ),
	),
)); ?>
