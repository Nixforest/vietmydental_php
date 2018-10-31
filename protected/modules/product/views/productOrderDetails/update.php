<?php
/* @var $this ProductOrderDetailsController */
/* @var $model ProductOrderDetails */

$this->createMenu('update', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>