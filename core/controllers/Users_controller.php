<?php

defined('_EXEC') or die;

class Users_controller extends Controller
{
	private $lang;

	public function __construct()
	{
		parent::__construct();

		$this->lang = Session::get_value('account')['language'];
	}

	public function index()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_user' OR $_POST['action'] == 'get_user_level')
			{
				if ($_POST['action'] == 'get_user')
					$query = $this->model->get_user($_POST['id']);
				else if ($_POST['action'] == 'get_user_level')
					$query = $this->model->get_user_level($_POST['id']);

                if (!empty($query))
                {
                    Functions::environment([
    					'status' => 'success',
    					'data' => $query
    				]);
                }
                else
                {
                    Functions::environment([
    					'status' => 'error',
    					'message' => '{$lang.operation_error}'
    				]);
                }
			}

			if ($_POST['action'] == 'new_user' OR $_POST['action'] == 'edit_user')
			{
				$labels = [];

				if (!isset($_POST['firstname']) OR empty($_POST['firstname']))
					array_push($labels, ['firstname','']);

				if (!isset($_POST['lastname']) OR empty($_POST['lastname']))
					array_push($labels, ['lastname','']);

				if (!isset($_POST['email']) OR empty($_POST['email']) OR Functions::check_email($_POST['email']) == false)
					array_push($labels, ['email','']);

				if (!isset($_POST['phone_lada']) OR empty($_POST['phone_lada']))
					array_push($labels, ['phone_lada','']);

				if (!isset($_POST['phone_number']) OR empty($_POST['phone_number']))
					array_push($labels, ['phone_number','']);

				if (!isset($_POST['username']) OR empty($_POST['username']))
					array_push($labels, ['username','']);

				if (!isset($_POST['permissions']) OR empty($_POST['permissions']))
					array_push($labels, ['permissions','']);

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_user')
					{
						$_POST['password'] = Functions::get_random(8);

						$query = $this->model->new_user($_POST);
					}
					else if ($_POST['action'] == 'edit_user')
						$query = $this->model->edit_user($_POST);

					if (!empty($query))
					{
						if ($_POST['action'] == 'new_user')
						{
							$mail = new Mailer(true);

							try
							{
								$mail->setFrom('noreply@guestvox.com', 'Guestvox');
								$mail->addAddress($_POST['email'], $_POST['firstname'] . ' ' . $_POST['lastname']);
								$mail->Subject = Languages::email('thanks_signup_guestvox')[$this->lang];
								$mail->Body =
								'<html>
									<head>
										<title>' . $mail->Subject . '</title>
									</head>
									<body>
										<table style="width:600px;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#eee">
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
														<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype_color.png">
													</figure>
												</td>
											</tr>
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail->Subject . '</h4>
													<h6 style="width:100%;margin:0px 0px 5px 0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Languages::email('username')[$this->lang] . ': ' . $_POST['username'] . '</h6>
													<h6 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Languages::email('password')[$this->lang] . ': ' . $_POST['password'] . '</h6>
													<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:40px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://' . Configuration::$domain . '/login">' . Languages::email('login')[$this->lang] . '</a>
												</td>
											</tr>
											' . (isset($_POST['whatsapp']) ? '
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . Languages::email('receive_notifications_on_whatsapp')[$this->lang] . '</h4>
													<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:40px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://personalizaforservices.com/whatsapp/optin/?bId=f543c489-ad53-406c-8642-739023556e45&bName=GuestVoxBot&s=URL&lang=en_US">' . Languages::email('join')[$this->lang] . '</a>
												</td>
											</tr>' : '') . '
											<tr style="width:100%;margin:0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '">' . Configuration::$domain . '</a>
												</td>
											</tr>
										</table>
									</body>
								</html>';
								$mail->send();
							}
							catch (Exception $e) {}
						}
						else if ($_POST['action'] == 'edit_user' AND isset($_POST['whatsapp']))
						{
							$mail = new Mailer(true);

							try
							{
								$mail->setFrom('noreply@guestvox.com', 'Guestvox');
								$mail->addAddress($_POST['email'], $_POST['firstname'] . ' ' . $_POST['lastname']);
								$mail->Subject = Languages::email('notifications_on_whatsapp')[$this->lang];
								$mail->Body =
								'<html>
									<head>
										<title>' . $mail->Subject . '</title>
									</head>
									<body>
										<table style="width:600px;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#eee">
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
														<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype_color.png">
													</figure>
												</td>
											</tr>
											<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . Languages::email('receive_notifications_on_whatsapp')[$this->lang] . '</h4>
													<a style="width:100%;display:block;margin:0px;padding:20px 0px;border-radius:40px;box-sizing:border-box;background-color:#00a5ab;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;" href="https://personalizaforservices.com/whatsapp/optin/?bId=f543c489-ad53-406c-8642-739023556e45&bName=GuestVoxBot&s=URL&lang=en_US">' . Languages::email('join')[$this->lang] . '</a>
												</td>
											</tr>
											<tr style="width:100%;margin:0px;padding:0px;border:0px;">
												<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
													<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '">' . Configuration::$domain . '</a>
												</td>
											</tr>
										</table>
									</body>
								</html>';
								$mail->send();
							}
							catch (Exception $e) {}
						}

						Functions::environment([
							'status' => 'success',
							'message' => ($_POST['action'] == 'new_user') ? '{$lang.thanks_signup_guestvox_4} <strong>' . $_POST['email'] . '</strong> {$lang.thanks_signup_guestvox_5}' : '{$lang.operation_success}'
						]);
					}
					else
					{
						Functions::environment([
							'status' => 'error',
							'message' => '{$lang.operation_error}'
						]);
					}
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'restore_password_user')
			{
				$_POST['password'] = Functions::get_random(8);

				$query = $this->model->restore_password_user($_POST);

				if (!empty($query))
				{
					$mail = new Mailer(true);

					try
					{
						$mail->setFrom('noreply@guestvox.com', 'Guestvox');
						$mail->addAddress($query['email'], $query['firstname'] . ' ' . $query['lastname']);
						$mail->Subject = Languages::email('restore_password')[$this->lang];
						$mail->Body =
						'<html>
							<head>
								<title>' . $mail->Subject . '</title>
							</head>
							<body>
								<table style="width:600px;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#eee">
									<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
										<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
											<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
												<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype_color.png">
											</figure>
										</td>
									</tr>
									<tr style="width:100%;margin:0px 0px 10px 0px;padding:0px;border:0px;">
										<td style="width:100%;margin:0px;padding:40px 20px;border:0px;box-sizing:border-box;background-color:#fff;">
											<h4 style="width:100%;margin:0px 0px 20px 0px;padding:0px;font-size:18px;font-weight:600;text-align:center;color:#212121;">' . $mail->Subject . '</h4>
											<h6 style="width:100%;margin:0px;padding:0px;font-size:14px;font-weight:400;text-align:center;color:#757575;">' . Languages::email('new_password')[$this->lang] . ': ' . $_POST['password'] . '</h6>
										</td>
									</tr>
									<tr style="width:100%;margin:0px;padding:0px;border:0px;">
										<td style="width:100%;margin:0px;padding:20px;border:0px;box-sizing:border-box;background-color:#fff;">
											<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#757575;" href="https://' . Configuration::$domain . '">' . Configuration::$domain . '</a>
										</td>
									</tr>
								</table>
							</body>
						</html>';
						$mail->send();
					}
					catch (Exception $e) {}

					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.restore_password_1} <strong>' . $query['email'] . '</strong> {$lang.restore_password_2}'
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}'
					]);
				}
			}

			if ($_POST['action'] == 'deactivate_user' OR $_POST['action'] == 'activate_user' OR $_POST['action'] == 'delete_user')
			{
				if ($_POST['action'] == 'deactivate_user')
					$query = $this->model->deactivate_user($_POST['id']);
				else if ($_POST['action'] == 'activate_user')
					$query = $this->model->activate_user($_POST['id']);
				else if ($_POST['action'] == 'delete_user')
					$query = $this->model->delete_user($_POST['id']);

				if (!empty($query))
				{
					Functions::environment([
						'status' => 'success',
						'message' => '{$lang.operation_success}'
					]);
				}
				else
				{
					Functions::environment([
						'status' => 'error',
						'message' => '{$lang.operation_error}'
					]);
				}
			}
		}
		else
		{
			$template = $this->view->render($this, 'index');

			define('_title', 'Guestvox | {$lang.users}');

			$tbl_users = '';

			foreach ($this->model->get_users() as $value)
			{
				$tbl_users .=
				'<div>
					<div class="datas">
						<div class="itm_1">
							<h2>' . $value['firstname'] . ' ' . $value['lastname'] . '</h2>
							<span>' . $value['email'] . '</span>
							<span>+ (' . $value['phone']['lada'] . ') ' . $value['phone']['number'] . '</span>
						</div>
						<div class="itm_2">
							<figure>
								<img src="' . (!empty($value['avatar']) ? '{$path.uploads}' . $value['avatar'] : '{$path.images}avatar.png') . '">
							</figure>
						</div>
					</div>
					<div class="buttons">
						' . ((Functions::check_user_access(['{users_deactivate}','{users_activate}']) == true) ? '<a class="big" data-action="' . (($value['status'] == true) ? 'deactivate_user' : 'activate_user') . '" data-id="' . $value['id'] . '">' . (($value['status'] == true) ? '<i class="fas fa-ban"></i><span>{$lang.deactivate}</span>' : '<i class="fas fa-check"></i><span>{$lang.activate}</span>') . '</a>' : '') . '
						' . ((Functions::check_user_access(['{users_restore_password}']) == true) ? '<a class="big" data-action="restore_password_user" data-id="' . $value['id'] . '"><i class="fas fa-key"></i><span>{$lang.restore_password}</span></a>' : '') . '
						' . ((Functions::check_user_access(['{users_update}']) == true) ? '<a class="edit" data-action="edit_user" data-id="' . $value['id'] . '"><i class="fas fa-pen"></i></a>' : '') . '
						' . ((Functions::check_user_access(['{users_delete}']) == true) ? '<a class="delete" data-action="delete_user" data-id="' . $value['id'] . '"><i class="fas fa-trash"></i></a>' : '') . '
					</div>
				</div>';
			}

			$opt_ladas = '';

			foreach ($this->model->get_countries() as $value)
				$opt_ladas .= '<option value="' . $value['lada'] . '">' . $value['name'][$this->lang] . ' (+' . $value['lada'] . ')</option>';

			$opt_users_levels = '';

			foreach ($this->model->get_users_levels() as $value)
				$opt_users_levels .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

			$cbx_permissions = '<p>{$lang.supervision_permissions}</p>';

            foreach ($this->model->get_permissions('supervision') as $key => $value)
            {
                $cbx_permissions .=
    			'<div>
                    <p>{$lang.' . $key . '}</p>';

                foreach ($value as $subvalue)
                {
                    $cbx_permissions .=
    				'<div>
    					<input type="' . (($subvalue['unique'] == true) ? 'radio' : 'checkbox') . '" name="permissions[]" value="' . $subvalue['id'] . '">
    					<span>' . $subvalue['name'][$this->lang] . '</span>
    				</div>';
                }

                $cbx_permissions .= '</div>';
            }

            $cbx_permissions .= '<p>{$lang.administrative_permissions}</p>';

            foreach ($this->model->get_permissions('administrative') as $key => $value)
            {
                $cbx_permissions .=
    			'<div>
                    <p>{$lang.' . $key . '}</p>';

                foreach ($value as $subvalue)
                {
                    $cbx_permissions .=
    				'<div>
    					<input type="' . (($subvalue['unique'] == true) ? 'radio' : 'checkbox') . '" name="permissions[]" value="' . $subvalue['id'] . '">
    					<span>' . $subvalue['name'][$this->lang] . '</span>
    				</div>';
                }

                $cbx_permissions .= '</div>';
            }

            $cbx_permissions .= '<p>{$lang.operational_permissions}</p>';

            foreach ($this->model->get_permissions('operational') as $key => $value)
            {
                $cbx_permissions .=
    			'<div>
                    <p>{$lang.' . $key . '}</p>';

                foreach ($value as $subvalue)
                {
                    $cbx_permissions .=
    				'<div>
    					<input type="' . (($subvalue['unique'] == true) ? 'radio' : 'checkbox') . '" name="permissions[]" value="' . $subvalue['id'] . '">
    					<span>' . $subvalue['name'][$this->lang] . '</span>
    				</div>';
                }

                $cbx_permissions .= '</div>';
            }

			$cbx_opportunity_areas =
            '<div>
				<input type="checkbox" name="checked_all">
				<span>{$lang.all}</span>
			</div>';

            foreach ($this->model->get_opportunity_areas() as $key => $value)
            {
                $cbx_opportunity_areas .=
				'<div>
					<input type="checkbox" name="opportunity_areas[]" value="' . $value['id'] . '">
					<span>' . $value['name'][$this->lang] . '</span>
				</div>';
            }

			$replace = [
				'{$tbl_users}' => $tbl_users,
				'{$opt_ladas}' => $opt_ladas,
				'{$opt_users_levels}' => $opt_users_levels,
				'{$cbx_permissions}' => $cbx_permissions,
				'{$cbx_opportunity_areas}' => $cbx_opportunity_areas
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
