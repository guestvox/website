<?php

defined('_EXEC') or die;

class Route_vkye
{
    private $path;
    private $user_level;

    public function __construct($path)
    {
        $this->path = $path;
        $this->user_level = new User_level();
    }

    public function on_change_start()
    {
        global $vkye_path;
        $vkye_path = $this->path;

        $redirection_paths = [
            '/Index/index',
            '/Hi/voxes',
            '/Hi/menu',
            '/Hi/surveys',
            '/Hi/reviews',
            '/Hi/hotels',
            '/Hi/restaurants',
            '/Hi/hospitals',
            '/Hi/enlace',
            '/Hi/webinar',
            '/Policies/terms',
            '/Policies/privacy',
            '/Signup/index',
            '/Signup/activate',
            '/Login/index',
            '/Api/execute'
        ];

        $not_redirection_paths = [
            '/Myvox/index',
            '/Myvox/request',
            '/Myvox/incident',
            '/Myvox/menu',
            '/Myvox/survey',
            '/Reviews/index'
        ];

        if (in_array($this->path, $redirection_paths) OR in_array($this->path, $not_redirection_paths))
        {
            if (in_array($this->path, $redirection_paths))
            {
                if (Session::exists_var('session'))
                    header('Location: ' . User_level::redirection());
            }
        }
        else
        {
            $hour_last_activity = (Session::exists_var('_vkye_last_access')) ? Session::get_value('_vkye_last_access') : date('Y-m-d H:i:s', strtotime('-2 hour', strtotime(Functions::get_current_date_hour())));
            $hour_lapse_time = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($hour_last_activity)));
            $hour_now = date('Y-m-d H:i:s');

            if (!Session::exists_var('_vkye_last_access') AND strtotime($hour_lapse_time) < strtotime($hour_now))
            {
                Session::destroy();

                header('Location: /');
            }

            Session::set_value('_vkye_last_access', Functions::get_current_date_hour());

            if (!Session::exists_var('session'))
            {
                Session::destroy();

                header('Location: /');
            }
            else
            {
                if ($this->user_level->access($this->path) == false)
                    header('Location: /404');
            }
        }
    }

    public function on_change_end()
    {

    }
}
