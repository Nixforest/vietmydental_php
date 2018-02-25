<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CmsFormatter
 *
 * @author NguyenPT
 */
class CmsFormatter extends CFormatter {
    /** Publish format */
    protected $publishFormat = array('0' => 'Unpublished', '1' => 'Published');

    /** Status format */
    protected $statusFormat = array('1' => 'Active', '0' => 'Inactive');

    /**
     * Format status type
     * @param array $value Value of status
     * @return String of status
     */
    public function formatStatus($value) {
        if (is_array($value)) {
            return (($value['status'] == DomainConst::DEFAULT_STATUS_INACTIVE) ?
                    CHtml::link(
                            DomainConst::CONTENT00028, array("ajaxActive", "id" => $value['id']), array(
                        "class" => "ajaxUpdate",
                        "title" => "Click here to " . $this->$publishFormat[0],
                            )
                    ) :
                    CHtml::link(
                            DomainConst::CONTENT00027, array("ajaxDeactivate", "id" => $value['id']), array(
                        "class" => "ajaxupdate",
                        "title" => "Click here to " . $this->publishFormat[1],
                            )
                    )
                    );
        } else {
            return $value == DomainConst::DEFAULT_STATUS_INACTIVE ? DomainConst::CONTENT00028 : DomainConst::CONTENT00027;
        }
    }

    /**
     * Format access type
     * @param array $value Value of access
     * @return String of access
     */
    public function formatAccess($value) {
        if (is_array($value)) {
            return (($value['status'] == DomainConst::DEFAULT_ACCESS_ALLOW) ?
                    CHtml::link(
                            DomainConst::CONTENT00032, array("ajaxActive", "id" => $value['id']), array(
                        "class" => "ajaxUpdate",
                        "title" => "Click here to " . $this->$publishFormat[1],
                            )
                    ) :
                    CHtml::link(
                            DomainConst::CONTENT00033, array("ajaxDeactivate", "id" => $value['id']), array(
                        "class" => "ajaxupdate",
                        "title" => "Click here to " . $this->publishFormat[0],
                            )
                    )
                    );
        } else {
            return $value == DomainConst::DEFAULT_ACCESS_ALLOW ? DomainConst::CONTENT00032 : DomainConst::CONTENT00033;
        }
    }

}
