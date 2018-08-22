<?php

/**
 * This is the model class for table "news_categories".
 *
 * The followings are the available columns in table 'news_categories':
 * @property integer $id            Id
 * @property string $name           Name
 * @property string $description    Description
 * @property integer $parent_id     Id of parent category
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 * 
 * The followings are the available model relations:
 * @property Users                  $rCreatedBy         User created this record
 * @property News[]                 $rNews              List news belong this category
 * @property NewsCategories         $rParent            Parent model
 * @property NewsCategories[]       $rChildren          List children models
 */
class NewsCategories extends BaseActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return NewsCategories the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'news_categories';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, created_date', 'required'),
            array('parent_id, status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('created_by', 'length', 'max' => 10),
            array('description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description, parent_id, status, created_date, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rNews' => array(
                self::HAS_MANY, 'News', 'category_id',
                'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
            ),
            'rParent'   => array(
                self::BELONGS_TO, 'NewsCategories', 'parent_id',
                'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
            ),
            'rChildren' => array(
                self::HAS_MANY, 'NewsCategories', 'parent_id',
                'on'    => 'status !=' . DomainConst::DEFAULT_STATUS_INACTIVE,
            ),
            'rCreatedBy' => array(self::BELONGS_TO, 'Users', 'created_by'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'name'          => DomainConst::CONTENT00426,
            'description'   => DomainConst::CONTENT00062,
            'parent_id'     => DomainConst::CONTENT00427,
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('status', $this->status);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('created_by', $this->created_by, true);

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
     * Loads the items from the database
     * @param type $emptyOption boolean the item is empty
     * @return type List data
     */
    public static function loadItems($emptyOption = false) {
        $_items = array();
        if ($emptyOption) {
            $_items[""] = "";
        }
        $models = self::model()->findAll(array(
            'order' => 'id ASC',
        ));
        foreach ($models as $model) {
            if (!isset($model->parent_id)) {
                $_items[$model->id] = $model->name;
                if (!empty($model->rChildren)) {
                    foreach ($model->rChildren as $child) {
                        $_items[$child->id] = '---> ' . $child->name;
                    }
                }
            }
        }
        return $_items;
    }
        
    //-----------------------------------------------------
    // Parent override methods
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
            if (empty($this->created_date)) {
                $this->created_date = CommonProcess::getCurrentDateTime();
            }
        } else {                    // Update
            
        }
        return parent::beforeSave();
    }
}
