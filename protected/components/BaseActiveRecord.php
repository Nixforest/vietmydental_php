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
     * Field save error message.
     * @var type 
     */
    public $errMsg;
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
    
    public function behaviors() {
        return array(
            // Classname => path to Class
            'ActiveRecordLogableBehavior' =>
            'application.behaviors.ActiveRecordLogableBehavior',
        );
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
    
    /**
     * Get total value
     * @param type $records
     * @param type $column
     * @return type
     */
    public function getTotal($records, $column) {
        $total = 0;
        foreach ($records as $record) {
            $total += $record->$column;
        }
        return $total;
    }
    
    /**
     * Get field name of table
     * @param string $fieldName
     * @return string
     */
    public function getField($fieldName) {
        return isset($this->$fieldName) ? $this->$fieldName : '';
    }
    
    /**
     * Format date
     * @param String $field Name of field date
     */
//    public function formatDate($field) {
//        // Format birthday value
//        $date = $this->$field;
//        $this->$field = CommonProcess::convertDateTimeToMySqlFormat(
//                $date, DomainConst::DATE_FORMAT_3);
//        if (empty($this->$field)) {
//            $this->$field = CommonProcess::convertDateTimeToMySqlFormat(
//                        $date, DomainConst::DATE_FORMAT_4);
//        }
//        if (empty($this->$field)) {
//            $this->$field = $date;
//        }
//    }
    
    /**
     * Add error message
     * @param String $msg Message content
     */
    public function addErrorMessage($msg) {
        $this->addError('errMsg', $msg);
    }
    
    /**
     * Can update this model
     * @return boolean True
     */
    public function canUpdate() {
        return true;
    }
    
    /**
     * Get info of model
     * @param Array $arrInputs Input array
     * @return String Model information
     */
    public function getInfo($arrInputs) {
        $arrStr = array();
        foreach ($arrInputs as $input) {
            $arrStr[] = '[' . $input . ']';
        }
        $retVal = implode('-', $arrStr);
        
        return $retVal;
    }
    
    /**
     * Convert object to string
     * @return String Default value is all attributes
     */
    public function toString() {
        return $this->getInfo($this->attributes);
    }
    
    /**
     * Format date field
     * @param String $field         Field name
     * @param String $fromFormat    Format date convert from
     * @param String $toFormat      Format date convert to
     */
    public function formatDate($field,
            $fromFormat = DomainConst::DATE_FORMAT_BACK_END,
            $toFormat = DomainConst::DATE_FORMAT_1) {
        $date = $this->$field;
        $this->$field = CommonProcess::convertDateTime($date, $fromFormat, $toFormat);
        if (empty($this->$field)) {
            $this->$field = $date;
        }
    }
    
    /**
     * Return new record with cloned attributes
     *
     * @param string $scenario
     * @return static
     */
    public function cloneModel($scenario = 'insert')
    {
        /** @var \CActiveRecord $newModel */
        $newModel = new static($scenario);
        /** @var \CModel $this */
        $newModel->setAttributes($this->getAttributes($this->getSafeAttributeNames()));
        return $newModel;
    }
    /**
     * Clone related records and attach to current model
     *
     * @param static $originModel   Model where to take original related data
     * @param string $relationName  name of active relation to clone
     * @param string $type          Type of relation
     * @throws \CException
     */
    public function cloneRelation($originModel, $relationName, $type = '')
    {
        if (!isset($originModel[$relationName])) {
            throw new \CException('Model ' . get_class($originModel) . ' has no relation ' . $relationName);
        }
        $relatedRecords = $originModel->$relationName;
        Loggers::info('Count relation', count($relatedRecords), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        if (count($relatedRecords) > 0) {
            foreach ($relatedRecords as $record) {
                OneMany::insertOne($this->getField('id'), $record->getField('id'), $type);
            }
        }
    }
    /**
     * Get created user
     * @return string
     */
    public function getCreatedBy() {
        if (isset($this->rCreatedBy)) {
            return $this->rCreatedBy->getFullName();
        }
        return '';
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rCreatedBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
        );
    }
    
    /**
     * Get name value
     * @return String Name value
     */
    public function getName() {
        if (isset($this->name)) {
            return $this->name;
        }
        return '';
    }
    
    /**
     * Get relation model's field name value
     * @param String $relation Name of relation
     * @return string Field name value
     */
    public function getRelationModelName($relation) {
        if (isset($this->$relation)) {
            return $this->$relation->getName();
        }
        return '';
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'name'          => DomainConst::CONTENT00042,
            'description'   => DomainConst::CONTENT00062,
            'status'        => DomainConst::CONTENT00026,
            'created_date'  => DomainConst::CONTENT00010,
            'created_by'    => DomainConst::CONTENT00054,
        );
    }
    
    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Load model by class name
     * @param type $id
     * @param type $className
     * @param type $moduleName
     * @return type
     * @throws CHttpException
     */
    public static function loadModelByClass($id, $className, $moduleName) {
        try {
            $modelObj = self::checkModel($className, $moduleName);
            $model = $modelObj->findByPk($id);
            if ($model === NULL) {
                $cUid = Yii::app()->user->id;
                Yii::log("Class $className Uid : $cUid Model Bị NULL trong hàm loadModelByClass dùng hàm call_user_func.");
                throw new CHttpException(404, 'The requested page does not exist.');
            }
            return $model;
        } catch (Exception $e) {
            Yii::log("Exception " . print_r($e, true), 'error');
            throw new CHttpException("Exception " . print_r($e, true));
        }
    }
    
    /**
     * Check model
     * @param String $className Name of class
     * @param String $moduleName Name of module
     * @return Model object
     * @throws CHttpException
     */
    public static function checkModel($className, $moduleName) {
        $path = DirectoryHandler::getRootPath() . "/protected/modules/$moduleName/models/$className.php";
        Loggers::info('File path', $path, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        if (!is_file($path)) {
            $cUid = Yii::app()->user->id;
            Yii::log("Class $className Uid : $cUid Lỗi model không tồn tại. Important to review this error. User có thể đã chỉnh URL");
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model = call_user_func(array($className, 'model'));
    }
    
    /**
     * Check if method is exist
     * @param String $className Name of class
     * @param String $moduleName Name of module
     * @param String $method Name of method
     * @return boolean True if object contain method, false otherwise
     */
    public static function checkMethodExist($className, $moduleName, $method) {
        try {
            // Try to check model of class name is exist
            self::checkModel($className, $moduleName);
            // Get model object
            $modelObj = new $className();
            if (method_exists($modelObj, $method)) {
                return true;
            }
        } catch (Exception $exc) {
            Loggers::error('Exception', $exc->getMessage(), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        return false;
    }
    
    /**
     * BLACK MAGIC: change class of object
     * @param Object $object Model
     * @param String $new_class Class name
     * @return Object New class object
     */
    public static function change_class($object, $new_class) {
        preg_match('~^O:[0-9]+:"[^"]+":(.+)$~', serialize($object), $matches);
        return unserialize(sprintf('O:%s:"%s":%s', strlen($new_class), $new_class, $matches[1]));
    }
}
