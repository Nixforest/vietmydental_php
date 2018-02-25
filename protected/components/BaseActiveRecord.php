<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BaseActiveRecord
 *
 * @author NguyenPT
 */
class BaseActiveRecord extends CActiveRecord {
    public $baseArrayJsonDecode, $baseArrayJsonDecodeV1;// Jan 26, 2017 sử dụng để làm biến tạm decode json
    /**
     * Update json from variable data
     * @param String $field Json field
     * @param String $json_db_name Json database name
     */
    public function setJsonDataField($field = DomainConst::KEY_JSON_FIELD,
            $json_db_name = DomainConst::KEY_JSON) {
        $json = array();
        foreach ($this->{$field} as $field_name) {
            $json[$field_name] = $this->$field_name;
        }
        $this->{$json_db_name} = json_encode($json);
    }
    
    /**
     * Get data from json field
     * @param String $field_name Field name
     * @param String $json_db_name Json database name
     * @return String Value of field
     */
    public function getJsonDataField($field_name,
            $json_db_name = DomainConst::KEY_JSON) {
        $temp = json_decode($this->{$json_db_name}, true);
        if (is_array($temp) && isset($temp[$field_name])) {
            return $temp[$field_name];
        }
        return '';
    }
    
    /**
     * Map json field to model field
     * @param String $field Field name
     */
    public function mapJsonDataField($field = DomainConst::KEY_JSON_FIELD) {
        foreach ($this->{$field} as $field_name) {
            $this->$field_name = $this->getJsonDataField($field_name);
        }
    }
    
    /**
     * Get data from json field
     * @param type $field_name
     * @param type $json_db_name
     * @param type $baseArrayJsonDecode
     * @return string
     */
    public function getJsonFieldOneDecode($field_name,
            $json_db_name = DomainConst::KEY_JSON,
            $baseArrayJsonDecode = 'baseArrayJsonDecode') {
        if (empty($this->{$baseArrayJsonDecode})) {
            $this->{$baseArrayJsonDecode} = json_decode($this->{$json_db_name}, true);
        }
        if (is_array($this->{$baseArrayJsonDecode})
            && isset($this->{$baseArrayJsonDecode}[$field_name])) {
            return $this->{$baseArrayJsonDecode}[$field_name];
        }
        return '';
    }
    
    /**
     * Map data json fo field
     * @param type $field
     * @param type $json_db_name
     * @param type $baseArrayJsonDecode
     */
    public function mapJsonFieldOneDecode($field, $json_db_name, $baseArrayJsonDecode) {
        foreach ($this->{$field} as $$field_name) {
            $this->$field_name = $this->getJsonFieldOneDecode($field_name, $json_db_name, $baseArrayJsonDecode);
        }
    }
    
    /**
     * Check if id is exist
     * @param String $id Id value
     * @return True if id is exist in database, False otherwise
     */
    public function isIdExist($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $id, true);
        $data = new CActiveDataProvider(
                $this,
                array(
            'criteria' => $criteria,
        ));
        return !empty($data->getData());
    }
    
    /**
     * Check if id is exist, and status is not inactive
     * @param String $id Id value
     * @return True if id is exist in database, False otherwise
     */
    public function isIdActiveExist($id) {
        $criteria = new CDbCriteria();
        $criteria->compare('id', $id, true);
        $criteria->addCondition('status!=' . DomainConst::DEFAULT_STATUS_INACTIVE);
        $data = new CActiveDataProvider(
                $this,
                array(
            'criteria' => $criteria,
        ));
        return !empty($data->getData());
    }
}
