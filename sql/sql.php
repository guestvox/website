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
