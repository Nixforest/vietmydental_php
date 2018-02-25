<?php
/* @var $this ActionsRolesController */
/* @var $model ActionsRoles */

//$this->breadcrumbs = $this->createBreadCrumbs('create');
//
//$menus = array(
//	array('label'=>$this->getPageTitleByAction('index'), 'url'=>array('index')),
//	//array('label'=>'Manage ActionsRoles', 'url'=>array('admin')),
//);
//$this->menu = AdminController::createOperationMenu($menus, $actions);
$this->createMenu('create', $model);
?>

<!--<h1>Create ActionsRoles</h1>-->
<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>