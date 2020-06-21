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
            '/operation' => [
                'controller' => 'Hi', // Rediseño - Actualización de información - Mencionar el qr y Myvox.
                'method' => 'operation'
            ],
            '/reputation' => [
                'controller' => 'Hi',
                'method' => 'reputation'
            ],
            '/menu' => [
                'controller' => 'Hi', // Rediseño
                'method' => 'menu'
            ],
            '/webinar' => [
                'controller' => 'Hi',
                'method' => 'webinar'
            ],
            '/terms-and-conditions' => [
                'controller' => 'Policies',
                'method' => 'terms'
            ],
            '/privacy-policies' => [
                'controller' => 'Policies',
                'method' => 'privacy'
            ],
            '/signup' => [
                'controller' => 'Signup',
                'method' => 'index'
            ],
            '/activate/%param%/%param%' => [
                'controller' => 'Signup',
                'method' => 'activate'
            ],
            '/%param%/myvox' => [
                'controller' => 'Myvox', // Rediseño
                'method' => 'index'
            ],
            '/%param%/myvox/%param%/%param%' => [
                'controller' => 'Myvox',
                'method' => 'index'
            ],
            '/%param%/myvox/request' => [
                'controller' => 'Myvox', // Rediseño
                'method' => 'request'
            ],
            '/%param%/myvox/incident' => [
                'controller' => 'Myvox', // Rediseño
                'method' => 'incident'
            ],
            // '/%param%/myvox/menu' => [
            //     'controller' => 'Myvox',
            //     'method' => 'menu'
            // ],
            // '/%param%/myvox/survey' => [
            //     'controller' => 'Myvox',
            //     'method' => 'survey'
            // ],
            '/%param%/reviews' => [
                'controller' => 'Reviews', // Rediseño
                'method' => 'index'
            ],
            '/login' => [
                'controller' => 'Login',
                'method' => 'index'
            ],
            '/logout' => [
                'controller' => 'Login',
                'method' => 'logout'
            ],
            '/dashboard' => [
                'controller' => 'Dashboard', // Rediseño
                'method' => 'index'
            ],
            '/qr' => [
                'controller' => 'Qr',
                'method' => 'index'
            ],
            '/voxes' => [
                'controller' => 'Voxes',
                'method' => 'index'
            ],
            '/voxes/create' => [
                'controller' => 'Voxes',
                'method' => 'create'
            ],
            '/voxes/details/%param%' => [
                'controller' => 'Voxes',
                'method' => 'details'
            ],
            '/voxes/edit/%param%' => [
                'controller' => 'Voxes',
                'method' => 'edit'
            ],
            // '/voxes/reports/%param%' => [
            //     'controller' => 'Voxes',
            //     'method' => 'reports'
            // ],
            // '/voxes/stats' => [
            //     'controller' => 'Voxes',
            //     'method' => 'stats'
            // ],
            // '/voxes/charts' => [
            //     'controller' => 'Voxes',
            //     'method' => 'charts'
            // ],
            // '/surveys' => [
            //     'controller' => 'Surveys',
            //     'method' => 'index'
            // ],
            // '/surveys/questions' => [
            //     'controller' => 'Surveys',
            //     'method' => 'questions'
            // ],
            // '/surveys/answers' => [
            //     'controller' => 'Surveys',
            //     'method' => 'answers'
            // ],
            // '/surveys/comments' => [
            //     'controller' => 'Surveys',
            //     'method' => 'comments'
            // ],
            // '/surveys/contacts' => [
            //     'controller' => 'Surveys',
            //     'method' => 'contacts'
            // ],
            // '/surveys/stats' => [
            //     'controller' => 'Surveys',
            //     'method' => 'stats'
            // ],
            // '/surveys/charts' => [
            //     'controller' => 'Surveys',
            //     'method' => 'charts'
            // ],
            '/menu' => [
                'controller' => 'Menu',
                'method' => 'index'
            ],
            '/menu/products' => [
                'controller' => 'Menu',
                'method' => 'products'
            ],
            '/menu/restaurants' => [
                'controller' => 'Menu',
                'method' => 'restaurants'
            ],
            '/owners' => [
                'controller' => 'Owners',
                'method' => 'index'
            ],
            '/opportunity-areas' => [
                'controller' => 'Opportunityareas',
                'method' => 'index'
            ],
            '/opportunity-types' => [
                'controller' => 'Opportunitytypes',
                'method' => 'index'
            ],
            '/locations' => [
                'controller' => 'Locations',
                'method' => 'index'
            ],
            '/guests-treatments' => [
                'controller' => 'Gueststreatments',
                'method' => 'index'
            ],
            '/guests-types' => [
                'controller' => 'Gueststypes',
                'method' => 'index'
            ],
            '/reservations-statuses' => [
                'controller' => 'Reservationsstatuses',
                'method' => 'index'
            ],
            '/users' => [
                'controller' => 'Users',
                'method' => 'index'
            ],
            '/users-levels' => [
                'controller' => 'Userslevels',
                'method' => 'index'
            ],
            '/account' => [
                'controller' => 'Account',
                'method' => 'index'
            ],
            '/my-profile' => [
                'controller' => 'Profile',
                'method' => 'index'
            ]
        ];
    }
}
