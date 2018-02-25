<?php
/* @var $this ActionsRolesController */
/* @var $model ActionsRoles */

//$this->breadcrumbs = $this->createBreadCrumbs('update', $model);
//
//$menus = array(
//	array('label'=>$this->getPageTitleByAction('index'), 'url'=>array('index')),
//	array('label'=>$this->getPageTitleByAction('create'), 'url'=>array('create')),
//	array('label'=>$this->getPageTitleByAction('view'), 'url'=>array('view', 'id'=>$model->id)),
//	//array('label'=>'Manage ActionsRoles', 'url'=>array('admin')),
//);
//$this->menu = AdminController::createOperationMenu($menus, $actions);
$this->createMenu('update', $model);
?>

<!--<h1>Update ActionsRoles <?php echo $model->id; ?></h1>-->
<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>