<?php

/**
 * This is the model class for table "refer_codes".
 *
 * The followings are the available columns in table 'refer_codes':
 * @property string $id             Id of record
 * @property string $code           Code
 * @property string $object_id      Id of object
 * @property integer $status        Status
 * @property integer $type          Type of code
 * 
 * The followings are the available model relations:
 * @property Customers              $rCustomer              Customer model
 */
class ReferCodes extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = '0';
    /** Active */
    const STATUS_ACTIVE                 = '1';
    /** Print */
    const STATUS_PRINTED                = '2';
    /** Connected */
//    const STATUS_CONNECTED              = '3';
    
    //-----------------------------------------------------
    // Type of relation
    //-----------------------------------------------------
    /** 1 [customer] has 1 [refer code] */
    const TYPE_CUSTOMER             = DomainConst::NUMBER_ONE_VALUE;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ReferCodes the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'refer_codes';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, type', 'required'),
            array('status, type', 'numerical', 'integerOnly' => true),
            array('object_id', 'length', 'max' => 11),
            array('code', 'length', 'max' => 32),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, code, object_id, status, type', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rCustomer' => array(
                self::BELONGS_TO, 'Customers', 'object_id',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        $label = parent::attributeLabels();
        $label['code']      = 'Code';
        $label['object_id'] = 'Object';
        $label['type']      = DomainConst::CONTENT00568;
        return $label;
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
        $criteria->compare('code', $this->code, true);
        $criteria->compare('object_id', $this->object_id, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('type', $this->type);
        $criteria->order = 'id DESC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Settings::getListPageSize(),
            ),
        ));
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Generate url of this refer code
     * @return String
     */
    public function generateURL() {
        $url = '';
        switch ($this->type) {
            case self::TYPE_CUSTOMER:
                $url = Yii::app()->createAbsoluteUrl('front/customer/view', array(
                    'code'    => $this->code,
                ));
                break;

            default:
                break;
        }
        return $url;
    }
    
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
     * Return type string
     * @return string Type value as string
     */
    public function getType() {
        if (isset(self::getArrayType()[$this->type])) {
            return self::getArrayType()[$this->type];
        }
        return '';
    }
    
    /**
     * Get object link
     * @return type
     */
    public function getObject() {
        $url = '';
        $name = '';
        switch ($this->type) {
            case self::TYPE_CUSTOMER:
                $url = Yii::app()->createAbsoluteUrl('admin/customers/view', array(
                    'id'    => $this->object_id,
                ));
                $name = $this->rCustomer->getName();
                break;

            default:
                break;
        }
        return '<a href="' . $url . '">' . $name . '</a>';
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Insert new record
     * @param String $code      Code value
     * @param Int $object_id    Object id
     * @param String $type      Type of relation
     */
    public static function insertOne($code, $object_id, $type) {
        $model              = new ReferCodes();
        $model->code        = $code;
        $model->object_id   = $object_id;
        $model->type        = $type;
        
        if ($model->save()) {
            Loggers::info('Create success', $model->id, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        } else {
            Loggers::error('Create failed', CommonProcess::json_encode_unicode($model->getErrors()), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
    }

    /**
     * Connect an object with and Code value
     * @param String $code      Code value
     * @param Int $object_id    Object id
     * @param String $type      Type of relation
     */
    public static function connect($code, $object_id, $type) {
        $model = self::model()->findByAttributes(array(
            'code' => $code,
        ));
        if ($model) {
            // Connect
            if ($model->status == self::STATUS_PRINTED) {
                // Case Refer code was printed
                $model->object_id   = $object_id;
                $model->type        = $type;
                $model->save();
            } else if ($model->status == self::STATUS_ACTIVE) {
                // Case Refer code was not printed
                throw new Exception(DomainConst::CONTENT00299);
            } else if ($model->object_id == $object_id) {
                // Connected before
                return;
            } else {
                throw new Exception(DomainConst::CONTENT00268);
            }
        } else {
            throw new Exception(DomainConst::CONTENT00269);
        }
    }

    /**
     * Get customer object by qr code
     * @param String $code QR code
     * @return Customers Model customer
     */
    public static function getCustomerByQRCode($code) {
        $model = self::model()->findByAttributes(array(
            'code' => $code,
        ));
        if ($model) {
            if (isset($model->rCustomer)) {
                return $model->rCustomer;
            }
        }
        return NULL;
    }
    
    /**
     * Get status array
     * @return Array Array status of record
     */
    public static function getArrayStatus() {
        return array(
            self::STATUS_INACTIVE       => DomainConst::CONTENT00408,
            self::STATUS_ACTIVE         => DomainConst::CONTENT00567,
            self::STATUS_PRINTED        => DomainConst::CONTENT00565,
        );
    }
    
    /**
     * Get type array
     * @return Array Array type of refer code
     */
    public static function getArrayType() {
        return array(
            self::TYPE_CUSTOMER       => DomainConst::CONTENT00135,
        );
    }

}
