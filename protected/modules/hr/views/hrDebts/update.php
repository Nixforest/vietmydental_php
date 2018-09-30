<?php
/* @var $this HrDebtsController */
/* @var $model HrDebts */

$this->createMenu('update', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->getUserName(); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>