<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'model'     => $model,
    'attribute' => $field,
    'language'  =>'en-GB',
    'options'   => array(
        'showAnim'      => 'slide',
        'dateFormat'    => $format,
        'changeMonth'   => true,
        'changeYear'    => true,
        'showButtonPanel'=>true,
    ),
    'htmlOptions'       => array(
        'readonly'  => $isReadOnly,
        'value'     => $value,
    ),
));