<?php
/* @var $this StreetsController */
/* @var $model Streets */

?>

<h1><?php echo $this->pageTitle; ?></h1>
<?php
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
echo '<pre style="max-height: 1000px;">';
print_r($result);
echo '</pre>';
?>