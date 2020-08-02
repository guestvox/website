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
            '/hola/voxes' => [
                'controller' => 'Hi',
                'method' => 'voxes'
            ],
            '/hola/menu' => [
                'controller' => 'Hi',
                'method' => 'menu'
            ],
            '/hola/encuestas' => [
                'controller' => 'Hi',
                'method' => 'surveys'
            ],
            '/hola/resenas' => [
                'controller' => 'Hi',
                'method' => 'reviews'
            ],
            '/hola/hoteles' => [
                'controller' => 'Hi',
                'method' => 'hotels'
            ],
            '/hola/restaurantes' => [
                'controller' => 'Hi',
                'method' => 'restaurants'
            ],
            '/hola/hospitales' => [
                'controller' => 'Hi',
                'method' => 'hospitals'
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
            '/activate/%param%' => [
                'controller' => 'Signup',
                'method' => 'activate'
            ],
            '/%param%/myvox' => [
                'controller' => 'Myvox', // - Rediseño
                'method' => 'index'
            ],
            '/%param%/myvox/%param%/%param%' => [
                'controller' => 'Myvox', // - Rediseño
                'method' => 'index'
            ],
            '/%param%/request' => [
                'controller' => 'Myvox',
                'method' => 'request'
            ],
            '/%param%/incident' => [
                'controller' => 'Myvox',
                'method' => 'incident'
            ],
            '/%param%/menu/%param%' => [
                'controller' => 'Myvox',
                'method' => 'menu'
            ],
            '/%param%/survey' => [
                'controller' => 'Myvox',
                'method' => 'survey'
            ],
            '/%param%/reviews' => [
                'controller' => 'Reviews', // - Rediseño
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
            // '/dashboard' => [
            //     'controller' => 'Dashboard', // - Rediseño
            //     'method' => 'index'
            // ],
            '/my-profile' => [
                'controller' => 'Profile',
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
            '/voxes/stats' => [
                'controller' => 'Voxes',
                'method' => 'stats'
            ],
            '/voxes/charts' => [
                'controller' => 'Voxes',
                'method' => 'charts'
            ],
            '/voxes/reports/%param%' => [
                'controller' => 'Voxes',
                'method' => 'reports'
            ],
            '/surveys/questions' => [
                'controller' => 'Surveys',
                'method' => 'questions'
            ],
            '/surveys/answers/%param%' => [
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
            '/menu/products' => [
                'controller' => 'Menu',
                'method' => 'products'
            ],
            // '/menu/restaurants' => [
            //     'controller' => 'Menu',
            //     'method' => 'restaurants'
            // ],
            '/menu/categories' => [
                'controller' => 'Menu',
                'method' => 'categories'
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
            '/technical-support' => [
                'controller' => 'Support',
                'method' => 'index'
            ],
            '/account' => [
                'controller' => 'Account',
                'method' => 'index'
            ]
        ];
    }
}
