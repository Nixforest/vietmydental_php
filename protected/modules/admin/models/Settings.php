<?php

/**
 * This is the model class for table "settings".
 *
 * The followings are the available columns in table 'settings':
 * @property string $id
 * @property string $updated
 * @property string $key
 * @property string $value
 * @property string $description
 */
class Settings extends BaseActiveRecord
{
    //-----------------------------------------------------
    // ++ Define keys
    //-----------------------------------------------------
    /** Key General setting */
    const KEY_GENERAL_SETTINGS                  = 'general_settings';
    /** Key App setting */
    const KEY_APP_SETTINGS                      = 'app_settings';
    /** Key Mail setting */
    const KEY_MAIL_SETTINGS                     = 'mail_settings';
    
    /* --- General settings --- */
    /** Key website title */
    const KEY_TITLE                             = 'WEBSITE_TITLE';
    /** Key Page size of list */
    const KEY_LIST_PAGE_SIZE                    = 'LIST_PAGE_SIZE';
    /** Key Min of password length */
    const KEY_PASSWORD_LEN_MIN                  = 'PASSWORD_LEN_MIN';
    /** Key Max of password length */
    const KEY_PASSWORD_LEN_MAX                  = 'PASSWORD_LEN_MAX';
    
    /* --- App settings --- */
    /** Key Mobile app version iOS */
    const KEY_APP_MOBILE_VERSION_IOS            = 'APP_MOBILE_VERSION_IOS';
    /** Key Page size of api list */
    const KEY_APP_API_LIST_PAGE_SIZE            = 'APP_API_LIST_PAGE_SIZE';
    
    /* --- Email settings --- */
    /** Key admin email */
    const KEY_ADMIN_EMAIL                       = 'ADMIN_EMAIL';
    /** Key Email main subject */
    const KEY_EMAIL_MAIN_SUBJECT                = 'EMAIL_MAIN_SUBJECT';
    /** Key Email transport type */
    const KEY_EMAIL_TRANSPORT_TYPE              = 'EMAIL_TRANSPORT_TYPE';
    /** Key Email host */
    const KEY_EMAIL_TRANSPORT_HOST              = 'EMAIL_TRANSPORT_HOST';
    /** Key Email username */
    const KEY_EMAIL_TRANSPORT_USERNAME          = 'EMAIL_TRANSPORT_USERNAME';
    /** Key Email password */
    const KEY_EMAIL_TRANSPORT_PASSWORD          = 'EMAIL_TRANSPORT_PASSWORD';
    /** Key Email transport port */
    const KEY_EMAIL_TRANSPORT_PORT              = 'EMAIL_TRANSPORT_PORT';
    /** Key Email transport encryption */
    const KEY_EMAIL_TRANSPORT_ENCRYPTION        = 'EMAIL_TRANSPORT_ENCRYPTION';
    
    /* --- Others settings --- */
    /** Key Ajax template value */
    const KEY_AJAX_TEMPLATE_VALUE               = 'AJAX_TEMPLATE_VALUE';
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('updated, key, value', 'required'),
			array('key', 'length', 'max'=>255),
			array('description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, updated, key, value, description', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'updated' => 'Updated',
			'key' => 'Key',
			'value' => 'Value',
			'description' => 'Description',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('description',$this->description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Settings the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------    
    /**
     * Loads the application items for the specified type from the database
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
            $_items[$model->key] = $model;
        }
        return $_items;
    }
    
    /**
     * Update setting value
     * @param String $id Id of setting
     * @param String $value Value of setting
     */
    public static function updateSetting($id, $value) {
        self::model()->updateByPk(
                $id,
                array(
                    'value' => $value,
                )
            );
    }
    
    /**
     * Save setting
     * @param String $key   Key string
     * @param String $value Value string
     */
    public static function saveSetting($key, $value) {
        $criteria = new CDbCriteria();
        $criteria->compare('t.key', $key, true);
        $model = self::model()->find($criteria);
        if ($model) {
            // Update
            $model->value = $value;
            $model->save();
        } else {
            // Add new
            $setting = new Settings();
            $setting->key = $key;
            $setting->value = $value;
            $setting->updated = CommonProcess::getCurrentDateTimeWithMySqlFormat();
            $setting->save();
        }
    }
    
    /**
     * Get item value
     * @param String $key Key string
     * @return string Value of key
     */
    public static function getItem($key) {
        $arrModel = Settings::loadItems();
        if (isset($arrModel[$key])) {
            return $arrModel[$key]->value;
        }
        return '';
    }
    
    /**
     * Get value of ajax template variable
     * @return String
     */
    public static function getAjaxTempValue() {
        return Settings::getItem(Settings::KEY_AJAX_TEMPLATE_VALUE . '_' . Yii::app()->user->id);
    }
    
    /**
     * Save value of ajax template variable
     * @param String $value Value need to save
     */
    public static function saveAjaxTempValue($value) {
        Settings::saveSetting(Settings::KEY_AJAX_TEMPLATE_VALUE . '_'  . Yii::app()->user->id, $value);
    }
    
    /**
     * Apply setting for system
     */
    public static function applySetting() {
        Yii::app()->mail->transportType = self::getItem(Settings::KEY_EMAIL_TRANSPORT_TYPE);
        Yii::app()->mail->transportOptions[DomainConst::KEY_HOST] = self::getItem(
                Settings::KEY_EMAIL_TRANSPORT_HOST);
        Yii::app()->mail->transportOptions[DomainConst::KEY_USERNAME] = self::getItem(
                Settings::KEY_EMAIL_TRANSPORT_USERNAME);
        Yii::app()->mail->transportOptions[DomainConst::KEY_PASSWORD] = self::getItem(
                Settings::KEY_EMAIL_TRANSPORT_PASSWORD);
        Yii::app()->mail->transportOptions[DomainConst::KEY_PORT] = self::getItem(
                Settings::KEY_EMAIL_TRANSPORT_PORT);
        Yii::app()->mail->transportOptions[DomainConst::KEY_ENCRYPTION] = self::getItem(
                Settings::KEY_EMAIL_TRANSPORT_ENCRYPTION);
    }
    
    /**
     * Get list page size
     * @return int List page size
     */
    public static function getListPageSize() {
        $retVal = Settings::getItem(Settings::KEY_LIST_PAGE_SIZE);
        if (!empty($retVal)) {
            return $retVal;
        }
        return 10;
    }
    
    /**
     * Get api list page size
     * @return int API list page size
     */
    public static function getApiListPageSize() {
        $retVal = Settings::getItem(Settings::KEY_APP_API_LIST_PAGE_SIZE);
        if (!empty($retVal)) {
            return $retVal;
        }
        return 10;
    }
    
    /**
     * Get min of password length
     * @return int Min of password length
     */
    public static function getPasswordLenMin() {
        $retVal = Settings::getItem(Settings::KEY_PASSWORD_LEN_MIN);
        if (!empty($retVal)) {
            return $retVal;
        }
        return 6;
    }
    
    /**
     * Get max of password length
     * @return int Max of password length
     */
    public static function getPasswordLenMax() {
        $retVal = Settings::getItem(Settings::KEY_PASSWORD_LEN_MAX);
        if (!empty($retVal)) {
            return $retVal;
        }
        return 50;
    }
}
