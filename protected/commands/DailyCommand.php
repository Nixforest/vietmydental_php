<?php

//include_once '../config/info.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DailyCommand
 *
 * @author nguyenpt
 */
class DailyCommand extends CConsoleCommand {
    public function run($arg) {
        try {
            self::doRun();
        } catch (Exception $ex) {
            CommonProcess::dumpVariable($ex->getMessage());
        }
    }
    
    /**
     * Run command
     */
    public static function doRun() {
        Loggers::info('Run daily command: ', 'Start', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        // Send sms alert schedule tomorrow
        if (Settings::getItem(Settings::KEY_SMS_SEND_ALARM_SCHEDULE)) {
            $date = CommonProcess::getTomorrowDateTime(DomainConst::DATE_FORMAT_4);
            $dateTime = CommonProcess::getCurrentDateTime();
            $arrCustomerId = TreatmentScheduleDetails::getListCustomerIdHaveScheduleToday($date);
            $criteria = new CDbCriteria();
            $criteria->addInCondition('id', $arrCustomerId);
            $models = Customers::model()->findAll($criteria);
            $type = Settings::KEY_SMS_SEND_ALARM_SCHEDULE;
            foreach ($models as $model) {
                SMSHandler::sendSMSSchedule($type,
                        $model->getPhone(),
                        'Quý Khách hàng đã đặt hẹn trên Hệ thống Nha Khoa Việt Mỹ vào lúc '
                            . $startTime . ' với bác sĩ ' . $doctor
                            . '. Quý Khách hàng vui lòng sắp xếp thời gian đến đúng hẹn',
                        $model->id,
                        $type,
                        $dateTime);
            }
        }
        
        Loggers::info('Run daily command: ', 'End', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
    }
}
