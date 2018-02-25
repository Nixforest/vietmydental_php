<?php
/* @var $this MedicalRecordsController */
/* @var $model MedicalRecords */
/* @var $form CActiveForm */

?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'medical-records-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo DomainConst::CONTENT00081; ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'customer_id'); ?>
		<?php echo $form->hiddenField($model, 'customer_id', array('class' => '')); ?>
                <?php
                    $custName = isset($model->rCustomer) ? $model->rCustomer->getAutoCompleteCustomerName() : '';
                    $aData = array(
                        'model'             => $model,
                        'field_id'          => 'customer_id',
                        'update_value'      => $custName,
                        'ClassAdd'          => 'w-350',
                        'url'               => Yii::app()->createAbsoluteUrl('admin/ajax/searchCustomer'),
                        'field_autocomplete_name' => 'autocomplete_name_customer',
                    );
                    $this->widget('ext.AutocompleteExt.AutocompleteExt',
                            array('data' => $aData));
                ?>
		<?php echo $form->error($model,'customer_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'record_number'); ?>
		<?php echo $form->textField($model,'record_number',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'record_number'); ?>
	</div>
        <div class="row">
            <label for="pathological"><?php echo DomainConst::CONTENT00137; ?></label>
            <table style="">
                <?php
                    $pathologicals = Pathological::loadModels();
                    $rPathological = array();
                    if (isset($model->rJoinPathological)) {
                        foreach ($model->rJoinPathological as $item) {
                            $rPathological[] = $item->rPathological;
                        }
                    }
                ?>
                <?php foreach ($pathologicals as $pathological): ?>
                    <?php
                        $inputId = "pathological_" . $pathological->id;
                        $inputName = "pathological" . '[' . $pathological->id . ']';
                        $checked = "";
                    if (in_array($pathological, $rPathological)) {
                        $checked = 'checked="checked"';
                    }
                    ?>
                    <tr>
                        <td>
                            <input
                                name="<?php echo $inputName ?>"
                                value="1"
                                type="checkbox"
                                id="<?php echo $inputId ?>"
                                <?php echo $checked; ?>
                                >
                            <label for="<?php echo $inputId ?>" >
                                <?php echo $pathological->name; ?>
                            </label>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="row" style="display: none">
		<?php echo $form->labelEx($model,'created_date'); ?>
		<?php
                echo $form->textField(
                        $model, 'created_date', array(
                            'value' => date(DomainConst::DATE_FORMAT_1),
                            'readonly' => 'true',
                        )
                );
                ?>
		<?php echo $form->error($model,'created_date'); ?>
	</div>

<!--	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save',
                        array(
                            'name'  => 'submit',
                        )); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<style>
    td label {
        float: none;
        padding-top: 0px;
        padding-left: 20px;
        text-align: left;
        width: 100%;
    }
/*    table, th, td {
        border: 1px solid black;
    }*/
</style>