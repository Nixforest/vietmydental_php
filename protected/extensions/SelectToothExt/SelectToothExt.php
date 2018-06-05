<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Yii::import('zii.widgets.CPortlet');

/**
 * Description of SelectToothExt
 *
 * @author nguyenpt
 */
class SelectToothExt extends CPortlet {
    /**
     * Current data
     * array('model' => $model, 'url' => custom url, 'field_name' => field_name)
     */
    public $data;
    
    /**
     * Initializer
     */
    public function init() {
        parent::init();
    }
    
    /**
     * Render content.
     */
    protected function renderContent() {
        // Render
        $this->render('view', array(
            'data'              => $this->data,
        ));
    }
}
