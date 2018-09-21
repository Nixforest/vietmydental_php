<?php

/**
 * This is the model class for table "comments".
 *
 * The followings are the available columns in table 'comments':
 * @property string $id             Id of record
 * @property string $content        Content
 * @property integer $relate_id     Id relate record
 * @property integer $type          Type of comment
 * @property integer $status            Status
 * @property string $created_date       Created date
 * @property string $created_by         Created by
 * 
 * The followings are the available model relations:
 * @property Users                  $rCreatedBy         User created this record
 * @property News                   $rNews              News relate with this record
 */
class Comments extends BaseActiveRecord {
    //-----------------------------------------------------
    // Type of relation
    //-----------------------------------------------------
    const TYPE_NEWS             = 1;
    const TYPE_CHILD            = 2;
    
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_INACTIVE       = 0;
    const STATUS_ACTIVE         = 1;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Comments the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'comments';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content', 'required'),
            array('relate_id, type, status', 'numerical', 'integerOnly' => true),
            array('created_by', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, content, relate_id, type, status, created_date, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rCreatedBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
            'rNews' => array(self::BELONGS_TO, 'News', 'relate_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'content'       => DomainConst::CONTENT00428,
            'relate_id'     => DomainConst::CONTENT00446,
            'type'          => DomainConst::CONTENT00063,
            'status'        => DomainConst::CONTENT00026,
            'created_date'  => DomainConst::CONTENT00010,
            'created_by'    => DomainConst::CONTENT00054,
        );
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
        $criteria->compare('content', $this->content, true);
        $criteria->compare('relate_id', $this->relate_id);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);
        $criteria->order = 't.id DESC';

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
     * Override before save method
     * @return Parent result
     */
    public function beforeSave() {
        $userId = isset(Yii::app()->user) ? Yii::app()->user->id : '';
        if ($this->isNewRecord) {   // Add
            // Handle created by
            if (empty($this->created_by)) {
                $this->created_by = $userId;
            }
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        } else {                    // Update
        }
        return parent::beforeSave();
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Get relation information
     * @return String Html string
     */
    public function getRelateInfo() {
        $retVal = '';
        $name = '';
        switch ($this->type) {
            case self::TYPE_NEWS:
                $retVal = Yii::app()->createAbsoluteUrl('admin/news/view', array(
                    'id'    => $this->relate_id,
                ));
                $name = $this->rNews->description;
                break;
            case self::TYPE_CHILD:
                $retVal = Yii::app()->createAbsoluteUrl('admin/comments/view', array(
                    'id'    => $this->relate_id,
                ));
                $name = 'Bình luận của ' . $this->getCreator() . ' vào ' . $this->created_date;
                break;

            default:
                break;
        }
        
        return '<a href="' . $retVal . '">' . $name . '</a>';;
    }
    
    /**
     * Get type string
     * @return string
     */
    public function getType() {
        if (isset(self::getArrayTypes()[$this->type])) {
            return self::getArrayTypes()[$this->type];
        }
        return '';
    }
    
    /**
     * Get creator
     * @return String Name of creator
     */
    public function getCreator() {
        return isset($this->rCreatedBy) ? $this->rCreatedBy->getFullName() : '';
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Get array status
     * @return array
     */
    public static function getArrayStatus() {
        return [
            self::STATUS_ACTIVE     => 'Hoạt động',
            self::STATUS_INACTIVE   => 'Không hoạt động'
        ];
    }
    
    /**
     * Get array types
     * @return Array
     */
    public static function getArrayTypes() {
        return [
            self::TYPE_NEWS     => 'Comment cha',
            self::TYPE_CHILD    => 'Comment con',
        ];
    }
}
