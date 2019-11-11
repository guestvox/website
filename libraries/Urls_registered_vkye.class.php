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
            '/settings' => [
                'controller' => 'Settings',
                'method' => 'index'
            ],
            '/users' => [
                'controller' => 'Users',
                'method' => 'index'
            ],
            '/survey' => [
                'controller' => 'Survey',
                'method' => 'index'
            ],
            '/survey/charts' => [
                'controller' => 'Survey',
                'method' => 'charts'
            ],
            '/account' => [
                'controller' => 'Account',
                'method' => 'index'
            ],
            '/profile' => [
                'controller' => 'Profile',
                'method' => 'index'
            ],
            '/logout' => [
                'controller' => 'Index',
                'method' => 'logout'
            ],
        ];
    }
}
