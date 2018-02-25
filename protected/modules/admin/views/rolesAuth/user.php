<?php
/* @var $this RolesAuthController */

//$this->breadcrumbs=array(
//	$this->controllerDescription=>array('/users/index'),
//	'User',
//);
?>
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
            $listAllowActionsRoles = ActionsRoles::getActionArrByRoleAndController($mUser->role_id, $controller_id);
            $listAllowActionsUser = ActionsUsers::getActionArrByUserAndController($id, $controller_id);
            $mActionsUsers = ActionsUsers::model()->findAll('user_id = ' . $id . ' AND controller_id = ' . $controller_id);
        ?>
        <tr>
            <th colspan="3" >
                <h2>
                    <?php echo $aController[DomainConst::KEY_ALIAS] . ' - ' . Controllers::getNameById($controller_id); ?>
                </h2>
            </th>
        </tr>
        <?php foreach($aController[DomainConst::KEY_ACTIONS] as $keyAction=>$aAction): ?>
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
                    if (in_array($keyAction, $listAllowActionsUser)
                            || (($mActionsUsers == NULL) && in_array($keyAction, $listAllowActionsRoles))) {
                        echo 'checked="checked"';
                    }
                ?>
                >
                <label for="<?php echo $checkBoxId ?>" >
                <?php echo $aAction[DomainConst::KEY_ALIAS] ?>
            </label>
            </td>
        </tr>
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
