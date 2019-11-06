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
        $paths = [
            '/Index/index',
            '/Index/validate',
            '/Myvox/index',
            '/Public_sites/hola',
            '/Api/execute'
        ];

        if (in_array($this->path, $paths))
            if (Session::exists_var('session')) : header('Location: /dashboard'); endif;
        else
        {
            $hour_last_activity = (Session::exists_var('_vkye_last_access')) ? Session::get_value('_vkye_last_access') : date('Y-m-d H:i:s', strtotime('-2 hour', strtotime(Functions::get_current_date_hour())));
            $hour_lapse_time = date('Y-m-d H:i:s', strtotime('+1 hour', strtotime($hour_last_activity)));
            $hour_now = date('Y-m-d H:i:s');

            if (!Session::exists_var('_vkye_last_access') AND strtotime($hour_lapse_time) < strtotime($hour_now))
            {
                Session::destroy();

                header("Location: /");
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
