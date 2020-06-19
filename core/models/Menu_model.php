<?php

defined('_EXEC') or die;

class Menu_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_menu_products()
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_products', [
			'id',
			'avatar',
			'name',
			'description',
			'price',
			'status'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

    public function get_menu_product($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_products', [
			'avatar',
			'name',
			'description',
			'price',
			'categories'
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
			'status' => true
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

	public function get_menu_settings()
	{
		$query = Functions::get_json_decoded_query($this->database->select('accounts', [
			'settings'
		], [
			'id' => Session::get_value('account')['id']
		]));

		return !empty($query) ? $query[0]['settings']['myvox']['menu'] : null;
	}

	public function new_menu_product($data)
	{
		$query = $this->database->insert('menu_products', [
			'account' => Session::get_value('account')['id'],
			'avatar' => Functions::uploader($data['avatar'], Session::get_value('account')['path'] . '_menu_product_'),
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'description' => json_encode([
				'es' => $data['description_es'],
				'en' => $data['description_en']
			]),
			'price' => $data['price'],
			'categories' => json_encode($data['categories']),
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
				'avatar' => !empty($data['avatar']['name']) ? Functions::uploader($data['avatar']) : $edited[0]['avatar'],
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en']
				]),
				'description' => json_encode([
					'es' => $data['description_es'],
					'en' => $data['description_en']
				]),
				'price' => $data['price'],
				'categories' => json_encode($data['categories'])
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

	public function get_menu_owners()
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_owners', [
			'id',
			'name',
			'status'
		], [
			'account' => Session::get_value('account')['id'],
			'ORDER' => [
				'name' => 'ASC'
			]
		]));

		return $query;
	}

	public function get_menu_owner($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_owners', [
			'name'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function new_menu_owner($data)
	{
		$query = $this->database->insert('menu_owners', [
			'account' => Session::get_value('account')['id'],
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'status' => true
		]);

		return $query;
	}

	public function edit_menu_owner($data)
	{
		$query = $this->database->update('menu_owners', [
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			])
		], [
			'id' => $data['id']
		]);

		return $query;
	}

	public function deactivate_menu_owner($id)
	{
		$query = $this->database->update('menu_owners', [
			'status' => false
		], [
			'id' => $id
		]);

		return $query;
	}

	public function activate_menu_owner($id)
	{
		$query = $this->database->update('menu_owners', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_menu_owner($id)
	{
		$query = $this->database->delete('menu_owners', [
			'id' => $id
		]);

		return $query;
	}
}
