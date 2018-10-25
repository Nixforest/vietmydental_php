<?php
Yii::import('zii.widgets.grid.CGridView');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseGridView
 *
 * @author nguyenpt
 */
class BaseGridView extends CGridView {
    /**
     * Array DatePicker control
     * @var Array 
     */
    public $datePickers = array();
    
    /**
     * Initialize
     */
    public function init() {
        parent::init();
        $this->reinstallDatePickers();
    }
    
    /**
     * Reinstall java script for date pickers
     */
    public function reinstallDatePickers() {
        $javascript = '';
        foreach ($this->datePickers as $datePicker) {
            $javascript .= "$('#{$datePicker}').datepicker(jQuery.extend(jQuery.datepicker.regional['it']));";
        }
        Yii::app()->clientScript->registerScript('re-install-date-picker', "function reinstallDatePicker(id, data) {{$javascript}}");
    }
}
