<?php

/**
 * This is the model class for table "page_counts".
 *
 * The followings are the available columns in table 'page_counts':
 * @property string $id                 Id of record
 * @property string $module             Name of module
 * @property string $controller         Name of controller
 * @property string $action             Name of action
 * @property integer $count             Count of view
 * @property string $created_date       Created date
 * @property string $updated_date       Updated date
 */
class PageCounts extends BaseActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return PageCounts the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'page_counts';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('module', 'required'),
            array('count', 'numerical', 'integerOnly' => true),
            array('module, controller, action', 'length', 'max' => 255),
            array('created_date, updated_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, module, controller, action, count, created_date, updated_date', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['module']       = 'Module';
        $labels['controller']   = 'Controller';
        $labels['count']        = 'View';
        $labels['action']       = 'Action';
        $labels['updated_date'] = 'Time update';
        return $labels;
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
        $criteria->compare('module', $this->module, true);
        $criteria->compare('controller', $this->controller, true);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('count', $this->count);
        $criteria->compare('created_date', $this->created_date, true);
        $criteria->compare('updated_date', $this->updated_date, true);
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
        if ($this->isNewRecord) {
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        } else {
            $this->updated_date = CommonProcess::getCurrentDateTime();
        }
        
        return parent::beforeSave();
    }
    
    /**
     * Update count of view
     * @param String $module        Name of module
     * @param String $controller    Name of controller
     * @param String $action        Name of action
     */
    public static function updateView($module, $controller, $action) {
        $model = self::model()->findByAttributes(array(
            'module'        => $module,
            'controller'    => $controller,
            'action'        => $action,
        ));
        if ($model) {
            $model->count += 1;
        } else {
            $model = new PageCounts('create');
            $model->module      = $module;
            $model->controller  = $controller;
            $model->action      = $action;
            $model->count       = 1;
        }
        $model->save();
    }
    
    /**
     * Get view number of page
     * @param String $module        Name of module
     * @param String $controller    Name of controller
     * @param String $action        Name of action
     * @return int Number of view
     */
    public static function getPageView($module, $controller, $action) {
        $model = self::model()->findByAttributes(array(
            'module'        => $module,
            'controller'    => $controller,
            'action'        => $action,
        ));
        if ($model) {
            return $model->count;
        }
        return 0;
    }

}
