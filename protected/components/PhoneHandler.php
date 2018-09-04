<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Phone number handler class
 *
 * @author nguyenpt
 */
class PhoneHandler {
    private $carriers_number = array(
        '096'  => 'Viettel',
        '097'  => 'Viettel',
        '098'  => 'Viettel',
        '0162' => 'Viettel',
        '0163' => 'Viettel',
        '0164' => 'Viettel',
        '0165' => 'Viettel',
        '0166' => 'Viettel',
        '0167' => 'Viettel',
        '0168' => 'Viettel',
        '0169' => 'Viettel',

        '090'  => 'Mobifone',
        '093'  => 'Mobifone',
        '0120' => 'Mobifone',
        '0121' => 'Mobifone',
        '0122' => 'Mobifone',
        '0126' => 'Mobifone',
        '0128' => 'Mobifone',

        '091'  => 'Vinaphone',
        '094'  => 'Vinaphone',
        '0123' => 'Vinaphone',
        '0124' => 'Vinaphone',
        '0125' => 'Vinaphone',
        '0127' => 'Vinaphone',
        '0129' => 'Vinaphone',

        '0993' => 'Gmobile',
        '0994' => 'Gmobile',
        '0995' => 'Gmobile',
        '0996' => 'Gmobile',
        '0997' => 'Gmobile',
        '0199' => 'Gmobile',

        '092'  => 'Vietnamobile',
        '0186' => 'Vietnamobile',
        '0188' => 'Vietnamobile',

        '095'  => 'SFone'
    );
    
    private $network_number = array(
        '096'  => ScheduleSms::NETWORK_VIETTEL,
        '097'  => ScheduleSms::NETWORK_VIETTEL,
        '098'  => ScheduleSms::NETWORK_VIETTEL,
        '0162' => ScheduleSms::NETWORK_VIETTEL,
        '0163' => ScheduleSms::NETWORK_VIETTEL,
        '0164' => ScheduleSms::NETWORK_VIETTEL,
        '0165' => ScheduleSms::NETWORK_VIETTEL,
        '0166' => ScheduleSms::NETWORK_VIETTEL,
        '0167' => ScheduleSms::NETWORK_VIETTEL,
        '0168' => ScheduleSms::NETWORK_VIETTEL,
        '0169' => ScheduleSms::NETWORK_VIETTEL,

        '090'  => ScheduleSms::NETWORK_MOBI,
        '093'  => ScheduleSms::NETWORK_MOBI,
        '0120' => ScheduleSms::NETWORK_MOBI,
        '0121' => ScheduleSms::NETWORK_MOBI,
        '0122' => ScheduleSms::NETWORK_MOBI,
        '0126' => ScheduleSms::NETWORK_MOBI,
        '0128' => ScheduleSms::NETWORK_MOBI,

        '091'  => ScheduleSms::NETWORK_VINA,
        '094'  => ScheduleSms::NETWORK_VINA,
        '0123' => ScheduleSms::NETWORK_VINA,
        '0124' => ScheduleSms::NETWORK_VINA,
        '0125' => ScheduleSms::NETWORK_VINA,
        '0127' => ScheduleSms::NETWORK_VINA,
        '0129' => ScheduleSms::NETWORK_VINA,

        '0993' => ScheduleSms::NETWORK_G_MOBILE,
        '0994' => ScheduleSms::NETWORK_G_MOBILE,
        '0995' => ScheduleSms::NETWORK_G_MOBILE,
        '0996' => ScheduleSms::NETWORK_G_MOBILE,
        '0997' => ScheduleSms::NETWORK_G_MOBILE,
        '0199' => ScheduleSms::NETWORK_G_MOBILE,

        '092'  => ScheduleSms::NETWORK_VIETNAM_MOBILE,
        '0186' => ScheduleSms::NETWORK_VIETNAM_MOBILE,
        '0188' => ScheduleSms::NETWORK_VIETNAM_MOBILE,

        '095'  => ScheduleSms::NETWORK_S_PHONE
    );
    
    /*
    * Check if a string is started with another string
    *
    * @param (string) ($needle) The string being searched for.
    * @param (string) ($haystack) The string being searched
    * @return (boolean) true if $haystack is started with $needle
    */
    function start_with($needle, $haystack) {
        $length = strlen($needle);
        return (substr($haystack, 0, $length) === $needle);
    }
    
    /*
    * Detect carrier name by phone number
    *
    * @param (string) ($number) The input phone number
    * @return (mixed) Name of the carrier, false if not found
    */
   function detect_number($number) {
       $number = str_replace(array('-', '.', ' '), '', $number);

       // $number is not a phone number
       if (!preg_match('/^(01[2689]|09)[0-9]{8}$/', $number)) {
            return false;
        }

        // Store all start number in an array to search
       $start_numbers = array_keys($this->carriers_number);

       foreach ($start_numbers as $start_number) {
           // if $start number found in $number then return value of $carriers_number array as carrier name
           if ($this->start_with($start_number, $number)) {
               return $this->carriers_number[$start_number];
           }
       }

       // if not found, return false
       return false;
   }
   
    /*
    * Detect carrier name by phone number
    *
    * @param (string) ($number) The input phone number
    * @return (mixed) Name of the carrier, false if not found
    */
   function detect_number_network($number) {
       $number = str_replace(array('-', '.', ' '), '', $number);

       // $number is not a phone number
       if (!preg_match('/^(01[2689]|09)[0-9]{8}$/', $number)) {
            return false;
        }

        // Store all start number in an array to search
       $start_numbers = array_keys($this->network_number);

       foreach ($start_numbers as $start_number) {
           // if $start number found in $number then return value of $carriers_number array as carrier name
           if ($this->start_with($start_number, $number)) {
               return $this->network_number[$start_number];
           }
       }

       // if not found, return false
       return false;
   }
}
