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
            '/copyright' => [
                'controller' => 'Copyright',
                'method' => 'index'
            ],
            '/terms' => [
                'controller' => 'Terms',
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
            '/logout' => [
                'controller' => 'Dashboard',
                'method' => 'logout'
            ],
            '/rooms' => [
                'controller' => 'Rooms',
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
            '/profile' => [
                'controller' => 'Profile',
                'method' => 'index'
            ],
        ];
    }
}
