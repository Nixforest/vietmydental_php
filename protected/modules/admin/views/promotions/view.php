<?php
/* @var $this PromotionsController */
/* @var $model Promotions */

//$this->breadcrumbs=array(
//	'Promotions'=>array('index'),
//	$model->title,
//);
//
//$this->menu=array(
//	array('label'=>'List Promotions', 'url'=>array('index')),
//	array('label'=>'Create Promotions', 'url'=>array('create')),
//	array('label'=>'Update Promotions', 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>'Delete Promotions', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	array('label'=>'Manage Promotions', 'url'=>array('admin')),
//);
$this->createMenu('view', $model);
?>

<!--<h1>View Promotions #<?php // echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
                    'name' => DomainConst::CONTENT00004,
                    'value' => $model->getField('title')
                ),
                array(
                    'name' => DomainConst::CONTENT00062,
                    'value' => $model->getField('description')
                ),
                array(
                    'name' => DomainConst::CONTENT00139,
                    'value' => $model->getStartDate()
                ),
                array(
                    'name' => DomainConst::CONTENT00140,
                    'value' => $model->getEndDate()
                ),
                array(
                    'name' => DomainConst::CONTENT00199,
                    'value' => $model->getAgents()
                ),
                array(
                    'name' => DomainConst::CONTENT00054,
                    'value' => $model->getCreatedBy()
                ),
                array(
                    'name' => DomainConst::CONTENT00010,
                    'value' => $model->getCreatedDate()
                ),
	),
)); ?>
<?php include '_view_detail.php' ?>
