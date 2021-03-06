<?php

/**
 * This is the model class for table "labo_producers".
 *
 * The followings are the available columns in table 'labo_producers':
 * @property string $id             Labo producer id
 * @property string $name           Labo producer name
 * @property string $address        Labo producer address
 * @property string $phone          Labo producer phone
 * @property string $admin_id       Labo producer manager id
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users          $rCreatedBy     User created this record
 * @property Users          $rAdmin         User manage this labo producer
 * @property LaboServices[] $rLaboServices  Labo services belong to this record
 */
class LaboProducers extends BaseActiveRecord {
    //-----------------------------------------------------
    // Autocomplete fields
    //-----------------------------------------------------
    public $autocomplete_name_admin;

    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_ACTIVE         = 1;
    const STATUS_INACTIVE       = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaboProducers the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'labo_producers';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, address, phone', 'required', 'on' => 'create,update'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, address, phone, admin_id, status, created_date, created_by', 'safe'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rAdmin' => array(self::BELONGS_TO, 'Users', 'admin_id'),
            'rCreatedBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
            'rLaboServices' => array(
                self::HAS_MANY, 'LaboSercices', 'producer_id',
                'on' => 't.status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => DomainConst::KEY_ID,
            'name'          => DomainConst::CONTENT00042,
            'address'       => DomainConst::CONTENT00045,
            'phone'         => DomainConst::CONTENT00170,
            'admin_id'      => DomainConst::CONTENT00414,
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

        $criteria->compare('name', $this->name, true);
        $criteria->compare('address', $this->address, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('admin_id', $this->admin_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_by', $this->created_by);

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
     * Before save
     * @return parent
     */
    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_by = Yii::app()->user->id;
        }
        return parent::beforeSave();
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * get created date
     * @return date
     */
    public function getCreatedDate() {
        return CommonProcess::convertDateTime($this->created_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_11);
    }

    /**
     * get full name of created by users
     * @return string
     */
    public function getCreatedBy() {
        return !empty($this->rCreatedBy) ? $this->rCreatedBy->getFullName() : '';
    }

    /**
     * get full name of created by users
     * @return string
     */
    public function getAdmin() {
        return !empty($this->rAdmin) ? $this->rAdmin->getFullName() : '';
    }

    /**
     * get field name of table
     * @param string $fieldName
     * @return string
     */
    public function getField($fieldName) {
        return !empty($this->$fieldName) ? $this->$fieldName : '';
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * 
     * @param type $emptyOption
     * @return string
     */
    public static function loadItems() {
        $_items = array();
        $criteria = new CDbCriteria;
        $criteria->compare('t.status', self::STATUS_ACTIVE);
        $criteria->order = 't.id ASC';
        $models = self::model()->findAll($criteria);
        foreach ($models as $model) {
            $_items[$model->id] = $model->name;
        }
        return $_items;
    }

}
