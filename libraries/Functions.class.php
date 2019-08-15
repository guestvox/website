<?php

defined('_EXEC') or die;

class Functions
{
    public static function get_json_decoded_query($query)
    {
        if (is_array($query))
        {
            foreach ($query as $key => $value)
            {
                if (is_array($query[$key]))
                {
                    foreach ($query[$key] as $subkey => $subvalue)
                        $query[$key][$subkey] = (is_array(json_decode($query[$key][$subkey], true)) AND (json_last_error() == JSON_ERROR_NONE)) ? json_decode($query[$key][$subkey], true) : $query[$key][$subkey];
                }
                else
                    $query[$key] = (is_array(json_decode($query[$key], true)) AND (json_last_error() == JSON_ERROR_NONE)) ? json_decode($query[$key], true) : $query[$key];
            }
        }
        else
            $query = (is_array(json_decode($query, true)) AND (json_last_error() == JSON_ERROR_NONE)) ? json_decode($query, true) : $query;

        return $query;
    }

    public static function get_format_cost($cost = 0, $format = 'MXN')
    {
        if (!empty($cost))
            return '$ ' . $cost . ' ' . $format;
        else
            return '$ 0 ' . $format;
    }

    public static function check_access($user_permissions)
    {
        $access = false;

        foreach ($user_permissions as $value)
        {
            if (in_array($value, Session::get_value('user')['user_permissions']))
                $access = true;
        }

        return $access;
    }

    public static function check_email($email)
    {
        return (filter_var($email, FILTER_VALIDATE_EMAIL)) ? true : false;
    }
}
