<?php

/**
 * This is the model class for table "labo_requests".
 *
 * The followings are the available columns in table 'labo_requests':
 * @property string $id                     Request id
 * @property string $treatment_detail_id    Treatment detail id
 * @property string $service_id             Labo service id
 * @property string $date_request           Request date
 * @property integer $time_id               Id of time
 * @property string $date_receive           Receive date
 * @property string $date_test              Test date
 * @property string $tooth_color            Color of tooth
 * @property string $description            Description
 * @property double $price                  Price
 * @property integer $status                Status
 * @property string $created_date           Created date
 * @property string $created_by             Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property OneMany[]                  $rJoinTeeth                     List of teeth
 * @property LaboServices               $rService                       Labo service
 * @property TreatmentScheduleDetails   $rTreatmentScheduleDetail       Treatment schedule detail
 * @property ScheduleTimes              $rTimeReceive                   Time receive model
 */
class LaboRequests extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_ACTIVE                 = 1;
    const STATUS_INACTIVE               = 0;
    /** Cưa đai */
    const STATUS_SAW_BELT               = 2;            // Cưa đai
    /** Điêu khắc sáp */
    const STATUS_WAX_SCULPTURE          = 3;            // Điêu khắc sáp
    /** Nung kim loại */
    const STATUS_METAL_HEATING          = 4;            // Nung kim loại
    /** Sườn kim loại */
    const STATUS_METAL_FRAME            = 5;            // Sườn kim loại
    /** Quét OPEC */
    const STATUS_SCAN_OPEC              = 6;            // Quét OPEC
    /** Đắp sứ và Nướng */
    const STATUS_GRAFTING_PORCELAIN     = 7;            // Đắp sứ và Nướng
    /** Mài sứ (thử sứ thô) */
    const STATUS_GRINDING_PORCELAIN     = 8;            // Mài sứ (thử sứ thô)
    /** Nướng bóng */
    const STATUS_GRILLED_POLIST         = 9;            // Nướng bóng
    /** Lễ tân kiểm tra và đóng gói */
    const STATUS_PACKAGED               = 10;           // Lễ tân kiểm tra và đóng gói
    /** Phòng Zico (Máy cắt CAM) */
    const STATUS_ZICO_CAM_CUT           = 11;           // Phòng Zico (Máy cắt CAM)
    /** Nung Zico */
    const STATUS_ZICO_HEATING           = 12;           // Nung Zico
    /** Mài Sườn */
    const STATUS_GRINDING_FRAME         = 13;           // Mài Sườn
    /** Tháo lắp */
    const STATUS_REMOVABLE              = 14;
    /** Làm gối sáp (Cắn khớp) */
    const STATUS_WAX_PILLOW             = 15;
    /** Lên răng (Thử răng) */
    const STATUS_TEST_TEETH             = 16;
    /** Ép nhựa */
    const STATUS_PLASTIC                = 17;
    /** Nhận hàng */
    const STATUS_RECEIVE                = 18;

    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $teeths;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return LaboRequests the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'labo_requests';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('price, service_id', 'required', 'on' => 'create,update'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, time_id, treatment_detail_id, service_id, date_request, date_receive, date_test, tooth_color, teeths, description, price, status, created_date, created_by', 'safe'),
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
            'rJoinTeeth' => array(
                self::HAS_MANY, 'OneMany', 'one_id',
                'on' => 'type = ' . OneMany::TYPE_LABO_REQUEST_TEETH,
            ),
            'rService' => array(self::BELONGS_TO, 'LaboServices', 'service_id'),
            'rTreatmentScheduleDetail' => array(self::BELONGS_TO, 'TreatmentScheduleDetails', 'treatment_detail_id'),
            'rTimeReceive' => array(self::BELONGS_TO, 'ScheduleTimes', 'time_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'                    => DomainConst::KEY_ID,
            'treatment_detail_id'   => DomainConst::CONTENT00146,
            'service_id'            => DomainConst::CONTENT00255,
            'date_request'          => DomainConst::CONTENT00416,
            'time_id'               => DomainConst::CONTENT00435,
            'date_receive'          => DomainConst::CONTENT00417,
            'date_test'             => DomainConst::CONTENT00418,
            'tooth_color'           => DomainConst::CONTENT00419,
            'teeths'                => DomainConst::CONTENT00420,
            'description'           => DomainConst::CONTENT00437,
            'price'                 => DomainConst::CONTENT00353,
            'status'                => DomainConst::CONTENT00026,
            'created_date'          => DomainConst::CONTENT00010,
            'created_by'            => DomainConst::CONTENT00054,
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
        $criteria->compare('treatment_detail_id', $this->treatment_detail_id);
        $criteria->compare('date_request', $this->date_request, true);
        $criteria->compare('time_id', $this->time_id);
        $criteria->compare('date_receive', $this->date_receive, true);
        $criteria->compare('date_test', $this->date_test, true);
        $criteria->compare('tooth_color', $this->tooth_color, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('price', $this->price);
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
     * before save
     * @return parent
     */
    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->created_by = Yii::app()->user->id;
        }
        $this->price = str_replace(DomainConst::SPLITTER_TYPE_2, '', $this->price);
        return parent::beforeSave();
    }

    /**
     * delete join
     * @return parent
     */
    public function beforeDelete() {
        $this->deleteJoin();
        return parent::beforeDelete();
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * get field name of table
     * @param string $fieldName
     * @return string
     */
    public function getField($fieldName) {
        return !empty($this->$fieldName) ? $this->$fieldName : '';
    }

    /**
     * get created date
     * @return date
     */
    public function getCreatedDate() {
        return CommonProcess::convertDateTime($this->created_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_11);
    }

    /**
     * get date
     * @return date
     */
    public function getRequestDate() {
        return CommonProcess::convertDateTime($this->date_request, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3);
    }

    /**
     * get date
     * @return date
     */
    public function getReceiveDate() {
        return CommonProcess::convertDateTime($this->date_receive, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3);
    }

    /**
     * get created date
     * @return date
     */
    public function getTestDate() {
        return CommonProcess::convertDateTime($this->date_test, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3);
    }

    /**
     * get full name of created by users
     * @return string
     */
    public function getCreatedBy() {
        return !empty($this->rCreatedBy) ? $this->rCreatedBy->getFullName() : '';
    }

    /**
     * get service
     * @return string
     */
    public function getService() {
        return !empty($this->rService) ? $this->rService->name : '';
    }

    /**
     * get tooth color
     * @return string
     */
    public function getToothColor() {
        $aToothColor = $this->getItemToothColor();
        return !empty($aToothColor[$this->tooth_color]) ? $aToothColor[$this->tooth_color] : '';
    }

    /**
     * get string of price
     * @return string
     */
    public function getPrice() {
        return !empty($this->price) ? CommonProcess::formatCurrency($this->price) : '';
    }

    /**
     * handle before save
     */
    public function handleBeforeSave() {
        $this->date_request = CommonProcess::convertDateTime($this->date_request, DomainConst::DATE_FORMAT_3, DomainConst::DATE_FORMAT_4);
        $this->date_receive = CommonProcess::convertDateTime($this->date_receive, DomainConst::DATE_FORMAT_3, DomainConst::DATE_FORMAT_4);
        $this->date_test = CommonProcess::convertDateTime($this->date_test, DomainConst::DATE_FORMAT_3, DomainConst::DATE_FORMAT_4);
    }

    /**
     * handle save
     */
    public function handlesave() {
        if ($this->save()) {
            $tableName = OneMany::model()->tableName();
            $aRowInsert = [];
            $typeOneMany = OneMany::TYPE_LABO_REQUEST_TEETH;
            if (!empty($this->teeths)) {
                $arrTeethConst = CommonProcess::getListTeeth(false, '');
                foreach ($arrTeethConst as $key => $teeth) {
                    $arrTeethConst[$key] = str_replace(' - ', '', $teeth);
                }
                $aTeeth = explode(',', $this->teeths);
                foreach ($aTeeth as $key => $teeth_id) {
                    if (empty($teeth_id)) {
                        continue;
                    }
                    $idInsert = array_search($teeth_id, $arrTeethConst);
                    $aRowInsert[] = "(
                            '{$this->id}',
                            '{$idInsert}',
                            '{$typeOneMany}'
                            )";
                }
                $sql = "insert into $tableName (
                                one_id,
                                many_id,
                                type
                            ) values" . implode(',', $aRowInsert);
                if (count($aRowInsert)) {
                    $this->deleteJoin();
                    Yii::app()->db->createCommand($sql)->execute();
                }
            }
        }
    }

    /**
     * delete onemany
     */
    public function deleteJoin() {
        $aOneMany = $this->rJoinTeeth;
        foreach ($aOneMany as $key => $mOnemany) {
            $mOnemany->delete();
        }
    }

    /**
     * handle after read for search
     */
    public function handleSearch() {
        $this->date_request = CommonProcess::convertDateTime($this->date_request, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3);
        $this->date_receive = CommonProcess::convertDateTime($this->date_receive, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3);
        $this->date_test = CommonProcess::convertDateTime($this->date_test, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_3);
    }

    /**
     * get array item tooth color
     */
    public function getItemToothColor() {
        return explode(DomainConst::SPLITTER_TYPE_2, Settings::getItem(Settings::KEY_TOOTH_COLOR));
    }
    
    /**
     * Get treatment info
     * @return string Treatment info as string
     */
    public function getTreatmentInfo() {
        if (isset($this->rTreatmentScheduleDetail)) {
            $retVal = $this->rTreatmentScheduleDetail->getTitle();
            $retVal .= '<br/>';
            $retVal .= $this->rTreatmentScheduleDetail->getStartTime();
            return $retVal;
        }
        
        return '';
    }
    
    /**
     * Get customer model
     * @return Object Customer model, Null if not found
     */
    public function getCustomer() {
        if (isset($this->rTreatmentScheduleDetail)) {
            return $this->rTreatmentScheduleDetail->getCustomerModel();
        }
        return NULL;
    }
    
    /**
     * Get customer name
     * @return Customers Customer name, empty string if not found
     */
    public function getCustomerName() {
        $customer = $this->getCustomer();
        if (isset($customer)) {
            return $customer->name;
        }
        return '';
    }
    
    /**
     * Get customer name
     * @return string Customer name, empty string if not found
     */
    public function getCustomerRecordNumber() {
        $customer = $this->getCustomer();
        if (isset($customer) && isset($customer->rMedicalRecord)) {
            return $customer->rMedicalRecord->record_number;
        }
        return '';
    }
    
    /**
     * Get receive time
     * @return type
     */
    public function getReceiveTime() {
        $retVal = isset($this->rTimeReceive) ? $this->rTimeReceive->name : '';
        if (!empty($retVal)) {
            $retVal .= ' ';
        }
        if (!DateTimeExt::isDateNull($this->date_receive)) {
            $retVal .= CommonProcess::convertDateTime($this->date_receive, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_4);
        } else {
            $retVal = '';
        }
        
        return $retVal;
    }
    
    /**
     * Get agent name
     * @return String Name of agent
     */
    public function getAgentName() {
        $retVal = '';
        if (isset($this->rCreatedBy)) {
            $retVal = $this->rCreatedBy->getAgentName();
        }
        
        return $retVal;
    }
    
    /**
     * Get doctor name
     * @return String Name of doctor
     */
    public function getDoctorName() {
        $retVal = '';
        if (isset($this->rTreatmentScheduleDetail)) {
            $retVal = $this->rTreatmentScheduleDetail->getDoctor();
        }
        return $retVal;
    }
    
    /**
     * Get status of model
     * @return string Status string
     */
    public function getStatus() {
        if (isset(self::getArrayStatus()[$this->status])) {
            return self::getArrayStatus()[$this->status];
        }
        return '';
    }

    //-----------------------------------------------------
    // Static methods
    //-----------------------------------------------------
    /**
     * Get list status of model
     * @return Array List status
     */
    public static function getArrayStatus() {
        return [
            self::STATUS_INACTIVE           => DomainConst::CONTENT00403,
            self::STATUS_ACTIVE             => DomainConst::CONTENT00467,
            self::STATUS_RECEIVE            => DomainConst::CONTENT00450,
            self::STATUS_SAW_BELT           => DomainConst::CONTENT00451,
            self::STATUS_WAX_SCULPTURE      => DomainConst::CONTENT00452,
            self::STATUS_METAL_HEATING      => DomainConst::CONTENT00453,
            self::STATUS_METAL_FRAME        => DomainConst::CONTENT00454,
            self::STATUS_SCAN_OPEC          => DomainConst::CONTENT00455,
            self::STATUS_GRAFTING_PORCELAIN => DomainConst::CONTENT00456,
            self::STATUS_GRINDING_PORCELAIN => DomainConst::CONTENT00457,
            self::STATUS_GRILLED_POLIST     => DomainConst::CONTENT00458,
            self::STATUS_PACKAGED           => DomainConst::CONTENT00459,
            self::STATUS_ZICO_CAM_CUT       => DomainConst::CONTENT00460,
            self::STATUS_ZICO_HEATING       => DomainConst::CONTENT00461,
            self::STATUS_GRINDING_FRAME     => DomainConst::CONTENT00462,
            self::STATUS_REMOVABLE          => DomainConst::CONTENT00463,
            self::STATUS_WAX_PILLOW         => DomainConst::CONTENT00464,
            self::STATUS_TEST_TEETH         => DomainConst::CONTENT00465,
            self::STATUS_PLASTIC            => DomainConst::CONTENT00466,
        ];
    }
}
