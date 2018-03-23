<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailHandler
 *
 * @author NguyenPT
 */
class EmailHandler {
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
//        CommonProcess::dumpVariable($message->from);
//        CommonProcess::dumpVariable(Yii::app()->mail->transportOptions[DomainConst::KEY_HOST]);
//        CommonProcess::dumpVariable(Yii::app()->mail->class);
        return Yii::app()->mail->send($message);
//        return Yii::app()->mail->sendSimple('nguyenpt@spj.vn', 'nixforest@live.com', 'Subject', 'Body');
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
    
    public static function mailsend($to, $from, $from_name, $subject, $message, $cc = array(), $attachment = array()) {
        $mail = Yii::app()->Smtpmail;
        $mail->SetFrom($from, $from_name);
        $mail->Subject = $subject;
//        $mail->MsgHTML($this->mailTemplate($message));
        $mail->AddAddress($to, "");

        // Add CC
        if (!empty($cc)) {
            foreach ($cc as $email) {
                $mail->AddCC($email);
            }
        }

        // Add Attchments
        if (!empty($attachment)) {
            foreach ($attachment as $attach) {
                $mail->AddAttachment($attach);
            }
        }

        if (!$mail->Send()) {
            return false; // Fail echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            return true; // Success
        }
    }

}
