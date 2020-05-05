<?php

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
        			'voxes.owner',
        			'voxes.opportunity_area',
        			'voxes.opportunity_type',
        			'voxes.started_date',
        			'voxes.started_hour',
        			'voxes.location',
        			'voxes.cost',
        			'voxes.urgency',
        			'voxes.confidentiality',
        			'voxes.assigned_users',
        			'voxes.observations',
        			'voxes.subject',
        			'voxes.description',
        			'voxes.action_taken',
        			'voxes.guest_treatment',
        			'voxes.firstname',
        			'voxes.lastname',
        			'voxes.guest_id',
        			'voxes.guest_type',
        			'voxes.reservation_number',
        			'voxes.reservation_status',
        			'voxes.check_in',
        			'voxes.check_out',
        			'voxes.attachments',
        			'voxes.viewed_by',
        			'voxes.comments',
        			'voxes.changes_history',
        			'voxes.created_user',
        			'voxes.edited_user',
        			'voxes.completed_user',
        			'voxes.reopened_user',
        			'voxes.created_date',
        			'voxes.created_hour',
        			'voxes.edited_date',
        			'voxes.edited_hour',
        			'voxes.completed_date',
        			'voxes.completed_hour',
        			'voxes.reopened_date',
        			'voxes.reopened_hour',
        			'voxes.status',
        			'voxes.origin',
                    'accounts.zaviapms'
                ], [
                    'voxes.id' => $params[1]
                ]));

                if (!empty($query) AND $query[0]['zaviapms']['status'] == true)
                {
                    if ($query[0]['status'] == 'open')
                    {
                        $query[0]['owner'] = $this->database->select('owners', [
                            'id',
                            'name'
                        ], [
                            'id' => $query[0]['owner']
                        ]);

                        array_map('current', $query[0]['owner']);

                        $query[0]['opportunity_area'] = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
                            'id',
                            'name'
                        ], [
                            'id' => $query[0]['opportunity_area']
                        ]));

                        array_map('current', $query[0]['opportunity_area']);

                        $query[0]['opportunity_type'] = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
                            'id',
                            'name'
                        ], [
                            'id' => $query[0]['opportunity_type']
                        ]));

                        array_map('current', $query[0]['opportunity_type']);

                        $query[0]['location'] = Functions::get_json_decoded_query($this->database->select('locations', [
                            'id',
                            'name'
                        ], [
                            'id' => $query[0]['location']
                        ]));

                        array_map('current', $query[0]['location']);

                        foreach ($query[0]['assigned_users'] as $key => $value)
                        {
                            $query[0]['assigned_users'][$key] = $this->database->select('users', [
                                'id',
                    			'firstname',
                    			'lastname',
                    			'email',
                    			'phone',
                    			'avatar',
                    			'username'
                            ], [
                                'id' => $value
                            ]);

                            array_map('current', $query[0]['assigned_users'][$key]);
                        }

                        $query[0]['guest_treatment'] = $this->database->select('guest_treatments', [
                            'id',
                            'name'
                        ], [
                            'id' => $query[0]['guest_treatment']
                        ]);

                        array_map('current', $query[0]['guest_treatment']);

                        $query[0]['guest_type'] = $this->database->select('guest_types', [
                            'id',
                            'name'
                        ], [
                            'id' => $query[0]['guest_type']
                        ]);

                        array_map('current', $query[0]['guest_type']);

                        $query[0]['reservation_status'] = $this->database->select('reservation_statuses', [
                            'id',
                            'name'
                        ], [
                            'id' => $query[0]['reservation_status']
                        ]);

                        array_map('current', $query[0]['reservation_status']);

                        foreach ($query[0]['assigned_users'] as $key => $value)
                        {
                            $query[0]['assigned_users'][$key] = $this->database->select('users', [
                                'id',
                    			'firstname',
                    			'lastname',
                    			'email',
                    			'phone',
                    			'avatar',
                    			'username'
                            ], [
                                'id' => $value
                            ]);

                            array_map('current', $query[0]['assigned_users'][$key]);
                        }

                        unset($query[0]['zaviapms']);

                        return $query[0];
                    }
                    else
                        return 'Este vox está cerrado';
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
        			'voxes.owner',
        			'voxes.opportunity_area',
        			'voxes.opportunity_type',
        			'voxes.started_date',
        			'voxes.started_hour',
        			'voxes.location',
        			'voxes.cost',
        			'voxes.urgency',
        			'voxes.confidentiality',
        			'voxes.assigned_users',
        			'voxes.observations',
        			'voxes.subject',
        			'voxes.description',
        			'voxes.action_taken',
        			'voxes.guest_treatment',
        			'voxes.firstname',
        			'voxes.lastname',
        			'voxes.guest_id',
        			'voxes.guest_type',
        			'voxes.reservation_number',
        			'voxes.reservation_status',
        			'voxes.check_in',
        			'voxes.check_out',
        			'voxes.attachments',
        			'voxes.viewed_by',
        			'voxes.comments',
        			'voxes.changes_history',
        			'voxes.created_user',
        			'voxes.edited_user',
        			'voxes.completed_user',
        			'voxes.reopened_user',
        			'voxes.created_date',
        			'voxes.created_hour',
        			'voxes.edited_date',
        			'voxes.edited_hour',
        			'voxes.completed_date',
        			'voxes.completed_hour',
        			'voxes.reopened_date',
        			'voxes.reopened_hour',
        			'voxes.status',
        			'voxes.origin',
                    'accounts.zaviapms'
                ], [
                    'voxes.account' => $params[0]
                ]));

                if (!empty($query) AND $query[0]['zaviapms']['status'] == true)
                {
                    foreach ($query as $key => $value)
                    {
                        if ($query[$key]['status'] == 'open')
                        {
                            $query[$key]['owner'] = $this->database->select('owners', [
                                'id',
                                'name'
                            ], [
                                'id' => $query[$key]['owner']
                            ]);

                            $query[$key]['opportunity_area'] = Functions::get_json_decoded_query($this->database->select('opportunity_areas', [
                                'id',
                                'name'
                            ], [
                                'id' => $query[$key]['opportunity_area']
                            ]));

                            $query[$key]['opportunity_type'] = Functions::get_json_decoded_query($this->database->select('opportunity_types', [
                                'id',
                                'name'
                            ], [
                                'id' => $query[$key]['opportunity_type']
                            ]));

                            $query[$key]['location'] = Functions::get_json_decoded_query($this->database->select('locations', [
                                'id',
                                'name'
                            ], [
                                'id' => $query[$key]['location']
                            ]));

                            $query[$key]['guest_treatment'] = $this->database->select('guest_treatments', [
                                'id',
                                'name'
                            ], [
                                'id' => $query[$key]['guest_treatment']
                            ]);

                            array_map('current', $query[$key]['owner']);
                            array_map('current', $query[$key]['opportunity_area']);
                            array_map('current', $query[$key]['opportunity_type']);
                            array_map('current', $query[$key]['location']);
                            array_map('current', $query[$key]['guest_treatment']);

                            unset($query[$key]['zaviapms']);
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
                    array_push($errors, ['username','$username: No deje está variable vacía']);
                else
                {
                    $count = $this->database->count('users', [
                        'username' => $_POST['username']
                    ]);

                    if ($count <= 0)
                        array_push($errors, ['username','$username: No se encontraron registros']);
                }

                if (!isset($_POST['account']) OR empty($_POST['account']))
                    array_push($errors, ['account','$account: No deje está variable vacía']);
                else
                {
                    $_POST['account'] = $this->database->count('accounts', [
                        'id',
                        'type'
                    ], [
                        'id' => $_POST['account']
                    ]);

                    if (!empty($_POST['account']))
                        $_POST['account'] = $_POST['account'][0];
                    else
                        array_push($errors, ['account','$account: No se encontraron registros']);
                }

                if (!isset($_POST['type']) OR empty($_POST['type']))
                    array_push($labels, ['type','$type: No deje está variable vacía (Valores disponibles: request, incident, workorder)']);
                else if ($_POST['type'] != 'request' AND $_POST['type'] != 'incident' AND $_POST['type'] != 'workorder')
                    array_push($labels, ['type','$type: Valor no válido (Valores disponibles: request, incident, workorder)']);

                if (!isset($_POST['owner']) OR empty($_POST['owner']))
                    array_push($labels, ['owner','$owner: No deje está variable vacía']);
                else
                {
                    $count = $this->database->count('owners', [
                        'id' => $_POST['owner']
                    ]);

                    if ($count <= 0)
                        array_push($errors, ['owner','$owner: No se encontraron registros']);
                }

                if (!isset($_POST['opportunity_area']) OR empty($_POST['opportunity_area']))
                    array_push($labels, ['opportunity_area','$opportunity_area: No deje está variable vacía']);
                else
                {
                    $count = $this->database->count('opportunity_areas', [
                        'id' => $_POST['opportunity_area']
                    ]);

                    if ($count <= 0)
                        array_push($errors, ['opportunity_area','$opportunity_area: No se encontraron registros']);
                }

                if (!isset($_POST['opportunity_type']) OR empty($_POST['opportunity_type']))
                    array_push($labels, ['opportunity_type','$opportunity_type: No deje está variable vacía']);
                else
                {
                    $count = $this->database->count('opportunity_types', [
                        'id' => $_POST['opportunity_type']
                    ]);

                    if ($count <= 0)
                        array_push($errors, ['opportunity_type','$opportunity_type: No se encontraron registros']);
                }

                if (!isset($_POST['started_date']) OR empty($_POST['started_date']))
                    array_push($labels, ['started_date','$started_date: No deje está variable vacía']);

                if (!isset($_POST['started_hour']) OR empty($_POST['started_hour']))
                    array_push($labels, ['started_hour','$started_hour: No deje está variable vacía']);

                if (!isset($_POST['location']) OR empty($_POST['location']))
                    array_push($labels, ['location','$location: No deje está variable vacía']);
                else
                {
                    $count = $this->database->count('locations', [
                        'id' => $_POST['location']
                    ]);

                    if ($count <= 0)
                        array_push($errors, ['location','$location: No se encontraron registros']);
                }

                if (!isset($_POST['urgency']) OR empty($_POST['urgency']))
                    array_push($labels, ['urgency','$urgency: No deje está variable vacía (Valores disponibles: low, medium, high)']);
                else if ($_POST['urgency'] != 'low' AND $_POST['urgency'] != 'medium' AND $_POST['urgency'] != 'high')
                    array_push($labels, ['urgency','$urgency: Valor no válido (Valores disponibles: low, medium, high)']);

                if ($_POST['type'] == 'request' OR $_POST['type'] == 'workorder')
                {
                    if (!empty($_POST['observations']))
                        array_push($labels, ['observations','$observations: No deje está variable vacía']);
                    else if (strlen($_POST['observations']) > 120)
                        array_push($labels, ['observations','$observations: Ingrese máximo 120 carácteres']);
                }
                else if ($_POST['type'] == 'incident')
                {
                    if (!empty($_POST['subject']))
                        array_push($labels, ['subject','$subject: No deje está variable vacía']);
                    else if (strlen($_POST['subject']) > 120)
                        array_push($labels, ['subject','$subject: Ingrese máximo 120 carácteres']);
                }

                if (empty($errors))
                {
                    $query = $this->database->insert('voxes', [
                        'account' => $_POST['account']['id'],
                        'type' => $_POST['type'],
                        'token' => Functions::get_random(8),
                        'owner' => $_POST['owner'],
                        'opportunity_area' => $_POST['opportunity_area'],
                        'opportunity_type' => $_POST['opportunity_type'],
                        'started_date' => Functions::get_formatted_date($_POST['started_date']),
                        'started_hour' => Functions::get_formatted_hour($_POST['started_hour']),
                        'location' => $_POST['location'],
                        'cost' => ($_POST['type'] == 'incident' OR $_POST['type'] == 'workorder') ? $_POST['cost'] : null,
                        'urgency' => $_POST['urgency'],
                        'confidentiality' => ($_POST['type'] == 'incident') ? (!empty($_POST['confidentiality']) ? true : false) : false,
                        'assigned_users' => json_encode([]),
                        'observations' => ($_POST['type'] == 'request' OR $_POST['type'] == 'workorder') ? $_POST['observations'] : null,
                        'subject' => ($_POST['type'] == 'incident') ? $_POST['subject'] : null,
                        'description' => ($_POST['type'] == 'incident') ? $_POST['description'] : null,
                        'action_taken' => ($_POST['type'] == 'incident') ? $_POST['action_taken'] : null,
                        'guest_treatment' => ($_POST['type'] == 'request' OR $_POST['type'] == 'incident') ? (($_POST['account']['type'] == 'hotel') ? $_POST['guest_treatment'] : null) : null,
                        'firstname' => ($_POST['type'] == 'request' OR $_POST['type'] == 'incident') ? $_POST['firstname'] : null,
                        'lastname' => ($_POST['type'] == 'request' OR $_POST['type'] == 'incident') ? $_POST['lastname'] : null,
                        'guest_id' => ($_POST['type'] == 'incident') ? (($_POST['account']['type'] == 'hotel') ? $data['guest_id'] : null) : null,
                        'guest_type' => ($_POST['type'] == 'incident') ? (($_POST['account']['type'] == 'hotel') ? $data['guest_type'] : null) : null,
                        'reservation_number' => ($_POST['type'] == 'incident') ? (($_POST['account']['type'] == 'hotel') ? $data['reservation_number'] : null) : null,
                        'reservation_status' => ($_POST['type'] == 'incident') ? (($_POST['account']['type'] == 'hotel') ? $data['reservation_status'] : null) : null,
                        'check_in' => ($_POST['type'] == 'incident') ? (($_POST['account']['type'] == 'hotel') ? $data['check_in'] : null) : null,
                        'check_out' => ($_POST['type'] == 'incident') ? (($_POST['account']['type'] == 'hotel') ? $data['check_out'] : null) : null,
                        'attachments' => json_encode([]),
                        'viewed_by' => json_encode([]),
                        'comments' => json_encode([]),
                        'changes_history' => json_encode([
                            [
                                'type' => 'create',
                                'user' => [
                                    'api',
                                    $_POST['username']
                                ],
                                'date' => Functions::get_current_date(),
                                'hour' => Functions::get_current_hour()
                            ]
                        ]),
                        'created_user' => json_encode([
                            'api',
                            $_POST['username']
                        ]),
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
                        'status' => 'open',
                        'origin' => 'external'
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
                    array_push($errors, ['username','$username: No deje esta variable vacía']);
                else
                {
                    $count = $this->database->count('users', [
                        'username' => $_POST['username']
                    ]);

                    if ($count <= 0)
                        array_push($errors, ['username','$username: No se encontraron registros']);
                }

                if (!isset($_POST['vox']) OR empty($_POST['vox']))
                    array_push($errors, ['vox','$vox: No deje está variable vacía']);
                else
                {
                    $_POST['vox'] = Functions::get_json_decoded_query($this->database->select('voxes', [
                        '[>]accounts' => [
                            'account' => 'id'
                        ]
                    ], [
                        'voxes.id',
                        'voxes.changes_history',
                        'accounts.zaviapms'
                    ], [
                        'voxes.id' => $_POST['vox']
                    ]));

                    if (!empty($_POST['vox']))
                        $_POST['vox'] = $_POST['vox'][0];
                    else
                        array_push($errors, ['vox','$vox: No se encontraron registros']);
                }

                if (empty($errors))
                {
                    if ($_POST['vox']['zaviapms']['status'] == true)
                    {
                        array_push($_POST['vox']['changes_history'], [
                            'type' => 'complete',
                            'user' => [
                                'zaviapms',
                                $_POST['username']
                            ],
                            'date' => Functions::get_current_date(),
                            'hour' => Functions::get_current_hour()
                        ]);

                        $query = $this->database->update('voxes', [
                            'changes_history' => json_encode($_POST['vox']['changes_history']),
                            'completed_user' => json_encode([
                                'zaviapms',
                                $_POST['username']
                            ]),
                            'completed_date' => Functions::get_current_date(),
                            'completed_hour' => Functions::get_current_hour(),
                            'status' => 'close'
                        ], [
                            'id' => $_POST['vox']['id']
                        ]);

                        return !empty($query) ? 'Vox completado correctamente' : 'Error de operación';
                    }
                    else
                        return '$account: Esta cuenta no tiene los permisos necesarios';
                }
                else
                    return $errors;
            }
        }
        else
            return '$action: No deje esta variable vacía (Valores disponibles: create, complete)';
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
