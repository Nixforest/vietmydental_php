<?php

/**
 * This is the model class for table "daily_reports".
 *
 * The followings are the available columns in table 'daily_reports':
 * @property string $id
 * @property double $receipt_total
 * @property double $agent_id
 * @property double $receipt_total_confirm
 * @property string $approve_id
 * @property integer $status
 * @property string $date_report
 * @property string $created_by
 * @property string $created_date
 */
class DailyReports extends CActiveRecord
{
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    const STATUS_NEW        = 1;
    const STATUS_PROCESS    = 2;
    const STATUS_CONFIRM    = 3;

    //-----------------------------------------------------
    // Properties
    //-----------------------------------------------------
    public $doctors,$revenue;

    /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DailyReports the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'daily_reports';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('approve_id, created_by, created_date', 'required', 'on' => 'create,update'),
			array('receipt_total, receipt_total_confirm, approve_id, status, created_by, created_date', 'safe'),
			array('agent_id,date_report,doctors,revenue', 'safe'),
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
                    'rApprove' => array(self::BELONGS_TO, 'Users', 'approve_id'),
                    'rAgent' => array(self::BELONGS_TO, 'Agents', 'agent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => DomainConst::KEY_ID,
			'receipt_total' => DomainConst::CONTENT00353,
			'receipt_total' => 'Tổng tiền xác thực',
			'approve_id' => 'Người duyệt',
			'status' => DomainConst::CONTENT00026,
			'created_by' => DomainConst::CONTENT00054,
			'created_date' => DomainConst::CONTENT00010,
			'date_report' => 'Ngày báo cáo',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('approve_id',$this->approve_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_by',$this->created_by);
		$criteria->compare('date_report',CommonProcess::convertDateTime($this->date_report, DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_4));
                $agentId    = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : 0;
                $criteria->compare('agent_id',$agentId);
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        /**
         * get array status of record of table
         * @return array array status of record
         */
        public function getArrayStatus(){
            return [
                self::STATUS_NEW        => 'Mới tạo',
                self::STATUS_PROCESS    => 'Đang xử lý',
                self::STATUS_CONFIRM    => 'Đã xác thực',
            ];
        }
        
        /**
         * get list doctor by agent current
         * @return array doctors
         */
        public function getArrayDoctor(){
            $aDoctor = [];
            $agentId = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';
            $mAgent = Agents::model()->findByPk($agentId);
            if(!empty($mAgent)){
                $aDoctor    = Users::getListUser(Roles::getRoleByName(Roles::ROLE_DOCTOR)->id,$mAgent->id);
            }
            return $aDoctor;
        }
        
        /**
         * get data show in view
         * @return array data show in view
         */
        public function getDataReport(){
            $aData      = [];
            $date       = !empty($this->date_report) ? CommonProcess::convertDateTime($this->date_report, DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_4) : date(DomainConst::DATE_FORMAT_4);
            $agentId    = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : '';
            $mAgent     = Agents::model()->findByPk($agentId);
            $aData['DOCTOR']    = $this->getArrayDoctor();
            $id_isset   = CHtml::listData($this->getDailyReports($date), 'approve_id', 'approve_id');
    //        Load receipts
            $receipts = $mAgent->getReceipts($date, $date, array(Receipts::STATUS_RECEIPTIONIST),true);
    //        $receipts->pagination = false;
            $aReceipts = $receipts->getData();
            foreach ($aReceipts as $key => $mJoinReceipt) {
                $mReceipt = $mJoinReceipt->rReceipt;
                $doctor_id = !empty($mReceipt->getDoctorId()) ? $mReceipt->getDoctorId() : 0;
                if(in_array($doctor_id, $id_isset) || empty($aData['DOCTOR'][$doctor_id])){
                    continue;
                }
                $money = $mJoinReceipt->getReceiptFinal();
    //            $date = CommonProcess::convertDateTime($mReceipt->created_date, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_4);
                $date = $mReceipt->process_date;
    //            set money RECEIPT
                if(!empty($aData['RECEIPT'][$doctor_id])){
                    $aData['RECEIPT'][$doctor_id] += (int)$money;
                }else{
                    $aData['RECEIPT'][$doctor_id] = (int)$money;
                }
            }
            return $aData;
        }
        
        /**
         * get all daily report in date
         * @param string $date Y-m-d
         */
        public function getDailyReports($date){
            $criteria=new CDbCriteria;
            $criteria->compare('t.date_report',$date);
            return DailyReports::model()->findAll($criteria);
        }
        
        /**
         * created daily report
         */
        public function createDailyReport(){
            if(!empty($this->doctors) && is_array($this->doctors)){
                $agentId    = isset(Yii::app()->user->agent_id) ? Yii::app()->user->agent_id : 0;
                $aRowInsert = [];
                $status_new = self::STATUS_NEW;
                $date_now   = date('Y-m-d H:i:s');
                $current_id = Yii::app()->user->id;
                $date_report = !empty($this->date_report) ? CommonProcess::convertDateTime($this->date_report, DomainConst::DATE_FORMAT_BACK_END, DomainConst::DATE_FORMAT_4) : date(DomainConst::DATE_FORMAT_4);
                foreach ($this->doctors as $key => $id_doctor) {
                    $revenue = !empty($this->revenue[$id_doctor]) ? $this->revenue[$id_doctor] : 0;
                    $aRowInsert[] = "(
                        '{$revenue}',
                        '{$revenue}',
                        '{$id_doctor}',
                        '{$status_new}',
                        '{$current_id}',
                        '{$date_report}',
                        '{$date_now}',
                        '{$agentId}'
                        )";
                }
                $tableName = DailyReports::model()->tableName();
                $sql = "insert into $tableName (
                                receipt_total,
                                receipt_total_confirm,
                                approve_id,
                                status,
                                created_by,
                                date_report,
                                created_date,
                                agent_id
                                ) values " . implode(',', $aRowInsert);
                if (count($aRowInsert)){
                    Yii::app()->db->createCommand($sql)->execute();
                }
                
            }
        }
        
        /**
         * 
         * @return string
         */
        public function getReceiptTotal(){
            return CommonProcess::formatCurrency($this->receipt_total) . ' ' . DomainConst::CONTENT00134;
        }
        
        /**
         * 
         * @return string
         */
        public function getReceiptTotalConfirm(){
            return CommonProcess::formatCurrency($this->receipt_total_confirm) . ' ' . DomainConst::CONTENT00134;
        }
        
        /**
         * 
         * @return string
         */
        public function getApprove(){
            return !empty($this->rApprove) ? $this->rApprove->getFullName() : '';
        }
        
        /**
         * 
         * @return string
         */
        public function getStatus(){
            $aStatus = $this->getArrayStatus();
            return !empty($aStatus[$this->status]) ? $aStatus[$this->status] : '';
        }
        
        /**
         * 
         * @return string
         */
        public function getDateReport(){
            return !empty($this->date_report) ? CommonProcess::convertDateTime($this->date_report, DomainConst::DATE_FORMAT_4, DomainConst::DATE_FORMAT_BACK_END) : '';
        }
        
        /**
         * 
         * @return boolean
         */
        public function canUpdateStatus(){
            return true;
        }
        
        /**
         * 
         * @return boolean
         */
        public function canCreateNew(){
            return true;
        }
        
        /**
         * can highlight
         * @return boolean
         */
        public function canHighLight(){
            if($this->receipt_total != $this->receipt_total_confirm){
                return '<span class=\'highlight\'></span>';
            }
        }
        
        /**
         * 
         * @return string
         */
        public function getAgent(){
            return !empty($this->rAgent) ? $this->rAgent->getFullName() : '';
        }
}