<?php
//$this->breadcrumbs = array(
//    $this->controllerDescription => array('roles/index'),
//    'Setting Privilege',
//);
?>

<!--<h1>Phân Quyền Cho Role: <?php echo $mGroup->role_short_name ?></h1>-->
<h1><?php echo $this->pageTitle ?></h1>

<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'roles-auth',
    'enableAjaxValidation' => false,
        ));
?>
<?php if (Yii::app()->user->hasFlash(DomainConst::KEY_SUCCESS_UPDATE)): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash(DomainConst::KEY_SUCCESS_UPDATE); ?>
    </div>
<?php endif; // end if (Yii::app()->user->hasFlash('successUpdate'))  ?>
<table style="">
    <?php foreach($this->aControllers as $controller_id=>$aController): ?>
        <?php
            $listAllowActions = ActionsRoles::getActionArrByRoleAndController($id, $controller_id);
            $mController = Controllers::getById($controller_id);
            if ($mController) {
                $name = $mController->name;
                if (isset($mController->rModule)) {
                    $module = $mController->rModule->name;
                }
            }
        ?>
        <tr>
            <th colspan="3" >
                <h2>
                    <?php // echo $aController[DomainConst::KEY_ALIAS] . ' - ' . Controllers::getNameById($controller_id); ?>
                    <?php echo $aController[DomainConst::KEY_ALIAS] . ' - ' . $module . '/' . $name; ?>
                </h2>
            </th>
        </tr>
        <?php foreach($aController[DomainConst::KEY_ACTIONS] as $keyAction=>$aAction): ?>
            <?php if ((CommonProcess::isUserAdmin()
                    || (!CommonProcess::isUserAdmin() && $keyAction != DomainConst::KEY_ACTION_DELETE))): ?>
                <?php
                    $checkBoxName = $controller_id . '[' . $keyAction . ']';
                    $checkBoxId = $controller_id . '_' . $keyAction;
                    ?>
                <tr>
                    <td>
                        <input
                        name="<?php echo $checkBoxName ?>"
                        value="1"
                        type="checkbox"
                        id="<?php echo $checkBoxId ?>"
                        <?php
                            if (in_array($keyAction, $listAllowActions)) {
                                echo 'checked="checked"';
                            }
                        ?>
                        >
                        <label for="<?php echo $checkBoxId ?>" >
                        <?php echo $aAction[DomainConst::KEY_ALIAS] ?>
                        </label>
                    </td>
                </tr>
            <?php endif; // end if (condition) ?>
        <?php endforeach; ?>   
    <?php endforeach; ?>    
</table>
<div class="form form_fix_submit">
    <div class="row buttons" style="padding-left: 250px; padding-top: 20px;">
        <?php echo CHtml::submitButton("Save", array('name'=>'submit')); ?>
    </div>    
</div>
<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
<style>
    form label {
        float: none;
        padding-top: 0px;
        padding-left: 20px;
        text-align: left;
        width: 100%;
    }
    table, th, td {
        border: 1px solid black;
    }
</style>
 <script>
</script>