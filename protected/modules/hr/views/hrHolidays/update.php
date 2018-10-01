<?php
/* @var $this HrHolidaysController */
/* @var $model HrHolidays */

$this->createMenu('update', $model);
?>

<h1><?php echo $this->pageTitle . ' ' . $model->date; ?></h1>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>