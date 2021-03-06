<?php

/**
 * This is the model class for table "promotions".
 *
 * The followings are the available columns in table 'promotions':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property integer $status
 * @property string $created_date
 * @property string $created_by
 */
class Promotions extends BaseActiveRecord
{
    public $agents;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Promotions the static model class
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
		return 'promotions';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, start_date, end_date, agents ,created_by', 'required','on'=>'update,create'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('created_by', 'length', 'max'=>10),
			array('title, description, start_date, end_date, status,agents,', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, start_date, end_date, status, created_date, created_by', 'safe', 'on'=>'search'),
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
                    'rJoinAgent' => array(
                        self::HAS_MANY, 'OneMany', 'one_id',
                        'on'    => 'type = ' . OneMany::TYPE_PROMOTION_AGENT,
                    ),
                    'rUsers' => array(self::BELONGS_TO, 'Users', 'created_by'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => DomainConst::KEY_ID,
			'title' => DomainConst::CONTENT00004,
			'description' => DomainConst::CONTENT00062,
			'start_date' => DomainConst::CONTENT00139,
			'end_date' => DomainConst::CONTENT00140,
			'status' => DomainConst::CONTENT00026,
			'created_date' => DomainConst::CONTENT00010,
			'created_by' => DomainConst::CONTENT00054,
			'agents' => DomainConst::CONTENT00199,
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('created_by',$this->created_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination' => array(
                            'pageSize' => Settings::getListPageSize(),
                        ),
		));
	}
        
        /**
         * handle save promotions
         */
        public function handleSave(){
            if($this->scenario == 'create'){
                $this->created_by = Yii::app()->user->id;
            }else{
                $this->deleteAgentsJoin();
            }
            if($this->save()){
//                save onemany of promotion - agent
                $tableName = OneMany::model()->tableName();
                $aRowInsert = [];
                $typeOneMany = OneMany::TYPE_PROMOTION_AGENT;
                foreach ($this->agents as $key => $agent_id) {
                    $aRowInsert[] = "(
                        '{$this->id}',
                        '{$agent_id}',
                        '{$typeOneMany}'
                        )";
                }
                $sql = "insert into $tableName (
                            one_id,
                            many_id,
                            type
                        ) values" . implode(',', $aRowInsert);
                if (count($aRowInsert)){
                    Yii::app()->db->createCommand($sql)->execute();
                }
                return true;
            }
            return false;
        }
        
        /**
         * get array status
         * @return array
         */
        public function getArrayStatus(){
            return [
                self::STATUS_ACTIVE => DomainConst::CONTENT00407,
                self::STATUS_INACTIVE => DomainConst::CONTENT00408,
            ];
        }
        
        /**
         * get field name of model
         * @param string $field
         * @return string
         */
        public function getField($field = 'id'){
            return !empty($this->$field) ? $this->$field : '';
        }
        
        /**
         * get created date
         * @return date
         */
        public function getCreatedDate(){
            return CommonProcess::convertDateTime($this->created_date,DomainConst::DATE_FORMAT_1,DomainConst::DATE_FORMAT_11);
        }
        
        /**
         * get created date
         * @return date
         */
        public function getStartDate(){
            return CommonProcess::convertDateTime($this->start_date,DomainConst::DATE_FORMAT_4,DomainConst::DATE_FORMAT_3);
        }
        
        /**
         * get created date
         * @return date
         */
        public function getEndDate(){
            return CommonProcess::convertDateTime($this->end_date,DomainConst::DATE_FORMAT_4,DomainConst::DATE_FORMAT_3);
        }
        
        /**
         * get agents
         * @return string
         */
        public function getAgents(){
            $strResult = [];
            $aOneMany = $this->rJoinAgent;
            $agent = [];
            foreach ($aOneMany as $key => $mOnemany) {
                $agent[] = $mOnemany->many_id;
            }
            $criteria = new CDbCriteria;
            $criteria->addInCondition('id', $agent);
            $aAgent = Agents::model()->findAll($criteria);
            foreach ($aAgent as $key => $mAgents) {
                $strResult[] = $mAgents->name;
            }
            return implode('<br>', $strResult);
        }
        
        /**
         * get created by
         * @return string
         */
        public function getCreatedBy(){
            return !empty($this->rUsers) ? $this->rUsers->getFullName() : '';
        }
        
        /**
         * handle before save
         */
        public function handleBeforeSave(){
            $this->start_date = CommonProcess::convertDateTime($this->start_date,DomainConst::DATE_FORMAT_3,DomainConst::DATE_FORMAT_4);
            $this->end_date = CommonProcess::convertDateTime($this->end_date,DomainConst::DATE_FORMAT_3,DomainConst::DATE_FORMAT_4);
        }
        
        /**
         * handle after read for search
         */
        public function handleSearch(){
            $this->setAgents();
            $this->start_date = CommonProcess::convertDateTime($this->start_date,DomainConst::DATE_FORMAT_4,DomainConst::DATE_FORMAT_3);
            $this->end_date = CommonProcess::convertDateTime($this->end_date,DomainConst::DATE_FORMAT_4,DomainConst::DATE_FORMAT_3);
        }
        
        /**
         * set list agents of model to $agents
         */
        public function setAgents(){
            $aOneMany = $this->rJoinAgent;
            foreach ($aOneMany as $key => $mOnemany) {
                $this->agents[$mOnemany->many_id] = $mOnemany->many_id;
            }
            
        }
        
        /**
         * delete onemany of promotions
         */
        public function deleteAgentsJoin(){
            $aOneMany = $this->rJoinAgent;
            foreach ($aOneMany as $key => $mOnemany) {
                $mOnemany->delete();
            }
        }
        
        /**
         * delete join before delete
         */
        public function beforeDelete() {
            $this->deleteAgentsJoin();
            return parent::beforeDelete();
        }
        
        /**
         * get list detail for view
         * @return \CActiveDataProvider
         */
        public function searchDetail(){
             if(empty($this->id)){
                return null;
            }
            $mPromotionDetail = new PromotionDetails('search');
            $criteria   =   new CDbCriteria;
            $criteria->compare('promotion_id',$this->id);
            return new CActiveDataProvider($mPromotionDetail, array(
                    'criteria'=>$criteria,
            ));
        }
}