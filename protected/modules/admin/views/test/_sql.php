<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'settings-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <div class="row buttons">
        <?php echo CHtml::submitButton('SQL_FindAll', array(
            'name'  => 'sql_submit_findAll',
        )); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('SQL_Find Condition', array(
            'name'  => 'sql_submit_findCondition',
        )); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->