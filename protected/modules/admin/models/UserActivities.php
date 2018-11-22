<?php

/**
 * This is the model class for table "user_activities".
 *
 * The followings are the available columns in table 'user_activities':
 * @property string $id                 Id of record
 * @property string $session            Session
 * @property string $ipaddress          IP address
 * @property string $module             Name of module
 * @property string $controller         Name of controller
 * @property string $action             Name of action
 * @property string $browser            Name of browser
 * @property string $os                 Name of operation system
 * @property string $details            Detail
 * @property integer $status            Status
 * @property string $created_date       Created date
 * @property string $created_by         Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 */
class UserActivities extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE               = '0';
    /** Active */
    const STATUS_ACTIVE                 = '1';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserActivities the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'user_activities';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('session, ipaddress, module, browser, os', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('session, browser, os', 'length', 'max' => 100),
            array('ipaddress', 'length', 'max' => 50),
            array('module, controller, action', 'length', 'max' => 255),
            array('created_by', 'length', 'max' => 10),
            array('details, created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, session, ipaddress, module, controller, action, browser, os, details, status, created_date, created_by', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        $relation = parent::relations();
        return $relation;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        $labels = parent::attributeLabels();
        $labels['session']      = 'Session';
        $labels['ipaddress']    = 'IP Address';
        $labels['module']       = 'Module';
        $labels['controller']   = 'Controller';
        $labels['action']       = 'Action';
        $labels['browser']      = 'Browser';
        $labels['os']           = 'Operation System';
        $labels['details']      = 'Detail';
        $labels['created_by']   = 'User';
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
        $criteria->compare('session', $this->session, true);
        $criteria->compare('ipaddress', $this->ipaddress, true);
        $criteria->compare('module', $this->module, true);
        $criteria->compare('controller', $this->controller, true);
        $criteria->compare('action', $this->action, true);
        $criteria->compare('browser', $this->browser, true);
        $criteria->compare('os', $this->os, true);
        $criteria->compare('details', $this->details, true);
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
        if ($this->isNewRecord) {
            $this->created_by   = CommonProcess::getCurrentUserId();
            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        }
        
        return parent::beforeSave();
    }
    
    /**
     * Return status string
     * @return string Status value as string
     */
    public function getStatus() {
        if (isset(self::getArrayStatus()[$this->status])) {
            return self::getArrayStatus()[$this->status];
        }
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
        );
    }
    
    /**
     * Insert 1 record
     */
    public static function insertOne($module) {
        $model = new UserActivities('create');
        $model->session      = CommonProcess::getSessionId();
        $model->ipaddress    = CommonProcess::getUserIP();
        $model->module       = $module;
        $model->controller   = isset(Yii::app()->controller->id) ? Yii::app()->controller->id : '';
        $model->action       = isset(Yii::app()->controller->action->id) ? Yii::app()->controller->action->id : '';
        $model->browser      = CommonProcess::getBrowser();
        $model->os           = CommonProcess::getOS();
        if (($module == 'admin') && ($model->controller == 'userActivities') && ($model->action == 'index')) {
            return;
        }
        if (!$model->save()) {
            Loggers::error('Create failed', CommonProcess::json_encode_unicode($model->getErrors()),
                    __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
    }

}
