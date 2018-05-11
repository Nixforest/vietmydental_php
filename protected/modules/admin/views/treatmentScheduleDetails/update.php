<?php
/* @var $this TreatmentScheduleDetailsController */
/* @var $model TreatmentScheduleDetails */

$this->createMenu('update', $model);
$this->menu[] = array(
                    'label' => $this->getPageTitleByAction('updateImageXRay'),
                    'url' => array(
                        'updateImageXRay',
                        'id' => $model->id
                ));
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>