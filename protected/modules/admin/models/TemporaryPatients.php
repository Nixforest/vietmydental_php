<?php

/**
 * This is the model class for table "temporary_patients".
 *
 * The followings are the available columns in table 'temporary_patients':
 * @property string $id                 Id of record
 * @property string $name               Name of patient
 * @property string $phone              Phone of patient
 * @property string $content            Content request
 * @property string $book_date          Book date
 * @property integer $customer_id       Id of customer
 * @property integer $source_id         Id of source information
 * @property string $receptionist_id    Id of receptionist
 * @property string $agent_id           Id of agent
 * @property integer $status            Status
 * @property string $created_date       Created date
 * @property string $created_by         Created by
 *
 * The followings are the available model relations:
 * @property Users                  $rCreatedBy                     User created this record
 * @property Customer               $rCustomer                      Customer model
 * @property SourceInformations     $rSourceInfo                    SourceInformations model
 * @property Users                  $rReceptionist                  Receptionist model
 * @property Agents                 $rAgent                         Agent model
 * @property SocialNetworks[]       $rSocialNetwork                 Social network
 */
class TemporaryPatients extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = '0';
    /** Active */
    const STATUS_ACTIVE                 = '1';
    /** Converted to really customer */
    const STATUS_CONVERTED              = '2';
    
    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $autocomplete_name_customer;
    public $autocomplete_user;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return TemporaryPatients the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'temporary_patients';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, source_id', 'required'),
            array('customer_id, source_id, status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('phone', 'length', 'max' => 200),
            array('receptionist_id, agent_id, created_by', 'length', 'max' => 10),
            array('content, book_date, created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, phone, content, book_date, customer_id, source_id, receptionist_id, agent_id, status, created_date, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $relation = parent::relations();
        $relation['rCustomer']  = array(
            self::BELONGS_TO, 'Customers', 'customer_id',
            'on'    => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
        );
        $relation['rSourceInfo']  = array(
            self::BELONGS_TO, 'SourceInformations', 'source_id',
        );
        $relation['rReceptionist']  = array(
            self::BELONGS_TO, 'Users', 'receptionist_id',
            'on'    => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
        );
        $relation['rAgent']  = array(
            self::BELONGS_TO, 'Agents', 'agent_id',
            'on'    => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
        );
        $relation['rSocialNetwork']  = array(
            self::HAS_MANY, 'SocialNetworks', 'object_id',
                'on' => 'type = ' . SocialNetworks::TYPE_TEMP_PATIENT,
        );
        return $relation;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        $attributeLabes                     = parent::attributeLabels();
        $attributeLabes['name']             = DomainConst::CONTENT00100;
        $attributeLabes['phone']            = DomainConst::CONTENT00048;
        $attributeLabes['content']          = DomainConst::CONTENT00428;
        $attributeLabes['book_date']        = DomainConst::CONTENT00442;
        $attributeLabes['customer_id']      = DomainConst::CONTENT00138;
        $attributeLabes['source_id']        = DomainConst::CONTENT00109;
        $attributeLabes['receptionist_id']  = DomainConst::CONTENT00557;
        $attributeLabes['agent_id']         = DomainConst::CONTENT00199;
        return $attributeLabes;
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('book_date', $this->book_date, true);
        $criteria->compare('customer_id', $this->customer_id);
        $criteria->compare('source_id',$this->source_id);
        $criteria->compare('receptionist_id',$this->receptionist_id,true);
        $criteria->compare('agent_id',$this->agent_id,true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->order = 'id desc';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Settings::getListPageSize(),
            ),
        ));
    }
    
    //-----------------------------------------------------
    // Parent methods
    //-----------------------------------------------------
    /**
     * Override before save
     * @return parent
     */
    protected function beforeSave() {
        $this->formatDate('book_date', DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_DB);
        if ($this->isNewRecord) {
            $this->created_by = Yii::app()->user->id;
            
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        }
        
        return parent::beforeSave();
    }
    
    /**
     * Override before delete method
     * @return Parent result
     */
    protected function beforeDelete() {
        $retVal = parent::beforeDelete();
        return $retVal;
    }
    
    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Return status string
     * @return string Status value as string
     */
    public function getStatus() {
        if (isset(self::getArrayStatus()[$this->status])) {
            return self::getArrayStatus()[$this->status];
        }
        return '';
    }
    
    /**
     * Get customer name
     * @return String Customer name
     */
    public function getCustomer() {
        return $this->getRelationModelName('rCustomer');
    }
    
    /**
     * Get source information name
     * @return String Source information name
     */
    public function getSourceInfo() {
        return $this->getRelationModelName('rSourceInfo');
    }
    
    /**
     * Get receptionist name
     * @return String Receptionist name
     */
    public function getReceptionist() {
        return $this->getRelationModelName('rReceptionist');
    }
    
    /**
     * Get agent name
     * @return String Agent name
     */
    public function getAgent() {
        return $this->getRelationModelName('rAgent');
    }
    
    /**
     * Get book date
     * @return String Book date
     */
    public function getBookDate() {
        return CommonProcess::convertDateBackEnd($this->book_date);
    }

    /**
     * Get social network value
     * @param Int $type_network Network type
     * @return String
     */
    public function getSocialNetwork($type_network) {
        if (isset($this->rSocialNetwork)) {
            foreach ($this->rSocialNetwork as $value) {
                if ($value->type_network == $type_network) {
                    return $value->value;
                }
            }
        }
        return '';
    }

    /**
     * Get social network information
     * @return String
     */
    public function getSocialNetworkInfo() {
        $retVal = array();
        if (isset($this->rSocialNetwork)) {
            foreach ($this->rSocialNetwork as $value) {
                $retVal[] = SocialNetworks::TYPE_NETWORKS[$value->type_network] . ": $value->value";
            }
        }
        return implode('<br>', $retVal);
    }
    
    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Get status array
     * @return Array Array status of debt
     */
    public static function getArrayStatus() {
        return array(
            self::STATUS_INACTIVE       => DomainConst::CONTENT00408,
            self::STATUS_ACTIVE         => DomainConst::CONTENT00407,
            self::STATUS_CONVERTED      => DomainConst::CONTENT00556,
        );
    }
    
    /**
     * Create model from API call
     * @param Json $root Json object
     */
    public static function createFromAPI($root) {
        $model = new TemporaryPatients('create');
        $model->name        = CommonProcess::getValueFromJson($root, DomainConst::KEY_NAME);
        $model->phone       = CommonProcess::getValueFromJson($root, DomainConst::KEY_PHONE);
        $model->content     = CommonProcess::getValueFromJson($root, DomainConst::KEY_CONTENT);
        $model->book_date   = CommonProcess::getValueFromJson($root, DomainConst::KEY_DATE);
        $model->source_id   = Settings::getItemValue(Settings::KEY_SOURCE_INFO_WEBSITE);
        if ($model->save()) {
            if (isset($root->email)) {
                SocialNetworks::insertOne($root->email, $model->id,
                        SocialNetworks::TYPE_TEMP_PATIENT, SocialNetworks::TYPE_NETWORK_EMAIL);
            }
            Loggers::info('Create temporary patient success', $model->id,
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            return true;
        } else {
            Loggers::info('Create temporary patient failed', CommonProcess::json_encode_unicode($model->getErrors()),
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        return false;
    }
    /**
     * Create model from API (Mobile app) call
     * @param Json $root Json object
     * @param String $customerId Id of customer
     */
    public static function createFromAPIApp($root, $customerId = '') {
        $model = new TemporaryPatients('create') ;
        $model->name        = CommonProcess::getValueFromJson($root, DomainConst::KEY_NAME);
        $model->phone       = CommonProcess::getValueFromJson($root, DomainConst::KEY_PHONE);
        $model->content     = CommonProcess::getValueFromJson($root, DomainConst::KEY_CONTENT);
        $model->book_date   = CommonProcess::getValueFromJson($root, DomainConst::KEY_DATE);
        $model->source_id   = Settings::getItemValue(Settings::KEY_SOURCE_INFO_APP);
        $model->customer_id = $customerId;
        if ($model->save()) {
            if (isset($root->email)) {
                SocialNetworks::insertOne($root->email, $model->id,
                        SocialNetworks::TYPE_TEMP_PATIENT, SocialNetworks::TYPE_NETWORK_EMAIL);
            }
            Loggers::info('Create temporary patient success', $model->id,
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            return true;
        } else {
            Loggers::info('Create temporary patient failed', CommonProcess::json_encode_unicode($model->getErrors()),
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        return false;
    }

}
