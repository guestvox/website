<?php

require 'plugins/php_qr_code/qrlib.php';

public function sql()
{
    $query = $this->database->select('accounts', [
        'id',
        'token',
        'path',
        'qrs'
    ]);

    foreach ($query as $value)
    {
        $value['menu_delivery_qr']['filename'] = $value['path'] . '_menu_delivery_qr_' . $value['token'] . '.png';
        $value['menu_delivery_qr']['content'] = 'https://' . Configuration::$domain . '/' . $value['path'] . '/myvox/delivery';
        $value['menu_delivery_qr']['dir'] = PATH_UPLOADS . $value['menu_delivery_qr']['filename'];
        $value['menu_delivery_qr']['level'] = 'H';
        $value['menu_delivery_qr']['size'] = 5;
        $value['menu_delivery_qr']['frame'] = 3;

        $value['reviews_qr']['filename'] = $value['path'] . '_reviews_qr_' . $value['token'] . '.png';
        $value['reviews_qr']['content'] = 'https://' . Configuration::$domain . '/' . $value['path'] . '/reviews';
        $value['reviews_qr']['dir'] = PATH_UPLOADS . $value['reviews_qr']['filename'];
        $value['reviews_qr']['level'] = 'H';
        $value['reviews_qr']['size'] = 5;
        $value['reviews_qr']['frame'] = 3;

        $this->database->update('accounts', [
            'qrs' => json_encode([
                'account' => $value['qrs'],
                'menu_delivery' => $value['menu_delivery_qr']['filename'],
                'reviews' => $value['reviews_qr']['filename']
            ])
        ], [
            'id' => $value['id']
        ]);

        QRcode::png($value['menu_delivery_qr']['content'], $value['menu_delivery_qr']['dir'], $value['menu_delivery_qr']['level'], $value['menu_delivery_qr']['size'], $value['menu_delivery_qr']['frame']);
        QRcode::png($value['reviews_qr']['content'], $value['reviews_qr']['dir'], $value['reviews_qr']['level'], $value['reviews_qr']['size'], $value['reviews_qr']['frame']);
    }
}

public function sql()
{
    set_time_limit(600);

    $db = new Medoo([
        'database_type' => 'mysql',
        'database_name' => 'gv_website_old',
        'server' => 'localhost',
        'username' => 'root',
        'password' => ''
    ]);

    // 3126
    // 3477

    $q = $db->select('voxes', '*', [
        'account' => 18
    ]);

    foreach ($q as $v)
    {
        if ($v['id'] >= 3400 AND $v['id'] < 3477)
        {
            $v['data'] = json_decode(Functions::get_openssl('decrypt', $v['data']), true);

            $x['created_user'] = $this->database->select('users', ['id'], [
                'tmp' => $v['data']['created_user'][1]
            ]);

            if (!empty($x['created_user']))
            {
                if (!empty($v['data']['room']))
                {
                    $x['owner'] = $this->database->select('owners', ['id'], [
                        'tmp' => $v['data']['room']
                    ]);
                }

                $x['opportunity_area'] = $this->database->select('opportunity_areas', ['id'], [
                    'tmp' => $v['data']['opportunity_area']
                ]);

                $x['opportunity_type'] = $this->database->select('opportunity_types', ['id'], [
                    'tmp' => $v['data']['opportunity_type']
                ]);

                $x['location'] = $this->database->select('locations', ['id'], [
                    'tmp' => $v['data']['location']
                ]);

                if (!empty($v['data']['assigned_users']))
                {
                    foreach ($v['data']['assigned_users'] as $k => $s)
                    {
                        if (!empty($s))
                        {
                            $s = $this->database->select('users', ['id'], [
                                'tmp' => $s
                            ]);

                            if (!empty($s))
                                $v['data']['assigned_users'][$k] = $s[0]['id'];
                            else
                                unset($v['data']['assigned_users'][$k]);
                        }
                    }

                    $v['data']['assigned_users'] = array_unique($v['data']['assigned_users']);
                    $v['data']['assigned_users'] = array_values($v['data']['assigned_users']);
                }

                if (!empty($v['data']['guest_type']))
                {
                    $x['guest_type'] = $this->database->select('guests_types', ['id'], [
                        'tmp' => $v['data']['guest_type']
                    ]);
                }

                if (!empty($v['data']['reservation_status']))
                {
                    $x['reservation_status'] = $this->database->select('reservations_statuses', ['id'], [
                        'tmp' => $v['data']['reservation_status']
                    ]);
                }

                if (!empty($v['data']['comments']))
                {
                    foreach ($v['data']['comments'] as $k => $s)
                    {
                        $s['user'] = $this->database->select('users', ['id'], [
                            'tmp' => $s['user']
                        ]);

                        if (!empty($s['user']))
                        {
                            $v['data']['comments'][$k] = [
                                'user' => $s['user'][0]['id'],
                                'date' => $s['date'],
                                'hour' => $s['hour'],
                                'cost' => 0,
                                'comment' => $s['message'],
                                'attachments' => !empty($s['attachments']) ? $s['attachments'] : []
                            ];
                        }
                        else
                            unset($v['data']['comments'][$k]);
                    }

                    $v['data']['comments'] = array_values($v['data']['comments']);
                }

                $x['viewed_by'] = [
                    $x['created_user'][0]['id']
                ];

                if (!empty($v['data']['viewed_by']))
                {
                    foreach ($v['data']['viewed_by'] as $k => $s)
                    {
                        if (!empty($s))
                        {
                            $s = $this->database->select('users', ['id'], [
                                'tmp' => $s
                            ]);

                            if (!empty($s))
                            {
                                if (!in_array($s[0]['id'], $x['viewed_by']))
                                    array_push($x['viewed_by'], $s[0]['id']);
                            }
                        }
                    }
                }

                $x['changes_history'] = [
                    [
                        'type' => 'created',
                        'user' => $x['created_user'][0]['id'],
                        'date' => $v['data']['created_date'],
                        'hour' => $v['data']['created_hour']
                    ],
                    [
                        'type' => 'viewed',
                        'user' => $x['created_user'][0]['id'],
                        'date' => $v['data']['created_date'],
                        'hour' => $v['data']['created_hour']
                    ]
                ];

                if (!empty($v['data']['changes_history']))
                {
                    $v['data']['changes_history'] = array_reverse($v['data']['changes_history']);

                    $x['tmp'] = [
                        $x['created_user'][0]['id']
                    ];

                    foreach ($v['data']['changes_history'] as $k => $s)
                    {
                        if ($s['type'] == 'viewed')
                        {
                            $s['user'] = $this->database->select('users', ['id'], [
                                'tmp' => $s['user']
                            ]);

                            if (!empty($s['user']))
                            {
                                if (!in_array($s['user'][0]['id'], $x['tmp']))
                                {
                                    array_push($x['tmp'], $s['user'][0]['id']);

                                    array_push($x['changes_history'], [
                                        'type' => 'viewed',
                                        'user' => $s['user'][0]['id'],
                                        'date' => $s['date'],
                                        'hour' => $s['hour']
                                    ]);
                                }
                            }
                        }
                        else if ($s['type'] == 'new_comment')
                        {
                            $s['user'] = $this->database->select('users', ['id'], [
                                'tmp' => $s['user']
                            ]);

                            if (!empty($s['user']))
                            {
                                array_push($x['changes_history'], [
                                    'type' => 'commented',
                                    'user' => $s['user'][0]['id'],
                                    'date' => $s['date'],
                                    'hour' => $s['hour']
                                ]);
                            }
                        }
                        else if ($s['type'] == 'complete')
                        {
                            $s['user'] = $this->database->select('users', ['id'], [
                                'tmp' => $s['user'][1]
                            ]);

                            if (!empty($s['user']))
                            {
                                array_push($x['changes_history'], [
                                    'type' => 'completed',
                                    'user' => $s['user'][0]['id'],
                                    'date' => $s['date'],
                                    'hour' => $s['hour']
                                ]);
                            }
                        }
                        else if ($s['type'] == 'reopen')
                        {
                            $s['user'] = $this->database->select('users', ['id'], [
                                'tmp' => $s['user'][1]
                            ]);

                            if (!empty($s['user']))
                            {
                                array_push($x['changes_history'], [
                                    'type' => 'reopened',
                                    'user' => $s['user'][0]['id'],
                                    'date' => $s['date'],
                                    'hour' => $s['hour']
                                ]);
                            }
                        }
                    }
                }

                $a = [];

                foreach ($x['changes_history'] as $k => $s)
                    $a[$k] = Functions::get_formatted_date_hour($s['date'], $s['hour']);

                array_multisort($a, SORT_ASC, $x['changes_history']);

                if (!empty($v['data']['completed_user']))
                {
                    $x['completed_user'] = $this->database->select('users', ['id'], [
                        'tmp' => $v['data']['completed_user'][1]
                    ]);
                }

                if (!empty($v['data']['reopened_user']))
                {
                    $x['reopened_user'] = $this->database->select('users', ['id'], [
                        'tmp' => $v['data']['reopened_user'][1]
                    ]);
                }

                $z = [
                    'account' => 9,
                    'type' => $v['type'],
                    'token' => strtolower($v['data']['token']),
                    'owner' => !empty($v['data']['room']) ? $x['owner'][0]['id'] : null,
                    'opportunity_area' => $x['opportunity_area'][0]['id'],
                    'opportunity_type' => $x['opportunity_type'][0]['id'],
                    'started_date' => $v['data']['started_date'],
                    'started_hour' => $v['data']['started_hour'],
                    'location' => $x['location'][0]['id'],
                    'address' => null,
                    'cost' => !empty($v['data']['cost']) ? $v['data']['cost'] : null,
                    'urgency' => $v['data']['urgency'],
                    'confidentiality' => !empty($v['data']['confidentiality']) ? true : false,
                    'assigned_users' => json_encode((!empty($v['data']['assigned_users']) ? $v['data']['assigned_users'] : [])),
                    'observations' => !empty($v['data']['observations']) ? $v['data']['observations'] : null,
                    'subject' => !empty($v['data']['subject']) ? $v['data']['subject'] : null,
                    'description' => !empty($v['data']['description']) ? $v['data']['description'] : null,
                    'action_taken' => !empty($v['data']['action_taken']) ? $v['data']['action_taken'] : null,
                    'guest_treatment' => null,
                    'firstname' => !empty($v['data']['firstname']) ? $v['data']['firstname'] : null,
                    'lastname' => !empty($v['data']['lastname']) ? $v['data']['lastname'] : null,
                    'email' => null,
                    'phone' => json_encode([
                        'lada' => '',
                        'number' => ''
                    ]),
                    'guest_id' => !empty($v['data']['guest_id']) ? $v['data']['guest_id'] : null,
                    'guest_type' => !empty($v['data']['guest_type']) ? $x['guest_type'][0]['id'] :  null,
                    'reservation_number' => !empty($v['data']['reservation_number']) ? $v['data']['reservation_number'] : null,
                    'reservation_status' => !empty($v['data']['reservation_status']) ? $x['reservation_status'][0]['id'] : null,
                    'check_in' => !empty($v['data']['check_in']) ? $v['data']['check_in'] : null,
                    'check_out' => !empty($v['data']['check_out']) ? $v['data']['check_out'] : null,
                    'attachments' => json_encode((!empty($v['data']['attachments']) ? $v['data']['attachments'] : [])),
                    'viewed_by' => json_encode($x['viewed_by']),
                    'comments' => json_encode((!empty($v['data']['comments']) ? $v['data']['comments'] : [])),
                    'changes_history' => json_encode($x['changes_history']),
                    'created_user' => $x['created_user'][0]['id'],
                    'created_date' => $v['data']['created_date'],
                    'created_hour' => $v['data']['created_hour'],
                    'edited_user' => null,
                    'edited_date' => null,
                    'edited_hour' => null,
                    'completed_user' => !empty($v['data']['completed_user']) ? (!empty($x['completed_user']) ? $x['completed_user'][0]['id'] : null) : null,
                    'completed_date' => !empty($v['data']['completed_date']) ? (!empty($x['completed_user']) ? $v['data']['completed_date'] : null) : null,
                    'completed_hour' => !empty($v['data']['completed_hour']) ? (!empty($x['completed_user']) ? $v['data']['completed_hour'] : null) : null,
                    'reopened_user' => !empty($v['data']['reopened_user']) ? (!empty($x['reopened_user']) ? $x['reopened_user'][0]['id'] : null) : null,
                    'reopened_date' => !empty($v['data']['reopened_date']) ? (!empty($x['reopened_user']) ? $v['data']['reopened_date'] : null) : null,
                    'reopened_hour' => !empty($v['data']['reopened_hour']) ? (!empty($x['reopened_user']) ? $v['data']['reopened_hour'] : null) : null,
                    'menu_order' => null,
                    'status' => (!empty($x['completed_user']) AND $v['data']['status'] == 'close') ? false : true,
                    'origin' => 'internal'
                ];

                print_r($z);

                // $this->database->insert('voxes', $z);
            }
        }
    }
}

public function sql()
{
    // set_time_limit(300);
    //
    // $query = $this->database->select('voxes', [
    // 	'id',
    // 	'data',
    // ], [
    // 	'account' => 3,
    // 	'ORDER' => [
    // 		'id' => 'DESC'
    // 	]
    // ]);
    //
    // foreach ($query as $key => $value)
    // {
    // 	$value['data'] = json_decode(Functions::get_openssl('decrypt', $value['data']), true);
    //
    // 	// if (!isset($value['data']['assigned_users']) OR empty($value['data']['assigned_users']))
    // 	// 	$value['data']['assigned_users'] = [];
    // 	//
    // 	// if (!isset($value['data']['attachments']) OR empty($value['data']['attachments']))
    // 	// 	$value['data']['attachments'] = [];
    // 	//
    // 	// if (!isset($value['data']['viewed_by']) OR empty($value['data']['viewed_by']))
    // 	// 	$value['data']['viewed_by'] = [];
    // 	//
    // 	// if (!isset($value['data']['comments']) OR empty($value['data']['comments']))
    // 	// 	$value['data']['comments'] = [];
    // 	// else
    // 	// {
    // 	// 	foreach ($value['data']['comments'] as $key => $subvalue)
    // 	// 	{
    // 	// 		if (!empty($subvalue['message']))
    // 	// 		{
    // 	// 			if (!isset($subvalue['attachments']) OR empty($subvalue['attachments']))
    // 	// 				$value['data']['comments'][$key]['attachments'] = [];
    // 	// 		}
    // 	// 		else
    // 	// 			unset($value['data']['comments'][$key]);
    // 	// 	}
    // 	//
    // 	// 	array_merge($value['data']['comments']);
    // 	// }
    // 	//
    // 	// if (!isset($value['data']['changes_history']) OR empty($value['data']['changes_history']))
    // 	// 	$value['data']['changes_history'] = [];
    //
    // 	print_r($value);
    //
    // 	// $this->database->update('voxes', [
    // 	// 	'data' => Functions::get_openssl('encrypt', json_encode($value['data']))
    // 	// ], [
    // 	// 	'id' => $value['id']
    // 	// ]);
    // }
}

public function sql()
{
    // set_time_limit(300);
    //
    // $query = $this->database->select('voxes', [
    // 	'id',
    // 	'data',
    // ], [
    // 	'account' => 6
    // ]);
    //
    // foreach ($query as $key => $value)
    // {
    // 	$value['data'] = json_decode(Functions::get_openssl('decrypt', $value['data']), true);
    //
    // 	// print_r($value);
    //
    // 	if (!empty($value['data']['assigned_users']))
    // 	{
    // 		foreach ($value['data']['assigned_users'] as $key => $subvalue)
    // 		{
    // 			if (!isset($subvalue) OR empty($subvalue))
    // 				unset($value['data']['assigned_users'][$key]);
    // 		}
    //
    // 		$value['data']['assigned_users'] = array_merge($value['data']['assigned_users']);
    // 	}
    //
    // 	if (!empty($value['data']['viewed_by']))
    // 	{
    // 		foreach ($value['data']['viewed_by'] as $key => $subvalue)
    // 		{
    // 			if (!isset($subvalue) OR empty($subvalue))
    // 				unset($value['data']['viewed_by'][$key]);
    // 		}
    //
    // 		$value['data']['viewed_by'] = array_merge($value['data']['viewed_by']);
    // 	}
    //
    // 	if (!empty($value['data']['changes_history']))
    // 	{
    // 		foreach ($value['data']['changes_history'] as $key => $subvalue)
    // 		{
    // 			if (!isset($subvalue['user']) OR empty($subvalue['user']))
    // 				unset($value['data']['changes_history'][$key]);
    // 		}
    //
    // 		$value['data']['changes_history'] = array_merge($value['data']['changes_history']);
    // 	}
    //
    // 	// print_r($value);
    //
    // 	$this->database->update('voxes', [
    // 		'data' => Functions::get_openssl('encrypt', json_encode($value['data']))
    // 	], [
    // 		'id' => $value['id']
    // 	]);
    // }
}

// Creación de QR

public function sql()
{
    // $query = Functions::get_json_decoded_query($this->database->select('accounts', '*'));
    //
    // foreach ($query as $value)
    // {
    // 	$data['qr']['filename'] = 'qr_' . $value['path'] . '_' . $value['token'] . '.png';
    // 	$data['qr']['content'] = 'https://' . Configuration::$domain . '/' . $value['path'] . '/myvox';
    // 	$data['qr']['dir'] = PATH_UPLOADS . $data['qr']['filename'];
    // 	$data['qr']['level'] = 'H';
    // 	$data['qr']['size'] = 5;
    // 	$data['qr']['frame'] = 3;
    // 	QRcode::png($data['qr']['content'], $data['qr']['dir'], $data['qr']['level'], $data['qr']['size'], $data['qr']['frame']);
    // }

    // $query = Functions::get_json_decoded_query($this->database->select('rooms', [
    // 	'[>]accounts' => [
    // 		'account' => 'id'
    // 	]
    // ], [
    // 	'rooms.token',
    // 	'accounts.path'
    // ]));
    //
    // foreach ($query as $value)
    // {
    // 	$data['qr']['filename'] = 'qr_' . $value['path'] . '_room_' . $value['token'] . '.png';
    // 	$data['qr']['content'] = 'https://' . Configuration::$domain . '/' . $value['path'] . '/myvox/room/' . $value['token'];
    // 	$data['qr']['dir'] = PATH_UPLOADS . $data['qr']['filename'];
    // 	$data['qr']['level'] = 'H';
    // 	$data['qr']['size'] = 5;
    // 	$data['qr']['frame'] = 3;
    // 	QRcode::png($data['qr']['content'], $data['qr']['dir'], $data['qr']['level'], $data['qr']['size'], $data['qr']['frame']);
    // }

    // $query = Functions::get_json_decoded_query($this->database->select('tables', [
    // 	'[>]accounts' => [
    // 		'account' => 'id'
    // 	]
    // ], [
    // 	'tables.token',
    // 	'accounts.path'
    // ]));
    //
    // foreach ($query as $value)
    // {
    // 	$data['qr']['filename'] = 'qr_' . $value['path'] . '_table_' . $value['token'] . '.png';
    // 	$data['qr']['content'] = 'https://' . Configuration::$domain . '/' . $value['path'] . '/myvox/table/' . $value['token'];
    // 	$data['qr']['dir'] = PATH_UPLOADS . $data['qr']['filename'];
    // 	$data['qr']['level'] = 'H';
    // 	$data['qr']['size'] = 5;
    // 	$data['qr']['frame'] = 3;
    // 	QRcode::png($data['qr']['content'], $data['qr']['dir'], $data['qr']['level'], $data['qr']['size'], $data['qr']['frame']);
    // }
}

// public function sql()
// {
// 	$this->database->update('accounts', [
// 		'settings' => json_encode([
// 			'myvox' => [
// 				'request' => false,
// 				'incident' => false,
// 				'survey' => false,
// 				'survey_title' => [
// 					'es' => '',
// 					'en' => ''
// 				],
// 				'survey_widget' => ''
// 			],
// 			'review' => [
// 				'online' => false,
// 				'email' => '',
// 				'phone' => [
// 					'lada' => '',
// 					'number' => ''
// 				],
// 				'description' => [
// 					'es' => '',
// 					'en' => ''
// 				],
// 				'seo' => [
// 					'keywords' => [
// 						'es' => '',
// 						'en' => ''
// 					],
// 					'meta_description' => [
// 						'es' => '',
// 						'en' => ''
// 					]
// 				],
// 				'social_media' => [
// 					'facebook' => '',
// 					'instagram' => '',
// 					'twitter' => '',
// 					'linkedin' => '',
// 					'youtube' => '',
// 					'google' => '',
// 					'tripadvisor' => ''
// 				]
// 			]
// 		])
// 	]);
// }

$query = Functions::get_json_decoded_query($this->database->select('accounts', [
    'id',
    'settings'
]));

foreach ($query as $value)
{
    $value['settings']['myvox']['menu']['payment'] = [
        'status' => false,
        'mit' => '',
        'types' => '',
        'contract' => [
            'status' => 'deactivated',
            'place' => '',
            'date' => '',
            'signature' => '',
            'titular' => [
                'fiscal' => [
                    'person' => '',
                    'id' => '',
                    'name' => '',
                    'activity' => ''
                ],
                'address' => [
                    'street' => '',
                    'external_number' => '',
                    'internal_number' => '',
                    'cp' => '',
                    'colony' => '',
                    'delegation' => '',
                    'city' => '',
                    'state' => '',
                    'country' => ''
                ],
                'bank' => [
                    'name' => '',
                    'branch' => '',
                    'checkbook' => '',
                    'clabe' => ''
                ],
                'personal_references' => [
                    'first' => [
                        'name' => '',
                        'email' => '',
                        'phone' => [
                            'country' => '',
                            'number' => ''
                        ]
                    ],
                    'second' => [
                        'name' => '',
                        'email' => '',
                        'phone' => [
                            'country' => '',
                            'number' => ''
                        ]
                    ],
                    'third' => [
                        'name' => '',
                        'email' => '',
                        'phone' => [
                            'country' => '',
                            'number' => ''
                        ]
                    ],
                    'fourth' => [
                        'name' => '',
                        'email' => '',
                        'phone' => [
                            'country' => '',
                            'number' => ''
                        ]
                    ]
                ],
                'email' => '',
                'phone' => [
                    'country' => '',
                    'number' => ''
                ],
                'tpv' => ''
            ],
            'company' => [
                'writing_number' => '',
                'writing_date' => '',
                'public_record_folio' => '',
                'public_record_date' => '',
                'notary_name' => '',
                'notary_number' => '',
                'city' => '',
                'legal_representative' => [
                    'name' => '',
                    'writing_number' => '',
                    'writing_date' => '',
                    'notary_name' => '',
                    'notary_number' => '',
                    'city' => '',
                    'card' => [
                        'type' => '',
                        'number' => '',
                        'expedition_date' => '',
                        'validity' => ''
                    ]
                ]
            ]
        ]
    ];

    $this->database->update('accounts', [
        'settings' => json_encode($value['settings'])
    ], [
        'id' => $value['id']
    ]);
}
