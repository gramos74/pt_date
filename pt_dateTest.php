<?php

require_once("pt_date.php");

class DateTest extends PHPUnit_Framework_TestCase {

    
    public function test_month() {
        $date1 = new pt_date("2009-05-01");
        $this->assertEquals(5, $date1->month());    
    }

    public function test_seconds_between() {
        $date1 = new pt_date("2010-12-25 12:12:34");
        $date2 = new pt_date("2010-12-25 12:12:32");
        $this->assertEquals(2, $date1->seconds_between($date2));
        
        
        $date1 = new pt_date("2010-12-25 12:12:34");
        $date2 = new pt_date("2010-12-25 12:13:34");
        $this->assertEquals(60, $date1->seconds_between($date2));

        $date1 = new pt_date("2010-12-25 12:12:34");
        $date2 = new pt_date("2010-12-26 12:12:34");
        $this->assertEquals(86400, $date1->seconds_between($date2));
    }

    public function test_minutes_between() {
        $date1 = new pt_date("2010-12-25 12:12:34");
        $date2 = new pt_date("2010-12-25 12:12:32");
        $this->assertEquals(0, $date1->minutes_between($date2));
        
        
        $date1 = new pt_date("2010-12-25 12:12:34");
        $date2 = new pt_date("2010-12-25 12:13:34");
        $this->assertEquals(1, $date1->minutes_between($date2));

        $date1 = new pt_date("2010-12-25 12:12:34");
        $date2 = new pt_date("2010-12-26 12:12:34");
        $this->assertEquals(1440, $date1->minutes_between($date2));
    }


    public function test_hours_between() {
        $date1 = new pt_date("2010-12-25 12:12:34");
        $date2 = new pt_date("2010-12-25 12:12:32");
        $this->assertEquals(0, $date1->hours_between($date2));
        
        
        $date1 = new pt_date("2010-12-25 11:12:34");
        $date2 = new pt_date("2010-12-25 12:13:34");
        $this->assertEquals(1, $date1->hours_between($date2));

        $date1 = new pt_date("2010-12-25 12:12:34");
        $date2 = new pt_date("2010-12-26 12:12:34");
        $this->assertEquals(24, $date1->hours_between($date2));
    }

    public function test_days_between() {
        $date1 = new pt_date();
        $date2 = new pt_date();
        $date2->add_hours(2);        
        $this->assertEquals(0, $date1->days_between($date2));

        $date1 = new pt_date();
        $date2 = new pt_date();
        $date2->add_days(1);        
        $this->assertEquals(1, $date1->days_between($date2));
        
        $date1 = new pt_date("2009-10-14 00:00:00");
        $date2 = new pt_date("2009-11-05 02:05:00");        
        $this->assertEquals(22, $date1->days_between($date2));        
    }

    public function test_weeks_between() {
        $date1 = new pt_date();
        $date2 = new pt_date();
        $date2->add_hours(2);        
        $this->assertEquals(0, $date1->weeks_between($date2));

        $date1 = new pt_date();
        $date2 = new pt_date();
        $date2->add_days(8);        
        $this->assertEquals(1, $date1->weeks_between($date2));
        
        $date1 = new pt_date("2009-10-14 00:00:00");
        $date2 = new pt_date("2009-11-05 02:05:00");        
        $this->assertEquals(3, $date1->weeks_between($date2));        
    }


    public function test_months_between() {
        $date1 = new pt_date();
        $date2 = new pt_date();
        $this->assertEquals(0, $date1->months_between($date2));

        $date1 = new pt_date();
        $date2 = new pt_date();
        $date2->add_months(2);        
        $this->assertEquals(2, $date1->months_between($date2));
                
        $date1 = new pt_date("2010-12-25 12:12:34");
        $date2 = new pt_date("2011-08-25 12:12:34");
        $this->assertEquals(8, $date1->months_between($date2));
    }


    public function test_years_between() {
        $date1 = new pt_date();
        $date2 = new pt_date();
        $this->assertEquals(0, $date1->years_between($date2));

        $date1 = new pt_date();
        $date2 = new pt_date();
        $date2->add_months(12);        
        $this->assertEquals(1, $date1->years_between($date2));
                
        $date1 = new pt_date("2010-12-25 12:12:34");
        $date2 = new pt_date("2013-08-25 12:12:34");
        $this->assertEquals(3, $date1->years_between($date2));
    }

    public function test_add_seconds() {
        $date = new pt_date("2009-10-06 00:00:00");
        $date->add_seconds(20);        
        $this->assertEquals("2009-10-06 00:00:20", $date->as_string());        

        $date = new pt_date("2009-10-06 00:00:00");
        $date->add_seconds(60);        
        $this->assertEquals("2009-10-06 00:01:00", $date->as_string());        
    
    }

    public function test_add_minutes() {
        $date = new pt_date("2009-10-06 00:00:00");
        $date->add_minutes(20);        
        $this->assertEquals("2009-10-06 00:20:00", $date->as_string());        

        $date = new pt_date("2009-10-06 00:00:00");
        $date->add_minutes(60);        
        $this->assertEquals("2009-10-06 01:00:00", $date->as_string());        
    
    }

    public function test_add_hours() {
        $date = new pt_date("2009-10-06 00:00:00");
        $date->add_hours(20);        
        $this->assertEquals("2009-10-06 20:00:00", $date->as_string());        

        $date = new pt_date("2009-10-06 00:00:00");
        $date->add_hours(24);        
        $this->assertEquals("2009-10-07 00:00:00", $date->as_string());        
    
    }

    public function test_add_days() {
        $date = new pt_date("2009-10-06 00:00:00");
        $date->add_days(20);        
        $this->assertEquals("2009-10-26 00:00:00", $date->as_string());        

        $date = new pt_date("2009-10-01 00:00:00");
        $date->add_days(-1);        
        $this->assertEquals("2009-09-30 00:00:00", $date->as_string());        

        $date = new pt_date("2009-10-31 00:00:00");
        $date->add_days(1);        
        $this->assertEquals("2009-11-01 00:00:00", $date->as_string());        

        $date = new pt_date("2009-10-31 00:00:00");
        $date->add_days(31);        
        $this->assertEquals("2009-12-01 00:00:00", $date->as_string());        

    }

    public function test_add_months() {
        $date1 = new pt_date("2009-05-01");
        $date1->add_months(2);
        $this->assertEquals("2009-07-01", $date1->as_string("%Y-%m-%d"));
        
        $date1 = new pt_date("2009-03-31");
        $date1->add_months(1);
        $this->assertEquals("2009-04-30", $date1->as_string("%Y-%m-%d"));

        $date1 = new pt_date("2010-12-31");
        $date1->add_months(2);
        $this->assertEquals("2011-02-28", $date1->as_string("%Y-%m-%d"));

        $date1 = new pt_date("2010-04-30");
        $date1->add_months(2);
        $this->assertEquals("2010-06-30", $date1->as_string("%Y-%m-%d"));


    }
    
    public function test_add_years() {
        $date1 = new pt_date("2009-05-01");
        $date1->add_years(2);
        $this->assertEquals("2011-05-01", $date1->as_string("%Y-%m-%d"));
        
        $date1 = new pt_date("2009-03-31");
        $date1->add_years(1);
        $this->assertEquals("2010-03-31", $date1->as_string("%Y-%m-%d"));

        $date1 = new pt_date("2012-02-29");
        $date1->add_years(1);
        $this->assertEquals("2013-02-28", $date1->as_string("%Y-%m-%d"));

        $date1 = new pt_date("2010-04-01");
        $date1->add_years(2);
        $this->assertEquals("2012-04-01", $date1->as_string("%Y-%m-%d"));


    }

    
    public function test_move_to_begin_of_week() {
        $date1 = new pt_date("2009-10-14");
        $date1->move_to_begin_of_week();
        $this->assertEquals("2009-10-12", $date1->as_string("%Y-%m-%d"));
        
        $date1 = new pt_date("2009-10-18");
        $date1->move_to_begin_of_week();
        $this->assertEquals("2009-10-12", $date1->as_string("%Y-%m-%d"));

        $date1 = new pt_date("2009-10-12");
        $date1->move_to_begin_of_week();
        $this->assertEquals("2009-10-12", $date1->as_string("%Y-%m-%d"));
    
    }

    
    public function test_move_to_end_of_week() {
        $date1 = new pt_date("2009-10-14");
        $date1->move_to_end_of_week();
        $this->assertEquals("2009-10-18", $date1->as_string("%Y-%m-%d"));
        
        $date1 = new pt_date("2009-10-18");
        $date1->move_to_end_of_week();
        $this->assertEquals("2009-10-18", $date1->as_string("%Y-%m-%d"));

        $date1 = new pt_date("2009-10-12");
        $date1->move_to_end_of_week();
        $this->assertEquals("2009-10-18", $date1->as_string("%Y-%m-%d"));
    
    }

    
    public function test_move_to_begin_of_month() {
        $date1 = new pt_date("2009-05-01");
        $date1->move_to_begin_of_month();
        $this->assertEquals("2009-05-01", $date1->as_string("%Y-%m-%d"));
        
        $date1 = new pt_date("2009-05-28");
        $date1->move_to_begin_of_month();
        $this->assertEquals("2009-05-01", $date1->as_string("%Y-%m-%d"));
    
    }
    
    public function test_move_to_end_of_month() {
        $date1 = new pt_date("2009-04-30");
        $date1->move_to_end_of_month();
        $this->assertEquals("2009-04-30", $date1->as_string("%Y-%m-%d"));

        $date1 = new pt_date("2009-04-01");
        $date1->move_to_end_of_month();
        $this->assertEquals("2009-04-30", $date1->as_string("%Y-%m-%d"));
        
        $date1 = new pt_date("2009-08-28");
        $date1->move_to_end_of_month();
        $this->assertEquals("2009-08-31", $date1->as_string("%Y-%m-%d"));

        $date1 = new pt_date("2009-02-20");
        $date1->move_to_end_of_month();
        $this->assertEquals("2009-02-28", $date1->as_string("%Y-%m-%d"));
    
    }

    public function test_move_to_begin_of_year() {
        $date1 = new pt_date("2009-05-01");
        $date1->move_to_begin_of_year();
        $this->assertEquals("2009-01-01 00:00:00", $date1->as_string());
    
    }
    
    public function test_move_to_end_of_year() {
        $date1 = new pt_date("2009-05-01");
        $date1->move_to_end_of_year();
        $this->assertEquals("2009-12-31 23:59:59", $date1->as_string());
    
    }
    
    public function test_time_between() {
    
        $date1 = new pt_date("2009-10-14 00:00:00");
        $date2 = new pt_date("2009-10-14 02:05:35");        
        $expected = array('seconds' => 35,
                          'minutes' => 5,
                          'hours'   => 2,
                          'days'    => 0,
                          'weeks'   => 0
                         );
        $this->assertEquals($expected, $date1->time_between($date2));
    
    
        $date1 = new pt_date("2009-10-14 00:00:00");
        $date2 = new pt_date("2009-10-15 02:05:00");
        $expected = array('seconds' => 0,
                          'minutes' => 5,
                          'hours'   => 2,
                          'days'    => 1,
                          'weeks'   => 0
                         );
        $this->assertEquals($expected, $date1->time_between($date2));
    

        $date1 = new pt_date("2009-10-14 00:00:00");
        $date2 = new pt_date("2009-10-22 02:05:00");
        $expected = array('seconds' => 0,
                          'minutes' => 5,
                          'hours'   => 2,
                          'days'    => 1,
                          'weeks'   => 1,
                         );
        $this->assertEquals($expected, $date1->time_between($date2));


        $date1 = new pt_date("2009-10-14 00:00:00");
        $date2 = new pt_date("2009-11-05 02:05:00");        
        $expected = array('seconds' => 0,
                          'minutes' => 5,
                          'hours'   => 2,
                          'days'    => 1,
                          'weeks'   => 3,
                         );
        $this->assertEquals($expected, $date1->time_between($date2));
    
    }
    
}

?>
