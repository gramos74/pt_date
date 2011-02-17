<?php

#   Copyright 2011, Gabriel Ramos <gabi@gabiramos.com>
#
#   Licensed under the Apache License, Version 2.0 (the "License");
#   you may not use this file except in compliance with the License.
#   You may obtain a copy of the License at
#
#       http://www.apache.org/licenses/LICENSE-2.0
#
#   Unless required by applicable law or agreed to in writing, software
#   distributed under the License is distributed on an "AS IS" BASIS,
#   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
#   See the License for the specific language governing permissions and
#   limitations under the License.

/**
 * pt_date 
 * 
 * @author Gabriel Ramos <gabi@gabiramos.com>
 */


class pt_date 
{
    
    protected $_date;
    protected $_format;
    
    public function __construct($date = null, $format = null) 
    {
        if (is_null($format)) $format = array('datetime' => "%Y-%m-%d %H:%M:%S", 'date' =>"%Y-%m-%d");
        $this->_format = $format;

        if (is_null($date)) {
            $this->_date = time();
            
        } else if (is_string($date)) {            
            $date = $this->_string2time($date);
            if ($date === false) throw new pt_date_exception("Date format does not match with string date or string date is not a valid date");
            $this->_date = mktime($date['tm_hour'], $date['tm_min'], $date['tm_sec'], $date['tm_mon'] + 1, $date['tm_mday'] ,$date['tm_year'] + 1900);
            
        } else if (is_numeric($date)) {
            $this->_date = $date;
            
        } else if (get_class($date) == 'pt_date') {
            $this->_date = $date->_date;    
            
        } else {
            throw new pt_date_exception("Type of date".gettype($date)." not supported");
        }
    }

    public function set_format($format) {
        $this->_format = $format;
    }
    
    public function month() {
        $date = $this->_string2time($this->as_string());
        return (integer)$date['tm_mon'] +1;
    }
    
    public function day() {
        $date = $this->_string2time($this->as_string());
        return (integer)$date['tm_mday'];
    }    

    public function year() {
        $date = $this->_string2time($this->as_string());
        return 1900 + (integer)$date['tm_year'];
    }    




    // ***********************************************************************************
    // Manipulation of the date
    // ***********************************************************************************    
    public function move_to_begin_of_day() {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime(0, 0, 0, $date['tm_mon'] +1,$date['tm_mday'] ,$date['tm_year'] + 1900);  
        return $this;          
    }

    public function move_to_end_of_day() {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime(23, 59, 59, $date['tm_mon'] +1, $date['tm_mday'] ,$date['tm_year'] + 1900);  
        return $this;          
    }

    public function move_to_begin_of_week() {
        $date = $this->_string2time($this->as_string());

        $day_week = $date['tm_wday'];
        if ($day_week != 1) $this->add_days($day_week == 0 ? -6 : -($day_week -1));
        $this->move_to_begin_of_day();
        return $this;          
    }

    public function move_to_end_of_week() {
        $date = $this->_string2time($this->as_string());

        $day_week = $date['tm_wday'];
        if ($day_week) $this->add_days(7 - $day_week);
        $this->move_to_end_of_day();
        return $this;          
    }

    public function move_to_day_of_month($day) {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime(0, 0, 0, $date['tm_mon'] +1, $day ,$date['tm_year'] + 1900);  
        return $this;              
    }

    public function move_to_begin_of_month() {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime(0, 0, 0, $date['tm_mon'] +1, 1 ,$date['tm_year'] + 1900);  
        return $this;          
    }

    public function move_to_end_of_month() {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime(23, 59, 59, $date['tm_mon'] +2, 0 ,$date['tm_year'] + 1900);  
        return $this;          
    }

    public function move_to_begin_of_year() {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime(0, 0, 0, 1, 1 ,$date['tm_year'] + 1900);  
        return $this;          
    }

    public function move_to_end_of_year() {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime(23, 59, 59, 12, 31 ,$date['tm_year'] + 1900);  
        return $this;          
    }

    public function add_seconds($seconds) {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime($date['tm_hour'], $date['tm_min'], $date['tm_sec'] + $seconds, $date['tm_mon'] + 1 , $date['tm_mday'], $date['tm_year'] + 1900); 
        return $this;         
    }

    public function add_minutes($minutes) {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime($date['tm_hour'], $date['tm_min'] + $minutes, $date['tm_sec'], $date['tm_mon'] + 1 , $date['tm_mday'], $date['tm_year'] + 1900); 
        return $this;         
    }

    public function add_hours($hours) {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime($date['tm_hour'] + $hours, $date['tm_min'], $date['tm_sec'], $date['tm_mon'] + 1 , $date['tm_mday'], $date['tm_year'] + 1900); 
        return $this;         
    }

    public function add_days($numdays) {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime($date['tm_hour'], $date['tm_min'], $date['tm_sec'], $date['tm_mon'] +1, $date['tm_mday'] + $numdays, $date['tm_year'] + 1900);  
        return $this;          
    }
    
    public function add_months($months) {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime($date['tm_hour'], $date['tm_min'], $date['tm_sec'], $date['tm_mon'] + 1 + $months, $date['tm_mday'] ,$date['tm_year'] + 1900); 

        $day_period = $date['tm_mday'];            
        $date = $this->_string2time($this->as_string());
        
        if ($day_period != $date['tm_mday']) {
            if ($day_period < $date['tm_mday']) throw new pt_date_exception("Data corrupted");
            $this->add_months(-1)->move_to_end_of_month();            
        }  
        
        return $this;         
    }

    public function add_years($years) {
        $date = $this->_string2time($this->as_string());
        $this->_date = mktime($date['tm_hour'], $date['tm_min'], $date['tm_sec'], $date['tm_mon'] + 1, $date['tm_mday'] ,$date['tm_year'] + 1900 + $years); 

        $day_period = $date['tm_mday'];            
        $date = $this->_string2time($this->as_string());
        
        if ($day_period != $date['tm_mday']) {
            if ($day_period < $date['tm_mday']) throw new pt_date_exception("Data corrupted");
            $this->add_months(-1)->move_to_end_of_month();            
        }  
        
        return $this;         
    }
    
   



    // ***********************************************************************************
    // Get times between two dates
    // ***********************************************************************************    
    public function seconds_between($date) {
        $begin = new pt_date($date);
        $end = new pt_date($this);
        
        return abs(($begin->_date - $end->_date));
    }

    public function minutes_between($date) {
        $begin = new pt_date($date);
        $end = new pt_date($this);
        
        return (integer)(abs(($begin->_date - $end->_date)) / 60);
    }

    public function hours_between($date) {
        $begin = new pt_date($date);
        $end = new pt_date($this);
        
        return (integer)(abs(($begin->_date - $end->_date)) / 3600);
    }

    public function days_between($date) {
        $time_between = $this->time_between($date);
        return $time_between['days'] + ($time_between['weeks'] * 7);
    }

    public function weeks_between($date) {
        $time_between = $this->time_between($date);
        return $time_between['weeks'];
    }

    public function months_between($date) {
        $months = $date->month() - $this->month();
        $months += ($date->year() - $this->year()) * 12;
        
        return $months;
    }

    public function years_between($date) {
        return $date->year() - $this->year();
    }


    // --------------------------------------------------------
    // time_between
    //
    // return time between two dates in the format:
    //    array('seconds', 'minutes', 'hours', 'days', 'weeks')
    // --------------------------------------------------------
    public function time_between($date) {

        $date = new pt_date($date);
        
        $from = $this->_string2time($this->as_string());
        $to = $this->_string2time($date->as_string());
        
        $diff = $date->as_numeric() - $this->as_numeric();
                
        $time_between = array();
        $time_between['seconds'] = abs($from['tm_sec'] - $to['tm_sec']);
        $time_between['minutes'] = abs($from['tm_min'] - $to['tm_min']);
        $time_between['hours'] = abs($from['tm_hour'] - $to['tm_hour']);
        $time_between['days'] = (integer)(abs($diff % 604800) / 86400);
        $time_between['weeks'] =(integer)(abs($diff / 604800));
        return $time_between;
                
    }
    


    
    // ***********************************************************************************
    // Comparation of dates
    // ***********************************************************************************    
    public function is_greater_than($date) {
        if (get_class($date) != 'pt_date') $date = new pt_date($date);
        return $this->_date > $date->_date;
    }

    public function is_greater_or_equal_than($date) {
        if (get_class($date) != 'pt_date') $date = new pt_date($date);
        return $this->_date >= $date->_date;
    }
    
    public function is_minor_than($date) {
        if (get_class($date) != 'pt_date') $date = new pt_date($date);
        return $this->_date < $date->_date;
    }

    public function is_minor_or_equal_than($date) {
        if (get_class($date) != 'pt_date') $date = new pt_date($date);
        return $this->_date <= $date->_date;
    }

    public function is_equal_than($date) {
        if (get_class($date) != 'pt_date') $date = new pt_date($date);
        return $this->_date == $date->_date;
    }
    
    

    
    // ***********************************************************************************
    // Output
    // ***********************************************************************************    
    public function as_string($format = null, $locale = null) {
        $format = is_null($format) ? $this->_format : $format;
        
        if (!is_array($format)) {        
            return strftime($format, $this->_date);
        }        
        
        if (isset($format['datetime'])) return strftime($format['datetime'], $this->_date);
        if (isset($format['date'])) return strftime($format['date'], $this->_date);
        if (isset($format['simple'])) return $this->strftime($format['date'], $this->_date);
        return "";
    }
    
    public function as_numeric() {
        return $this->_date;
    }
    
    public function __toString() {
        return $this->as_string();
    }

    protected function _string2time($string) {
        if (is_array($this->_format)) {
            $date = false;
            if (isset($this->_format['datetime'])) $date = strptime($string, $this->_format['datetime']);
            if ($date === false && isset($this->_format['date'])) $date = strptime($string, $this->_format['date']);
            return $date;
        }  else {
            return strptime($string, $this->_format);
        }    
    }
    
    

}

class pt_date_exception extends Exception {}; 

?>
