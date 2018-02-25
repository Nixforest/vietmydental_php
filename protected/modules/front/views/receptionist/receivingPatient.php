<?php
/* @var $this ReceptionistController */

$this->breadcrumbs=array(
	'Receptionist'=>array('/front/receptionist'),
	'ReceivingPatient',
);
?>
<h1><?php echo $this->id . '/' . $this->action->id; ?></h1>

<p>
	You may change the content of this page by modifying
	the file <tt><?php echo __FILE__; ?></tt>.
</p>

<?php
    echo CHtml::link(DomainConst::CONTENT00176, "", array(
        'style' => 'cursor: pointer; text-decoration: underline;',
        'onclick' => "{addClassroom(); $('#dialogClassroom').dialog('open');}"
    ));
?>
<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id'    => 'dialogClassroom',
        'options' => array(
            'title' => DomainConst::CONTENT00176,
            'autoOpen'  => false,
            'modal'     => true,
            'width'     => 700,
            'heigh'     => 470,
            'close'     => 'js:function() { }',
        ),
    ));
?>
<div class="divForForm"></div>

<?php $this->endWidget();?>

<script type="text/javascript">
function addClassroom()
{
    <?php echo CHtml::ajax(array(
            'url'=>Yii::app()->createAbsoluteUrl('front/receptionist/createCustomer'),
            'data'=> "js:$(this).serialize()",
            'type'=>'post',
            'dataType'=>'json',
            'success'=>"function(data)
            {
                if (data.status == 'failure')
                {
                    $('#dialogClassroom div.divForForm').html(data.div);
                          // Here is the trick: on submit-> once again this function!
                    $('#dialogClassroom div.divForForm form').submit(addClassroom);
                }
                else
                {
                    $('#dialogClassroom div.divForForm').html(data.div);
                    setTimeout(\"$('#dialogClassroom').dialog('close') \",3000);
                }
 
            } ",
            ))?>;
    return false; 
 
}
</script>