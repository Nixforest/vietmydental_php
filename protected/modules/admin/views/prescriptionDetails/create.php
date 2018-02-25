<?php
/* @var $this PrescriptionDetailsController */
/* @var $model PrescriptionDetails */

$this->createMenu('create', $model);
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>