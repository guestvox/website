<?php

defined('_EXEC') or die;

class Hi_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

	public function get_menu_categories()
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_categories', [
			'[>]icons' => [
				'icon' => 'id'
			]
		], [
			'menu_categories.name',
			'icons.url(icon_url)',
			'icons.type(icon_type)'
		], [
			'AND' => [
				'menu_categories.account' => 2,
				'menu_categories.position[>=]' => 1,
				'menu_categories.status' => true
			],
			'ORDER' => [
				'menu_categories.position' => 'ASC'
			]
		]));

		return $query;
	}

	public function get_menu_products()
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_products', [
			'[>]icons' => [
				'icon' => 'id'
			],
			'[>]menu_restaurants' => [
				'restaurant' => 'id'
			]
		], [
			'menu_products.id',
			'menu_products.name',
			'menu_products.description',
			'menu_products.topics',
			'menu_products.price',
			'menu_products.avatar',
			'menu_products.image',
			'icons.url(icon_url)',
			'icons.type(icon_type)',
			'icons.color(icon_color)'
		], [
			'AND' => [
				'menu_products.account' => 2,
				'menu_products.position[>=]' => 1,
				'menu_products.status' => true
			],
			'ORDER' => [
				'menu_products.position' => 'ASC'
			]
		]));

		foreach ($query as $key => $value)
		{
			foreach ($value['topics'] as $subkey => $subvalue)
			{
				foreach ($subvalue as $parentkey => $parentvalue)
				{
					$parentvalue['topic'] = Functions::get_json_decoded_query($this->database->select('menu_topics', [
						'name'
					], [
						'id' => $parentvalue['id']
					]));

					if (!empty($parentvalue['topic']))
						$query[$key]['topics'][$subkey][$parentkey]['name'] = $parentvalue['topic'][0]['name'];
					else
						unset($query[$key]['topics'][$subkey][$parentkey]);
				}

				if (empty($query[$key]['topics'][$subkey]))
					unset($query[$key]['topics'][$subkey]);
			}
		}

		return $query;
	}

	public function get_webinar()
	{
		$query = $this->database->select('webinars', [
			'id',
			'image',
			'link',
			'date',
			'hour'
		], [
			'status' => true
		]);

		return !empty($query) ? $query[0] : null;
	}

	public function new_webinar_signup($data)
	{
		$query = $this->database->insert('webinars_records', [
			'webinar' => $data['webinar'],
			'name' => $data['name'],
			'email' => $data['email'],
			'business' => $data['business'],
			'job' => $data['job'],
			'date' => Functions::get_current_date(),
			'hour' => Functions::get_current_hour()
		]);

		return $query;
	}
}
