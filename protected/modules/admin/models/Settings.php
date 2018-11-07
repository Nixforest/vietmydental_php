<?php

/**
 * This is the model class for table "settings".
 *
 * The followings are the available columns in table 'settings':
 * @property string $id             Id of record
 * @property string $updated        Updated time
 * @property string $key            Key value
 * @property string $value          Value
 * @property string $description    Description
 */
class Settings extends BaseActiveRecord {

    //-----------------------------------------------------
    // ++ Define keys
    //-----------------------------------------------------
    /** Key General setting */
    const KEY_GENERAL_SETTINGS                  = 'general_settings';

    /** Key Application setting */
    const KEY_APP_SETTINGS                      = 'app_settings';

    /** Key Mail setting */
    const KEY_MAIL_SETTINGS                     = 'mail_settings';

    /** Key SMS setting */
    const KEY_SMS_SETTINGS                      = 'sms_settings';

    /** Key SMS setting */
    const KEY_SMS_SETTING_SENDS                 = 'sms_setting_sends';

    /** Key API setting */
    const KEY_API_SETTINGS                      = 'api_settings';

    /* --- General settings --- */
    /** Key website title */
    const KEY_TITLE                             = 'WEBSITE_TITLE';
    /** Key Page size of list */
    const KEY_LIST_PAGE_SIZE                    = 'LIST_PAGE_SIZE';
    /** Key Min of password length */
    const KEY_PASSWORD_LEN_MIN                  = 'PASSWORD_LEN_MIN';
    /** Key Max of password length */
    const KEY_PASSWORD_LEN_MAX                  = 'PASSWORD_LEN_MAX';
    /** Key Domain */
    const KEY_DOMAIN                            = 'DOMAIN';
    /** Key Max number download file QR code */
    const KEY_NUM_QRCODE_DOWNLOAD_MAX           = 'NUM_QRCODE_DOWNLOAD_MAX';
    /** Key print receipt font size rate */
    const KEY_PRINT_RECEIPT_FONT_SIZE_RATE      = 'PRINT_RECEIPT_FONT_SIZE_RATE';
    /** Key Website for sale */
    const KEY_DOMAIN_SALE_WEBSITE               = 'DOMAIN_SALE_WEBSITE';
    /** Key SMS provider */
    const KEY_SMS_PROVIDER                      = 'SMS_PROVIDER';
    /** Key TOOTH COLOR */
    const KEY_TOOTH_COLOR                       = 'TOOTH_COLOR';
    /** Key TOOTH COLOR */
    const KEY_NEWS_DATE_OF_HOT_NEWS             = 'NEWS_DATE_OF_HOT_NEWS';
    /** Key check this company working on Saturday or not */
    const KEY_HR_WORK_ON_SATURDAY               = 'HR_WORK_ON_SATURDAY';
    /** Key number of off day per month (with workshift role) */
    const KEY_HR_WORKSHIFT_OFF_DAY_PER_MONTH    = 'HR_WORKSHIFT_OFF_DAY_PER_MONTH';
    /** Key setting of source information: Website */
    const KEY_SOURCE_INFO_WEBSITE               = 'SOURCE_INFO_WEBSITE';
    /** Key setting of OTP: limit time */
    const KEY_OTP_LIMIT_TIME                    = 'OTP_LIMIT_TIME';

    /* --- App settings --- */
    /** Key Mobile application version iOS */
    const KEY_APP_MOBILE_VERSION_IOS            = 'APP_MOBILE_VERSION_IOS';
    /** Key Page size of api list */
    const KEY_APP_API_LIST_PAGE_SIZE            = 'APP_API_LIST_PAGE_SIZE';
    
    /* --- Email settings --- */
    /** Key administrator email */
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
    /** Key Email SendGrid API key */
    const KEY_EMAIL_SENDGRID_API_KEY            = 'EMAIL_SENDGRID_API_KEY';
    /** Key Email provider */
    const KEY_EMAIL_PROVIDER                    = 'EMAIL_PROVIDER';

    /* --- Others settings --- */
    /** Key Ajax template value */
    const KEY_AJAX_TEMPLATE_VALUE               = 'AJAX_TEMPLATE_VALUE';
    /** Key Ajax template value */
    const KEY_AJAX_TEMPLATE_VALUE_1             = 'AJAX_TEMPLATE_VALUE_1';

    /* --- SMS settings --- */
    /** Key SMS server url */
    const KEY_SMS_SERVER_URL                    = 'SMS_SERVER_URL';
    /** Key VIVAS SMS server url */
    const KEY_VIVAS_SMS_SERVER_URL              = 'VIVAS_SMS_SERVER_URL';
    /** Key VIVAS SMS server url: login */
    const KEY_VIVAS_URL_LOGIN                   = 'VIVAS_URL_LOGIN';

    /** Key VIVAS SMS server url: send sms */
    const KEY_VIVAS_URL_SEND_SMS                = 'VIVAS_URL_SEND_SMS';

    /** Key VIVAS SMS server url: send sms extend */
    const KEY_VIVAS_URL_SEND_SMS_EXT            = 'VIVAS_URL_SEND_SMS_EXT';

    /** Key VIVAS SMS server url: verify */
    const KEY_VIVAS_URL_VERIFY                  = 'VIVAS_URL_VERIFY';

    /** Key VIVAS SMS server url: logout */
    const KEY_VIVAS_URL_LOGOUT                  = 'VIVAS_URL_LOGOUT';

    /** Key VIVAS SMS username */
    const KEY_VIVAS_USERNAME                    = 'VIVAS_USERNAME';

    /** Key VIVAS SMS password */
    const KEY_VIVAS_PASSWORD                    = 'VIVAS_PASSWORD';

    /** Key VIVAS SMS share key */
    const KEY_VIVAS_SHARE_KEY                   = 'VIVAS_SHARE_KEY';

    /** Key SMS function on/off */
    const KEY_SMS_FUNC_ON_OFF                   = 'SMS_FUNC_ON_OFF';

    /** Key SMS type send: create schedule */
    const KEY_SMS_SEND_CREATE_SCHEDULE          = 'SMS_SEND_CREATE_SCHEDULE';

    /** Key SMS type send: update schedule */
    const KEY_SMS_SEND_UPDATE_SCHEDULE          = 'SMS_SEND_UPDATE_SCHEDULE';

    /** Key SMS type send: create schedule detail */
    const KEY_SMS_SEND_CREATE_SCHEDULE_DETAIL   = 'SMS_SEND_CREATE_SCHEDULE_DETAIL';

    /** Key SMS type send: create receipt */
    const KEY_SMS_SEND_CREATE_RECEIPT           = 'SMS_SEND_RECEIPT';

    /** Key SMS type send: alarm schedule */
    const KEY_SMS_SEND_ALARM_SCHEDULE           = 'SMS_SEND_ALARM_SCHEDULE';
    
    /* --- API settings --- */
    /** Key Wordpress api token */
    const KEY_WORDPRESS_API_TOKEN               = 'WORDPRESS_API_TOKEN';
    //-----------------------------------------------------
    // -- Define keys
    //-----------------------------------------------------

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'settings';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('updated, key, value', 'required'),
            array('key', 'length', 'max' => 255),
            array('description', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, updated, key, value, description', 'safe', 'on' => 'search'),
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
        return array(
            'id'            => 'ID',
            'updated'       => 'Updated',
            'key'           => 'Key',
            'value'         => 'Value',
            'description'   => 'Description',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('updated', $this->updated, true);
        $criteria->compare('key', $this->key, true);
        $criteria->compare('value', $this->value, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Settings the static model class
     */
    public static function model($className = __CLASS__) {
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
                $id, array(
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
        // TODO: Update data to cache

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
        // TODO: Get data from cache
        $arrModel = Settings::loadItems();
        if (isset($arrModel[$key])) {
            return $arrModel[$key]->value;
        }
        return '';
    }

    /**
     * Get value of ajax template variable
     * @param String id Id of key need to get
     * @return String
     */
    public static function getAjaxTempValue($id = '') {
        return Settings::getItem(Settings::KEY_AJAX_TEMPLATE_VALUE . '_' . Yii::app()->user->id . $id);
    }

    /**
     * Save value of ajax template variable
     * @param String $value Value need to save
     * @param String id Id of key need to save
     */
    public static function saveAjaxTempValue($value, $id = '') {
        Settings::saveSetting(Settings::KEY_AJAX_TEMPLATE_VALUE . '_' . Yii::app()->user->id . $id, $value);
    }

    /**
     * Get value of ajax template variable
     * @return String
     */
    public static function getAjaxTempValue1() {
        return Settings::getItem(Settings::KEY_AJAX_TEMPLATE_VALUE_1 . '_' . Yii::app()->user->id);
    }

    /**
     * Save value of ajax template variable
     * @param String $value Value need to save
     */
    public static function saveAjaxTempValue1($value) {
        Settings::saveSetting(Settings::KEY_AJAX_TEMPLATE_VALUE_1 . '_' . Yii::app()->user->id, $value);
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
        Yii::app()->name = self::getWebsiteName();
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

    /**
     * Get SMS server url.
     * @return string SMS server url
     */
    public static function getSMSServerUrl() {
        $retVal = Settings::getItem(Settings::KEY_SMS_SERVER_URL);
        if (!empty($retVal)) {
            return $retVal;
        }
        return "";
    }

    /**
     * Get name of website
     * @return string
     */
    public static function getWebsiteName() {
        $retVal = Settings::getItem(Settings::KEY_TITLE);
        if (!empty($retVal)) {
            return $retVal;
        }
        return DomainConst::CONTENT00273;
    }

    /**
     * Get domain of website
     * @return string
     */
    public static function getDomain() {
        $retVal = Settings::getItem(Settings::KEY_DOMAIN);
        if (!empty($retVal)) {
            return $retVal;
        }
        return "";
    }

    /**
     * Get print receipt font size
     * @return string
     */
    public static function getPrintReceiptFontSize() {
        $retVal = Settings::getItem(Settings::KEY_PRINT_RECEIPT_FONT_SIZE_RATE);
        if (!empty($retVal)) {
            return $retVal;
        }
        return "150%";
    }

    /**
     * Get domain of sale website
     * @return string
     */
    public static function getDomainSaleWebsite() {
        $retVal = Settings::getItem(Settings::KEY_DOMAIN_SALE_WEBSITE);
        if (!empty($retVal)) {
            return $retVal;
        }
        return DomainConst::CONTENT_WEBSITE;
    }

    /**
     * Check if system can send SMS
     * @return True if setting value is '1', False otherwise
     */
    public static function canSendSMS() {
        $retVal = Settings::getItem(Settings::KEY_SMS_FUNC_ON_OFF);
        if (!empty($retVal) && ($retVal == DomainConst::NUMBER_ONE_VALUE)) {
            return true;
        }
        return false;
    }

    /**
     * Get SendGrid api key
     * @return String API key
     */
    public static function getSendGridAPIKey() {
        $retVal = Settings::getItem(Settings::KEY_EMAIL_SENDGRID_API_KEY);
        if (!empty($retVal)) {
            return $retVal;
        }
        return SENDGRID_API_KEY;
    }

    /**
     * Get number of date hot news
     * @return int Number of date hot news
     */
    public static function getNumberOfDateHotNews() {
        $retVal = Settings::getItem(Settings::KEY_NEWS_DATE_OF_HOT_NEWS);
        if (!empty($retVal)) {
            return $retVal;
        }
        return 3;
    }
    
    /**
     * Get item value
     * @param String $key Key string
     * @param type $defaultVal Value default
     * @return type Value of item
     */
    public static function getItemValue($key, $defaultVal = '') {
        $retVal = self::getItem($key);
        if (!empty($retVal)) {
            return $retVal;
        }
        return $defaultVal;
    }
    
    /**
     * Check if working on Saturday
     * @return Int 1 - working on Saturday, 0 - off on Saturday
     */
    public static function isWorkingOnSaturday() {
        return self::getItemValue(self::KEY_HR_WORK_ON_SATURDAY, 0);
    }
    
    /**
     * Check if Wordpress api token is valid
     * @param String $token Token value
     * @return True if token is valid, False otherwise
     */
    public static function isValidTokenWordpressAPI($token) {
        return (Settings::getItemValue(Settings::KEY_WORDPRESS_API_TOKEN) == $token);
    }
    
    /**
     * Get OTP limit time
     * @return Number Number of second
     */
    public static function getOTPLimitTime() {
        return self::getItemValue(self::KEY_OTP_LIMIT_TIME, 120);
    }

}
