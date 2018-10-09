<?php
/* @var $this DepartmentTypesController */
/* @var $model DepartmentTypes */

$this->createMenu('create', $model);
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>