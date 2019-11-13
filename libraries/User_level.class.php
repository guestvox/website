users<?php

defined('_EXEC') or die;

class User_level
{
    public function access($path)
    {
        $paths = [];

        array_push($paths, '/Dashboard/index');
        array_push($paths, '/Dashboard/logout');
        array_push($paths, '/Voxes/index');
        array_push($paths, '/Voxes/create');
        array_push($paths, '/Voxes/view');
        array_push($paths, '/Survey/answers');
        array_push($paths, '/Survey/questions');
        array_push($paths, '/Survey/stats');
        array_push($paths, '/Survey/settings');
        array_push($paths, '/Account/index');
        array_push($paths, '/Profile/index');

        foreach (Session::get_value('user')['user_permissions'] as $key => $value)
        {
            switch ($value)
            {
                case '{voxes_update}' :
                    array_push($paths, '/Voxes/edit');
                break;

                case '{stats_view}' :
                    array_push($paths, '/Dashboard/charts');
                    array_push($paths, '/Stats/index');
                    array_push($paths, '/Stats/charts');
                break;

                case '{reports_generate}' :
                    array_push($paths, '/Reports/index');
                break;

                case '{opportunityareas_create}' :
                    array_push($paths, '/Settings/opportunityareas');
                break;

                case '{opportunityareas_update}' :
                    array_push($paths, '/Settings/opportunityareas');
                break;

                case '{opportunityareas_delete}' :
                    array_push($paths, '/Settings/opportunityareas');
                break;

                case '{opportunitytypes_create}' :
                    array_push($paths, '/Settings/opportunitytypes');
                break;

                case '{opportunitytypes_update}' :
                    array_push($paths, '/Settings/opportunitytypes');
                break;

                case '{opportunitytypes_delete}' :
                    array_push($paths, '/Settings/opportunitytypes');
                break;

                case '{locations_create}' :
                    array_push($paths, '/Settings/locations');
                break;

                case '{locations_update}' :
                    array_push($paths, '/Settings/locations');
                break;

                case '{locations_delete}' :
                    array_push($paths, '/Settings/locations');
                break;

                case '{rooms_create}' :
                    array_push($paths, '/Settings/rooms');
                break;

                case '{rooms_update}' :
                    array_push($paths, '/Settings/rooms');
                break;

                case '{rooms_delete}' :
                    array_push($paths, '/Settings/rooms');
                break;

                case '{guesttreatments_create}' :
                    array_push($paths, '/Settings/guesttreatments');
                break;

                case '{guesttreatments_update}' :
                    array_push($paths, '/Settings/guesttreatments');
                break;

                case '{guesttreatments_delete}' :
                    array_push($paths, '/Settings/guesttreatments');
                break;

                case '{guesttypes_create}' :
                    array_push($paths, '/Settings/guesttypes');
                break;

                case '{guesttypes_update}' :
                    array_push($paths, '/Settings/guesttypes');
                break;

                case '{guesttypes_delete}' :
                    array_push($paths, '/Settings/guesttypes');
                break;

                case '{reservationstatus_create}' :
                    array_push($paths, '/Settings/reservationstatus');
                break;

                case '{reservationstatus_update}' :
                    array_push($paths, '/Settings/reservationstatus');
                break;

                case '{reservationstatus_delete}' :
                    array_push($paths, '/Settings/reservationstatus');
                break;

                case '{users_create}' :
                    array_push($paths, '/Users/activates');
                break;

                case '{users_update}' :
                    array_push($paths, '/Users/activates');
                break;

                case '{users_restorepassword}' :
                    array_push($paths, '/Users/activates');
                break;

                case '{users_deactivate}' :
                    array_push($paths, '/Users/activates');
                break;

                case '{users_activate}' :
                    array_push($paths, '/Users/deactivates');
                break;

                case '{users_delete}' :
                    array_push($paths, '/Users/activates');
                break;

                case '{userlevels_create}' :
                    array_push($paths, '/Users/userspermissions');
                break;

                case '{userlevels_update}' :
                    array_push($paths, '/Users/userspermissions');
                break;

                case '{userlevels_delete}' :
                    array_push($paths, '/Users/userspermissions');
                break;

                default: break;
            }
        }

        $paths = array_unique($paths);
        $paths = array_values($paths);

        return $this->check_path($path, $paths);
    }

    private function check_path($path, $paths)
    {
        if (in_array($path, $paths))
            return true;
        else
            return false;
    }
}
