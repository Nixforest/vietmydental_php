<?php
/* @var $this ActionsRolesController */
/* @var $model ActionsRoles */
    
//$this->breadcrumbs = $this->createBreadCrumbs('view', $model);
//
//$menus = array(
//	array('label'=>$this->getPageTitleByAction('index'), 'url'=>array('index')),
//	array('label'=>$this->getPageTitleByAction('create'), 'url'=>array('create')),
//	array('label'=>$this->getPageTitleByAction('update'), 'url'=>array('update', 'id'=>$model->id)),
//	array('label'=>$this->getPageTitleByAction('delete'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
//	//array('label'=>'Manage ActionsRoles', 'url'=>array('admin')),
//);
//$this->menu = AdminController::createOperationMenu($menus, $actions);
$this->createMenu('view', $model);
?>

<!--<h1>View ActionsRoles #<?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		//'role_id',
                array(
                    'name' => 'role',
                    'value' => $model->role->role_name,
                ),
		//'controller_id',
                array(
                    'name' => 'controller',
                    'value' => $model->controller->name,
                ),
		'actions',
		//'can_access',
		array(
                   'name'=>'can_access',
                   'type'=>'access',
                ),
	),
)); ?>
