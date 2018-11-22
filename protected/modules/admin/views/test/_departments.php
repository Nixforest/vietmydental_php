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
        <div class="col-md-2">
            <?php
            echo CHtml::Button(
                    'getListUsers',
                    array(
                        'id' => 'getListUsers',
                        'onClick' => 'send(this.id);'
                    ));
            ?>
        </div>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script type="text/javascript">
    function send($id) {
        $.ajax({
            type: 'POST',
            url: '<?php echo Yii::app()->createAbsoluteUrl("admin/test/departments"); ?>',
            data: {data: $id},
            success: function(data){
                $('#result').html(data['data']);
            },
            error: function(data) { // if error occured
                alert("Error occured.please try again");
                alert(data);
            },
            dataType: 'json'
        });
    }
</script>