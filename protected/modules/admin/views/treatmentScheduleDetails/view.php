<?php
/* @var $this TreatmentScheduleDetailsController */
/* @var $model TreatmentScheduleDetails */

$this->createMenu('view', $model);
$this->menu[] = array(
                    'label' => $this->getPageTitleByAction('updateImageXRay'),
                    'url' => array(
                        'updateImageXRay',
                        'id' => $model->id
                ));

if (AdminController::canAccessAction('updateImageReal', $actions)) {
    $this->menu[] = array(
                    'label' => $this->getPageTitleByAction('updateImageReal'),
                    'url' => array(
                        'updateImageReal',
                        'id' => $model->id
                ));
}
?>

<h1><?php echo $this->pageTitle . ' ' . $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
//		'id',
		'schedule_id',
		'start_date',
		'end_date',
		array(
                    'label' => DomainConst::CONTENT00284,
                    'type'=>'html',
                    'value'=> isset($model->rJoinTeeth) ? $model->generateTeethInfo() : '',
                ),
		array(
                   'name'=>'diagnosis_id',
                   'value'=> isset($model->rDiagnosis) ? $model->rDiagnosis->name : '',
                ),
		array(
                   'name'=>'treatment_type_id',
                   'value'=> isset($model->rTreatmentType) ? $model->rTreatmentType->name : '',
                ),
		'description',
		'type_schedule',
                array(
                    'name'  => DomainConst::CONTENT00026,
                    'htmlOptions' => array('style' => 'text-align:center;'),
                    'value' => TreatmentScheduleDetails::getStatus()[$model->status],
                    'visible' => CommonProcess::isUserAdmin(),
                ),
	),
)); ?>
<table class="materials_table hm_table table-bordered">
<thead>
    <tr>
        <th class="item_c">#</th>
        <th class="item_code item_c"><?php echo DomainConst::CONTENT00298; ?></th>
    </tr>
</thead>
<tbody>
<?php 
    $listOldImage = array_reverse($model->rImgXRayFile);
    $index = 1;
?>
<?php if(count($model->rImgXRayFile)):?>
<?php foreach($listOldImage as $key=>$item):?>
<tr class="materials_row">
    <td class="item_c order_no"><?php echo $index++ . ""; ?></td>
    <td class="item_c w-400">
        <?php // echo $form->fileField($item,'file_name[]'); ?>
        <?php if(!empty($item->file_name) && !empty($item->created_date)): ?>
<!--                        <p>
            <a rel="group1" class="gallery" href="<?php echo ImageHandler::bindImageByModel($item,'','',array('size'=>'size2'));?>"> 
                <img width="100" height="70" src="<?php echo ImageHandler::bindImageByModel($item,'','',array('size'=>'size1'));?>">
            </a>
        </p>-->
            <?php echo $item->getViewImage(); ?>
        <?php endif;?>
    </td>
</tr> 
<?php endforeach;?>
<?php endif;?>
    </tbody>
</table>

<table class="materials_table hm_table table-bordered">
<thead>
    <tr>
        <th class="item_c">#</th>
        <th class="item_code item_c"><?php echo DomainConst::CONTENT00380; ?></th>
    </tr>
</thead>
<tbody>
<?php 
    $listOldImage = array_reverse($model->rImgRealFile);
    $index = 1;
?>
<?php if(count($model->rImgRealFile)):?>
<?php foreach($listOldImage as $key=>$item):?>
<tr class="materials_row">
    <td class="item_c order_no"><?php echo $index++ . ""; ?></td>
    <td class="item_c w-400">
        <?php // echo $form->fileField($item,'file_name[]'); ?>
        <?php if(!empty($item->file_name) && !empty($item->created_date)): ?>
<!--                        <p>
            <a rel="group1" class="gallery" href="<?php echo ImageHandler::bindImageByModel($item,'','',array('size'=>'size2'));?>"> 
                <img width="100" height="70" src="<?php echo ImageHandler::bindImageByModel($item,'','',array('size'=>'size1'));?>">
            </a>
        </p>-->
            <?php echo $item->getViewImage(); ?>
        <?php endif;?>
    </td>
</tr> 
<?php endforeach;?>
<?php endif;?>
    </tbody>
</table>
