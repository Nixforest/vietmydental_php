<?php
/* @var $controller Array */
/* @var $controller_id String */
/* @var $mUser Users */
?>
<?php
$listAllowActionsRoles  = ActionsRoles::getActionArrByRoleAndController($mUser->role_id, $controller_id);
Loggers::info('$listAllowActionsRoles', CommonProcess::json_encode_unicode($listAllowActionsRoles),
        __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
$listAllowActionsUser   = ActionsUsers::getActionArrByUserAndController($mUser->id, $controller_id);
$mActionsUsers          = ActionsUsers::model()->findAll('user_id = ' . $mUser->id . ' AND controller_id = ' . $controller_id);
?>
<div style="border-top: 2px solid black;">
<?php foreach($controller[DomainConst::KEY_ACTIONS] as $keyAction => $aAction): ?>
    <?php if ((CommonProcess::isUserAdmin() || (!CommonProcess::isUserAdmin() && $keyAction != DomainConst::KEY_ACTION_DELETE))):
        ?>
        <?php
        $checkBoxName = $controller_id . '[' . $keyAction . ']';
        $checkBoxId = $controller_id . '_' . $keyAction;
        ?>
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
        <label for="<?php echo $checkBoxId ?>" style="display: block;">
            <?php echo $aAction[DomainConst::KEY_ALIAS] ?>
        </label>
    <?php endif; ?>
<?php endforeach; // foreach ($module[DomainConst::KEY_CHILDREN] as $controller): ?>
</div>