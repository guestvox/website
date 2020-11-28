<?php

defined('_EXEC') or die;

class Languages
{
    static public function account($key)
    {
        $langs = [
            'hotel' => [
                'receive_requests' => [
                    'es' => 'Pedidos desde habitación',
                    'en' => 'Room orders'
                ]
            ],
            'restaurant' => [
                'receive_requests' => [
                    'es' => 'Pedidos desde mesa',
                    'en' => 'Table orders'
                ]
            ]
        ];

        return $langs[Session::get_value('account')['type']][$key];
    }

    static public function email($key, $subkey = null)
    {
        $langs = [
            'thanks_request_demo' => [
                'es' => '¡Gracias por solicitar tu demo!',
                'en' => '¡Thanks for requesting your demo!'
            ],
            'representative_contact_you' => [
                'es' => 'En estos días, uno de nuestros representantes se pondrá en contacto contigo para agendar una cita.',
                'en' => 'These days, one of our representatives will contact you to schedule an appointment.'
            ],
            'hotel' => [
                'es' => 'Hotel',
                'en' => 'Hotel'
            ],
            'restaurant' => [
                'es' => 'Restaurante',
                'en' => 'Restaurant'
            ],
            'hospital' => [
                'es' => 'Hospital',
                'en' => 'Hospital'
            ],
            'others' => [
                'es' => 'Otros',
                'en' => 'Others'
            ],
            'thanks_signup_webinar' => [
                'es' => '¡Gracias por registrarte a nuestro Webinar!',
                'en' => '¡Thanks for sign up for our Webinar!'
            ],
            'go_to_webinar' => [
                'es' => 'Ir a nuestro Webinar',
                'en' => 'Go to our Webinar'
            ],
            'not_name' => [
                'es' => 'Sin nombre',
                'en' => 'Not name'
            ],
            'download_file' => [
                'es' => 'Descargar archivo',
                'en' => 'Download file'
            ],
            'thanks_signup_guestvox' => [
                'es' => '¡Gracias por registrarte en Guestvox!',
                'en' => '¡Thanks for sign up in Guestvox!'
            ],
            'validate_signup_user' => [
                'es' => 'Soy <strong>Daniel Basurto</strong>, CEO de Guestvox y espero te encuentres de lo mejor. Hémos validado tu correo electrónico. Para terminar, por favor activa tu usuario.',
                'en' => 'I am <strong>Daniel Basurto</strong>, CEO for Guestvox and I hope you find the best. We have validated your email. To finish, please activate your user.'
            ],
            'active_user' => [
                'es' => 'Activar mi usuario',
                'en' => 'Active my user'
            ],
            'terms_and_conditions' => [
                'es' => 'Términos y condiciones',
                'en' => 'Terms and conditions'
            ],
            'privacy_policies' => [
                'es' => 'Políticas de privacidad',
                'en' => 'Privacy policies'
            ],
            'activated_user_subject' => [
                'es' => 'Tu usuario ha sido activado',
                'en' => 'Your user has been activated'
            ],
            'activated_user_text' => [
                'es' => 'Hemos activado tu usuario correctamente. Ahora ya puedes iniciar sesión y empezar a trabajar con tu equipo ¡Bienvenido a Guestvox!',
                'en' => 'We have activated your user correctly. Now you can log in and start working with your team ¡Welcome to Guestvox!'
            ],
            'receive_notifications_on_whatsapp' => [
                'es' => 'Recibe notificaciones en Whatsapp',
                'en' => 'Receive notifications on WhatsApp'
            ],
            'notifications_on_whatsapp' => [
                'es' => 'Notificaciones en WhatsApp',
                'en' => 'Notifications on WhatsApp'
            ],
            'join' => [
                'es' => 'Unirse',
                'en' => 'Join'
            ],
            'login' => [
                'es' => 'Iniciar sesión',
                'en' => 'Login'
            ],
            'thanks_received_request' => [
                'es' => '¡Gracias, hemos recibido tu petición!',
                'en' => '¡Thanks, we have received your request!'
            ],
            'thanks_received_incident' => [
                'es' => '¡Gracias, hemos recibido tu incidencia!',
                'en' => '¡Thanks, we have received your incident!'
            ],
            'thanks_received_menu_order' => [
                'es' => '¡Gracias, hemos recibido tu pedido!',
                'en' => '¡Thanks, we have received your order!'
            ],
            'new' => [
                'request' => [
                    'es' => 'Nueva petición',
                    'en' => 'New request'
                ],
                'incident' => [
                    'es' => 'Nueva incidencia',
                    'en' => 'New incident'
                ],
                'workorder' => [
                    'es' => 'Nueva orden de trabajo',
                    'en' => 'New workorder'
                ]
            ],
            'commented_vox' => [
                'es' => 'Vox comentado',
                'en' => 'Commented vox'
            ],
            'completed_vox' => [
                'es' => 'Vox completado',
                'en' => 'Completed vox'
            ],
            'reopened_vox' => [
                'es' => 'Vox reabierto',
                'en' => 'Reopened vox'
            ],
            'edited_vox' => [
                'es' => 'Vox editado',
                'en' => 'Edited vox'
            ],
            'token' => [
                'es' => 'Token',
                'en' => 'Token'
            ],
            'owner' => [
                'es' => 'Propietario',
                'en' => 'Owner'
            ],
            'not_owner' => [
                'es' => 'Sin propietario',
                'en' => 'Not owner'
            ],
            'opportunity_area' => [
                'es' => 'Área de oportunidad',
                'en' => 'Opportunity area'
            ],
            'opportunity_type' => [
                'es' => 'Tipo de oportunidad',
                'en' => 'Opportunity type'
            ],
            'started_date' => [
                'es' => 'Fecha de inicio',
                'en' => 'Started date'
            ],
            'started_hour' => [
                'es' => 'Hora de inicio',
                'en' => 'Started hour'
            ],
            'location' => [
                'es' => 'Ubicación',
                'en' => 'Location'
            ],
            'not_location' => [
                'es' => 'Sin ubicación',
                'en' => 'Not location'
            ],
            'references' => [
                'es' => 'Referencias',
                'en' => 'References'
            ],
            'not_references' => [
                'es' => 'Sin referencias',
                'en' => 'Not references'
            ],
            'urgency' => [
                'es' => 'Urgencia',
                'en' => 'Urgency'
            ],
            'low' => [
                'es' => 'Baja',
                'en' => 'Low'
            ],
            'medium' => [
                'es' => 'Media',
                'en' => 'Medium'
            ],
            'high' => [
                'es' => 'Alta',
                'en' => 'High'
            ],
            'observations' => [
                'es' => 'Observaciones',
                'en' => 'Observations'
            ],
            'not_observations' => [
                'es' => 'Sin observaciones',
                'en' => 'Not observations'
            ],
            'not_subject' => [
                'es' => 'Sin asunto',
                'en' => 'Not subject'
            ],
            'confidentiality' => [
                'es' => 'Confidencialidad',
                'en' => 'Confidentiality'
            ],
            'yes' => [
                'es' => 'Si',
                'en' => 'Yes'
            ],
            'not' => [
                'es' => 'No',
                'en' => 'Not'
            ],
            'subject' => [
                'es' => 'Asunto',
                'en' => 'Subject'
            ],
            'description' => [
                'es' => 'Descripción',
                'en' => 'Description'
            ],
            'not_description' => [
                'es' => 'Sin descripción',
                'en' => 'Not description'
            ],
            'give_follow_up' => [
                'es' => 'Dar seguimiento',
                'en' => 'Give follow up'
            ],
            'view_details' => [
                'es' => 'Ver detalles',
                'en' => 'View details'
            ],
            'restore_password' => [
                'es' => 'Tu contraseña ha sido restaurada',
                'en' => 'Your password has been restore'
            ],
            'new_password' => [
                'es' => 'Nueva contraseña',
                'en' => 'New password'
            ],
            'email' => [
                'es' => 'Correo electrónico',
                'en' => 'Email'
            ],
            'username' => [
                'es' => 'Nombre de usuario',
                'en' => 'Username'
            ],
            'password' => [
                'es' => 'Contraseña',
                'en' => 'Password'
            ],
            'view_my_order' => [
                'es' => 'Ver mi pedido',
                'en' => 'View my order'
            ]
        ];

        return !empty($subkey) ? $langs[$key][$subkey] : $langs[$key];
    }

    static public function charts($key)
    {
        $langs = [
            'v_oa_chart' => [
                'es' => 'Voxes por áreas de oportunidad',
                'en' => 'Voxes by opportunity areas'
            ],
            'v_o_chart' => [
                'es' => 'Voxes por propietario',
                'en' => 'Voxes by owner'
            ],
            'v_l_chart' => [
                'es' => 'Voxes por ubicación',
                'en' => 'Voxes by location'
            ],
            'ar_oa_chart' => [
                'es' => 'Tiempo de resolución por áreas de oportunidad',
                'en' => 'Resolution average by opportunity areas'
            ],
            'ar_o_chart' => [
                'es' => 'Tiempo de resolución por propietario',
                'en' => 'Resolution average by owner'
            ],
            'ar_l_chart' => [
                'es' => 'Tiempo de resolución por ubicación',
                'en' => 'Resolution average by location'
            ],
            'c_oa_chart' => [
                'es' => 'Costos por áreas de oportunidad',
                'en' => 'Costs by opportunity areas'
            ],
            'c_o_chart' => [
                'es' => 'Costos por propietario',
                'en' => 'Costs by owner'
            ],
            'c_l_chart' => [
                'es' => 'Costos por ubicación',
                'en' => 'Costs by location'
            ],
            's1_chart' => [
                'es' => 'Encuestas respondidas por propietario',
                'en' => 'Answered surveys by owner'
            ],
            's2_chart' => [
                'es' => '¿Qué tan probable es que nos recomiende a un amigo?',
                'en' => 'How likely are you to refer us to a friend?'
            ],
            's3_chart' => [
                'es' => '',
                'en' => ''
            ],
            's4_chart' => [
                'es' => 'Nacionalidad',
                'en' => 'Nationality'
            ],
            's5_chart' => [
                'es' => 'Canal de entrada',
                'en' => 'Input channel'
            ],
            's6_chart' => [
                'es' => 'Tipo de viajero',
                'en' => 'Traveler type'
            ],
            's7_chart' => [
                'es' => 'Grupo de edad',
                'en' => 'Age group'
            ],
            'not_owner' => [
                'es' => 'Sin propietario',
                'en' => 'Not owner'
            ],
            'empty' => [
                'es' => 'Sin datos',
                'en' => 'No data'
            ]
        ];

        return $langs[$key];
    }
}
