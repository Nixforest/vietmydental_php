<?php

/**
 * This is the model class for table "refer_codes".
 *
 * The followings are the available columns in table 'refer_codes':
 * @property string $id
 * @property string $code
 * @property string $object_id
 * @property integer $status
 * @property integer $type
 */
class ReferCodes extends CActiveRecord
{
    //-----------------------------------------------------
    // Type of relation
    //-----------------------------------------------------
    const TYPE_NOT_SELECTED_YET     = DomainConst::NUMBER_ZERO_VALUE;
    const TYPE_PRINTED              = DomainConst::NUMBER_TWO_VALUE;
    /** 1 [customer] has 1 [refer code] */
    const TYPE_CUSTOMER             = DomainConst::NUMBER_ONE_VALUE;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReferCodes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'refer_codes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, type', 'required'),
			array('status, type', 'numerical', 'integerOnly'=>true),
			array('object_id', 'length', 'max'=>11),
			array('code', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, object_id, status, type', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
//                    'rCustomer' => array(
//                        self::HAS_ONE, 'Customers', 'object_id',
////                        'on' => 'type = ' . self::TYPE_CUSTOMER,
//                    ),
                    'rCustomer' => array(
                        self::BELONGS_TO, 'Customers', 'object_id',
                    ),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'object_id' => 'Object',
			'status' => 'Status',
			'type' => 'Type',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('object_id',$this->object_id,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type);
                $criteria->order = 'id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => Settings::getListPageSize(),
                        ),
		));
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Get value of id
     * @return String
     */
    public function getId() {
        return CommonProcess::generateID(DomainConst::REFER_CODE_ID_PREFIX, $this->id);
    }
    
    /**
     * Generate url of this refer code
     * @return String
     */
    public function generateURL() {
        $url = '';
        switch ($this->type) {
            case self::TYPE_CUSTOMER:
                $url = 'http://' . Settings::getDomain() . "/index.php/front/customer/view/code/" . $this->code;

                break;
            case self::TYPE_NOT_SELECTED_YET:
                $url = 'http://' . Settings::getDomain() . "/index.php/front/customer/view/code/" . $this->code;

                break;

            default:
                $url = 'http://' . Settings::getDomain() . "/index.php/front/customer/view/code/" . $this->code;
                break;
        }
        return $url;
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
        $model = new ReferCodes();
        $model->code        = $code;
        $model->object_id   = $object_id;
        $model->type        = $type;
        $model->save();
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
            if ($model->type == self::TYPE_PRINTED) {
                $model->object_id = $object_id;
                $model->type = $type;
                $model->save();
            } else if ($model->type == self::TYPE_NOT_SELECTED_YET) {
                throw new Exception(DomainConst::CONTENT00299);
            } else if ($model->object_id == $object_id) {
                return;
            } else {
                throw new Exception(DomainConst::CONTENT00268);
            }
        } else {
            throw new Exception(DomainConst::CONTENT00269);
        }
    }
}