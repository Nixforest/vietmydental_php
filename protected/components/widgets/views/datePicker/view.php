<?php
$this->widget('zii.widgets.jui.CJuiDatePicker', array(
    'model'     => $model,
    'attribute' => $field,
    'language'  =>'en-GB',
    'options'   => array(
        'showAnim'      => 'slide',
        'dateFormat'    => DomainConst::DATE_FORMAT_2,
        'changeMonth'   => true,
        'changeYear'    => true,
    ),
    'htmlOptions'       => array(
        'readonly'  => $isReadOnly,
        'value'     => $value,
    ),
));