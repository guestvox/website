<?php

defined('_EXEC') or die;

require 'plugins/php_qr_code/qrlib.php';

class Menu_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_menu_products()
	{
		$join = [
			'[>]icons' => [
				'icon' => 'id'
			],
			'[>]menu_restaurants' => [
				'restaurant' => 'id'
			]
		];

		$fields = [
			'menu_products.id',
			'menu_products.name',
			'menu_products.description',
			'menu_products.price',
			'menu_products.outstanding',
			'menu_products.avatar',
			'menu_products.image',
			'icons.type(icon_type)',
			'icons.url(icon_url)',
			'menu_restaurants.name(restaurant)',
			'menu_products.status'
		];

		$query1 = Functions::get_json_decoded_query($this->database->select('menu_products', $join, $fields, [
			'AND' => [
				'menu_products.account' => Session::get_value('account')['id'],
				'menu_products.outstanding[>=]' => 1
			],
			'ORDER' => [
				'menu_products.outstanding' => 'ASC'
			]
		]));

		$query2 = Functions::get_json_decoded_query($this->database->select('menu_products', $join, $fields, [
			'AND' => [
				'menu_products.account' => Session::get_value('account')['id'],
				'menu_products.outstanding[=]' => null
			],
			'ORDER' => [
				'menu_products.name' => 'ASC'
			]
		]));

		return array_merge($query1, $query2);
	}

    public function get_menu_product($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_products', [
			'name',
			'description',
			'topics',
			'price',
			'outstanding',
			'avatar',
			'image',
			'icon',
			'categories',
			'restaurant'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_menu_products_outstandings()
	{
		$query = $this->database->select('menu_products', [
			'outstanding'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'outstanding[>=]' => 1
			],
			'ORDER' => [
				'outstanding' => 'DESC'
			]
		]);

		return !empty($query) ? ($query[0]['outstanding'] + 1) : '1';
	}

	public function get_icons($type)
	{
		$icons = [];

		$query = Functions::get_json_decoded_query($this->database->select('icons', [
			'id',
			'name',
			'url',
			'type'
		], [
			$type => true,
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		foreach ($query as $value)
		{
			if (array_key_exists($value['type'], $icons))
				array_push($icons[$value['type']], $value);
			else
				$icons[$value['type']] = [$value];
		}

		return $icons;
	}

	public function new_menu_product($data)
	{
		$query = $this->database->insert('menu_products', [
			'account' => Session::get_value('account')['id'],
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'description' => json_encode([
				'es' => !empty($data['description_es']) ? $data['description_es'] : '',
				'en' => !empty($data['description_en']) ? $data['description_en'] : ''
			]),
			'topics' => json_encode((!empty($data['topics']) ? $data['topics'] : [])),
			'price' => $data['price'],
			'outstanding' => !empty($data['outstanding']) ? $data['outstanding'] : null,
			'avatar' => $data['avatar'],
			'image' => ($data['avatar'] == 'image') ? Functions::uploader($data['image'], Session::get_value('account')['path'] . '_menu_product_avatar_') : null,
			'icon' => ($data['avatar'] == 'icon') ? $data['icon'] : null,
			'categories' => json_encode((!empty($data['categories']) ? $data['categories'] : [])),
			'restaurant' => (Session::get_value('account')['settings']['menu']['multi'] == true) ? (!empty($data['restaurant']) ? $data['restaurant'] : null) : null,
			'status' => true
		]);

		if (!empty($query) AND !empty($data['outstanding']))
		{
			$outstandings = $this->database->select('menu_products', [
				'id',
				'outstanding'
			], [
				'AND' => [
					'id[!]' => $this->database->id(),
					'account' => Session::get_value('account')['id'],
					'outstanding[>=]' => $data['outstanding']
				]
			]);

			foreach ($outstandings as $value)
			{
				$this->database->update('menu_products', [
					'outstanding' => ($value['outstanding'] + 1)
				], [
					'id' => $value['id']
				]);
			}
		}

		return $query;
	}

	public function edit_menu_product($data)
	{
		$query = null;

		$edited = $this->database->select('menu_products', [
			'image'
		], [
			'id' => $data['id']
		]);

		if (!empty($edited))
		{
			$query = $this->database->update('menu_products', [
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en']
				]),
				'description' => json_encode([
					'es' => !empty($data['description_es']) ? $data['description_es'] : '',
					'en' => !empty($data['description_en']) ? $data['description_en'] : ''
				]),
				'topics' => json_encode((!empty($data['topics']) ? $data['topics'] : [])),
				'price' => $data['price'],
				'outstanding' => !empty($data['outstanding']) ? $data['outstanding'] : null,
				'avatar' => $data['avatar'],
				'image' => ($data['avatar'] == 'image' AND !empty($data['image']['name'])) ? Functions::uploader($data['image'], Session::get_value('account')['path'] . '_menu_product_avatar_') : $edited[0]['image'],
				'icon' => ($data['avatar'] == 'icon') ? $data['icon'] : null,
				'categories' => json_encode((!empty($data['categories']) ? $data['categories'] : [])),
				'restaurant' => (Session::get_value('account')['settings']['menu']['multi'] == true) ? (!empty($data['restaurant']) ? $data['restaurant'] : null) : null
			], [
				'id' => $data['id']
			]);

			if (!empty($query))
			{
				if (!empty($data['outstanding']))
				{
					$outstandings = $this->database->select('menu_products', [
						'id',
						'outstanding'
					], [
						'AND' => [
							'id[!]' => $data['id'],
							'account' => Session::get_value('account')['id'],
							'outstanding[>=]' => $data['outstanding']
						]
					]);

					foreach ($outstandings as $value)
					{
						$this->database->update('menu_products', [
							'outstanding' => ($value['outstanding'] + 1)
						], [
							'id' => $value['id']
						]);
					}
				}

				if (!empty($data['image']['name']) AND !empty($edited[0]['image']))
					Functions::undoloader($edited[0]['image']);
			}
		}

		return $query;
	}

	public function deactivate_menu_product($id)
	{
		$query = $this->database->update('menu_products', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_menu_product($id)
	{
		$query = $this->database->update('menu_products', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_menu_product($id)
	{
		$query = null;

		$deleted = $this->database->select('menu_products', [
			'image'
		], [
			'id' => $id
		]);

		if (!empty($deleted))
		{
			$query = $this->database->delete('menu_products', [
				'id' => $id
			]);

			if (!empty($query) AND !empty($deleted[0]['image']))
				Functions::undoloader($deleted[0]['image']);
		}

		return $query;
	}

	public function get_menu_restaurants($option = 'all')
	{
		$where = [];

		if ($option == 'all')
			$where['account'] = Session::get_value('account')['id'];
		else if ($option == 'actives')
		{
			$where['AND'] = [
				'account' => Session::get_value('account')['id'],
				'status' => true
			];
		}

		$where['ORDER'] = [
			'name' => 'ASC'
		];

		$query = Functions::get_json_decoded_query($this->database->select('menu_restaurants', [
			'id',
			'token',
			'name',
			'qr',
			'status'
		], $where));

		return $query;
	}

	public function get_menu_restaurant($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_restaurants', [
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_menu_restaurant($data)
	{
		$data['token'] = strtolower(Functions::get_random(8));
		$data['qr']['filename'] = Session::get_value('account')['path'] . '_menu_restaurant_qr_' . $data['token'] . '.png';
		$data['qr']['content'] = 'https://' . Configuration::$domain . '/' . Session::get_value('account')['path'] . '/myvox/menu/' . $data['token'];
		$data['qr']['dir'] = PATH_UPLOADS . $data['qr']['filename'];
		$data['qr']['level'] = 'H';
		$data['qr']['size'] = 5;
		$data['qr']['frame'] = 3;

		$query = $this->database->insert('menu_restaurants', [
			'account' => Session::get_value('account')['id'],
			'token' => $data['token'],
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'qr' => $data['qr']['filename'],
			'status' => true
		]);

		QRcode::png($data['qr']['content'], $data['qr']['dir'], $data['qr']['level'], $data['qr']['size'], $data['qr']['frame']);

		return $query;
	}

	public function edit_menu_restaurant($data)
	{
		$query = $this->database->update('menu_restaurants', [
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			])
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function deactivate_menu_restaurant($id)
	{
		$query = $this->database->update('menu_restaurants', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_menu_restaurant($id)
	{
		$query = $this->database->update('menu_restaurants', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_menu_restaurant($id)
	{
		$query = null;

		$deleted = $this->database->select('menu_restaurants', [
			'qr'
		], [
			'id' => $id
		]);

		if (!empty($deleted))
		{
			$query = $this->database->delete('menu_restaurants', [
				'id' => $id
			]);

			if (!empty($query))
				Functions::undoloader($deleted[0]['qr']);
		}

		return $query;
	}

	public function get_menu_categories($option = 'all')
	{
		$where = [];

		if ($option == 'all')
			$where['menu_categories.account'] = Session::get_value('account')['id'];
		else if ($option == 'actives')
		{
			$where['AND'] = [
				'menu_categories.account' => Session::get_value('account')['id'],
				'menu_categories.status' => true
			];
		}

		$where['ORDER'] = [
			'menu_categories.name' => 'ASC'
		];

		$query = Functions::get_json_decoded_query($this->database->select('menu_categories', [
			'[>]icons' => [
				'icon' => 'id'
			]
		], [
			'menu_categories.id',
			'menu_categories.name',
			'icons.url(icon_url)',
			'icons.type(icon_type)',
			'menu_categories.status'
		], $where));

		return $query;
	}

	public function get_menu_category($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_categories', [
			'name',
			'icon'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_menu_category($data)
	{
		$query = $this->database->insert('menu_categories', [
			'account' => Session::get_value('account')['id'],
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'icon' => $data['icon'],
			'status' => true
		]);

		return $query;
	}

	public function edit_menu_category($data)
	{
		$query = $this->database->update('menu_categories', [
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'icon' => $data['icon']
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function deactivate_menu_category($id)
	{
		$query = $this->database->update('menu_categories', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_menu_category($id)
	{
		$query = $this->database->update('menu_categories', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_menu_category($id)
	{
		$query = $this->database->delete('menu_categories', [
			'id' => $id
		]);

		return $query;
	}

	public function get_menu_topics($option = 'all')
	{
		$where = [];

		if ($option == 'all')
			$where['account'] = Session::get_value('account')['id'];
		else if ($option == 'actives')
		{
			$where['AND'] = [
				'account' => Session::get_value('account')['id'],
				'status' => true
			];
		}

		$where['ORDER'] = [
			'name' => 'ASC'
		];

		$query = Functions::get_json_decoded_query($this->database->select('menu_topics', [
			'id',
			'name',
			'status'
		], $where));

		return $query;
	}

	public function get_menu_topic($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_topics', [
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_menu_topic($data)
	{
		$query = $this->database->insert('menu_topics', [
			'account' => Session::get_value('account')['id'],
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'status' => true
		]);

		return $query;
	}

	public function edit_menu_topic($data)
	{
		$query = $this->database->update('menu_topics', [
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			])
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function deactivate_menu_topic($id)
	{
		$query = $this->database->update('menu_topics', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_menu_topic($id)
	{
		$query = $this->database->update('menu_topics', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_menu_topic($id)
	{
		$query = $this->database->delete('menu_topics', [
			'id' => $id
		]);

		return $query;
	}
}
