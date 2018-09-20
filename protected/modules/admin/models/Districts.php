<?php

/**
 * This is the model class for table "districts".
 *
 * The followings are the available columns in table 'districts':
 * @property integer $id                Id of district
 * @property integer $city_id           Id of city
 * @property string $name               Name of district
 * @property string $short_name         Short name of district
 * @property integer $status            Status
 * @property string $slug               Slug
 * @property string $code_no            Code no
 * 
 * The followings are the available model relations:
 * @property Cities                         $rCity              City model
 * @property Wards                          $rWard              List ward belong to district
 * @property Agents[]                       $rAgent             List agents belong to district
 * @property Customers[]                    $rCustomer          List customers belong to district
 * @property Users[]                        $rUsers             List users belong to district
 */
class Districts extends BaseActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Districts the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'districts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('city_id, name', 'required'),
            array('city_id, status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 200),
            array('short_name, slug', 'length', 'max' => 150),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, city_id, name, short_name, status, slug, code_no', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'rCity' => array(self::BELONGS_TO, 'Cities', 'city_id'),
            'rWard' => array(self::HAS_MANY, 'Wards', 'district_id',
                'on' => 'status = 1',
                'order' => 'name ASC',
            ),
            'rUsers' => array(self::HAS_MANY, 'Users', 'district_id',
                'on' => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
                'order' => 'name ASC',
            ),
            'rAgent' => array(self::HAS_MANY, 'Agents', 'district_id',
                'on' => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
                'order' => 'name ASC',
            ),
            'rCustomer' => array(self::HAS_MANY, 'Customers', 'district_id',
                'on' => 'status != ' . DomainConst::DEFAULT_STATUS_INACTIVE,
                'order' => 'name ASC',
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'city_id'       => DomainConst::CONTENT00093,
            'name'          => DomainConst::CONTENT00042,
            'short_name'    => DomainConst::CONTENT00092,
            'status'        => DomainConst::CONTENT00026,
            'slug'          => DomainConst::CONTENT00095,
            'code_no'       => DomainConst::CONTENT00444,
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
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('short_name', $this->short_name, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('code_no', $this->code_no);
        $criteria->order = 'name ASC';

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => Settings::getListPageSize(),
            ),
        ));
    }

    //-----------------------------------------------------
    // Parent override methods
    //-----------------------------------------------------
    /**
     * Override before delete method
     * @return Parent result
     */
    protected function beforeDelete() {
        $retVal = true;
        // Check foreign table wards
        $wards = Wards::model()->findByAttributes(array('district_id' => $this->id));
        if (count($wards) > 0) {
            $retVal = false;
        }
        // Check foreign table agents
        $agents = Agents::model()->findByAttributes(array('district_id' => $this->id));
        if (count($agents) > 0) {
            $retVal = false;
        }
        // Check foreign table customers
        $customers = Customers::model()->findByAttributes(array('district_id' => $this->id));
        if (count($customers) > 0) {
            $retVal = false;
        }
        // Check foreign table users
        $users = Users::model()->findByAttributes(array('district_id' => $this->id));
        if (count($users) > 0) {
            $retVal = false;
        }
        return $retVal;
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------    
    /**
     * Loads the application items for the specified type from the database
     * @param type $city_id Id of city
     * @param type $emptyOption boolean the item is empty
     * @return type List data
     */
    public static function loadItems($city_id = '', $emptyOption = false) {
        $_items = array();
        if ($emptyOption) {
            $_items[""] = "";
        }
        $models = self::model()->findAll(array(
            'order' => 'name ASC',
        ));
        foreach ($models as $model) {
            if (!empty($city_id)) {
                if ($model->city_id == $city_id) {
                    $_items[$model->id] = $model->name . ' - ' . $model->rCity->name;
                }
            } else {
                $_items[$model->id] = $model->name . ' - ' . $model->rCity->name;
            }
        }
        return $_items;
    }

    /**
     * Get all wards in district
     * @param Int $id   District id
     * @return CArrayDataProvider
     */
    public function getWards($id) {
        return new CArrayDataProvider(self::model()->findByPk($id)->rWard, array(
            'id' => 'wards',
            'sort' => array(
                'attributes' => array(
                    'id', 'name', 'short_name', 'slug',
                ),
            ),
            'pagination' => array(
                'pageSize' => Settings::getListPageSize(),
            ),
        ));
    }
    
    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Get model by name
     * @param type $name Name of model
     * @return Object Model if found, NULL otherwise
     */
    public static function getModelByName($name) {
        $nameArr = array(
            'Q1' => 'Quận 1',
            'Q2' => 'Quận 2',
            'Q3' => 'Quận 3',
            'Q4' => 'Quận 4',
            'Q5' => 'Quận 5',
            'Q6' => 'Quận 6',
            'Q7' => 'Quận 7',
            'Q8' => 'Quận 8',
            'Q9' => 'Quận 9',
            'Q10' => 'Quận 10',
            'Q11' => 'Quận 11',
            'Q12' => 'Quận 12',
            'Q.1' => 'Quận 1',
            'Q.2' => 'Quận 2',
            'Q.3' => 'Quận 3',
            'Q.4' => 'Quận 4',
            'Q.5' => 'Quận 5',
            'Q.6' => 'Quận 6',
            'Q.7' => 'Quận 7',
            'Q.8' => 'Quận 8',
            'Q.9' => 'Quận 9',
            'Q.10' => 'Quận 10',
            'Q.11' => 'Quận 11',
            'Q.12' => 'Quận 12',
            'TP.Mỹ Tho' => 'Thành phố Mỹ Tho',
            'Trà Vinh' => 'Thành phố Trà Vinh',
            'Bến Tre' => 'Thành phố Bến Tre',
        );
        $name = str_replace('Q. ', '', $name);
        $name = str_replace('H. ', '', $name);
        if (isset($nameArr[$name])) {
            $name = $nameArr[$name];
        }
        $criteria = new CDbCriteria();
        $criteria->addSearchCondition('t.name', $name, true);
        $model = self::model()->find($criteria);
        return $model;
    }

}
