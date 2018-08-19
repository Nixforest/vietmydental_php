<?php

/**
 * This is the model class for table "renodcm3_tb_patient".
 *
 * The followings are the available columns in table 'renodcm3_tb_patient':
 * @property integer $Id
 * @property integer $FamilyID
 * @property string $Code
 * @property string $LastName
 * @property string $FirstName
 * @property string $FullName
 * @property string $FullName_EN
 * @property integer $TitleId
 * @property string $Image
 * @property integer $Sex
 * @property string $DateOfBirth
 * @property integer $YearOfBirth
 * @property string $Address
 * @property integer $ProvinceId
 * @property integer $DistrictId
 * @property string $Phone
 * @property string $Mobile
 * @property string $Email
 * @property integer $Nationality
 * @property integer $IsForeigner
 * @property integer $InfoSourceId
 * @property integer $CareerId
 * @property integer $RateId
 * @property string $CreateDate
 * @property string $Creater
 * @property string $LastModify
 * @property string $LastModifier
 * @property string $Note
 * @property integer $Hidden
 * @property integer $InRoom
 * @property string $CompanyName
 * @property string $CompanyPhone
 * @property string $CompanyAddress
 * @property string $TaxCode
 * @property string $ReasonCome
 * @property integer $TreatmentPeriod
 * @property integer $ContactPhone
 * @property integer $ContactEmail
 * @property integer $ContactPost
 * @property integer $IsContract
 * @property string $ContractNumber
 * @property integer $Insurance
 * @property integer $InsuranceCompany_ID
 * @property string $InsuranceNumber
 * @property integer $DoctorExamination
 * @property integer $DoctorTreatment
 * @property integer $Broker_ID
 * @property integer $BrokerCommission
 * @property integer $Marketing
 * @property integer $Collaborator
 * @property integer $IsDelete
 * @property integer $IsLock
 */
class Renodcm3TbPatient extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Renodcm3TbPatient the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'renodcm3_tb_patient';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('FamilyID, TitleId, Sex, YearOfBirth, ProvinceId, DistrictId, Nationality, IsForeigner, InfoSourceId, CareerId, RateId, Hidden, InRoom, TreatmentPeriod, ContactPhone, ContactEmail, ContactPost, IsContract, Insurance, InsuranceCompany_ID, DoctorExamination, DoctorTreatment, Broker_ID, BrokerCommission, Marketing, Collaborator, IsDelete, IsLock', 'numerical', 'integerOnly' => true),
            array('Code, LastName, FirstName, FullName, FullName_EN, Address', 'length', 'max' => 255),
            array('Phone, Mobile, Email, CompanyName', 'length', 'max' => 100),
            array('Creater, LastModifier, CompanyPhone, TaxCode, ContractNumber, InsuranceNumber', 'length', 'max' => 50),
            array('Note', 'length', 'max' => 2000),
            array('CompanyAddress', 'length', 'max' => 300),
            array('ReasonCome', 'length', 'max' => 500),
            array('Image, DateOfBirth, CreateDate, LastModify', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('Id, FamilyID, Code, LastName, FirstName, FullName, FullName_EN, TitleId, Image, Sex, DateOfBirth, YearOfBirth, Address, ProvinceId, DistrictId, Phone, Mobile, Email, Nationality, IsForeigner, InfoSourceId, CareerId, RateId, CreateDate, Creater, LastModify, LastModifier, Note, Hidden, InRoom, CompanyName, CompanyPhone, CompanyAddress, TaxCode, ReasonCome, TreatmentPeriod, ContactPhone, ContactEmail, ContactPost, IsContract, ContractNumber, Insurance, InsuranceCompany_ID, InsuranceNumber, DoctorExamination, DoctorTreatment, Broker_ID, BrokerCommission, Marketing, Collaborator, IsDelete, IsLock', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'Id' => 'ID',
            'FamilyID' => 'Family',
            'Code' => 'Code',
            'LastName' => 'Last Name',
            'FirstName' => 'First Name',
            'FullName' => 'Full Name',
            'FullName_EN' => 'Full Name En',
            'TitleId' => 'Title',
            'Image' => 'Image',
            'Sex' => 'Sex',
            'DateOfBirth' => 'Date Of Birth',
            'YearOfBirth' => 'Year Of Birth',
            'Address' => 'Address',
            'ProvinceId' => 'Province',
            'DistrictId' => 'District',
            'Phone' => 'Phone',
            'Mobile' => 'Mobile',
            'Email' => 'Email',
            'Nationality' => 'Nationality',
            'IsForeigner' => 'Is Foreigner',
            'InfoSourceId' => 'Info Source',
            'CareerId' => 'Career',
            'RateId' => 'Rate',
            'CreateDate' => 'Create Date',
            'Creater' => 'Creater',
            'LastModify' => 'Last Modify',
            'LastModifier' => 'Last Modifier',
            'Note' => 'Note',
            'Hidden' => 'Hidden',
            'InRoom' => 'In Room',
            'CompanyName' => 'Company Name',
            'CompanyPhone' => 'Company Phone',
            'CompanyAddress' => 'Company Address',
            'TaxCode' => 'Tax Code',
            'ReasonCome' => 'Reason Come',
            'TreatmentPeriod' => 'Treatment Period',
            'ContactPhone' => 'Contact Phone',
            'ContactEmail' => 'Contact Email',
            'ContactPost' => 'Contact Post',
            'IsContract' => 'Is Contract',
            'ContractNumber' => 'Contract Number',
            'Insurance' => 'Insurance',
            'InsuranceCompany_ID' => 'Insurance Company',
            'InsuranceNumber' => 'Insurance Number',
            'DoctorExamination' => 'Doctor Examination',
            'DoctorTreatment' => 'Doctor Treatment',
            'Broker_ID' => 'Broker',
            'BrokerCommission' => 'Broker Commission',
            'Marketing' => 'Marketing',
            'Collaborator' => 'Collaborator',
            'IsDelete' => 'Is Delete',
            'IsLock' => 'Is Lock',
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

        $criteria->compare('Id', $this->Id);
        $criteria->compare('FamilyID', $this->FamilyID);
        $criteria->compare('Code', $this->Code, true);
        $criteria->compare('LastName', $this->LastName, true);
        $criteria->compare('FirstName', $this->FirstName, true);
        $criteria->compare('FullName', $this->FullName, true);
        $criteria->compare('FullName_EN', $this->FullName_EN, true);
        $criteria->compare('TitleId', $this->TitleId);
        $criteria->compare('Image', $this->Image, true);
        $criteria->compare('Sex', $this->Sex);
        $criteria->compare('DateOfBirth', $this->DateOfBirth, true);
        $criteria->compare('YearOfBirth', $this->YearOfBirth);
        $criteria->compare('Address', $this->Address, true);
        $criteria->compare('ProvinceId', $this->ProvinceId);
        $criteria->compare('DistrictId', $this->DistrictId);
        $criteria->compare('Phone', $this->Phone, true);
        $criteria->compare('Mobile', $this->Mobile, true);
        $criteria->compare('Email', $this->Email, true);
        $criteria->compare('Nationality', $this->Nationality);
        $criteria->compare('IsForeigner', $this->IsForeigner);
        $criteria->compare('InfoSourceId', $this->InfoSourceId);
        $criteria->compare('CareerId', $this->CareerId);
        $criteria->compare('RateId', $this->RateId);
        $criteria->compare('CreateDate', $this->CreateDate, true);
        $criteria->compare('Creater', $this->Creater, true);
        $criteria->compare('LastModify', $this->LastModify, true);
        $criteria->compare('LastModifier', $this->LastModifier, true);
        $criteria->compare('Note', $this->Note, true);
        $criteria->compare('Hidden', $this->Hidden);
        $criteria->compare('InRoom', $this->InRoom);
        $criteria->compare('CompanyName', $this->CompanyName, true);
        $criteria->compare('CompanyPhone', $this->CompanyPhone, true);
        $criteria->compare('CompanyAddress', $this->CompanyAddress, true);
        $criteria->compare('TaxCode', $this->TaxCode, true);
        $criteria->compare('ReasonCome', $this->ReasonCome, true);
        $criteria->compare('TreatmentPeriod', $this->TreatmentPeriod);
        $criteria->compare('ContactPhone', $this->ContactPhone);
        $criteria->compare('ContactEmail', $this->ContactEmail);
        $criteria->compare('ContactPost', $this->ContactPost);
        $criteria->compare('IsContract', $this->IsContract);
        $criteria->compare('ContractNumber', $this->ContractNumber, true);
        $criteria->compare('Insurance', $this->Insurance);
        $criteria->compare('InsuranceCompany_ID', $this->InsuranceCompany_ID);
        $criteria->compare('InsuranceNumber', $this->InsuranceNumber, true);
        $criteria->compare('DoctorExamination', $this->DoctorExamination);
        $criteria->compare('DoctorTreatment', $this->DoctorTreatment);
        $criteria->compare('Broker_ID', $this->Broker_ID);
        $criteria->compare('BrokerCommission', $this->BrokerCommission);
        $criteria->compare('Marketing', $this->Marketing);
        $criteria->compare('Collaborator', $this->Collaborator);
        $criteria->compare('IsDelete', $this->IsDelete);
        $criteria->compare('IsLock', $this->IsLock);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
                    'rCity' => array(self::BELONGS_TO, 'Renodcm3TbProvince', 'ProvinceId'),
                    'rDistrict' => array(self::BELONGS_TO, 'Renodcm3TbDistrict', 'DistrictId'),
                    'rCreatedBy' => array(self::BELONGS_TO, 'RsTbAccount', 'Creater'),
                    'rTreatmentProfiles' => array(
                        self::HAS_MANY, 'Renodcm3TbTreatmentprofiles', 'Patient_ID',
                    ),
                    'rTreatment' => array(
                        self::HAS_MANY, 'Renodcm3TbTreatment', 'Patient_ID',
                    ),
        );
    }
    
    public function createFieldsLbl() {
        $fields = array();
        
        $fields[] = 'Code';
        $fields[] = 'FullName';
        $fields[] = 'Sex';
        $fields[] = 'DateOfBirth';
        $fields[] = 'YearOfBirth';
        $fields[] = 'Mobile';
        $fields[] = 'Email';
        $fields[] = 'City';
        $fields[] = 'District';
        $fields[] = 'Address';
        $fields[] = 'CreatedBy';
        $fields[] = 'CreateDate';
        return $fields;
    }
    
    public function createFields() {
        $fields = array();
        
        $fields[] = 'Code: ' . $this->Code;
        $fields[] = 'FullName: ' . $this->FullName;
        $fields[] = 'Sex: ' . $this->Sex;
        $fields[] = 'DateOfBirth: ' . $this->DateOfBirth;
        $fields[] = 'YearOfBirth: ' . $this->YearOfBirth;
        $fields[] = 'Mobile: ' . $this->Mobile;
        $fields[] = 'Email: ' . $this->Email;
        $fields[] = 'City: ' . (isset($this->rCity) ? $this->rCity->Name : '');
        $fields[] = 'District: ' . (isset($this->rDistrict) ? $this->rDistrict->Name : '');
        $fields[] = 'Address: ' . $this->Address;
        $fields[] = 'Created by: ' . $this->getCreatedBy();
        $fields[] = 'CreateDate: ' . $this->CreateDate;
        return $fields;
    }
    
    public function getCreatedBy() {
        return isset($this->rCreatedBy) ? $this->rCreatedBy->Name : '';
    }
    
    public function createChildData($relation, $fieldId) {
        $retVal = array();
        
        foreach ($this->$relation as $model) {
//            $retVal[] = '[' . implode('][', $model->createFieldsLbl()) . ']';
            $retVal[$model->$fieldId] = $model->createFields();
            switch ($relation) {
                case 'rTreatmentProfiles':
                    $retVal['-TreatmentSchedule-' . $model->$fieldId] = Customers::transferTreatmentSchedule($model, NULL, '', true);
                    $retVal['-Treatment-' . $model->$fieldId] = $model->createChildData('renodcm3TbTreatment', 'Treatment_Id');
                    $retVal['-TreatmentDetail-' . $model->$fieldId] = $model->createChildData('renodcm3TbTreatmentdetails', 'Id');
                    $retVal['-Phieu thu-' . $model->$fieldId] = $model->createChildData('renodcm3TbPhieuthu', 'Id');
                    break;
                case 'rTreatment':
//                    $retVal['-Chi tiet phieu thu-' . $model->$fieldId] = $model->createChildData('renodcm3TbChitietphieuthus', 'Id');
                    break;

                default:
                    break;
            }
            
        }
        return $retVal;
    }

    public static function import($agentId, $isValidate = true) {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 600);
        $models = self::model()->findAll(array(
            'order' => 'id desc',
             'limit' => 100,
//            'condition'  => 't.Code = ' . '01999',
//            'condition'  => 't.Code = ' . '017841',
//            'condition' => 't.Id >= 1 AND t.Id <= 5000',
//            'condition' => 't.Id >= 5001 AND t.Id <= 10000',
//            'condition' => 't.Id >= 10001 AND t.Id <= 15000',
//            'condition' => 't.Id >= 15001 AND t.Id <= 20000',
            
        ));
        $print = array();
        
//        CommonProcess::dumpVariable(count($models));
        foreach ($models as $model) {
            if ($isValidate) {
                $fields = $model->createFields();
//                $print[] = '[' . implode('][', $model->createFieldsLbl()) . ']';
//                $print[$model->Id] = '[' . implode('][', $fields) . ']';
                $print[$model->Id] = $fields;
//                $print['-Customer-' . $model->Id] = self::validateCustomer($model);
                $customer = new Customers();
                $print['-Customer-' . $model->Id] = Customers::saveCustomer($model, $agentId, $customer, true, true);
                $print['-TreatmentProfile-' . $model->Id] = $model->createChildData('rTreatmentProfiles', 'TreatmentProfiles_ID');
//                $print['-Treatment-' . $model->Id] = $model->createChildData('rTreatment', 'Treatment_Id');
            } else {
                // Transfer customer
                $medicalRecordId = Customers::transferCustomer($model, $agentId);
                if (!empty($medicalRecordId)) {
                    $treatmentId = '';
                    // Transfer treatment profiles
                    foreach ($model->rTreatmentProfiles as $renoTreatmentProfile) {
                        $treatmentId = Customers::transferTreatmentSchedule($renoTreatmentProfile, $medicalRecordId, $agentId);
                        if (!empty($treatmentId)) {
                            $detailId = '';
                            if (!empty($renoTreatmentProfile->renodcm3TbTreatment)) {
                                // Transfer treatment
                                foreach ($renoTreatmentProfile->renodcm3TbTreatment as $treatment) {
                                    $detailId = Customers::transferTreatmentScheduleDetail($treatment, $treatmentId, $agentId);
                                }
                            } else {
                                $detailId = Customers::createNewTreatmentDetail($renoTreatmentProfile, $treatmentId);
                            }
                            if (!empty($detailId)) {
                                foreach ($renoTreatmentProfile->renodcm3TbTreatmentdetails as $treatmentDetail) {
                                    Customers::transferTreatmentProcess($treatmentDetail, $detailId, $agentId);
                                }
                            }
                        }
                    }
                }
            }
        }
        
//        echo '<pre>';
//        print_r($print);
//        echo '</pre>';
        return $print;
    }
}
