<?php
/* @var $this CustomerTypesController */
/* @var $model CustomerTypes */

$this->createMenu('create', $model);
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>