<?php

defined('_EXEC') or die;

class Dates
{
    public function __construct()
    {
        date_default_timezone_set(Configuration::$time_zone);
    }

    static public function get_current_date($format = 'Y-m-d')
    {
		return date($format);
    }

    static public function get_past_date($date, $number, $lapse, $format = 'Y-m-d')
    {
        if (!empty($date) AND !empty($number) AND !empty($lapse))
            return date($format, strtotime($date . ' - ' . $number . ' ' . $lapse));
        else
            return null;
    }

    static public function get_format_date($date, $format = 'Y-m-d')
    {
        if (!empty($date))
            return date($format, strtotime($date));
        else
            return null;
    }

    static public function get_current_hour($format = 'H:i:s')
    {
		return date($format, time());
    }

    static public function get_format_hour($hour, $format = 'H:i:s')
    {
        if (!empty($hour))
        {
            if ($format == '+ hrs')
                return $hour . ' Hrs';
            else
        	    return date($format, strtotime($hour));
        }
        else
            return null;
    }

    static public function get_current_date_hour($format = 'Y-m-d H:i:s')
    {
		return date($format, time());
    }

    static public function get_format_date_hour($date, $hour, $format = 'Y-m-d H:i:s')
    {
        if (!empty($date) AND !empty($hour))
        {
            if ($format == '+ hrs')
                return $date . ' ' . $hour . ' Hrs';
            else
                return date($format, strtotime($date . ' ' . $hour));
        }
        else
            return null;
    }

    static public function get_current_week()
    {
        return [date('Y-m-d', strtotime('monday this week')), date('Y-m-d', strtotime('sunday this week'))];
    }

    static public function get_current_month()
    {
        return [date('Y-m-d', strtotime('first day of this month')), date('Y-m-d', strtotime('last day of this month'))];
    }

    static public function get_current_year()
    {
		return explode('-', date('Y-m-d'))[0];
    }
}
