<?php
/* @var $this TemporaryPatientsController */
/* @var $model TemporaryPatients */

$this->createMenu('update', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->getName(); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>