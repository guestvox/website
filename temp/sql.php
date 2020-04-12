<?php

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
