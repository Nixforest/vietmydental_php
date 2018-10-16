<?php
/* @var $module Array */
/* @var $module_id String */
/* @var $mUser Users */
?>

<?php
//echo $module[DomainConst::KEY_ALIAS];
$arrayTabs = array();
$isActive = true;
foreach ($module[DomainConst::KEY_CHILDREN] as $controller_id => $controller) {
    $id = $module_id . '_' . $controller_id;
    $label = $controller[DomainConst::KEY_ALIAS];
    $content = $this->renderPartial('_controller_tab_content', array(
        'controller'    => $controller,
        'controller_id' => $controller_id,
        'mUser'         => $mUser,
    ), true);
    if ($isActive) {
        $isActive = false;
        $tab = array(
            'id'        => $id,
            'label'     => $label,
            'content'   => $content,
            'active'    => true,
        );
    } else {
        $tab = array(
            'id'        => $id,
            'label'     => $label,
            'content'   => $content,
        );
    }
    $arrayTabs[] = $tab;
}
$this->widget('bootstrap.widgets.TbTabs', array(
    'type' => 'tabs',
    'tabs' => $arrayTabs,
        )
);