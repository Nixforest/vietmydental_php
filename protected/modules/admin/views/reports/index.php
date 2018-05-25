<?php
/* @var $this ReportsController */

$this->createMenu('index', null);
?>

<h1><?php echo $this->pageTitle; ?></h1>

<a target="_blank" href="<?php echo Yii::app()->createAbsoluteUrl("admin/reports/revenue"); ?>">
Báo cáo doanh thu
</a>
