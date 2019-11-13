<?php

defined('_EXEC') or die;

class Urls_registered_vkye
{
    static public $home_page_default = '/';

    static public function urls()
    {
        return [
            '/' => [
                'controller' => 'Index',
                'method' => 'index'
            ],
            '/validate/%param%/%param%' => [
                'controller' => 'Index',
                'method' => 'validate'
            ],
            '/hola' => [
                'controller' => 'Hola',
                'method' => 'index'
            ],
            '/myvox/%param%' => [
                'controller' => 'Myvox',
                'method' => 'index'
            ],
            '/dashboard' => [
                'controller' => 'Dashboard',
                'method' => 'index'
            ],
            '/dashboard/charts' => [
                'controller' => 'Dashboard',
                'method' => 'charts'
            ],
            '/logout' => [
                'controller' => 'Dashboard',
                'method' => 'logout'
            ],
            '/voxes' => [
                'controller' => 'Voxes',
                'method' => 'index'
            ],
            '/voxes/create' => [
                'controller' => 'Voxes',
                'method' => 'create'
            ],
            '/voxes/edit/%param%' => [
                'controller' => 'Voxes',
                'method' => 'edit'
            ],
            '/voxes/view/%param%' => [
                'controller' => 'Voxes',
                'method' => 'view'
            ],
            '/stats' => [
                'controller' => 'Stats',
                'method' => 'index'
            ],
            '/stats/charts' => [
                'controller' => 'Stats',
                'method' => 'charts'
            ],
            '/reports' => [
                'controller' => 'Reports',
                'method' => 'index'
            ],
            '/settings/opportunityareas' => [
                'controller' => 'Settings',
                'method' => 'opportunityareas'
            ],
            '/settings/opportunitytypes' => [
                'controller' => 'Settings',
                'method' => 'opportunitytypes'
            ],
            '/settings/locations' => [
                'controller' => 'Settings',
                'method' => 'locations'
            ],
            '/settings/rooms' => [
                'controller' => 'Settings',
                'method' => 'rooms'
            ],
            '/settings/guesttreatments' => [
                'controller' => 'Settings',
                'method' => 'guesttreatments'
            ],
            '/settings/guesttypes' => [
                'controller' => 'Settings',
                'method' => 'guesttypes'
            ],
            '/settings/reservationstatus' => [
                'controller' => 'Settings',
                'method' => 'reservationstatus'
            ],
            '/users/activates' => [
                'controller' => 'Users',
                'method' => 'activates'
            ],
            '/users/deactivates' => [
                'controller' => 'Users',
                'method' => 'deactivates'
            ],
            '/users/userspermissions' => [
                'controller' => 'Users',
                'method' => 'userspermissions'
            ],
            '/survey/answers' => [
                'controller' => 'Survey',
                'method' => 'answers'
            ],
            '/survey/questions' => [
                'controller' => 'Survey',
                'method' => 'questions'
            ],
            '/survey/stats' => [
                'controller' => 'Survey',
                'method' => 'stats'
            ],
            '/survey/settings' => [
                'controller' => 'Survey',
                'method' => 'settings'
            ],
            '/account' => [
                'controller' => 'Account',
                'method' => 'index'
            ],
            '/profile' => [
                'controller' => 'Profile',
                'method' => 'index'
            ],
        ];
    }
}
