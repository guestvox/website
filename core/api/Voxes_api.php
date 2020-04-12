<?php

// require_once 'plugins/nexmo/vendor/autoload.php';

class Voxes_api extends Model
{
    public function get($params)
    {
        if (!empty($params[0]))
        {
            if (!empty($params[1]))
            {
                $query = Functions::get_json_decoded_query($this->database->select('voxes', [
                    '[>]accounts' => [
                        'account' => 'id'
                    ]
                ], [
                    'voxes.id',
                    'voxes.type',
                    'voxes.data',
                    'accounts.zaviapms'
                ], [
                    'voxes.id' => $params[1]
                ]));

                if (!empty($query) AND $query[0]['zaviapms']['status'] == true)
                {
                    unset($query[0]['zaviapms']);

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
                        return 'Vox cerrado';
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
                    'accounts.zaviapms'
                ], [
                    'voxes.account' => $params[0]
                ]));

                if (!empty($query) AND $query[0]['zaviapms']['status'] == true)
                {
                    foreach ($query as $key => $value)
                    {
                        $query[$key]['data'] = json_decode(Functions::get_openssl('decrypt', $query[$key]['data']), true);

                        if ($query[$key]['data']['status'] == 'open')
                        {
                            unset($query[$key]['zaviapms']);

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

                    return $query;
                }
                else
                    return 'No se encontraron registros';
            }
        }
        else
            return 'Cuenta no establecida';
    }

    public function post($params)
    {
        if (!empty($_POST['action']))
        {
            if ($_POST['action'] == 'create')
            {
                $errors = [];

                if (!isset($_POST['username']) OR empty($_POST['username']))
                    array_push($errors, ['username','']);

                if (!isset($_POST['account']) OR empty($_POST['account']))
                    array_push($errors, ['account','']);

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

                if (empty($errors))
                {
                    $_POST['confidentiality'] = (!empty($_POST['confidentiality'])) ? true : false;
                    $_POST['attachments'] = [];

                    $query = $this->database->insert('voxes', [
                        'account' => $_POST['account'],
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

                    return !empty($query) ? $this->database->id() : 'Error de operación';
                }
                else
                    return $errors;
            }

            if ($_POST['action'] == 'complete')
            {
                $errors = [];

                if (!isset($_POST['username']) OR empty($_POST['username']))
                    array_push($errors, ['username','']);

                if (!isset($_POST['vox']) OR empty($_POST['vox']))
                    array_push($errors, ['vox','']);

                if (empty($errors))
                {
                    $query = Functions::get_json_decoded_query($this->database->select('voxes', [
                        '[>]accounts' => [
                            'account' => 'id'
                        ]
                    ], [
                        'voxes.data',
                        'accounts.zaviapms'
                    ], [
                        'voxes.id' => $_POST['vox']
                    ]));

                    if (!empty($query) AND $query[0]['zaviapms']['status'] == true)
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
                            'id' => $_POST['vox']
                        ]);

                        return !empty($query) ? 'Vox completado correctamente' : 'Error de operación';
                    }
                    else
                        return 'No se encontraron registros';
                }
                else
                    return $errors;
            }
        }
        else
            return 'Establesca la variable "action" en el $_POST. Acciones disponibles: create, complete.';
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
