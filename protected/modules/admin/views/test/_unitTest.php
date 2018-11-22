<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
$arrTabs = array(
    'Companies' => '_companies',
    'Department' => '_departments',
);
$arrayTabs = array();
$isActive = true;
foreach ($arrTabs as $key => $value) {
    $tab = array();
    $tab['label']   = $key;
    $tab['content'] = $this->renderPartial($value, array(), true);
    if ($isActive) {
        $tab['active']  = true;
        $isActive = false;
    }
    $arrayTabs[] = $tab;
}
$this->widget('bootstrap.widgets.TbTabs', array(
        'type' => 'tabs',
        'tabs' => $arrayTabs,
    )
);