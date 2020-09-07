<?php

defined('_EXEC') or die;

require 'plugins/php_qr_code/qrlib.php';

class Menu_model extends Model
{
	public function __construct()
	{
		parent::__construct();
	}

    public function get_menu_products($option = 'all')
	{
		$where = [
			'menu_products.account' => Session::get_value('account')['id'],
			'menu_products.position[>=]' => 1
		];

		if ($option == 'actives')
			$where['menu_products.status'] = true;

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
			'icons.color(icon_color)',
			'menu_products.categories',
			'menu_restaurants.name(restaurant)',
			'menu_products.status'
		], [
			'AND' => $where,
			'ORDER' => [
				'menu_products.position' => 'ASC'
			]
		]));

		foreach ($query as $key => $value)
		{
			if ($option == 'actives')
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

			if ($option == 'all')
			{
				foreach ($value['categories'] as $subkey => $subvalue)
				{
					$subvalue = Functions::get_json_decoded_query($this->database->select('menu_categories', [
						'name'
					], [
						'id' => $subvalue,
						'ORDER' => [
							'position' => 'ASC'
						]
					]));

					if (!empty($subvalue))
						$query[$key]['categories'][$subkey] = $subvalue[0];
					else
						unset($query[$key]['categories'][$subkey]);
				}
			}
		}

		return $query;
	}

    public function get_menu_product($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_products', [
			'name',
			'description',
			'topics',
			'price',
			'position',
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

	public function get_menu_product_position()
	{
		$query = $this->database->select('menu_products', [
			'position'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'position[>=]' => 1
			],
			'ORDER' => [
				'position' => 'DESC'
			]
		]);

		return !empty($query) ? ($query[0]['position'] + 1) : '1';
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
			'topics' => json_encode(Session::get_value('temporal')['menu_topics_groups']),
			'price' => $data['price'],
			'position' => $data['position'],
			'avatar' => $data['avatar'],
			'image' => ($data['avatar'] == 'image') ? Functions::uploader($data['image'], Session::get_value('account')['path'] . '_menu_product_avatar_') : null,
			'icon' => ($data['avatar'] == 'icon') ? $data['icon'] : null,
			'categories' => json_encode((!empty($data['categories']) ? $data['categories'] : [])),
			'restaurant' => (Session::get_value('account')['settings']['menu']['multi'] == true) ? (!empty($data['restaurant']) ? $data['restaurant'] : null) : null,
			'status' => true
		]);

		if (!empty($query))
		{
			$positions = $this->database->select('menu_products', [
				'id',
				'position'
			], [
				'AND' => [
					'id[!]' => $this->database->id(),
					'account' => Session::get_value('account')['id'],
					'position[>=]' => $data['position']
				]
			]);

			foreach ($positions as $value)
			{
				$data['position'] = $data['position'] + 1;

				$this->database->update('menu_products', [
					'position' => $data['position']
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
			'position',
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
				'topics' => json_encode(Session::get_value('temporal')['menu_topics_groups']),
				'price' => $data['price'],
				'position' => $data['position'],
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
				if ($data['position'] != $edited[0]['position'])
				{
					$positions = $this->database->select('menu_products', [
						'id',
						'position'
					], [
						'AND' => [
							'id[!]' => $data['id'],
							'account' => Session::get_value('account')['id'],
							'position[>=]' => $data['position']
						]
					]);

					foreach ($positions as $value)
					{
						$data['position'] = $data['position'] + 1;

						$this->database->update('menu_products', [
							'position' => $data['position']
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

	public function up_menu_product($id)
	{
		$positions = $this->database->select('menu_products', [
			'id',
			'position'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'position[>=]' => 1
			],
			'ORDER' => [
				'position' => 'ASC'
			]
		]);

		$current = null;
		$previous = null;

		foreach ($positions as $key => $value)
		{
			if ($id == $value['id'])
			{
				$current = $key;
				$previous = ($key - 1);
			}
		}

		if (isset($current) AND isset($previous) AND array_key_exists($previous, $positions))
		{
			$current_position = $positions[$current]['position'];
			$previous_position = $positions[$previous]['position'];

			$this->database->update('menu_products', [
				'position' => $previous_position
			], [
				'id' => $positions[$current]['id']
			]);

			$this->database->update('menu_products', [
				'position' => $current_position
			], [
				'id' => $positions[$previous]['id']
			]);

			foreach ($positions as $key => $value)
			{
				if ($key > $current)
				{
					$current_position = $current_position + 1;

					$this->database->update('menu_products', [
						'position' => $current_position
					], [
						'id' => $value['id']
					]);
				}
			}
		}

		return true;
	}

	public function down_menu_product($id)
	{
		$positions = $this->database->select('menu_products', [
			'id',
			'position'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'position[>=]' => 1
			],
			'ORDER' => [
				'position' => 'ASC'
			]
		]);

		$current = null;
		$next = null;

		foreach ($positions as $key => $value)
		{
			if ($id == $value['id'])
			{
				$current = $key;
				$next = ($key + 1);
			}
		}

		if (isset($current) AND isset($next) AND array_key_exists($next, $positions))
		{
			$current_position = $positions[$current]['position'];
			$next_position = $positions[$next]['position'];

			$this->database->update('menu_products', [
				'position' => $next_position
			], [
				'id' => $positions[$current]['id']
			]);

			$this->database->update('menu_products', [
				'position' => $current_position
			], [
				'id' => $positions[$next]['id']
			]);

			foreach ($positions as $key => $value)
			{
				if ($key > $next)
				{
					$next_position = $next_position + 1;

					$this->database->update('menu_products', [
						'position' => $next_position
					], [
						'id' => $value['id']
					]);
				}
			}
		}

		return true;
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

	public function get_menu_categories($option = 'all')
	{
		$where = [
			'menu_categories.account' => Session::get_value('account')['id'],
			'menu_categories.position[>=]' => 1
		];

		if ($option == 'actives')
			$where['menu_categories.status'] = true;

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
		], [
			'AND' => $where,
			'ORDER' => [
				'menu_categories.position' => 'ASC'
			]
		]));

		return $query;
	}

	public function get_menu_category($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_categories', [
			'name',
			'position',
			'icon'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_menu_category_position()
	{
		$query = $this->database->select('menu_categories', [
			'position'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'position[>=]' => 1
			],
			'ORDER' => [
				'position' => 'DESC'
			]
		]);

		return !empty($query) ? ($query[0]['position'] + 1) : '1';
	}

	public function new_menu_category($data)
	{
		$query = $this->database->insert('menu_categories', [
			'account' => Session::get_value('account')['id'],
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'position' => $data['position'],
			'icon' => $data['icon'],
			'status' => true
		]);

		if (!empty($query))
		{
			$positions = $this->database->select('menu_categories', [
				'id',
				'position'
			], [
				'AND' => [
					'id[!]' => $this->database->id(),
					'account' => Session::get_value('account')['id'],
					'position[>=]' => $data['position']
				]
			]);

			foreach ($positions as $value)
			{
				$data['position'] = $data['position'] + 1;

				$this->database->update('menu_categories', [
					'position' => $data['position']
				], [
					'id' => $value['id']
				]);
			}
		}

		return $query;
	}

	public function edit_menu_category($data)
	{
		$query = null;

		$edited = $this->database->select('menu_categories', [
			'position'
		], [
			'id' => $data['id']
		]);

		if (!empty($edited))
		{
			$query = $this->database->update('menu_categories', [
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en']
				]),
				'position' => $data['position'],
				'icon' => $data['icon']
			], [
				'id' => $data['id']
			]);

			if (!empty($query))
			{
				if ($data['position'] != $edited[0]['position'])
				{
					$positions = $this->database->select('menu_categories', [
						'id',
						'position'
					], [
						'AND' => [
							'id[!]' => $data['id'],
							'account' => Session::get_value('account')['id'],
							'position[>=]' => $data['position']
						]
					]);

					foreach ($positions as $value)
					{
						$data['position'] = $data['position'] + 1;

						$this->database->update('menu_categories', [
							'position' => $data['position']
						], [
							'id' => $value['id']
						]);
					}
				}
			}
		}

		return $query;
	}

	public function up_menu_category($id)
	{
		$positions = $this->database->select('menu_categories', [
			'id',
			'position'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'position[>=]' => 1
			],
			'ORDER' => [
				'position' => 'ASC'
			]
		]);

		$current = null;
		$previous = null;

		foreach ($positions as $key => $value)
		{
			if ($id == $value['id'])
			{
				$current = $key;
				$previous = ($key - 1);
			}
		}

		if (isset($current) AND isset($previous) AND array_key_exists($previous, $positions))
		{
			$current_position = $positions[$current]['position'];
			$previous_position = $positions[$previous]['position'];

			$this->database->update('menu_categories', [
				'position' => $previous_position
			], [
				'id' => $positions[$current]['id']
			]);

			$this->database->update('menu_categories', [
				'position' => $current_position
			], [
				'id' => $positions[$previous]['id']
			]);

			foreach ($positions as $key => $value)
			{
				if ($key > $current)
				{
					$current_position = $current_position + 1;

					$this->database->update('menu_categories', [
						'position' => $current_position
					], [
						'id' => $value['id']
					]);
				}
			}
		}

		return true;
	}

	public function down_menu_category($id)
	{
		$positions = $this->database->select('menu_categories', [
			'id',
			'position'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'position[>=]' => 1
			],
			'ORDER' => [
				'position' => 'ASC'
			]
		]);

		$current = null;
		$next = null;

		foreach ($positions as $key => $value)
		{
			if ($id == $value['id'])
			{
				$current = $key;
				$next = ($key + 1);
			}
		}

		if (isset($current) AND isset($next) AND array_key_exists($next, $positions))
		{
			$current_position = $positions[$current]['position'];
			$next_position = $positions[$next]['position'];

			$this->database->update('menu_categories', [
				'position' => $next_position
			], [
				'id' => $positions[$current]['id']
			]);

			$this->database->update('menu_categories', [
				'position' => $current_position
			], [
				'id' => $positions[$next]['id']
			]);

			foreach ($positions as $key => $value)
			{
				if ($key > $next)
				{
					$next_position = $next_position + 1;

					$this->database->update('menu_categories', [
						'position' => $next_position
					], [
						'id' => $value['id']
					]);
				}
			}
		}

		return true;
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
		$where = [
			'account' => Session::get_value('account')['id'],
			'position[>=]' => 1
		];

		if ($option == 'actives')
			$where['status'] = true;

		$query = Functions::get_json_decoded_query($this->database->select('menu_topics', [
			'id',
			'name',
			'status'
		], [
			'AND' => $where,
			'ORDER' => [
				'position' => 'ASC'
			]
		]));

		return $query;
	}

	public function get_menu_topic($id)
	{
		$query = Functions::get_json_decoded_query($this->database->select('menu_topics', [
			'name',
			'position'
		], [
			'id' => $id
		]));

		return !empty($query) ? $query[0] : null;
	}

	public function get_menu_topic_position()
	{
		$query = $this->database->select('menu_topics', [
			'position'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'position[>=]' => 1
			],
			'ORDER' => [
				'position' => 'DESC'
			]
		]);

		return !empty($query) ? ($query[0]['position'] + 1) : '1';
	}

	public function new_menu_topic($data)
	{
		$query = $this->database->insert('menu_topics', [
			'account' => Session::get_value('account')['id'],
			'name' => json_encode([
				'es' => $data['name_es'],
				'en' => $data['name_en']
			]),
			'position' => $data['position'],
			'status' => true
		]);

		if (!empty($query))
		{
			$positions = $this->database->select('menu_topics', [
				'id',
				'position'
			], [
				'AND' => [
					'id[!]' => $this->database->id(),
					'account' => Session::get_value('account')['id'],
					'position[>=]' => $data['position']
				]
			]);

			foreach ($positions as $value)
			{
				$data['position'] = $data['position'] + 1;

				$this->database->update('menu_topics', [
					'position' => $data['position']
				], [
					'id' => $value['id']
				]);
			}
		}

		return $query;
	}

	public function edit_menu_topic($data)
	{
		$query = null;

		$edited = $this->database->select('menu_topics', [
			'position'
		], [
			'id' => $data['id']
		]);

		if (!empty($edited))
		{
			$query = $this->database->update('menu_topics', [
				'name' => json_encode([
					'es' => $data['name_es'],
					'en' => $data['name_en']
				]),
				'position' => $data['position']
			], [
				'id' => $data['id']
			]);

			if (!empty($query))
			{
				if ($data['position'] != $edited[0]['position'])
				{
					$positions = $this->database->select('menu_topics', [
						'id',
						'position'
					], [
						'AND' => [
							'id[!]' => $data['id'],
							'account' => Session::get_value('account')['id'],
							'position[>=]' => $data['position']
						]
					]);

					foreach ($positions as $value)
					{
						$data['position'] = $data['position'] + 1;

						$this->database->update('menu_topics', [
							'position' => $data['position']
						], [
							'id' => $value['id']
						]);
					}
				}
			}
		}

		return $query;
	}

	public function up_menu_topic($id)
	{
		$positions = $this->database->select('menu_topics', [
			'id',
			'position'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'position[>=]' => 1
			],
			'ORDER' => [
				'position' => 'ASC'
			]
		]);

		$current = null;
		$previous = null;

		foreach ($positions as $key => $value)
		{
			if ($id == $value['id'])
			{
				$current = $key;
				$previous = ($key - 1);
			}
		}

		if (isset($current) AND isset($previous) AND array_key_exists($previous, $positions))
		{
			$current_position = $positions[$current]['position'];
			$previous_position = $positions[$previous]['position'];

			$this->database->update('menu_topics', [
				'position' => $previous_position
			], [
				'id' => $positions[$current]['id']
			]);

			$this->database->update('menu_topics', [
				'position' => $current_position
			], [
				'id' => $positions[$previous]['id']
			]);

			foreach ($positions as $key => $value)
			{
				if ($key > $current)
				{
					$current_position = $current_position + 1;

					$this->database->update('menu_topics', [
						'position' => $current_position
					], [
						'id' => $value['id']
					]);
				}
			}
		}

		return true;
	}

	public function down_menu_topic($id)
	{
		$positions = $this->database->select('menu_topics', [
			'id',
			'position'
		], [
			'AND' => [
				'account' => Session::get_value('account')['id'],
				'position[>=]' => 1
			],
			'ORDER' => [
				'position' => 'ASC'
			]
		]);

		$current = null;
		$next = null;

		foreach ($positions as $key => $value)
		{
			if ($id == $value['id'])
			{
				$current = $key;
				$next = ($key + 1);
			}
		}

		if (isset($current) AND isset($next) AND array_key_exists($next, $positions))
		{
			$current_position = $positions[$current]['position'];
			$next_position = $positions[$next]['position'];

			$this->database->update('menu_topics', [
				'position' => $next_position
			], [
				'id' => $positions[$current]['id']
			]);

			$this->database->update('menu_topics', [
				'position' => $current_position
			], [
				'id' => $positions[$next]['id']
			]);

			foreach ($positions as $key => $value)
			{
				if ($key > $next)
				{
					$next_position = $next_position + 1;

					$this->database->update('menu_topics', [
						'position' => $next_position
					], [
						'id' => $value['id']
					]);
				}
			}
		}

		return true;
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
