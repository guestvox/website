<?php

defined('_EXEC') or die;

class Menu_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_menu_products($id = null)
	{
		if (!empty($id))
		{
			$query = Functions::get_json_decoded_query($this->database->select('menu_products', [
				'id',
				'account',
				'avatar',
				'name',
				'description',
				'price',
				'categories',
				'status'
			], [
				'id' => $id
			]));

			return !empty($query) ? $query[0] : null;
		}
		else
		{
			$query = Functions::get_json_decoded_query($this->database->select('menu_products', [
				'id',
				'account',
				'avatar',
				'name',
				'description',
				'price',
				'categories',
				'status'
			], [
				'account' => Session::get_value('account')['id'],
				'ORDER' => [
					'id' => 'ASC',
				]
			]));

			return $query;
		}
	}

	public function get_menu_owners($id = null)
	{
		if (!empty($id))
		{
			$query = Functions::get_json_decoded_query($this->database->select('menu_owners', [
				'id',
				'account',
				'name',
				'status'
			], [
				'id' => $id
			]));

			return !empty($query) ? $query[0] : null;
		}
		else
		{
			$query = Functions::get_json_decoded_query($this->database->select('menu_owners', [
				'id',
				'account',
				'name',
				'status'
			], [
				'account' => Session::get_value('account')['id'],
				'ORDER' => [
					'id' => 'ASC',
				]
			]));

			return $query;
		}
	}

	public function get_menu_categories()
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_categories', [
			'id',
			'name',
			'type',
			'accounts',
			'status'
		]));

		return $query;
	}

	public function new_menu_product($data)
	{
		$query = $this->database->insert('menu_products', [
			'account' => Session::get_value('account')['id'],
			'avatar' => Functions::uploader($data['avatar']),
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

	public function edit_menu_product($data)
	{
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
				'categories' => json_encode($data['categories']),
				'status' => true
			], [
				'id' => $data['id']
			]);

			if (!empty($query) AND !empty($data['avatar']['name']) AND !empty($edited[0]['avatar']))
                Functions::undoloader($edited[0]['avatar']);
		}

		return $query;
	}

	public function edit_menu_owner($data)
	{
		$query = $this->database->update('menu_owners', [
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'status' => true
		], [
			'id' => $data['id']
		]);

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

	public function deactivate_menu_owner($id)
	{
		$query = $this->database->update('menu_owners', [
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

	public function activate_menu_owner($id)
	{
		$query = $this->database->update('menu_owners', [
			'status' => true
		], [
			'id' => $id
		]);

		return $query;
	}

	public function delete_menu_product($id)
	{
		$query = $this->database->delete('menu_products', [
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
