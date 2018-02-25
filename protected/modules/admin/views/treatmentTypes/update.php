<?php
/* @var $this TreatmentTypesController */
/* @var $model TreatmentTypes */

$this->createMenu('update', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>