<?php

defined('_EXEC') or die;

require 'plugins/php_qr_code/qrlib.php';

class Menu_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_menu_orders()
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_orders', [
			'[>]owners' => [
				'owner' => 'id'
			],
			'[>]locations' => [
				'location' => 'id'
			],
		], [
			'menu_orders.token',
			'owners.name(owner_name)',
			'owners.number(owner_number)',
			'locations.name(location)',
			'menu_orders.address',
			'menu_orders.date',
			'menu_orders.hour',
			'menu_orders.total',
			'menu_orders.currency',
			'menu_orders.shopping_cart'
		], [
			'menu_orders.account' => Session::get_value('account')['id'],
			'ORDER' => [
				'menu_orders.date' => 'DESC',
				'menu_orders.hour' => 'DESC'
			]
		]));

		return $query;
	}

    public function get_menu_products()
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_products', [
			'[>]menu_restaurants' => [
				'restaurant' => 'id'
			]
		], [
			'menu_products.id',
			'menu_products.name',
			'menu_products.description',
			'menu_products.price',
			'menu_products.avatar',
			'menu_restaurants.name(restaurant)',
			'menu_products.status'
		], [
			'menu_products.account' => Session::get_value('account')['id'],
			'ORDER' => [
				'menu_products.name' => 'ASC'
			]
		]));

		return $query;
	}

    public function get_menu_product($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_products', [
			'name',
			'description',
			'price',
			'avatar',
			'categories',
			'restaurant'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_menu_categories()
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_categories', [
			'id',
			'name',
			'type',
			'accounts'
		], [
			'status' => true,
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		foreach ($query as $key => $value)
		{
			if ($value['type'] == 'close')
			{
				if (!in_array(Session::get_value('account')['id'], $value['accounts']))
					unset($query[$key]);
			}
		}

		return $query;
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
				'es' => $data['description_es'],
				'en' => $data['description_en']
			]),
			'price' => $data['price'],
			'avatar' => Functions::uploader($data['avatar'], Session::get_value('account')['path'] . '_menu_product_avatar_'),
			'categories' => json_encode($data['categories']),
			'restaurant' => (Session::get_value('account')['settings']['menu']['multi'] == true) ? $data['restaurant'] : null,
			'status' => true
		]);

		return $query;
	}

	public function edit_menu_product($data)
	{
		$query = null;

		$edited = $this->database->select('menu_products', [
			'avatar'
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
					'es' => $data['description_es'],
					'en' => $data['description_en']
				]),
				'price' => $data['price'],
				'avatar' => !empty($data['avatar']['name']) ? Functions::uploader($data['avatar']) : $edited[0]['avatar'],
				'categories' => json_encode($data['categories']),
				'restaurant' => (Session::get_value('account')['settings']['menu']['multi'] == true) ? $data['restaurant'] : null
			], [
				'id' => $data['id']
			]);

			if (!empty($query))
			{
				if (!empty($data['avatar']['name']) AND !empty($edited[0]['avatar']))
					Functions::undoloader($edited[0]['avatar']);
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
			'avatar'
		], [
			'id' => $id
		]);

		if (!empty($deleted))
		{
			$query = $this->database->delete('menu_products', [
				'id' => $id
			]);

			if (!empty($query))
				Functions::undoloader($deleted[0]['avatar']);
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
}
