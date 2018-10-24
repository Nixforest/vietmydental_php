<?php

/**
 * Working schedule widget
 */
class WorkScheduleWidget extends CWidget {
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    /** Model object */
    public $model;
    /** Date field name */
    public $field;
    /** Current value */
    public $value;
    /** Is readonly */
    public $isReadOnly = true;
    /** Format */
    public $format      = DomainConst::DATE_FORMAT_2;

    public function run() {
        $readOnly = '';
        if ($this->isReadOnly) {
            $readOnly = 'readonly';
        }
        $this->render('datePicker/view', array(
            'model' => $this->model,
            'field' => $this->field,
            'value' => $this->value,
            'isReadOnly'    => $readOnly,
            'format'        => $this->format,
        ));
    }

}
