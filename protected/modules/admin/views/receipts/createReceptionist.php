<?php
/* @var $this ReceiptsController */
/* @var $model Receipts */

$this->createMenu('create', $model);
?>

<h1><?php echo $this->pageTitle; ?></h1>

<?php echo $this->renderPartial('_form_receptionist', array('model'=>$model, 'total'=> $total,
                'detail' => $detail,)); ?>