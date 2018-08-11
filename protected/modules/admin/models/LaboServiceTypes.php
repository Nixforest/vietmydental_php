<?php

/**
 * This is the model class for table "labo_service_types".
 *
 * The followings are the available columns in table 'labo_service_types':
 * @property string $id             Labo service type id
 * @property string $name           Labo service type name
 * @property string $description    Labo service type description
 * @property integer $status        Status of record
 * @property string $created_date   Created date
 * @property integer $created_by    Created by
 *
 * The followings are the available model relations:
 * @property Users          $rCreatedBy     User created this record
 * @property LaboServices[] $rLaboServices  Labo services belong to this record
 */
class LaboServiceTypes extends BaseActiveRecord {

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaboServiceTypes the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'labo_service_types';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required', 'on' => 'update,create'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description, status, created_date, created_by', 'safe'),
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
            'rLaboServices' => array(
                self::HAS_MANY, 'LaboSercices', 'type_id',
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
            'description'   => DomainConst::CONTENT00062,
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
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_by', $this->created_by);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    //-----------------------------------------------------
    // Parent methods
    //-----------------------------------------------------
    /**
     * Before save
     * @return parent
     */
    public function beforeSave() {
        $userId = isset(Yii::app()->user) ? Yii::app()->user->id : '';
        if ($this->isNewRecord) {
            // Handle created by
            if (empty($this->created_by)) {
                $this->created_by = $userId;
            }
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
        return CommonProcess::convertDateTime($this->created_date,
                DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_11);
    }

    /**
     * get array status of record
     * @return array
     */
    public function getArrayStatus() {
        return [
            self::STATUS_ACTIVE => DomainConst::CONTENT00407,
            self::STATUS_INACTIVE => DomainConst::CONTENT00408,
        ];
    }

    /**
     * get full name of created by users
     * @return string
     */
    public function getCreatedBy() {
        return !empty($this->rCreatedBy) ? $this->rCreatedBy->getFullName() : '';
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
