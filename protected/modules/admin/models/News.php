<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property string $id                 Id
 * @property string $content            Content
 * @property string $description        Description
 * @property integer $category_id       Id of category
 * @property integer $status            Status
 * @property string $created_date       Created date
 * @property string $created_by         Created by
 * 
 * The followings are the available model relations:
 * @property Users                  $rCreatedBy         User created this record
 * @property NewsCategories         $rCategory          Category belong to
 * @property Comments[]             $rComments          List comments of news
 */
class News extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_INACTIVE       = 0;
    const STATUS_ACTIVE         = 1;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return News the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'news';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('content, category_id', 'required'),
            array('category_id, status', 'numerical', 'integerOnly' => true),
            array('created_by', 'length', 'max' => 10),
            array('description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('content, status, description', 'safe'),
            array('id, content, description, category_id, status, created_date, created_by, description', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rCreated' => array(self::BELONGS_TO, 'Users', 'created_by'),
            'rCategory' => array(
                self::BELONGS_TO, 'NewsCategories', 'category_id',
                'on' => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
            ),
            'rComments' => array(
                self::HAS_MANY, 'Comments', 'relate_id',
                'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE
                            . ' AND type =' . Comments::TYPE_NEWS,
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'content'       => DomainConst::CONTENT00428,
            'description'   => DomainConst::CONTENT00062,
            'category_id'   => DomainConst::CONTENT00426,
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

        $criteria->compare('id', $this->id);
        $criteria->compare('content', $this->content, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('category_id', $this->category_id);
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

    /**
     * get field of table
     * @param string $field
     * @return string
     */
    public function getField($field = 'id') {
        return !empty($this->$field) ? $this->$field : '';
    }

    /**
     * get array status
     * @return array
     */
    public function getArrayStatus() {
        return [
            self::STATUS_ACTIVE     => 'Hoạt động',
            self::STATUS_INACTIVE   => 'Không hoạt động'
        ];
    }

    /**
     * get status
     * @return string
     */
    public function getStatus() {
        $aStatus = $this->getArrayStatus();
        return !empty($aStatus[$this->status]) ? $aStatus[$this->status] : '';
    }

    /**
     * get full name of create by
     * @return string
     */
    public function getCreatedBy() {
        $mCreatedBy = $this->rCreated;
        return !empty($mCreatedBy) ? $mCreatedBy->getFullName() : '';
    }

    /**
     * get created date
     * @return date
     */
    public function getCreatedDate() {
        return CommonProcess::convertDateTime($this->created_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_11);
    }

    /**
     * handle before save
     */
    public function handleBeforeSave() {
        $this->created_by = Yii::app()->user->id;
    }

    /**
     * get array model news by status
     * @param int $status
     * @return array model
     */
    public function getArrayNews($status = News::STATUS_ACTIVE, $category = '') {
        $aNews = [];
        try {
            $criteria = new CDbCriteria;
            $criteria->compare('status', $status);
            if (!empty($category)) {
                $criteria->compare('category_id', $category);
            }
            $criteria->order = 't.id DESC';
            $aNews = News::model()->findAll($criteria);
        } catch (Exception $ex) {
            Loggers::error(DomainConst::CONTENT00214, $ex->getMessage(), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        
        return $aNews;
    }
    
    /**
     * Get array comments
     * @return Array List comments
     */
    public function getArrayComments() {
        $retVal = array();
        if (isset($this->rComments)) {
            $retVal = $this->rComments;
        }
        
        return $retVal;
    }

    /**
     * Check this model is a new model. That mean created_date between today and 3 days ago
     * @return boolean True if model is a new model, False otherwise
     */
    public function isNew() {
        $retVal = false;
        $today = CommonProcess::getCurrentDateTime();
        $lastDate = CommonProcess::getMinusDate(3);

        if ((DateTimeExt::compare($this->created_date, $lastDate) >= 0)
                && (DateTimeExt::compare($this->created_date, $today) <= 0)) {
            $retVal = true;
        }
        
        return $retVal;
    }
}
