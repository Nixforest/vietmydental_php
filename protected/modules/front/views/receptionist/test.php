<?php
/* @var $this ReceptionistController */
?>
<div class="form">
    <pre>
        <?php echo $message; ?>
    </pre>
    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'medical-records-form',
        'enableAjaxValidation' => false,
    ));
//            CommonProcess::dumpVariable(count(Agents::loadItems()));
    ?>
    <select id="agent" name="agent">
        <?php
            $html = '';
            foreach (Agents::loadItems() as $key => $agent) {
                $select = '';
                if ($agentId == $key) {
                    $select = 'selected="selected"';
                }
                $html .= '<option value="' . $key . '" ' . $select . '>';
                $html .= $agent;
                $html .= '</option>';
            }
            echo $html;
        ?>
    </select>
    <br>
    <?php
//        $sms = new SmsVivasHandler();
//        $sms->login();
//        $sms->logout();
//        $sms->sendSms('1', '976994876', 'Test 123');
//        SMSHandler::sendSMSOnce('976994876', 'SMSHandler');
        $number = '0987654321';
    $phoneHandler = new PhoneHandler();
        $carrier = $phoneHandler->detect_number($number);
        echo $carrier; // Viettel

        $wrong_number = '01869453611';
        $carrier = $phoneHandler->detect_number($wrong_number);
        echo $carrier; // false
//        $COOKIE = '';
//        if (!empty($_SESSION['Set-Cookie'])) {
//            $COOKIE = $_SESSION['Set-Cookie'];
//        }
//        CommonProcess::echoTest('Set cookie: ', $COOKIE);
//        CommonProcess::echoTest('Session id: ', $sms->getSessionId());
//    CommonProcess::echoTest("First date of current month: ", CommonProcess::getFirstDateOfCurrentMonth(DomainConst::DATE_FORMAT_6));
//        $detail = TreatmentScheduleDetails::model()->findByPk(22);
//        if ($detail) {
//            CommonProcess::echoTest("Star time raw value: ", $detail->getStartTimeRawValue());
//        }
//        $user = Users::model()->findByPk(6);
//        if ($user) {
//            $today = CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_6);
//            $lastMonth = CommonProcess::getPreviousMonth(DomainConst::DATE_FORMAT_6);
//            $from = $lastMonth;
//            $to = $today;
//                CommonProcess::echoTest("List customer: ", "<br?");
////            foreach ($user->getListCustomerOfDoctor($from, $to) as $value) {
////                CommonProcess::echoTest("Customer: ", $value->name);
////            }
//                $result = TreatmentScheduleDetails::getListCustomerByDoctor($user->id, $from, $to);
////            foreach (sort($result) as $key => $value) {
//            foreach ($result as $key => $value) {
//                CommonProcess::echoTest("Customer: ", "$key - $value->name");
//            }
//            CommonProcess::echoTest("List customer after sort: ", "<br?");
////            sort($result);
////            sort($result, SORT_DESC | SORT_STRING);
//            uksort($result, 'strcasecmp');
//            foreach ($result as $key => $value) {
//              CommonProcess::echoTest("Customer: ", "$key - $value->name");
//            }
//            CommonProcess::echoTest("List customer after reverse: ", "<br?");
//            foreach (array_reverse($result) as $key => $value) {
//              CommonProcess::echoTest("Customer: ", "$key - $value->name");
//            }
////            CommonProcess::echoArrayKeyValue("List customer: ", TreatmentScheduleDetails::getListCustomerByDoctor($user->id, $from, $to));
//        }
//    
//        $keyword = "nam, 1993";
////        $keyword = "nam";
//        $arrKeywords = explode(",", $keyword);
//        if (is_array($arrKeywords) && count($arrKeywords) > 1) {
//            CommonProcess::echoTest("Is array = true", '.');
//        }
//    
//        $customer = Customers::model()->findByPk(9);
//        if ($customer) {
//            CommonProcess::echoTest("Year of birth: ", $customer->getBirthYear());
//        }
        
//    FirebaseHandler::sendCloudMessageToAndroid('cLZvo3RR_L4:APA91bGf3XOzajLs8hmVO87YHpYPD6eH4XrKwpW4dwC-21vK-MsPaSjsJNZSbbAom2g80iL5cwYxOeE1vN_t0zQFX11kNQpTF96f7gX_TL_jqWFBU1G5CCVwYUrIZQywm9eyxAFzpM3V',
//    Settings::getWebsiteName(),
//            'Có bệnh nhân mới: Phạm Nam Kha',
//            "Có bệnh nhân mới đang chờ điều trị",
//            array(
//                'category'  => FirebaseHandler::NOTIFY_CATEGORY_NEW_TREATMENT_SCHEDULE,
//                'id'        => '1',
//                'object_id' => '16905',
//            ));
            
    
//    $this->widget('application.extensions.qrcode.QRCodeGenerator',array(
//    'data' => 'http://vietmy.immortal.vn/index.php/front/customer/view/code/2526821586D9E',
//    'subfolderVar' => false,
//    'matrixPointSize' => 5,
//    'displayImage'=>true, // default to true, if set to false display a URL path
//    'errorCorrectionLevel'=>'L', // available parameter is L,M,Q,H
//    'matrixPointSize'=>4, // 1 to 10 only
//    'filePath' => DirectoryHandler::getRootPath() . '/uploads',
//    'filename' => 'temp',
//)) 
    ?>
    <div class="maincontent clearfix">
        <?php
//        $root = '{"username":"trangnt","password":"123123","gcm_device_token":"","apns_device_token":"cdef"}';
//        CommonProcess::echoTest("Get root value: ", CommonProcess::getValueFromJson(json_decode($root), 'apns_device_token'));
//        CommonProcess::echoTest("Id của Chẩn đoán [Khác]: ", Diagnosis::getOtherDiagnosisId());
//        $name = "Răng thừa";
//        $isExist = Diagnosis::isNameExist($name);
//        CommonProcess::echoTest("Chẩn đoán [$name] ", $isExist ? "đã có." : "chưa có.");
//        CommonProcess::echoTest("Previous month: ", CommonProcess::getPreviousMonth());
//        $model = Users::model()->findByPk(1038264);
//        if ($model) {
//            CommonProcess::echoTest('DirectoryHandler::getRootPath() . $model->getImageAvatarPath() = ', DirectoryHandler::getRootPath() . $model->getImageAvatarPath());
//            
////        CommonProcess::echoTest('DirectoryHandler::getRootPath() . $source = ', DirectoryHandler::getRootPath() . $model->getImageAvatarPath());
////        DirectoryHandler::deleteFile($model->getImageAvatarPath());
//        }
//
//        $name = "gan Thận";
//        $isExist = Pathological::isNameExist($name);
//        CommonProcess::echoTest("Bệnh lý [$name] ", $isExist ? "đã có." : "chưa có.");
//        for ($index = 0; $index < 4; $index++) {
//            CommonProcess::echoTest("$index / 2 = ", $index / 2);
//            CommonProcess::echoTest("$index % 2 = ", $index % 2);
//        }
////     for ($index = 0; $index < 30 ; $index++) {
////         CommonProcess::echoTest('Unique id: ', CommonProcess::generateUniqId());
////     }
//        CommonProcess::echoTest('Unique id: ', CommonProcess::generateUniqId());
////    $listUser = Users::getListUserEmail();
////    $listUser = ScheduleEmail::handleBuildEmailResetPass();
////    CommonProcess::echoTest("Test list user's emails: ", count($listUser));
////    foreach ($listUser as $user) {
////        CommonProcess::echoTest("&nbsp;&nbsp;&nbsp;&nbsp;User: ", "($user->first_name) - ($user->email)");
////    }
////    CommonProcess::echoTest("Test email reset pass: ", ScheduleEmail::handleRunEmailResetPass());
//
//        $from = time();
//        // Test email content
//        $user = Users::model()->findByAttributes(array(
//            'username' => 'nguyenpt',
//        ));
//        if ($user) {
//            CommonProcess::echoTest("Test email: ", $user->first_name);
//            $date = date('d-m-Y');
//            CommonProcess::echoTest("&nbsp;&nbsp;&nbsp;&nbsp;Current date: ", $date);
//            $data = array($date, $user->first_name, $user->temp_password, 'nkvietmy.com');
//            CommonProcess::echoTest("&nbsp;&nbsp;&nbsp;&nbsp;Data array: ", $data);
//            $content = EmailTemplates::createEmailContent($data);
//            CommonProcess::echoArrayKeyValue("&nbsp;&nbsp;&nbsp;&nbsp;Content array: ", $content);
//            CommonProcess::echoTest("&nbsp;&nbsp;&nbsp;&nbsp;Email: ", $user->email);
////        $emailData = EmailHandler::sendTemplateMail(EmailTemplates::TEMPLATE_ID_RESET_PASSWORD, $content, $content, $user->email);
////        CommonProcess::echoArrayKeyValue("&nbsp;&nbsp;&nbsp;&nbsp;Email data: ", $emailData);
////        CommonProcess::echoTest("&nbsp;&nbsp;&nbsp;&nbsp;Body: ", $emailData);
//        } else {
//            CommonProcess::echoTest("Can not find user", '');
//        }
//
////     SMSHandler::sendSMS('smsbrand_gas24h', '147a@258', 'HUONGMINH', 0,
////             '84976994876', 'Gas24h', 'bulksms',
////             'DH ADMIN TEST. Gia BB: 20,657 - Gia B12: 291,000 INDUSTRIAL001-Cong ty TNHH ',
////             0);
//        CommonProcess::echoTest("CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4): ", CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_4));
//        CommonProcess::echoTest("CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_6): ", CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_6));
//        // Test username
//        $fullName = "Phạm Trung Nguyên";
//        $fullName1 = "Ngô Quang Phục";
//        // Test generate username
//        CommonProcess::echoTest("Username of '$fullName': ", Users::generateUsername($fullName));
//        CommonProcess::echoTest("Username of '$fullName1': ", Users::generateUsername($fullName1));
//        CommonProcess::echoTest("Username converted from '$fullName': ", CommonProcess::getUsernameFromFullName($fullName));
//        CommonProcess::echoTest("Username converted from '$fullName1': ", CommonProcess::getUsernameFromFullName($fullName1));
//        // Test compare date
//        $date1 = "2018/03/23";
//        $date2 = "2018-03-23 23:09:27";
//        $date2 = CommonProcess::convertDateTime($date2, DomainConst::DATE_FORMAT_1, DomainConst::DATE_FORMAT_4);
//        CommonProcess::echoTest("Compare date '$date1' - '$date2': ", DateTimeExt::compare($date1, $date2, ''));
//        CommonProcess::echoTest("strtotime($date1): ", strtotime($date1));
//        CommonProcess::echoTest("strtotime($date2): ", strtotime($date2));
//        // Test DirectoryHandler
//        CommonProcess::echoTest('Yii::app()->createAbsoluteUrl(DIRECTORY_SEPARATOR): ', Yii::app()->createAbsoluteUrl(DIRECTORY_SEPARATOR));
//        CommonProcess::echoTest('Yii::app()->baseUrl: ', Yii::app()->baseUrl);
//        CommonProcess::echoTest('Yii::getPathOfAlias("webroot"): ', Yii::getPathOfAlias("webroot"));
//        CommonProcess::echoTest('Yii root path: ', DirectoryHandler::getRootPath() . '/upload/admin/users/img_avatar_1038265.png');

//    CommonProcess::echoTest('Create path from array: ', DirectoryHandler::createPath(array(
//        DirectoryHandler::getRootPath(),
//        'a',
//        'b',
//        'c'
//    )));
//        CommonProcess::echoTest('Yii root path: ', DirectoryHandler::getRootPath());
//        CommonProcess::echoTest('Current date time: ', CommonProcess::getCurrentDateTime(DomainConst::DATE_FORMAT_3));
//        $to = time();
//        ScheduleEmail::logInfo($from, $to, __METHOD__, 5);
        ?>
        
        <?php
        echo CHtml::submitButton('Import', array(
            'name' => 'import',
        ));
        echo CHtml::submitButton('Validate', array(
            'name' => 'validate',
        ));
        ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
<?php
    $doctorName = 'Dinh Tan Khoa';
//    $doctorName = '';
    $doctor = Users::getDoctorByName($doctorName, '1');
    if (!empty($doctor)) {
        CommonProcess::echoTest("Tên của bác sĩ $doctorName: ", $doctor->first_name);
    }
    $teeth = '11';
    $teethIndex = CommonProcess::convertTeethIndex($teeth);
    if (!empty($teethIndex)) {
        CommonProcess::echoTest("Răng số $teeth có tên là: ", CommonProcess::getListTeeth(false, '')[$teethIndex]);
    }
        
?>
