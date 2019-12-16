<?php

// require_once 'plugins/nexmo/vendor/autoload.php';

class Voxes_api extends Model
{
    public function get($params)
    {
        if (Api_vkye::check_access($params[0], $params[1]) == true)
        {
            if (!empty($params[2]))
            {
                if (!empty($params[3]))
                {
                    $query = Functions::get_json_decoded_query($this->database->select('voxes', [
                        '[>]accounts' => [
                            'account' => 'id'
                        ]
                    ], [
                        'voxes.id',
                        'voxes.type',
                        'voxes.data',
                    ], [
                        'AND' => [
                            'voxes.id' => $params[3],
                            'accounts.zav' => true
                        ]
                    ]));

                    if (!empty($query))
                    {
                        $query[0]['data'] = json_decode(Functions::get_openssl('decrypt', $query[0]['data']), true);

                        if ($query[0]['data']['status'] == 'open')
                        {
                            $query[0]['data']['room'] = $this->database->select('rooms', [
                                'id',
                    			'name'
                    		], [
                    			'id' => $query[0]['data']['room']
                    		]);

                            $query[0]['data']['opportunity_area'] = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
                                'id',
                    			'name'
                    		], [
                    			'id' => $query[0]['data']['opportunity_area']
                    		]));

                            $query[0]['data']['opportunity_type'] = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
                                'id',
                    			'name'
                    		], [
                    			'id' => $query[0]['data']['opportunity_type']
                    		]));

                            $query[0]['data']['location'] = Functions::get_json_decoded_query($this->database->select('locations', [
                                'id',
                    			'name'
                    		], [
                    			'id' => $query[0]['data']['location']
                    		]));

                            $query[0]['data']['guest_treatment'] = $this->database->select('guest_treatments', [
                                'id',
                    			'name'
                    		], [
                    			'id' => $query[0]['data']['guest_treatment']
                    		]);

                            return $query[0];
                        }
                        else
                            return 'Vox no activo';
                    }
                    else
                        return 'No se encontraron registros';
                }
                else
                {
                    $query = Functions::get_json_decoded_query($this->database->select('voxes', [
                        '[>]accounts' => [
                            'account' => 'id'
                        ]
                    ], [
                        'voxes.id',
                        'voxes.type',
                        'voxes.data',
                    ], [
                        'AND' => [
                            'voxes.account' => $params[2],
                            'accounts.zav' => true
                        ]
                    ]));

                    foreach ($query as $key => $value)
                    {
                        $query[$key]['data'] = json_decode(Functions::get_openssl('decrypt', $query[$key]['data']), true);

                        if ($query[$key]['data']['status'] == 'open')
                        {
                            $query[$key]['data']['room'] = $this->database->select('rooms', [
                                'id',
                    			'name'
                    		], [
                    			'id' => $query[$key]['data']['room']
                    		]);

                            $query[$key]['data']['opportunity_area'] = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
                                'id',
                    			'name'
                    		], [
                    			'id' => $query[$key]['data']['opportunity_area']
                    		]));

                            $query[$key]['data']['opportunity_type'] = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
                                'id',
                    			'name'
                    		], [
                    			'id' => $query[$key]['data']['opportunity_type']
                    		]));

                            $query[$key]['data']['location'] = Functions::get_json_decoded_query($this->database->select('locations', [
                                'id',
                    			'name'
                    		], [
                    			'id' => $query[$key]['data']['location']
                    		]));

                            $query[$key]['data']['guest_treatment'] = $this->database->select('guest_treatments', [
                                'id',
                    			'name'
                    		], [
                    			'id' => $query[$key]['data']['guest_treatment']
                    		]);
                        }
                        else
                            unset($query[$key]);
                    }

                    return !empty($query) ? $query : 'No se encontraron registros';
                }
            }
            else
                return 'Cuenta de uso no definida';
        }
        else
            return 'Credenciales de acceso no válidas';
    }

    public function post($params)
    {
        if (Api_vkye::check_access($params[0], $params[1]) == true)
        {
            if (!empty($params[2]))
            {
                if (!empty($_POST['username']))
                {
                    if (!empty($params[3]))
                    {
                        $query = Functions::get_json_decoded_query($this->database->select('voxes', [
                            '[>]accounts' => [
                                'account' => 'id'
                            ]
                        ], [
                            'voxes.data',
                        ], [
                            'AND' => [
                                'voxes.id' => $params[3],
                                'accounts.zav' => true
                            ]
                        ]));

                        if (!empty($query))
                        {
                            $query[0]['data'] = json_decode(Functions::get_openssl('decrypt', $query[0]['data']), true);
                            $query[0]['data']['completed_user'] = [
                                'zavia',
                                $_POST['username']
                            ];
                			$query[0]['data']['completed_date'] = Functions::get_current_date();
                			$query[0]['data']['completed_hour'] = Functions::get_current_hour();
                			$query[0]['data']['status'] = 'close';

                            array_push($query[0]['data']['changes_history'], [
                				'type' => 'complete',
                				'user' => [
                                    'zavia',
                                    $_POST['username']
                                ],
                				'date' => Functions::get_current_date(),
                				'hour' => Functions::get_current_hour(),
                			]);

                            $query = $this->database->update('voxes', [
                				'data' => Functions::get_openssl('encrypt', json_encode($query[0]['data']))
                			], [
                				'id' => $params[3]
                			]);

                            return !empty($query) ? 'Ok' : 'Error de operación';
                        }
                        else
                            return 'No se encontraron registros';
                    }
                    else
                    {
                        $labels = [];

                        if (!isset($_POST['type']) OR empty($_POST['type']))
                            array_push($labels, ['type','']);

                        if (!isset($_POST['opportunity_area']) OR empty($_POST['opportunity_area']))
                            array_push($labels, ['opportunity_area','']);

                        if (!isset($_POST['opportunity_type']) OR empty($_POST['opportunity_type']))
                            array_push($labels, ['opportunity_type','']);

                        if (!isset($_POST['started_date']) OR empty($_POST['started_date']))
                            array_push($labels, ['started_date','']);

                        if (!isset($_POST['started_hour']) OR empty($_POST['started_hour']))
                            array_push($labels, ['started_hour','']);

                        if (!isset($_POST['location']) OR empty($_POST['location']))
                            array_push($labels, ['location','']);

                        if (!isset($_POST['urgency']) OR empty($_POST['urgency']))
                            array_push($labels, ['urgency','']);

                        if ($_POST['type'] == 'request')
                        {
                            if (!empty($_POST['observations']) AND strlen($_POST['observations']) > 120)
                                array_push($labels, ['observations','']);
                        }

                        if ($_POST['type'] == 'incident')
                        {
                            if (!empty($_POST['subject']) AND strlen($_POST['subject']) > 120)
                                array_push($labels, ['subject','']);
                        }

                        if (empty($labels))
                        {
                            $_POST['confidentiality'] = (!empty($_POST['confidentiality'])) ? true : false;
                            $_POST['attachments'] = [];

                			// if (!empty($_POST['attachments']))
                            // {
                            //     // $this->component->load_component('uploader');
                            //     //
                    		// 	// $_com_uploader = new Upload;
                            //     //
                    		// 	// foreach ($_POST['attachments']['name'] as $key => $value)
                    		// 	// {
                    		// 	// 	if (!empty($_POST['attachments']['name'][$key]))
                    		// 	// 	{
                    		// 	// 		$ext = explode('.', $_POST['attachments']['name'][$key]);
                    		// 	// 		$ext = end($ext);
                            //     //
                    		// 	// 		if ($ext == 'doc' || $ext == 'docx' || $ext == 'xls' || $ext == 'xlsx')
                    		// 	// 			$_POST['attachments']['type'][$key] = 'application/' . $ext;
                            //     //
                    		// 	// 		$_com_uploader->SetFileName($_POST['attachments']['name'][$key]);
                    		// 	// 		$_com_uploader->SetTempName($_POST['attachments']['tmp_name'][$key]);
                    		// 	// 		$_com_uploader->SetFileType($_POST['attachments']['type'][$key]);
                    		// 	// 		$_com_uploader->SetFileSize($_POST['attachments']['size'][$key]);
                    		// 	// 		$_com_uploader->SetUploadDirectory(PATH_UPLOADS);
                    		// 	// 		$_com_uploader->SetValidExtensions(['jpg','jpeg','png','pdf','doc','docx','xls','xlsx']);
                    		// 	// 		$_com_uploader->SetMaximumFileSize('unlimited');
                            //     //
                    		// 	// 		$_POST['attachments'][$key] = $_com_uploader->UploadFile();
                    		// 	// 	}
                    		// 	// }
                            //     //
                    		// 	// unset($_POST['attachments']['name'], $_POST['attachments']['type'], $_POST['attachments']['tmp_name'], $_POST['attachments']['error'], $_POST['attachments']['size']);
                            // }

                    		$query = $this->database->insert('voxes', [
                    			'account' => $params[2],
                    			'type' => $_POST['type'],
                    			'data' => Functions::get_openssl('encrypt', json_encode([
                    				'token' => Functions::get_random(8),
                    				'room' => $_POST['room'],
                    				'opportunity_area' => $_POST['opportunity_area'],
                    				'opportunity_type' => $_POST['opportunity_type'],
                    				'started_date' => Functions::get_formatted_date($_POST['started_date']),
                    				'started_hour' => Functions::get_formatted_hour($_POST['started_hour']),
                    				'location' => $_POST['location'],
                    				'cost' => ($_POST['type'] == 'incident') ? $_POST['cost'] : null,
                    				'urgency' => $_POST['urgency'],
                    				'confidentiality' => ($_POST['type'] == 'incident') ? $_POST['confidentiality'] : null,
                    				'assigned_users' => (!empty($_POST['assigned_users'])) ? $_POST['assigned_users'] : [],
                    				'observations' => ($_POST['type'] == 'request') ? $_POST['observations'] : null,
                    				'subject' => ($_POST['type'] == 'incident') ? $_POST['subject'] : null,
                    				'description' => ($_POST['type'] == 'incident') ? $_POST['description'] : null,
                    				'action_taken' => ($_POST['type'] == 'incident') ? $_POST['action_taken'] : null,
                    				'guest_treatment' => $_POST['guest_treatment'],
                    				'firstname' => ($_POST['type'] == 'incident') ? $_POST['firstname'] : null,
                    				'lastname' => $_POST['lastname'],
                    				'guest_id' => ($_POST['type'] == 'incident') ? $_POST['guest_id'] : null,
                    				'guest_type' => ($_POST['type'] == 'incident') ? $_POST['guest_type'] : null,
                    				'reservation_number' => ($_POST['type'] == 'incident') ? $_POST['reservation_number'] : null,
                    				'reservation_status' => ($_POST['type'] == 'incident') ? $_POST['reservation_status'] : null,
                    				'check_in' => ($_POST['type'] == 'incident') ? $_POST['check_in'] : null,
                    				'check_out' => ($_POST['type'] == 'incident') ? $_POST['check_out'] : null,
                    				'attachments' => $_POST['attachments'],
                    				'viewed_by' => [],
                    				'comments' => [],
                    				'changes_history' => [
                    					[
                    						'type' => 'create',
                    						'user' => [
                                                'zavia',
                                                $_POST['username'],
                                            ],
                    						'date' => Functions::get_current_date(),
                    						'hour' => Functions::get_current_hour(),
                    					]
                    				],
                    				'created_user' => [
                                        'zavia',
                                        $_POST['username'],
                                    ],
                    				'edited_user' => null,
                    				'completed_user' => null,
                    				'reopened_user' => null,
                    				'created_date' => Functions::get_current_date(),
                    				'created_hour' => Functions::get_current_hour(),
                    				'edited_date' => null,
                    				'edited_hour' => null,
                    				'completed_date' => null,
                    				'completed_hour' => null,
                    				'reopened_date' => null,
                    				'reopened_hour' => null,
                    				'readed' => false,
                    				'status' => 'open',
                    				'origin' => 'external',
                    			])),
                    		]);

                            if (!empty($query))
                            {
                                $query = $this->database->id();

                                // if (!empty($_POST['assigned_users']))
                                // {
                                //     $_POST['assigned_users'] = Functions::get_json_decoded_query($this->database->select('users', [
                        		// 		'name',
                        		// 		'lastname',
                        		// 		'email',
                        		// 		'cellphone',
                        		// 	], [
                        		// 		'id' => $_POST['assigned_users']
                        		// 	]));
                                // }
                                // else
                                // {
                                //     $_POST['assigned_users'] = Functions::get_json_decoded_query($this->database->select('users', [
                        		// 		'name',
                        		// 		'lastname',
                        		// 		'email',
                        		// 		'cellphone',
                        		// 		'opportunity_areas',
                        		// 	], [
                        		// 		'account' => $params[2]
                        		// 	]));
                                //
                                //     foreach ($_POST['assigned_users'] as $key => $value)
                        		// 	{
                        		// 		if (!in_array($_POST['opportunity_area'], $value['opportunity_areas']))
                        		// 			unset($_POST['assigned_users'][$key]);
                        		// 	}
                                // }
                                //
                                // $_POST['room'] = Functions::get_json_decoded_query($this->database->select('rooms', [
                        		// 	'name'
                        		// ], [
                        		// 	'id' => $_POST['room']
                        		// ]));
                                //
                                // $_POST['opportunity_area'] = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
                        		// 	'name'
                        		// ], [
                        		// 	'id' => $_POST['opportunity_area']
                        		// ]));
                                //
                                // $_POST['opportunity_type'] = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
                        		// 	'name'
                        		// ], [
                        		// 	'id' => $_POST['opportunity_type'],
                        		// ]));
                                //
                                // $_POST['location'] = Functions::get_json_decoded_query($this->database->select('locations', [
                        		// 	'name'
                        		// ], [
                        		// 	'id' => $_POST['location']
                        		// ]));
                                //
                                // $mail = new Mailer(true);
                                //
                                // try
                                // {
                                //     if ($_POST['type'] == 'request')
                                //         $mail_subject = 'Tienes una nueva petición en GuestVox';
                                //     else if ($_POST['type'] == 'incident')
                                //         $mail_subject = 'Tienes una nueva incidencia en GuestVox';
                                //
                                //     $mail_room = 'Habitación: ';
                                //     $mail_opportunity_area = 'Área de oportunidad: ';
                                //     $mail_opportunity_type = 'Tipo de oportunidad: ';
                                //     $mail_started_date = 'Fecha de inicio: ';
                                //     $mail_started_hour = 'Hora de inicio: ';
                                //     $mail_location = 'Ubicación: ';
                                //
                                //     if (Functions::get_current_date_hour() < Functions::get_formatted_date_hour($_POST['started_date'], $_POST['started_hour']))
                                //         $mail_urgency = 'Urgencia: Programada';
                                //     else if ($_POST['urgency'] == 'low')
                                //         $mail_urgency = 'Urgencia: Baja';
                                //     else if ($_POST['urgency'] == 'medium')
                                //         $mail_urgency = 'Urgencia: Media';
                                //     else if ($_POST['urgency'] == 'high')
                                //         $mail_urgency = 'Urgencia: Alta';
                                //
                                //     if ($_POST['confidentiality'] == true)
                                //         $mail_confidentiality = 'Confidencialidad: Si';
                                //     else if ($_POST['confidentiality'] == false)
                                //         $mail_confidentiality = 'Confidencialidad: No';
                                //
                                //     $mail_observations = 'Observaciones: ';
                                //     $mail_description = 'Descripción: ';
                                //     $mail_give_follow_up = 'Dar seguimiento';
                                //
                                //     $mail->isSMTP();
                                //     $mail->setFrom('noreply@guestvox.com', 'GuestVox');
                                //
                                //     foreach ($_POST['assigned_users'] as $value)
                                //         $mail->addAddress($value['email'], $value['name'] . ' ' . $value['lastname']);
                                //
                                //     $mail->isHTML(true);
                                //     $mail->Subject = $mail_subject;
                                //     $mail->Body =
                                //     '<html>
                                //         <head>
                                //             <title>' . $mail_subject . '</title>
                                //         </head>
                                //         <body>
                                //             <table style="width:600px;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#eee">
                                //                 <tr style="width:100%;margin:0px:margin-bottom:10px;border:0px;padding:0px;">
                                //                     <td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
                                //                         <figure style="width:100%;margin:0px;padding:0px;text-align:center;">
                                //                             <img style="width:100%;max-width:300px;" src="https://guestvox.com/images/logotype-color.png" />
                                //                         </figure>
                                //                     </td>
                                //                 </tr>
                                //                 <tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
                                //                     <td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
                                //                         <h4 style="font-size:24px;font-weight:600;text-align:center;color:#212121;margin:0px;margin-bottom:20px;padding:0px;">' . $mail_subject . '</h4>
                                //                         <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_room . $_POST['room'][0]['name'] . '</h6>
                                //                         <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_opportunity_area . $_POST['opportunity_area'][0]['name']['es'] . '</h6>
                                //                         <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_opportunity_type . $_POST['opportunity_type'][0]['name']['es'] . '</h6>
                                //                         <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_started_date . Functions::get_formatted_date($_POST['started_date'], 'd M, Y') . '</h6>
                                //                         <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_started_hour . Functions::get_formatted_hour($_POST['started_hour'], '+ hrs') . '</h6>
                                //                         <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_location . $_POST['location'][0]['name']['es'] . '</h6>
                                //                         <h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_urgency . '</h6>';
                                //
                                //     if ($_POST['type'] == 'request')
                                //         $mail->Body .= '<p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail_observations . $_POST['observations'] . '</p>';
                                //     else if ($_POST['type'] == 'incident')
                                //     {
                                //         $mail->Body .=
                                //         '<h6 style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;margin-bottom:5px;padding:0px;">' . $mail_confidentiality . '</h6>
                                //         <p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail_description . $_POST['description'] . '</p>';
                                //     }
                                //
                                //     $mail->Body .=
                                //     '                   <a style="width:100%;display:block;margin:15px 0px 20px 0px;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;background-color:#201d33;" href="https://guestvox.com/voxes/view/' . $query . '">' . $mail_give_follow_up . '</a>
                                //                     </td>
                                //                 </tr>
                                //                 <tr style="width:100%;margin:0px;border:0px;padding:0px;">
                                //                     <td style="width:100%;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#fff;">
                                //                         <a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#201d33;" href="https://guestvox.com/">www.guestvox.com</a>
                                //                     </td>
                                //                 </tr>
                                //             </table>
                                //         </body>
                                //     </html>';
                                //     $mail->AltBody = '';
                                //     $mail->send();
                                // }
                                // catch (Exception $e) { }

                                // $basic  = new \Nexmo\Client\Credentials\Basic('45669cce', 'CR1Vg1bpkviV8Jzc');
                                // $client = new \Nexmo\Client($basic);
                                //
                                // $sms = $this->database->select('settings', [
                        		// 	'sms'
                        		// ], [
                        		// 	'account' => $params[2]
                        		// ]);
                                //
                                // if ($sms[0]['sms'] > 0)
                                // {
                                //     if ($_POST['type'] == 'request')
                                //         $sms_subject = 'GuestVox: Nueva petición';
                                //     else if ($_POST['type'] == 'incident')
                                //         $sms_subject = 'GuestVox: Nueva incidencia';
                                //
                                //     $sms_room = 'Hab: ';
                                //     $sms_opportunity_area = 'AO: ';
                                //     $sms_opportunity_type = 'TO: ';
                                //     $sms_started_date = 'Fecha: ';
                                //     $sms_started_hour = 'Hr: ';
                                //     $sms_location = 'Ubic: ';
                                //
                                //     if (Functions::get_current_date_hour() < Functions::get_formatted_date_hour($_POST['started_date'], $_POST['started_hour']))
                                //         $sms_urgency = 'Urg: Programada';
                                //     else if ($_POST['urgency'] == 'low')
                                //         $sms_urgency = 'Urg: Baja';
                                //     else if ($_POST['urgency'] == 'medium')
                                //         $sms_urgency = 'Urg: Media';
                                //     else if ($_POST['urgency'] == 'high')
                                //         $sms_urgency = 'Urg: Alta';
                                //
                                //     if ($_POST['confidentiality'] == true)
                                //         $sms_confidentiality = 'Conf: Si';
                                //     else if ($_POST['confidentiality'] == false)
                                //         $sms_confidentiality = 'Conf: No';
                                //
                                //     $sms_observations = 'Obs: ';
                                //     $sms_description = 'Desc: ';
                                //
                                //     $sms_text = $sms_subject . $sms_room . $_POST['room'][0]['name'] . ' ' . $sms_opportunity_area . $_POST['opportunity_area'][0]['name']['es'] . ' ' . $sms_opportunity_type . $_POST['opportunity_type'][0]['name']['es'] . ' ' . $sms_started_date . Functions::get_formatted_date($_POST['started_date'], 'd M y') . ' ' . $sms_started_hour . Functions::get_formatted_hour($_POST['started_hour'], '+ hrs') . ' ' . $sms_location . $_POST['location'][0]['name']['es'] . ' ' . $sms_urgency . ' ';
                                //
                                //     if ($_POST['type'] == 'request')
                                //         $sms_text .= $sms_observations . $_POST['observations'];
                                //     else if ($_POST['type'] == 'incident')
                                //         $sms_text .= $sms_confidentiality . ' ' . $sms_description . $_POST['description'];
                                //
                                //     foreach ($_POST['assigned_users'] as $value)
                                //     {
                                //         if ($sms[0]['sms'] > 0)
                                //         {
                                //             $client->message()->send([
                                //                 'to' => '52' . $value['cellphone'],
                                //                 'from' => 'GuestVox',
                                //                 'text' => $sms_text . ' https://' . Configuration::$domain . '/voxes/view/' . $query
                                //             ]);
                                //
                                //             $sms[0]['sms'] = $sms[0]['sms'] - 1;
                                //         }
                                //     }
                                //
                                //     $this->database->update('settings', [
                            	// 		'sms' => $sms[0]['sms']
                            	// 	], [
                            	// 		'account' => $params[2]
                            	// 	]);
                                // }

                                return $query;
                            }
                            else
                                return 'Error de operación';
                        }
                        else
                            return $labels;
                    }
                }
                else
                    return 'Usuario relacionado no definido';
            }
            else
                return 'Cuenta de uso no definida';
        }
        else
            return 'Credenciales de acceso no válidas';
    }

    public function put($params)
    {
        return 'Ok';
    }

    public function delete($params)
    {
        return 'Ok';
    }
}
