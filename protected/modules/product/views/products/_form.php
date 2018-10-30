<?php
/* @var $this ProductsController */
/* @var $model Products */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'products-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <?php echo DomainConst::CONTENT00081; ?>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'name'); ?>
        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'code'); ?>
        <?php echo $form->textField($model, 'code', array('size' => 30, 'maxlength' => 30)); ?>
        <?php echo $form->error($model, 'code'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'unit_id'); ?>
        <?php echo $form->dropDownList($model, 'unit_id', Units::loadItems()); ?>
        <?php echo $form->error($model, 'unit_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'type_id'); ?>
        <?php echo $form->dropDownList($model, 'type_id', ProductTypes::loadItems(true)); ?>
        <?php echo $form->error($model, 'type_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'parent_id'); ?>
        <?php echo $form->dropDownList($model, 'parent_id', Products::loadItems(true)); ?>
        <?php echo $form->error($model, 'parent_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'price'); ?>
        <?php echo $form->textField($model, 'price', array('size' => 11, 'maxlength' => 11)); ?>
        <?php echo $form->error($model, 'price'); ?>
    </div>

    <div class="row" style="<?php echo (($model->isNewRecord) ? "display: none;" : ""); ?>">
        <?php echo $form->labelEx($model, 'status'); ?>
        <?php echo $form->dropDownList($model, 'status', Products::getArrayStatus()); ?>
        <?php echo $form->error($model, 'status'); ?>
    </div>

    <div class="row">
        <label><?php echo DomainConst::CONTENT00252; ?></label>
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
                    $listOldImage = array_reverse($model->rImages);
                    $index = 1;
                ?>
                <?php if(count($model->rImages)):?>
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

                <?php for($i=count($model->rImages) + 1; $i<=$max_upload; $i++): ?>
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
        <?php echo CHtml::submitButton($model->isNewRecord ? DomainConst::CONTENT00017 : DomainConst::CONTENT00377); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->theme->baseUrl.'/js/autoNumeric/autoNumeric.js'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#Products_price').autoNumeric('init', {lZero:"deny", aPad: false} ); 
    });
</script>