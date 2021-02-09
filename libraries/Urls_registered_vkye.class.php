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
            '/hoteles' => [
                'controller' => 'Hi',
                'method' => 'hotels'
            ],
            '/restaurantes' => [
                'controller' => 'Hi',
                'method' => 'restaurants'
            ],
            '/webinar' => [
                'controller' => 'Hi',
                'method' => 'webinar'
            ],
            '/personaliza' => [
                'controller' => 'Personalize',
                'method' => 'index'
            ],
            '/activar/%param%' => [
                'controller' => 'Activate',
                'method' => 'index'
            ],
            '/%param%/myvox' => [
                'controller' => 'Myvox',
                'method' => 'index'
            ],
            '/%param%/myvox/%param%' => [
                'controller' => 'Myvox',
                'method' => 'index'
            ],
            '/%param%/myvox/%param%/%param%' => [
                'controller' => 'Myvox',
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
                'controller' => 'Reviews',
                'method' => 'index'
            ],
            '/login' => [
                'controller' => 'Login',
                'method' => 'index'
            ],
            '/dashboard' => [
                'controller' => 'Dashboard',
                'method' => 'index'
            ],
            '/my-profile' => [
                'controller' => 'Profile',
                'method' => 'index'
            ],
            '/qrs' => [
                'controller' => 'Qrs',
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
            '/menu/restaurants' => [
                'controller' => 'Menu',
                'method' => 'restaurants'
            ],
            '/menu/categories' => [
                'controller' => 'Menu',
                'method' => 'categories'
            ],
            '/menu/topics' => [
                'controller' => 'Menu',
                'method' => 'topics'
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
            ],
            '/translate' => [
                'controller' => 'System',
                'method' => 'translate'
            ],
            '/logout' => [
                'controller' => 'System',
                'method' => 'logout'
            ],
            '/terminos-y-condiciones' => [
                'controller' => 'Policies',
                'method' => 'terms'
            ],
            '/politicas-de-privacidad' => [
                'controller' => 'Policies',
                'method' => 'privacy'
            ]
        ];
    }
}
