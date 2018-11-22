<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This class contain methods which complex sql statement
 *
 * @author nguyenpt
 */
class SqlHandler {
    //-----------------------------------------------------
    // Constants
    //-----------------------------------------------------
    
    //-----------------------------------------------------
    // Methods
    //-----------------------------------------------------
    /**
     * Get appointment on date
     * @param String $date      Date value as format Y-m-d
     * @param String $agentId   Id of agent (Default is empty mean get from all agents)
     * @return Array List data appointment
     */
    public static function getAppointmentOnDate($date, $agentId = '') {
        try {
            $agentSqlWhere = '';
            $agentSqlSelect = '';
            $type = OneMany::TYPE_AGENT_CUSTOMER;
            if (!empty($agentId)) {
                $agentSqlSelect = ", om.one_id as agent_id";
                $agentSqlWhere = "AND om.one_id='$agentId'";
            }
            $sql = "SELECT rs2.id, rs2.name, rs2.record_number, rs2.phone, rs2.address, rs2.time_id, rs2.start_date, rs2.created_date, rs2.doctor_id$agentSqlSelect
                    FROM (SELECT c.id, c.name, rs1.record_number, c.phone, c.address, rs1.time_id, rs1.start_date, rs1.created_date, rs1.doctor_id
                        FROM `customers` as c
                        INNER JOIN
                            (SELECT md.customer_id, md.record_number, rs.start_date, rs.created_date, rs.time_id, rs.doctor_id FROM `medical_records` as md
                            INNER JOIN 
                                (SELECT t.id, t.record_id, t.doctor_id, td.start_date, td.created_date, td.time_id
                                FROM `treatment_schedules` as t
                                INNER JOIN `treatment_schedule_details` as td
                                ON t.id=td.schedule_id
                                WHERE DATE(td.start_date)='$date') as rs
                            ON md.id=rs.record_id) as rs1
                        ON rs1.customer_id=c.id
                        ORDER BY rs1.created_date) as rs2
                    INNER JOIN
                    `one_many` as om
                    ON om.many_id=rs2.id
                    WHERE om.type='$type' $agentSqlWhere";
            return Yii::app()->db->createCommand($sql)->queryAll();
        } catch (Exception $ex) {
            Loggers::error(DomainConst::CONTENT00214, $ex->getMessage(), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        return array();
    }
    
    /**
     * Get max record number
     * @param String $agent_id Id of agent
     * @return String Value of max record number
     */
    public static function getMaxRecordNumber($agent_id) {
        $retVal = '';
        try {
            $type = OneMany::TYPE_AGENT_CUSTOMER;
            $sql = "SELECT MAX(CAST(md.record_number AS INT)) as number
                    FROM medical_records as md
                    WHERE md.customer_id IN
                        (SELECT c.id FROM customers as c
                        INNER JOIN
                        `one_many` as om
                        ON om.many_id=c.id
                        WHERE om.type=$type AND om.one_id=$agent_id)";
            $result = Yii::app()->db->createCommand($sql)->queryAll();
            if (isset($result[0]['number'])) {
                $retVal = $result[0]['number'];
            }
        } catch (Exception $ex) {
            Loggers::error(DomainConst::CONTENT00214, $ex->getMessage(), __CLASS__ . '::' . __FUNCTION__ . '(' . __LINE__ . ')');
        }
        return $retVal;
    }
    
}
