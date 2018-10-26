<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//include 'smtp.php';
//include("class.phpmailer.php");
/**
 * Description of EmailHandler
 *
 * @author NguyenPT
 */
class EmailHandler {
    /** Email provider SendGrid */
    const EMAIL_PROVIDER_SENDGRID = '1';

    /**
     * Get list Email provider
     * @return Array List Email provider
     */
    public static function getListEmailProvider() {
        return array(
            self::EMAIL_PROVIDER_SENDGRID => 'SendGrid',
        );
    }
    
    /**
     * Send email once
     * @param String $to        To email
     * @param String $from      From email
     * @param String $subject   Subject of email
     * @param String $content   Content of email
     */
    public static function sendEmailOnce($to, $from, $subject, $content) {
        $provider = Settings::getItem(Settings::KEY_EMAIL_PROVIDER);
        switch ($provider) {
            case self::EMAIL_PROVIDER_SENDGRID:
                Loggers::info('Start send email', self::getListEmailProvider()[$provider],
                        __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
                EmailSendGridHandler::sendEmailGrid($to, $from, $subject, $content);
                break;

            default:
                Loggers::error('Send email error', 'No provider', __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
                break;
        }
    }
    
    /**
     * Handle send email
     * @param Array $data Data of message
     * @param Boolean $requireView View or not
     * @return type
     */
    public static function send($data, $requireView = false) {
        $message = new YiiMailMessage($data[DomainConst::KEY_SUBJECT]);
        if (isset($data[DomainConst::KEY_VIEW])) {
            if ($requireView) {
                $path = YiiBase::getPathOfAlias(Yii::app()->mail->viewPath) . '/'
                        . $data[DomainConst::KEY_VIEW] . '.php';
                if (!file_exists($path)) {
                    return;
                }
            }
            $message->view = $data[DomainConst::KEY_VIEW];
        } else if ($requireView) {
            return;
        }
        
        // Body
        $message->setBody($data[DomainConst::KEY_PARAMS], 'text/html');
        
        // Receiver
        if (is_array($data[DomainConst::KEY_TO])) {
            foreach ($data[DomainConst::KEY_TO] as $value) {
                $message->addTo($value);
            }
        } else {
            $message->addTo($data[DomainConst::KEY_TO]);
        }
        
        // Sender
        $message->from = $data[DomainConst::KEY_FROM];
        $message->setFrom(array(
            $data[DomainConst::KEY_FROM] => Settings::getItem(Settings::KEY_EMAIL_MAIN_SUBJECT),
        ));
        
        // TODO - Hanl
        if (isset($data[DomainConst::KEY_ATTACHMENT])
                && !empty($data[DomainConst::KEY_ATTACHMENT])
                && file_exists($data[DomainConst::KEY_ATTACHMENT])) {
            $swiftAttachment = Swift_Attachment::fromPath($data[DomainConst::KEY_ATTACHMENT]);
            $message->attach($swiftAttachment);
        }
        return Yii::app()->mail->send($message);
    }
    
    /**
     * Handle send list email
     * @param Array $aData Array data of message
     */
    public static function sendAll($aData) {
        foreach ($aData as $data) {
            self::send($data);
        }
    }
    
    /**
     * Handle send email with a template
     * @param String $templateId Id of email template
     * @param Array $aSubject List of subject param
     * @param Array $aBody List of body param
     * @param String $sTo Address mail to
     * @return type
     */
    public static function sendTemplateMail($templateId, $aSubject, $aBody, $sTo) {
        // Get email template model
        $mEmailTemplate = EmailTemplates::model()->findByPk($templateId);
        
        // Subject
        $sSubject = $mEmailTemplate->subject;
        if (is_array($aSubject) && count($aSubject) > 0) {
            foreach ($aSubject as $key => $value) {
                $sSubject = str_replace($key, $value, $sSubject);
            }
        }
        
        // Body
        $sBody = $mEmailTemplate->body;
        if (is_array($aBody) && count($aBody) > 0) {
            foreach ($aBody as $key => $value) {
                $sBody = str_replace($key, $value, $sBody);
            }
        }
        
        $data = array(
            DomainConst::KEY_SUBJECT => $sSubject,
            DomainConst::KEY_PARAMS => array(
                DomainConst::KEY_MESSAGE => $sBody,
            ),
            DomainConst::KEY_VIEW => DomainConst::KEY_MESSAGE,
            DomainConst::KEY_TO => $sTo,
            DomainConst::KEY_FROM => Settings::getItem(Settings::KEY_ADMIN_EMAIL),
        );
        
        return EmailHandler::send($data);
    }
    
    /**
     * Handle send built-in email
     * @param Object $mScheduleEmail
     * @return type
     */
    public static function sendBuiltEmail($mScheduleEmail) {
        $data = array(
            DomainConst::KEY_SUBJECT => $mScheduleEmail->subject,
            DomainConst::KEY_PARAMS => array(
                DomainConst::KEY_MESSAGE => $mScheduleEmail->body,
            ),
            DomainConst::KEY_VIEW => DomainConst::KEY_MESSAGE,
            DomainConst::KEY_TO => $mScheduleEmail->email,
            DomainConst::KEY_FROM => Settings::getItem(Settings::KEY_ADMIN_EMAIL)
        );
        
        switch ($mScheduleEmail->type) {
            case '':
                break;

            default:
                break;
        }
        
        return EmailHandler::send($data);
    }
    
    /**
     * Send email manual
     * @param String $sSubject
     * @param String $sBody
     * @param String $sTo
     * @return type
     */
    public static function sendManual($sSubject, $sBody, $sTo) {
        $data = array(
            DomainConst::KEY_SUBJECT => $sSubject,
            DomainConst::KEY_PARAMS => array(
                DomainConst::KEY_MESSAGE => $sBody,
            ),
            DomainConst::KEY_VIEW => DomainConst::KEY_MESSAGE,
            DomainConst::KEY_TO => $sTo,
            DomainConst::KEY_FROM => Settings::getItem(Settings::KEY_ADMIN_EMAIL),
        );
        return self::send($data);
    }
    public static function sendMail() {
        try { 
            $transport = Swift_MailTransport::newInstance();
            $mailer = Swift_Mailer::newInstance($transport);
            $message = Swift_Message::newInstance('Wonderful Subject')
                    ->setFrom(array('nguyenpt@spj.vn' => 'John Doe'))
                    ->setTo(array('nixforest@live.com', 'nixforest21991920@gmail.com' => 'A name'))
                    ->setBody('Here is the message itself');

            $result = $mailer->send($message);
            Loggers::info('Result', $result, __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
            $mailer->getTransport()->stop();
        } catch (Swift_TransportException $e) {
            //this should be caught to understand if the issue is on transport
            Loggers::error('Swift_TransportException', $e->getMessage(), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        } catch (Exception $e) {
            Loggers::error('Exception', $e->getMessage(), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
    }
    
    public static function sendMail1() {
        // Create the mail transport configuration
        $transport = Swift_MailTransport::newInstance('ssl://mail.spj.vn', 465);

        // Create the message
        $message = Swift_Message::newInstance();
        $message->setTo(array(
          "nixforest@live.com" => "Aurelio De Rosa",
          "nixforest21991920@gmail.com" => "Audero"
        ));
        $message->setSubject("This email is sent using Swift Mailer");
        $message->setBody("You're our best client ever.");
        $message->setFrom("nguyenpt@spj.vn", "Your bank");

        // Send the email
        $mailer = Swift_Mailer::newInstance($transport);
        $mailer->send($message, $failedRecipients);
        print_r($failedRecipients);
    }
    
    public static function sendMailPA() {
        SendMail('nguyenpt@spj.vn', 'nixforest@live.com', 'Subject', 'Xin chao, toi muon gui mail lam roi!');
    }
    
    public static function sendMailByGmail() {
        $mail = new PHPMailer();

        $mail->IsSMTP();
        $mail->IsHTML(true);
//        $mail->Host = "ssl://smtp.gmail.com";
        $mail->Host = "smtp.gmail.com";

        $mail->Port = 465;
        $mail->SMTPSecure = "ssl";

        $mail->SMTPAuth = true;
        $mail->Username = "nixforest21991920@gmail.com";

        $mail->Password = "";



        $mail->Body = "<h3>SMTP Gmail</h3>";

        $mail->Subject = "SMTP Gmail";



        $mail->From = "********";

        $mail->FromName = "pavietnam";

        $mail->AddAddress("nixforest@live.com");



        if ($mail->Send()) {

            echo "OK!";
        } else {

            echo "Co loi!<br><br>";

            echo "Hiba: " . $mail->ErrorInfo;
        }
    }
    
    /**
     * Send email to request approved holiday plan
     * @param HrHolidayPlans    $mPlan Plan information
     * @param Users             $mUser User need to sending
     */
    public static function sendReqApprovedHolidayPlan($mPlan, $mUser) {
        $email      = $mUser->getEmail();
        $fullName   = $mUser->getFullName();
        $link       = Yii::app()->createAbsoluteUrl("hr/hrHolidayPlans/view", array(
                            'id'    => $mPlan->id,
                        ));
        $content    = "Xin chào: $fullName."
                       . "<br>Thông báo có Kế hoạch nghỉ lễ cần được phê duyệt."
                       . "<br>Vui lòng truy cập vào link bên dưới để thực hiện phê duyệt:"
                       . "<br>$link";
        $adminEmail = Settings::getItemValue(Settings::KEY_ADMIN_EMAIL);
        $subject    = Settings::getItemValue(Settings::KEY_EMAIL_MAIN_SUBJECT);
        EmailHandler::sendEmailOnce($email, $adminEmail, $subject, $content);
        
        Loggers::info('Sent email', $email,
                __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
    }
    
    /**
     * Send email to creator of holiday plan
     * @param HrHolidayPlans    $mPlan Plan information
     * @param Users             $mUser User need to sending
     */
    public static function sendApprovedHolidayPlan($mPlan, $mUser) {
        $email      = $mUser->getEmail();
        $fullName   = $mUser->getFullName();
        $link       = Yii::app()->createAbsoluteUrl("hr/hrHolidayPlans/view", array(
                            'id'    => $mPlan->id,
                        ));
        $content    = "Xin chào: $fullName."
                       . "<br>Thông báo Kế hoạch nghỉ lễ đã được cập nhật. "
                       . "<br>Vui lòng truy cập vào link bên dưới để xem thông tin chi tiết:"
                       . "<br>$link";
        $adminEmail = Settings::getItemValue(Settings::KEY_ADMIN_EMAIL);
        $subject    = Settings::getItemValue(Settings::KEY_EMAIL_MAIN_SUBJECT);
        EmailHandler::sendEmailOnce($email, $adminEmail, $subject, $content);
        
        Loggers::info('Sent email', $email,
                __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
    }
    
    /**
     * Send email about HrLeave record was updated by approver
     * @param HrLeaves $mLeave Model
     * @param Users $mUser Model user of creator
     */
    public static function sendApprovedHrLeave($mLeave, $mUser) {
        $email      = $mUser->getEmail();
        $fullName   = $mUser->getFullName();
        $link       = Yii::app()->createAbsoluteUrl("hr/hrLeaves/view", array(
                            'id'    => $mLeave->id,
                        ));
        $content    = "Xin chào: $fullName."
                       . "<br>Thông báo Thông tin nghỉ phép đã được cập nhật. "
                       . "<br>Vui lòng truy cập vào link bên dưới để xem thông tin chi tiết:"
                       . "<br>$link";
        $adminEmail = Settings::getItemValue(Settings::KEY_ADMIN_EMAIL);
        $subject    = Settings::getItemValue(Settings::KEY_EMAIL_MAIN_SUBJECT);
        EmailHandler::sendEmailOnce($email, $adminEmail, $subject, $content);
        
        Loggers::info('Sent email', $email,
                __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
    }
    
    /**
     * Send email to request approved HrLeaves record
     * @param HrLeaves $mLeave Model
     * @param Users $mUser Model user of approver
     */
    public static function sendReqApproveHrLeave($mLeave, $mUser) {
        $email      = $mUser->getEmail();
        $fullName   = $mUser->getFullName();
        $link       = Yii::app()->createAbsoluteUrl("hr/hrLeaves/update", array(
                            'id'    => $mLeave->id,
                        ));
        $content    = "Xin chào: $fullName."
                       . "<br>Thông báo có Thông tin nghỉ phép cần được phê duyệt."
                       . "<br>Vui lòng truy cập vào link bên dưới để thực hiện phê duyệt:"
                       . "<br>$link";
        $adminEmail = Settings::getItemValue(Settings::KEY_ADMIN_EMAIL);
        $subject    = Settings::getItemValue(Settings::KEY_EMAIL_MAIN_SUBJECT);
        EmailHandler::sendEmailOnce($email, $adminEmail, $subject, $content);
        
        Loggers::info('Sent email', $email,
                __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
    }
    
    /**
     * Send email to inform Working plan was created
     * @param HrWorkPlans   $mPlan Plan information
     * @param Users         $mUser User need to sending
     */
    public static function sendReqApprovedWorkPlan($mPlan, $mUser) {
        $email      = $mUser->getEmail();
        $fullName   = $mUser->getFullName();
        $link       = Yii::app()->createAbsoluteUrl("hr/hrWorkPlans/view", array(
                            'id'    => $mPlan->id,
                        ));
        $content    = "Xin chào: $fullName."
                       . "<br>Thông báo có Kế hoạch làm việc vừa được tạo."
                       . "<br>Vui lòng truy cập vào link bên dưới để xem thông tin chi tiết:"
                       . "<br>$link";
        $adminEmail = Settings::getItemValue(Settings::KEY_ADMIN_EMAIL);
        $subject    = Settings::getItemValue(Settings::KEY_EMAIL_MAIN_SUBJECT);
        EmailHandler::sendEmailOnce($email, $adminEmail, $subject, $content);
        
        Loggers::info('Sent email', $email,
                __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
    }
    
    /**
     * Send email about Working plan was updated by approver
     * @param HrWorkPlans   $mPlan Plan information
     * @param Users $mUser Model user of creator
     */
    public static function sendApprovedWorkPlan($mPlan, $mUser) {
        $email      = $mUser->getEmail();
        $fullName   = $mUser->getFullName();
        $link       = Yii::app()->createAbsoluteUrl("hr/hrWorkPlan/view", array(
                            'id'    => $mPlan->id,
                        ));
        $content    = "Xin chào: $fullName."
                       . "<br>Thông báo Kế hoạch làm việc đã được cập nhật. "
                       . "<br>Vui lòng truy cập vào link bên dưới để xem thông tin chi tiết:"
                       . "<br>$link";
        $adminEmail = Settings::getItemValue(Settings::KEY_ADMIN_EMAIL);
        $subject    = Settings::getItemValue(Settings::KEY_EMAIL_MAIN_SUBJECT);
        EmailHandler::sendEmailOnce($email, $adminEmail, $subject, $content);
        
        Loggers::info('Sent email', $email,
                __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
    }
}
