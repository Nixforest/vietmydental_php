<?php
/* @var $this MoneyAccountController */
/* @var $model MoneyAccount */

$this->createMenu('update', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>