<?php
/* @var $this PrescriptionDetailsController */
/* @var $model PrescriptionDetails */

$this->createMenu('update', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>