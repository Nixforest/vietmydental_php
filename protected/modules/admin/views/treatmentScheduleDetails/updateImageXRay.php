<?php
/* @var $this TreatmentScheduleDetailsController */
/* @var $model TreatmentScheduleDetails */

$this->createMenu('updateImageXRay', $model);
?>

<h1><?php echo $this->pageTitle; ?></h1>
<?php // $this->widget('zii.widgets.CDetailView', array(
//	'data'=>$model,
//	'attributes'=>array(
////		'id',
//		'schedule_id',
//		'start_date',
//		'end_date',
//		array(
//                    'label' => DomainConst::CONTENT00284,
//                    'type'=>'html',
//                    'value'=> isset($model->rJoinTeeth) ? $model->generateTeethInfo() : '',
//                ),
//		array(
//                   'name'=>'diagnosis_id',
//                   'value'=> isset($model->rDiagnosis) ? $model->rDiagnosis->name : '',
//                ),
//		array(
//                   'name'=>'treatment_type_id',
//                   'value'=> isset($model->rTreatmentType) ? $model->rTreatmentType->name : '',
//                ),
//		'description',
//		'type_schedule',
//                array(
//                    'name'  => DomainConst::CONTENT00026,
//                    'htmlOptions' => array('style' => 'text-align:center;'),
//                    'value' => TreatmentScheduleDetails::getStatus()[$model->status],
//                    'visible' => CommonProcess::isUserAdmin(),
//                ),
//	),
//)); ?>
<div class="form">
    <?php
    $form = $this->beginWidget(
        'CActiveForm',
        array(
            'id' => 'treatment-schedule-details-form',
            'enableAjaxValidation' => false,
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )
    ); ?>
    <div class="row">
        <label>&nbsp</label>
        <div>
            <a href="javascript:void(0);" class="text_under_none item_b" style="line-height:25px" onclick="fnBuildRow();">
                <img style="float: left;margin-right:8px;" src="<?php echo Yii::app()->theme->baseUrl;?>/img/add.png"> 
                <?php echo DomainConst::CONTENT00293; ?>
            </a>
        </div>
    </div>
    <div class="clr"></div>

    <div class="row">
        <label>&nbsp</label>
        <table class="materials_table hm_table table-bordered">
            <thead>
                <tr>
                    <th class="item_c">#</th>
                    <th class="item_code item_c"><?php echo DomainConst::CONTENT00294 . Files::ALLOW_IMAGE_FILE_TYPE; ?></th>
                    <th class="item_c" style="display: none;"><?php echo DomainConst::CONTENT00297; ?></th>
                    <th class="item_unit last item_c"><?php echo DomainConst::CONTENT00296; ?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $max_upload = Files::MAX_UPLOAD;
                    $max_upload_show = Files::MAX_UPLOAD_SHOW;
                    $aOrderNumber = CommonProcess::buildOrderNumberArray($max_upload);
                    $listOldImage = array_reverse($model->rImgXRayFile);
                    $index = 1;
                ?>
                <?php if(count($model->rImgXRayFile)):?>
                <?php foreach($listOldImage as $key=>$item):?>
                <tr class="materials_row">
                    <td class="item_c order_no"><?php echo $index++; ?></td>
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
                        <?php echo $form->error($item,'file_name'); ?>
                        <?php // echo $form->hiddenField($model,'aIdNotIn[]', array('value'=>$item->id)); ?>
                        <!-- //++ BUG0061-IMT (NamNH 20180808) --> 
                        <!--<input value="<?php // echo $item->id ?>" name="delete_file[]" id="delete_file" type="hidden">-->
                        <!-- //-- BUG0061-IMT (NamNH 20180808) -->
                    </td>
                    <td class="item_c" style="display: none;">
                        <?php echo $form->dropDownList($model,'order_number[]', $aOrderNumber,array('class'=>'w-50', 
                             'options' => array($item->order_number=>array('selected'=>true))
                                )); ?>
                    </td>
                    <!-- //++ BUG0061-IMT (NamNH 20180808) -->
                    <td class="item_c last"><span data-id='<?php echo$item->id;  ?>' class="remove_icon_only"></span></td>
                    <!-- //-- BUG0061-IMT (NamNH 20180808) -->
                </tr> 
                <?php // $max_upload_show--;?>
                <?php endforeach;?>
                <!-- //++ BUG0061-IMT (NamNH 20180808) -->
                <div id='divRemove' style='display: none;'></div>
                <!-- //-- BUG0061-IMT (NamNH 20180808) -->
                <?php endif;?>

                <?php for($i=count($model->rImgXRayFile) + 1; $i<=$max_upload; $i++): ?>
                <?php $display = "";
                    if($i>$max_upload_show)
                        $display = "display_none";
                ?>
                <tr class="materials_row <?php echo $display;?>">
                    <td class="item_c order_no"><?php echo $index++; ?></td>
                    <td class="item_l w-400">
                        <?php echo $form->fileField($model,'file_name[]', array('accept'=>'image/*')); ?>
                        <?php // echo $form->error($model->mDetail,'file_name'); ?>                        
                    </td>
                    <td class="item_c" style="display: none;">
                        <?php echo $form->dropDownList($model,'order_number[]', $aOrderNumber,array('class'=>'w-50', 
                             'options' => array($i=>array('selected'=>true))
                                )); ?>
                    </td>
                    <td class="item_c last"><span class="remove_icon_only"></span></td>
                </tr>                    
                <?php endfor;?>
            </tbody>
        </table>
    </div>
    <div class="row buttons">
        <?php
        echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array(
            'name' => 'submit',
        ));
        ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    $(document).keydown(function(e) {
        if(e.which == 119) {
            fnBuildRow();
        }
    });
    
    function fnBuildRow(){
        $('.materials_table').find('tr:visible:last').next('tr').show();
    }
    $(document).ready(function() {
       fnBindRemoveActionUploadFile();
    });
    function fnAfterRemoveActionUploadFile() {
        <?php if (!$model->isNewRecord): ?>
                $('.materials_table tbody').find('.display_none').eq(0).removeClass('display_none');
        <?php endif; ?>
    }
    //++ BUG0061-IMT (NamNH 20180808)
    function fnBeforeRemoveActionUploadFile($this){
        $idRemove = $($this).data('id');
        if($idRemove != 'undefined' && $idRemove != null){
            $('#divRemove').append('<input value="'+$idRemove+'" name="delete_file[]">');
        }
    }
    //-- BUG0061-IMT (NamNH 20180808)
</script>