<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Yii::import('zii.widgets.CPortlet');
/**
 * Description of AutocompleteExt
 *
 * @author NguyenPT
 */
class AutocompleteExt extends CPortlet {
    /** String 'field_autocomplete_name' */
    const KEY_FIELD_AUTOCOMPLETE_NAME                   = 'field_autocomplete_name';
    /** String 'class_name' */
    const KEY_CLASS_NAME                                = 'class_name';
    /** String 'model' */
    const KEY_MODEL                                     = 'model';
    /** String 'field_id' */
    const KEY_FIELD_ID                                  = 'field_id';
    /** String 'name_relation' */
    const KEY_NAME_RELATION                             = 'name_relation';
    /** String 'data_json' */
    const KEY_DATA_JSON                                 = 'data_json';
    /** String 'width' */
    const KEY_WIDTH                                     = 'width';
    /** String 'custom_source' */
    const KEY_CUSTOM_SOURCE                             = 'custom_source';
    /** String 'JSON_WIDGET' */
    const KEY_SESSION_JSON_WIDGET                       = 'JSON_WIDGET';
    /** String 'ClassAddDivWrap' */
    const KEY_CLASS_ADD_DIV_WRAP                        = 'ClassAddDivWrap';
    /** String 'url' */
    const KEY_URL                                       = 'url';
    /** String 'ClassAdd' */
    const KEY_CLASS_ADD                                 = 'ClassAdd';
    /** String 'placeholder' */
    const KEY_PLACE_HOLDER                              = 'placeholder';
    /** String 'isShowInfo' */
    const KEY_IS_SHOW_INFO                              = 'isShowInfo';
    /** String 'fnSelected' */
    const KEY_FN_SELECTED                               = 'fnSelected';
    /** String 'fnSelectedV2' */
    const KEY_FN_SELECTED_V2                            = 'fnSelectedV2';
    /** String 'doSomethingOnClose' */
    const KEY_DO_ST_ON_CLOSE                            = 'doSomethingOnClose';
    /** Default value of field autocomplete name */
    const FIELD_AUTOCOMPLETE_NAME_DEFAULT_VALUE         = 'autocomplete_name_value';
    /** String 'admin/ajax/searchUser' */
    const KEY_URL_DEFAULT_VALUE                         = 'admin/ajax/searchUser';
    /** Place holder default value */
    const DEFAULT_PLACE_HOLDER                          = DomainConst::CONTENT00067;
    /** Min length start search default value */
    const MIN_LENGTH_AUTOCOMPLETE                       = 2;
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
    public function renderContent() {
        $classdAddDivWrap       = CommonProcess::getValue($this->data, AutocompleteExt::KEY_CLASS_ADD_DIV_WRAP);
        $url                    = CommonProcess::getValue(
                                    $this->data,
                                    AutocompleteExt::KEY_URL,
                                    Yii::app()->createAbsoluteUrl(AutocompleteExt::KEY_URL_DEFAULT_VALUE));
        $fieldName              = CommonProcess::getValue(
                                    $this->data,
                                    AutocompleteExt::KEY_FIELD_AUTOCOMPLETE_NAME,
                                    AutocompleteExt::FIELD_AUTOCOMPLETE_NAME_DEFAULT_VALUE);
        $model                  = CommonProcess::getValue($this->data, AutocompleteExt::KEY_MODEL, NULL);
        $className              = '';
        $fieldId                = CommonProcess::getValue($this->data, AutocompleteExt::KEY_FIELD_ID, DomainConst::KEY_ID);
        $updateValue            = CommonProcess::getValue($this->data, 'update_value', '');
        $idFieldName            = '';       // Id field of name
        $idFieldId              = '';       // Id field of id
        $classAdd               = CommonProcess::getValue($this->data, AutocompleteExt::KEY_CLASS_ADD);
        $placeholder            = CommonProcess::getValue($this->data, AutocompleteExt::KEY_PLACE_HOLDER,
                                    AutocompleteExt::DEFAULT_PLACE_HOLDER)
                                    . ' Tối thiểu ' . AutocompleteExt::MIN_LENGTH_AUTOCOMPLETE . ' ký tự';
        $isShowInfo             = CommonProcess::getValue($this->data, AutocompleteExt::KEY_IS_SHOW_INFO, 1); // Flag show/hide detail information
        $isCallFuncSelected     = 0;
        $isCallFuncSelectedV2   = CommonProcess::getValue($this->data, AutocompleteExt::KEY_FN_SELECTED_V2, 0);
        $isDoSomethingOnClose   = CommonProcess::getValue($this->data, AutocompleteExt::KEY_DO_ST_ON_CLOSE, 0);
        if (isset($model)) {
            $className = get_class($model);
        }
        // Create id field of name
        $idFieldName = "#" . $className . "_" . $fieldName;
        // Create id field of id
        $idFieldId = "#" . $className . "_" . $fieldId;
        // Need call function selected
        if (isset($this->data[AutocompleteExt::KEY_FN_SELECTED])) {
            $isCallFuncSelected = 1;
        } else {
            $this->data[AutocompleteExt::KEY_FN_SELECTED] = 1;
        }
        // Render
        $this->render('view', array(
            'data'              => $this->data,
            'classdAddDivWrap'  => $classdAddDivWrap,
            'url'               => $url,
            'fieldName'         => $fieldName,
            'className'         => $className,
            'model'             => $model,
            'fieldId'           => $fieldId,
            'idFieldName'       => $idFieldName,
            'idFieldId'         => $idFieldId,
            'classAdd'          => $classAdd,
            'placeholder'       => $placeholder,
            'isShowInfo'        => $isShowInfo,
            'isCallFuncSelected'    => $isCallFuncSelected,
            'isCallFuncSelectedV2'  => $isCallFuncSelectedV2,
            'isDoSomethingOnClose'  => $isDoSomethingOnClose,
            'updateValue'       => $updateValue,
        ));
    }
}
