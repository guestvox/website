<?php

defined('_EXEC') or die;

class User_level
{
    public function access($path)
    {
        $paths = [];

        array_push($paths, '/Dashboard/index');
        array_push($paths, '/Profile/index');
        array_push($paths, '/Qrs/index');
        array_push($paths, '/Voxes/index');
        array_push($paths, '/Voxes/create');
        array_push($paths, '/Voxes/details');
        array_push($paths, '/Voxes/edit');
        array_push($paths, '/Menu/orders');
        array_push($paths, '/Support/index');
        array_push($paths, '/System/translate');
        array_push($paths, '/System/logout');

        foreach (Session::get_value('user')['permissions'] as $key => $value)
        {
            switch ($value)
            {
                case '{voxes_stats_view}' :
                    array_push($paths, '/Voxes/stats');
                    array_push($paths, '/Voxes/charts');
                break;

                case '{voxes_reports_create}' :
                    array_push($paths, '/Voxes/reports');
                break;

                case '{voxes_reports_update}' :
                    array_push($paths, '/Voxes/reports');
                break;

                case '{voxes_reports_deactivate}' :
                    array_push($paths, '/Voxes/reports');
                break;

                case '{voxes_reports_activate}' :
                    array_push($paths, '/Voxes/reports');
                break;

                case '{voxes_reports_delete}' :
                    array_push($paths, '/Voxes/reports');
                break;

                case '{voxes_reports_print}' :
                    array_push($paths, '/Voxes/reports');
                break;

                case '{surveys_questions_create}' :
                    array_push($paths, '/Surveys/index');
                    array_push($paths, '/Surveys/questions');
                break;

                case '{surveys_questions_update}' :
                    array_push($paths, '/Surveys/index');
                    array_push($paths, '/Surveys/questions');
                break;

                case '{surveys_questions_deactivate}' :
                    array_push($paths, '/Surveys/index');
                    array_push($paths, '/Surveys/questions');
                break;

                case '{surveys_questions_activate}' :
                    array_push($paths, '/Surveys/index');
                    array_push($paths, '/Surveys/questions');
                break;

                case '{surveys_questions_delete}' :
                    array_push($paths, '/Surveys/index');
                    array_push($paths, '/Surveys/questions');
                break;

                case '{surveys_answers_view}' :
                    array_push($paths, '/Surveys/answers');
                break;

                case '{surveys_stats_view}' :
                    array_push($paths, '/Surveys/stats');
                    array_push($paths, '/Surveys/charts');
                break;

                case '{menu_products_create}' :
                    array_push($paths, '/Menu/products');
                break;

                case '{menu_products_update}' :
                    array_push($paths, '/Menu/products');
                break;

                case '{menu_products_deactivate}' :
                    array_push($paths, '/Menu/products');
                break;

                case '{menu_products_activate}' :
                    array_push($paths, '/Menu/products');
                break;

                case '{menu_products_delete}' :
                    array_push($paths, '/Menu/products');
                break;

                case '{menu_categories_create}' :
                    array_push($paths, '/Menu/categories');
                break;

                case '{menu_categories_update}' :
                    array_push($paths, '/Menu/categories');
                break;

                case '{menu_categories_deactivate}' :
                    array_push($paths, '/Menu/categories');
                break;

                case '{menu_categories_activate}' :
                    array_push($paths, '/Menu/categories');
                break;

                case '{menu_categories_delete}' :
                    array_push($paths, '/Menu/categories');
                break;

                case '{menu_topics_create}' :
                    array_push($paths, '/Menu/topics');
                break;

                case '{menu_topics_update}' :
                    array_push($paths, '/Menu/topics');
                break;

                case '{menu_topics_deactivate}' :
                    array_push($paths, '/Menu/topics');
                break;

                case '{menu_topics_activate}' :
                    array_push($paths, '/Menu/topics');
                break;

                case '{menu_topics_delete}' :
                    array_push($paths, '/Menu/topics');
                break;

                case '{menu_restaurants_create}' :
                    array_push($paths, '/Menu/restaurants');
                break;

                case '{menu_restaurants_update}' :
                    array_push($paths, '/Menu/restaurants');
                break;

                case '{menu_restaurants_deactivate}' :
                    array_push($paths, '/Menu/restaurants');
                break;

                case '{menu_restaurants_activate}' :
                    array_push($paths, '/Menu/restaurants');
                break;

                case '{menu_restaurants_delete}' :
                    array_push($paths, '/Menu/restaurants');
                break;

                case '{owners_create}' :
                    array_push($paths, '/Owners/index');
                break;

                case '{owners_update}' :
                    array_push($paths, '/Owners/index');
                break;

                case '{owners_deactivate}' :
                    array_push($paths, '/Owners/index');
                break;

                case '{owners_activate}' :
                    array_push($paths, '/Owners/index');
                break;

                case '{owners_delete}' :
                    array_push($paths, '/Owners/index');

                case '{opportunity_areas_create}' :
                    array_push($paths, '/Opportunityareas/index');
                break;

                case '{opportunity_areas_update}' :
                    array_push($paths, '/Opportunityareas/index');
                break;

                case '{opportunity_areas_deactivate}' :
                    array_push($paths, '/Opportunityareas/index');
                break;

                case '{opportunity_areas_activate}' :
                    array_push($paths, '/Opportunityareas/index');
                break;

                case '{opportunity_areas_delete}' :
                    array_push($paths, '/Opportunityareas/index');
                break;

                case '{opportunity_types_create}' :
                    array_push($paths, '/Opportunitytypes/index');
                break;

                case '{opportunity_types_update}' :
                    array_push($paths, '/Opportunitytypes/index');
                break;

                case '{opportunity_types_deactivate}' :
                    array_push($paths, '/Opportunitytypes/index');
                break;

                case '{opportunity_types_activate}' :
                    array_push($paths, '/Opportunitytypes/index');
                break;

                case '{opportunity_types_delete}' :
                    array_push($paths, '/Opportunitytypes/index');
                break;

                case '{locations_create}' :
                    array_push($paths, '/Locations/index');
                break;

                case '{locations_update}' :
                    array_push($paths, '/Locations/index');
                break;

                case '{locations_deactivate}' :
                    array_push($paths, '/Locations/index');
                break;

                case '{locations_activate}' :
                    array_push($paths, '/Locations/index');
                break;

                case '{locations_delete}' :
                    array_push($paths, '/Locations/index');
                break;

                case '{reservations_statuses_create}' :
                    array_push($paths, '/Reservationsstatuses/index');
                break;

                case '{reservations_statuses_update}' :
                    array_push($paths, '/Reservationsstatuses/index');
                break;

                case '{reservations_statuses_deactivate}' :
                    array_push($paths, '/Reservationsstatuses/index');
                break;

                case '{reservations_statuses_activate}' :
                    array_push($paths, '/Reservationsstatuses/index');
                break;

                case '{reservations_statuses_delete}' :
                    array_push($paths, '/Reservationsstatuses/index');
                break;

                case '{guests_treatments_create}' :
                    array_push($paths, '/Gueststreatments/index');
                break;

                case '{guests_treatments_update}' :
                    array_push($paths, '/Gueststreatments/index');
                break;

                case '{guests_treatments_deactivate}' :
                    array_push($paths, '/Gueststreatments/index');
                break;

                case '{guests_treatments_activate}' :
                    array_push($paths, '/Gueststreatments/index');
                break;

                case '{guests_treatments_delete}' :
                    array_push($paths, '/Gueststreatments/index');
                break;

                case '{guests_types_create}' :
                    array_push($paths, '/Gueststypes/index');
                break;

                case '{guests_types_update}' :
                    array_push($paths, '/Gueststypes/index');
                break;

                case '{guests_types_deactivate}' :
                    array_push($paths, '/Gueststypes/index');
                break;

                case '{guests_types_activate}' :
                    array_push($paths, '/Gueststypes/index');
                break;

                case '{guests_types_delete}' :
                    array_push($paths, '/Gueststypes/index');
                break;

                case '{users_create}' :
                    array_push($paths, '/Users/index');
                break;

                case '{users_update}' :
                    array_push($paths, '/Users/index');
                break;

                case '{users_restore_password}' :
                    array_push($paths, '/Users/index');
                break;

                case '{users_deactivate}' :
                    array_push($paths, '/Users/index');
                break;

                case '{users_activate}' :
                    array_push($paths, '/Users/index');
                break;

                case '{users_delete}' :
                    array_push($paths, '/Users/index');
                break;

                case '{users_levels_create}' :
                    array_push($paths, '/Userslevels/index');
                break;

                case '{users_levels_update}' :
                    array_push($paths, '/Userslevels/index');
                break;

                case '{users_levels_deactivate}' :
                    array_push($paths, '/Userslevels/index');
                break;

                case '{users_levels_activate}' :
                    array_push($paths, '/Userslevels/index');
                break;

                case '{users_levels_delete}' :
                    array_push($paths, '/Userslevels/index');
                break;

                case '{account_update}' :
                    array_push($paths, '/Account/index');
                break;

                default: break;
            }
        }

        $paths = array_unique($paths);
        $paths = array_values($paths);

        return in_array($path, $paths) ? true : false;
    }

    static public function redirection()
    {
        if (Session::exists_var('session') == true)
        {
            if (Session::get_value('account')['type'] == 'hotel' OR Session::get_value('account')['type'] == 'others')
            {
                if (Functions::check_account_access(['operation']) == true)
                    return '/voxes';
                else if (Functions::check_account_access(['digital_menu']) == true)
                    return '/menu/orders';
                else if (Functions::check_account_access(['surveys']) == true)
                {
                    if (Functions::check_user_access(['{surveys_answers_view}']) == true)
                        return '/surveys/answers/raters';
                    else if (Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}','{surveys_questions_deactivate}','{surveys_questions_activate}','{surveys_questions_delete}']) == true)
                        return '/surveys/questions';
                    else if (Functions::check_user_access(['{surveys_stats_view}']) == true)
                        return '/surveys/stats';
                }
                else
                    return '/dashboard';
            }
            else if (Session::get_value('account')['type'] == 'restaurant')
            {
                if (Functions::check_account_access(['digital_menu']) == true)
                    return '/menu/orders';
                else if (Functions::check_account_access(['operation']) == true)
                    return '/voxes';
                else if (Functions::check_account_access(['surveys']) == true)
                {
                    if (Functions::check_user_access(['{surveys_answers_view}']) == true)
                        return '/surveys/answers/raters';
                    else if (Functions::check_user_access(['{surveys_questions_create}','{surveys_questions_update}','{surveys_questions_deactivate}','{surveys_questions_activate}','{surveys_questions_delete}']) == true)
                        return '/surveys/questions';
                    else if (Functions::check_user_access(['{surveys_stats_view}']) == true)
                        return '/surveys/stats';
                }
                else
                    return '/dashboard';
            }
        }
        else
            return '/';
    }
}
