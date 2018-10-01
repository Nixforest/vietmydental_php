<?php
/* @var $this HrHolidayPlansController */
/* @var $model HrHolidayPlans */

$this->createMenu('update', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>