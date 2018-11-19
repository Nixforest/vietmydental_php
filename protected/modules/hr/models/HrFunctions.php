<?php

/**
 * This is the model class for table "hr_functions".
 *
 * The followings are the available columns in table 'hr_functions':
 * @property string $id             Id of record
 * @property string $name           Name of function
 * @property string $function       Function content
 * @property integer $role_id       Id of role
 * @property integer $type_id       Id of type
 * @property integer $is_per_day    Flag function per day
 * @property integer $status        Status
 * @property string $created_date   Created date
 * @property string $created_by     Created by
 *
 * The followings are the available model relations:
 * @property Users                      $rCreatedBy                     User created this record
 * @property Roles                      $rRole                          Role belong to
 * @property HrFunctionTypes            $rType                          HrFunctionTypes belong to
 * @property HrParameters[]             $rParameters                    List parameters belong to
 * @property HrCoefficients[]           $rCoefficients                  List coefficients belong to
 */
class HrFunctions extends HrActiveRecord {

    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    /** Inactive */
    const STATUS_INACTIVE           = 0;

    /** Active */
    const STATUS_ACTIVE             = 1;

    /** List of keywords */
    const LIST_KEYWORD              = 'TS|HS';

    /** Parameter keyword */
    const KEYWORD_PARAM             = 'TS';

    /** Coefficient keyword */
    const KEYWORD_COEFFICIENT       = 'HS';

    /** Condition keyword */
    const KEYWORD_CONDITION         = 'IF';

    /** Type of function is count day per day */
    const FUNCTION_TYPE_COUNT       = '1';

    /** Type of function is calculate from date to a day (range of date) */
    const FUNCTION_TYPE_RANGE       = '0';

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return HrFunctions the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'hr_functions';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, type_id', 'required'),
            array('role_id, type_id, is_per_day, status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 255),
            array('created_by', 'length', 'max' => 10),
            array('function, created_date', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, function, role_id, type_id, is_per_day, status, created_date, created_by', 'safe', 'on' => 'search'),
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
            'rRole' => array(self::BELONGS_TO, 'Roles', 'role_id'),
            'rType' => array(
                self::BELONGS_TO, 'HrFunctionTypes', 'type_id',
                'on' => 'status !=' . HrFunctionTypes::STATUS_INACTIVE,
            ),
            'rParameters' => array(
                self::MANY_MANY, 'HrParameters', 'one_many(one_id, many_id)',
                'condition' => 'rParameters_rParameters.type=' . OneMany::TYPE_FUNCTION_PARAMETER,
            ),
            'rCoefficients' => array(
                self::MANY_MANY, 'HrCoefficients', 'one_many(one_id, many_id)',
                'condition' => 'rCoefficients_rCoefficients.type=' . OneMany::TYPE_FUNCTION_COEFFICIENT,
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id'            => 'ID',
            'name'          => DomainConst::CONTENT00042,
            'function'      => DomainConst::CONTENT00501,
            'role_id'       => DomainConst::CONTENT00488,
            'type_id'       => DomainConst::CONTENT00502,
            'is_per_day'    => DomainConst::CONTENT00503,
            'status'        => DomainConst::CONTENT00026,
            'created_date'  => DomainConst::CONTENT00010,
            'created_by'    => DomainConst::CONTENT00054,
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('function', $this->function, true);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('type_id', $this->type_id);
        $criteria->compare('is_per_day', $this->is_per_day);
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
            $this->created_by = Yii::app()->user->id;

            // Handle created date
            $this->created_date = CommonProcess::getCurrentDateTime();
        }

        return parent::beforeSave();
    }
    
    /**
     * Override before delete method
     * @return Parent result
     */
    protected function beforeDelete() {
        $retVal = true;
        // Delete all relation param
        OneMany::deleteAllOldRecords($this->id, OneMany::TYPE_FUNCTION_PARAMETER);
        OneMany::deleteAllOldRecords($this->id, OneMany::TYPE_FUNCTION_COEFFICIENT);
        return $retVal;
    }

    //-----------------------------------------------------
    // Utility methods
    //-----------------------------------------------------
    /**
     * Return status string
     * @return string Status value as string
     */
    public function getStatus() {
        if (isset(self::getArrayStatus()[$this->status])) {
            return self::getArrayStatus()[$this->status];
        }
        return '';
    }

    /**
     * Get value of function
     * @param String $from  Date from
     * @param String $to    Date to
     * @return Float Value of function
     */
    public function getValue($from, $to, $mUser) {
        $retVal = 0;
        if ($this->is_per_day == self::FUNCTION_TYPE_RANGE) {
            $function = $this->convertFunctionToValue($from, $to, $mUser);
            $retVal = self::calculateFunction($function);
        } else {
            $retVal = $this->getCountValue($from, $to, $mUser);
        }
        return $retVal;
    }
    /**
     * Get value of function
     * @param String $from  Date from
     * @param String $to    Date to
     * @return String Value of function was formated
     */
    public function getFormatedValue($from, $to, $mUser) {
        return CommonProcess::formatCurrency($this->getValue($from, $to, $mUser));
    }

    /**
     * Get function as human readable
     * @return String Function as human readable
     */
    public function getUnderstandingFunction() {
        $aParamModels = isset($this->rParameters) ? $this->rParameters : array();
        $aCoeffModels = isset($this->rCoefficients) ? $this->rCoefficients : array();
        $retVal = $this->function;
        $idx = 1;
        foreach ($aParamModels as $param) {
            $name = $param->getName();
            $retVal = str_ireplace(self::KEYWORD_PARAM . $idx++, ' [' . $name . '] ', $retVal);
        }
        $idxx = 1;
        foreach ($aCoeffModels as $coefficient) {
            $name = $coefficient->getName();
            $retVal = str_ireplace(self::KEYWORD_COEFFICIENT . $idxx++, ' [' . $name . '] ', $retVal);
        }
        foreach (self::getArrOperators() as $key => $value) {
            $retVal = str_ireplace($key, $value, $retVal);
        }

        return $retVal;
    }

    /**
     * Get type
     * @return string Name of type
     */
    public function getType() {
        if (isset($this->rType)) {
            return $this->rType->name;
        }
        return '';
    }

    /**
     * Get is_per_day value in text
     * @return string is_per_day value in text
     */
    public function isPerDayText() {
        if ($this->is_per_day == self::FUNCTION_TYPE_COUNT) {
            return DomainConst::CONTENT00512;
        }
        return DomainConst::CONTENT00513;
    }

    /**
     * Get array variables name
     * @return array List variables name
     */
    public function getArrVariablesName() {
        $retVal = array();
        $matches = array();
        preg_match_all('/(' . self::LIST_KEYWORD . ')\w+/', strtoupper($this->function), $matches);
        if (isset($matches[0])) {
            foreach ($matches[0] as $value) {
                if (!in_array($value, $retVal)) {
                    $retVal[] = $value;
                }
            }
        }

        return $retVal;
    }

    /**
     * Get parameter model by index
     * @param Int $index Index of parameter
     * @return HrParameters Object model if exist, NULL otherwise
     */
    public function getParamModel($index) {
        if ($index <= 0) {
            return NULL;
        }
        if (isset($this->rParameters)) {
            if (isset($this->rParameters[$index - 1])) {
                return $this->rParameters[$index - 1];
            }
        }
        return NULL;
    }

    /**
     * Get coefficient model by index
     * @param Int $index Index of coefficient
     * @return HrCoefficients Object model if exist, NULL otherwise
     */
    public function getCoefficientModel($index) {
        if ($index <= 0) {
            return NULL;
        }
        if (isset($this->rCoefficients)) {
            if (isset($this->rCoefficients[$index - 1])) {
                return $this->rCoefficients[$index - 1];
            }
        }
        return NULL;
    }

    /**
     * Convert function to value
     * @param String $from Date from (format is DATE_FORMAT_4 - 'Y-m-d')
     * @param String $to Date to (format is DATE_FORMAT_4 - 'Y-m-d')
     * @param Users $mUser User model
     * @return String Function as string
     */
    public function convertFunctionToValue($from, $to, $mUser) {
        $arrValues = array();
        // Get list variable
        $arrVariables = $this->getArrVariablesName();
        // List list value of parameter
        foreach ($arrVariables as $value) {
            $model = NULL;
            if (strpos($value, self::KEYWORD_PARAM) !== false) {
                $index = str_replace(self::KEYWORD_PARAM, '', $value);
                $model = $this->getParamModel($index);
                if (isset($model)) {
                    $arrValues[$value] = $model->getValue($from, $to, $mUser);
                }
            } else if (strpos($value, self::KEYWORD_COEFFICIENT) !== false) {
                $index = str_replace(self::KEYWORD_COEFFICIENT, '', $value);
                $model = $this->getCoefficientModel($index);
                if (isset($model)) {
                    $arrValues[$value] = $model->getValue();
                }
            }
        }
        
        Loggers::info('Values', CommonProcess::json_encode_unicode($arrValues), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        $function = self::normalizationFunction($this->function, 'retVal');
        foreach ($arrValues as $key => $value) {
            $function = str_replace($key, $value, $function);
        }
        return $function;
    }

    /**
     * Get value of function (for timesheet type)
     * @param String $from Date from (format is DATE_FORMAT_4 - 'Y-m-d')
     * @param String $to Date to (format is DATE_FORMAT_4 - 'Y-m-d')
     * @param Users $mUser User model
     * @return Number Value of total
     */
    public function getCountValue($from, $to, $mUser) {
        $retVal = 0;
        $begin = new DateTime($from);
        $end = (new DateTime($to))->modify('+1 day');
        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);
        $total = 0;
        // Loop for all date between range - Check date by date
        foreach ($period as $dt) {
            $dateValue = $dt->format(DomainConst::DATE_FORMAT_4);
            $function = $this->convertFunctionToValue($dateValue, $dateValue, $mUser);
            $retVal = self::calculateFunction($function);
            $total += $retVal;
        }

        return $total;
    }
    
    /**
     * Get all parameters
     * @return \CArrayDataProvider
     */
    public function getAllParameters() {
        return new CArrayDataProvider($this->rParameters, array(
            'id'    => 'hr_parameters',
            'sort'  => array(
                'attributes'    => HrParameters::model()->getTableSchema()->getColumnNames(),
            ),
            'pagination' => array(
                'pageSize' => Settings::getListPageSize(),
            ),
        ));
    }
    
    /**
     * Get all coefficients
     * @return \CArrayDataProvider
     */
    public function getAllCoefficients() {
        return new CArrayDataProvider($this->rCoefficients, array(
            'id'    => 'hr_coefficients',
            'sort'  => array(
                'attributes'    => HrCoefficients::model()->getTableSchema()->getColumnNames(),
            ),
            'pagination' => array(
                'pageSize' => Settings::getListPageSize(),
            ),
        ));
    }
    
    /**
     * Get html element
     * @param String $relation Name of relation
     * @param String $class Name of class
     * @return string Html formated
     */
    public function getElementHtml($relation, $class) {
        $retVal = '';
        $index = 1;
        foreach ($this->$relation as $value) {
            $retVal .= '<span class="btnDefault alreadyIn" data-id="' . $value->id . '" draggable="true">';
            $retVal .=      $index++ . ': ' . $value->getName();
            $retVal .= '<input class="display_none" name="HrFunctions[' . $this->id . '][' . $class . '][' . $value->id . ']" value="' . $value->id . '"/>';
            $retVal .= '</span>';
        }
        
        return $retVal;
    }
    
    /**
     * Get parameter html format
     * @return string Html formated
     */
    public function getParametersHtml() {
        return $this->getElementHtml('rParameters', 'param');
    }
    
    /**
     * Get coefficients html format
     * @return string Html formated
     */
    public function getCoefficientsHtml() {
        return $this->getElementHtml('rCoefficients', 'coeff');
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
            self::STATUS_INACTIVE => DomainConst::CONTENT00408,
            self::STATUS_ACTIVE => DomainConst::CONTENT00407,
        );
    }

    /**
     * Get array invalid char
     * @return Array Invalid chars
     */
    public static function getArrInvalidChar() {
        return array(
            '$'
        );
    }

    /**
     * Get list operators
     * @return Array List operators
     */
    public static function getArrOperators() {
        return array(
            '+' => ' + ',
            '-' => ' - ',
            '*' => ' * ',
            '/' => ' / ',
            '  ' => ' ',
        );
    }

    /**
     * Load list functions
     * @return Array List functions
     */
    public static function loadItems() {
        $models = self::model()->findAll();
        $retVal = [];
        foreach ($models as $model) {
            if ($model->status != self::STATUS_INACTIVE) {
                $retVal[$model->role_id][$model->type_id][$model->id] = $model;
            }
        }
        return $retVal;
    }

    /**
     * Check list variables was defined
     * @param Array $arrVariables   Array variables to check
     * @param Array $output         List variables was missing (output)
     * @return boolean True if all variables was defined, False otherwise
     */
    private static function issetVariables($arrVariables, &$output) {
        $allVariable = get_defined_vars();
        // Loop for all variables
        foreach ($arrVariables as $value) {
            if (!array_key_exists(strtoupper($value), $allVariable)) {
                $output[] = $value;
            }
        }

        // If list result is empty => All variables is valid
        if (!empty($output)) {
            return true;
        }

        return false;
    }

    /**
     * Normalization function string
     * @param String $strFunction Input function
     * @param String $outputName Name of output variable
     * @return string Function after normalization
     */
    private static function normalizationFunction($strFunction, $outputName) {
        $function = strtoupper($strFunction);
        foreach (self::getArrInvalidChar() as $value) {
            $function = str_replace($value, '', $function);
        }
        $index = strpos($function, self::KEYWORD_CONDITION, 0);
        while (!($index === false)) {
            $function = self::replaceStep(array('?'), ';', $function, true, array('limit' => 1), $index);
            $index = strpos($function, self::KEYWORD_CONDITION, $index + 1);
        }
        $function = str_replace(self::KEYWORD_CONDITION, '', $function);
        $function = str_replace(';', ':', $function);
        $strEval = '$' . $outputName . ' = ' . $function . ';';
        return $strEval;
    }

    /**
     * Replace keyword in function to be a calculable statement in PHP code
     * @param Array $aStep
     * @param String $strOld
     * @param String $strReplace
     * @param Bool $isLimit
     * @param String $aParam
     * @param Int $after
     * @return String Function after replace
     */
    private static function replaceStep($aStep, $strOld, $strReplace, $isLimit = false, $aParam = array(), $after = 0) {
        $limit = 0;
        $ii = 0;
        if (isset($aParam['limit'])) {
            $limit = $aParam['limit'];
        }
        $index = strpos($strReplace, $strOld, $after);
        while (!($index === false)) {
            if ($isLimit) {
                if ($limit <= 0) {
                    break;
                }
                $limit--;
            }
            $strStep = $aStep[$ii];
            $strReplace = substr_replace($strReplace, $strStep, $index, strlen($strOld));
            if (++$ii > (count($aStep) - 1)) {
                $ii = 0;
            }
            $index = strpos($strReplace, $strOld, $after);
        }
        return $strReplace;
    }

    /**
     * Calculate function
     * @param String $function Function
     * @return int Value of function
     */
    private static function calculateFunction($function) {
        $retVal = 0;
        set_error_handler(function() {
            throw new Exception(DomainConst::CONTENT00214);
        });
        try {
            Loggers::info('Function', $function, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            eval($function);
        } catch (Exception $ex) {
            $visibleFunc = str_replace('$retVal = ', "", $function);
            $visibleFunc = str_replace(';', "", $visibleFunc);
            Loggers::error(DomainConst::CONTENT00214, $ex->getMessage(), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            Loggers::error("Có lỗi chia cho 0!", $this->name . html_entity_decode('\n') . $visibleFunc, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        restore_error_handler();
        return $retVal;
    }
    
    /**
     * Get array is_per_day text
     * @return Array 
     */
    public static function getArrIsPerDayText() {
        return array(
            self::FUNCTION_TYPE_COUNT   => DomainConst::CONTENT00512,
            self::FUNCTION_TYPE_RANGE   => DomainConst::CONTENT00513,
        );
    }
    
    /**
     * Get list function
     * @param HrSalaryReport $report Model salary report
     * @return HrFunctions[] List functions
     */
    public static function getListFunctions($report) {
        $criteria = new CDbCriteria();
        $criteria->compare('role_id', $report->role_id);
        $criteria->compare('type_id', $report->type_id);
        $criteria->addCondition('status !=' . DomainConst::DEFAULT_STATUS_INACTIVE);
        return self::model()->findAll($criteria);
    }
    
    /**
     * Get list parameters
     * @param HrSalaryReport $report Model salary report
     * @return HrParameters[] List of parameters
     */
    public static function getListParameters($report) {
        $retVal = array();
        $mFunctions = self::getListFunctions($report);
        if ($mFunctions) {
            foreach ($mFunctions as $function) {
                if (isset($function->rParameters)) {
                    foreach ($function->rParameters as $param) {
                        if (!in_array($param->id, array_keys($retVal))) {
                            $retVal[$param->id] = $param;
                        }
                    }
                }
                
            }
        }
        return $retVal;
    }
    
    /**
     * Get list coefficients
     * @param HrSalaryReport $report Model salary report
     * @return HrCoefficients[] List of coefficients name
     */
    public static function getListCoefficients($report) {
        $retVal = array();
        $mFunctions = self::getListFunctions($report);
        if ($mFunctions) {
            foreach ($mFunctions as $function) {
                if (isset($function->rCoefficients)) {
                    foreach ($function->rCoefficients as $coef) {
                        if (!in_array($coef->id, array_keys($retVal))) {
                            $retVal[$coef->id] = $coef;
                        }
                    }
                }
                
            }
        }
        return $retVal;
    }

}
