<?php

/**
 * This is the model class for table "labo_requests".
 *
 * The followings are the available columns in table 'labo_requests':
 * @property string $id                     Request id
 * @property string $treatment_detail_id    Treatment detail id
 * @property string $service_id             Labo service id
 * @property string $date_request           Request date
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
 */
class LaboRequests extends BaseActiveRecord {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_ACTIVE         = 1;
    const STATUS_INACTIVE       = 0;

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
            array('price', 'numerical'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, treatment_detail_id, service_id, date_request, date_receive, date_test, tooth_color, teeths, description, price, status, created_date, created_by', 'safe'),
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
            'date_receive'          => DomainConst::CONTENT00417,
            'date_test'             => DomainConst::CONTENT00418,
            'tooth_color'           => DomainConst::CONTENT00419,
            'teeths'                => DomainConst::CONTENT00420,
            'description'           => DomainConst::CONTENT00091,
            'price'                 => DomainConst::CONTENT00129,
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
        $criteria->compare('date_receive', $this->date_receive, true);
        $criteria->compare('date_test', $this->date_test, true);
        $criteria->compare('tooth_color', $this->tooth_color, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('price', $this->price);
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
        return !empty($this->price) ? CommonProcess::formatCurrency($this->price) . ' ' . DomainConst::CONTENT00134 : '';
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
    public function Handlesave() {
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

}
