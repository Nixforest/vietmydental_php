<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActiveRecordLogableBehavior
 *
 * @author nguyenpt
 */
class ActiveRecordLogableBehavior extends CActiveRecordBehavior {
    /** Old attribute */
    private $_oldattributes = array();
    /** Except classes */
    private $_exceptClasses = array(
        'ActiveRecordLogs',
        'PageCounts',
        'Loggers',
        'ApiRequestLogs',
        'ApiSigninRequests',
        'ApiUserTokens',
        'ActionsRoles',
        'ActionsUsers',
        'Applications',
        'Controllers',
        'ControllersActions',
        'Files',
        'LoginLogs',
        'Menus',
        'Modules',
        'OneMany',
        'ScheduleEmail',
        'ScheduleSms',
        'ScheduleSmsHistory',
        'UserActivities',
    );
    /** Except fields */
    private $_exceptFields = array(
        'created_date',
        'updated_date',
    );

    /**
     * Handle after save
     * @param type $event
     */
    public function afterSave($event) {
        $class = get_class($this->Owner);
        if (in_array($class, $this->_exceptClasses)) {
            return;
        }
        if ($this->Owner->isNewRecord) {
            $description   = 'User ' . Yii::app()->user->Name
                                . ' created ' . $class
                                . '[' . $this->Owner->getPrimaryKey() . '].';
            ActiveRecordLogs::insertOne($description, 'CREATE',
                            $class, $this->Owner->getPrimaryKey(),
                            '', '', '');
        } else {
            // new attributes
            $newattributes = $this->Owner->getAttributes();
            $oldattributes = $this->getOldAttributes();

            // compare old and new
            foreach ($newattributes as $name => $value) {
                if (!empty($oldattributes)) {
                    $old = $oldattributes[$name];
                } else {
                    $old = '';
                }

                if (($value != $old) && !in_array($name, $this->_exceptFields)) {
                    //$changes = $name . ' ('.$old.') => ('.$value.'), ';
                    $description   = 'User ' . Yii::app()->user->Name
                                            . ' changed ' . $name . ' for '
                                            . $class
                                            . '[' . $this->Owner->getPrimaryKey() . '].';
                    ActiveRecordLogs::insertOne($description, 'CHANGE',
                            $class, $this->Owner->getPrimaryKey(),
                            $name, $old, $value);
                }
            }
        }
    }

    /**
     * Handle after delete
     * @param type $event
     */
    public function afterDelete($event) {
        $class = get_class($this->Owner);
        if (in_array($class, $this->_exceptClasses)) {
            return;
        }
        $description = 'User ' . Yii::app()->user->Name . ' deleted '
                . $class
                . '[' . $this->Owner->getPrimaryKey() . '].';
        ActiveRecordLogs::insertOne($description, 'DELETE',
                        $class, $this->Owner->getPrimaryKey(),
                        '', '', '');
    }

    public function afterFind($event) {
        // Save old values
        $this->setOldAttributes($this->Owner->getAttributes());
    }

    public function getOldAttributes() {
        return $this->_oldattributes;
    }

    public function setOldAttributes($value) {
        $this->_oldattributes = $value;
    }

}
