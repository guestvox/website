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
            '/terms' => [
                'controller' => 'Terms',
                'method' => 'index'
            ],
            '/%param%/myvox' => [
                'controller' => 'Myvox',
                'method' => 'index'
            ],
            '/%param%/myvox/%param%/%param%' => [
                'controller' => 'Myvox',
                'method' => 'index'
            ],
            '/dashboard' => [
                'controller' => 'Dashboard',
                'method' => 'index'
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
            '/voxes/view/details/%param%' => [
                'controller' => 'Voxes',
                'method' => 'details'
            ],
            '/voxes/view/history/%param%' => [
                'controller' => 'Voxes',
                'method' => 'history'
            ],
            '/voxes/edit/%param%' => [
                'controller' => 'Voxes',
                'method' => 'edit'
            ],
            '/voxes/reports' => [
                'controller' => 'Voxes',
                'method' => 'reports'
            ],
            '/voxes/reports/generate' => [
                'controller' => 'Voxes',
                'method' => 'generate'
            ],
            '/voxes/stats' => [
                'controller' => 'Voxes',
                'method' => 'stats'
            ],
            '/voxes/charts' => [
                'controller' => 'Voxes',
                'method' => 'charts'
            ],
            '/surveys' => [
                'controller' => 'Surveys',
                'method' => 'index'
            ],
            '/surveys/questions' => [
                'controller' => 'Surveys',
                'method' => 'questions'
            ],
            '/surveys/answers' => [
                'controller' => 'Surveys',
                'method' => 'answers'
            ],
            '/surveys/stats' => [
                'controller' => 'Surveys',
                'method' => 'stats'
            ],
            '/surveys/charts' => [
                'controller' => 'Surveys',
                'method' => 'charts'
            ],
            '/rooms' => [
                'controller' => 'Rooms',
                'method' => 'index'
            ],
            '/tables' => [
                'controller' => 'Tables',
                'method' => 'index'
            ],
            '/opportunityareas' => [
                'controller' => 'Opportunityareas',
                'method' => 'index'
            ],
            '/opportunitytypes' => [
                'controller' => 'Opportunitytypes',
                'method' => 'index'
            ],
            '/locations' => [
                'controller' => 'Locations',
                'method' => 'index'
            ],
            '/reservationstatuses' => [
                'controller' => 'Reservationstatuses',
                'method' => 'index'
            ],
            '/guesttreatments' => [
                'controller' => 'Guesttreatments',
                'method' => 'index'
            ],
            '/guesttypes' => [
                'controller' => 'Guesttypes',
                'method' => 'index'
            ],
            '/users' => [
                'controller' => 'Users',
                'method' => 'index'
            ],
            '/userlevels' => [
                'controller' => 'Userlevels',
                'method' => 'index'
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
