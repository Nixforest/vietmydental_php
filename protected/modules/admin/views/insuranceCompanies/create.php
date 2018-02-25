<?php
/* @var $this InsuranceCompaniesController */
/* @var $model InsuranceCompanies */

$this->createMenu('create', $model);
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>