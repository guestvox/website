<?php

defined('_EXEC') or die;

class Users_controller extends Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        if (Format::exist_ajax_request() == true)
		{
			if ($_POST['action'] == 'get_password_user')
			{
				Functions::environment([
					'status' => 'success',
					'data' => Functions::get_random(8)
				]);
			}

			if ($_POST['action'] == 'get_user_level')
			{
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

			if ($_POST['action'] == 'get_user')
			{
				$query = $this->model->get_user($_POST['id']);

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
					array_push($labels, ['firstname', '']);

				if (!isset($_POST['lastname']) OR empty($_POST['lastname']))
					array_push($labels, ['lastname', '']);

				if (!isset($_POST['email']) OR empty($_POST['email']) AND Functions::check_email($_POST['email']) == false)
					array_push($labels, ['email', '']);

				if (!isset($_POST['phone_lada']) OR empty($_POST['phone_lada']))
					array_push($labels, ['phone_lada', '']);

				if (!isset($_POST['phone_number']) OR empty($_POST['phone_number']))
					array_push($labels, ['phone_number', '']);

				if (!isset($_POST['username']) OR empty($_POST['username']))
					array_push($labels, ['username', '']);

				if ($_POST['action'] == 'new_user')
				{
					if (!isset($_POST['password']) OR empty($_POST['password']))
						array_push($labels, ['password', '']);
				}

				if (empty($labels))
				{
					if ($_POST['action'] == 'new_user')
						$query = $this->model->new_user($_POST);
					else if ($_POST['action'] == 'edit_user')
						$query = $this->model->edit_user($_POST);

					if (!empty($query))
					{
						if ($_POST['action'] == 'new_user')
						{
							$mail = new Mailer(true);

							try
							{
								if (Session::get_value('account')['language'] == 'es')
								{
									$mail_subject = 'Saludos de GuestVox';
									$mail_text = 'Hola <strong>' . $_POST['firstname'] . '</strong> ¡Has sido registrado en GuestVox! Soy <strong>Daniel Basurto</strong>, CEO de GuestVox y espero te encuentres de lo mejor. Tu usuario es: <strong>' . $_POST['username'] . '</strong> y tu contraseña es: <strong>' . $_POST['password'] . '</strong>';
									$mail_btn = 'Ir a GuestVox';
								}
								else if (Session::get_value('account')['language'] == 'en')
								{
									$mail_subject = 'Regards from GuestVox';
									$mail_text = 'Hi <strong>' . $_POST['firstname'] . '</strong> ¡You have been registered with GuestVox! I am <strong>Daniel Basurto</strong>, CEO for GuestVox and I hope you find the best. Your username is: <strong>' . $_POST['username'] . '</strong> and your password: <strong>' . $_POST['password'] . '</strong>';
									$mail_btn = 'Go to GuestVox';
								}

								$mail->isSMTP();
								$mail->setFrom('daniel@guestvox.com', 'Daniel Basurto');
								$mail->addAddress($_POST['email'], $_POST['firstname'] . ' ' . $_POST['lastname']);
								$mail->isHTML(true);
								$mail->Subject = $mail_subject;
								$mail->Body =
								'<html>
									<head>
										<title>' . $mail_subject . '</title>
									</head>
									<body>
										<table style="width:600px;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#eee">
											<tr style="width:100%;margin:0px:margin-bottom:10px;border:0px;padding:0px;">
												<td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
													<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
														<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype-color.png" />
													</figure>
												</td>
											</tr>
											<tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
												<td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
													<p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail_text . '</p>
													<a style="width:100%;display:block;margin:15px 0px 20px 0px;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;background-color:#201d33;" href="https://' . Configuration::$domain . '">' . $mail_btn . '</a>
												</td>
											</tr>
											<tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
												<td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
													<figure style="width:100%;margin:0px;border:0px;padding:40px 0px;box-sizing:border-box;text-align:center;">
														<img style="width:150px;height:150px;border-radius:50%;" src="https://' . Configuration::$domain . '/images/basurto.png">
														<span style="display:block;color:#757575;font-size:18px;">Daniel Basurto</span>
														<span style="display:block;color:#757575;font-size:18px;">CEO</span>
														<span style="display:block;color:#757575;font-size:18px;">daniel@guestvox.com</span>
														<span style="display:block;color:#757575;font-size:18px;">+52 (998) 845 28 43</span>
													</figure>
												</td>
											</tr>
											<tr style="width:100%;margin:0px;border:0px;padding:0px;">
												<td style="width:100%;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#fff;">
													<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#201d33;" href="https://' . Configuration::$domain . '">' . Configuration::$domain . '</a>
												</td>
											</tr>
										</table>
									</body>
								</html>';
								$mail->AltBody = '';
								$mail->send();
							}
							catch (Exception $e) { }
						}

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
				$labels = [];

				if (!isset($_POST['password']) OR empty($_POST['password']))
					array_push($labels, ['password', '']);

				if (empty($labels))
				{
					$query = $this->model->restore_password_user($_POST);

					if (!empty($query))
					{
						$mail = new Mailer(true);

						try
						{
							if (Session::get_value('account')['language'] == 'es')
							{
								$mail_subject = 'Contraseña restablecida';
								$mail_text = 'Hola <strong>' . $query['firstname'] . '</strong> ¡Tu contraseña ha sido restablecida! Tu nueva contraseña es: <strong>' . $_POST['password'] . '</strong>';
								$mail_btn = 'Ir a GuestVox';
							}
							else if (Session::get_value('account')['language'] == 'en')
							{
								$mail_subject = 'Password reset';
								$mail_text = 'Hi <strong>' . $query['firstname'] . '</strong> ¡Your password has been reset! Your new password: <strong>' . $_POST['password'] . '</strong>';
								$mail_btn = 'Go to GuestVox';
							}

							$mail->isSMTP();
							$mail->setFrom('noreply@guestvox.com', 'GuestVox');
							$mail->addAddress($query['email'], $query['firstname'] . ' ' . $query['lastname']);
							$mail->isHTML(true);
							$mail->Subject = $mail_subject;
							$mail->Body =
							'<html>
								<head>
									<title>' . $mail_subject . '</title>
								</head>
								<body>
									<table style="width:600px;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#eee">
										<tr style="width:100%;margin:0px:margin-bottom:10px;border:0px;padding:0px;">
											<td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
												<figure style="width:100%;margin:0px;padding:0px;text-align:center;">
													<img style="width:100%;max-width:300px;" src="https://' . Configuration::$domain . '/images/logotype-color.png" />
												</figure>
											</td>
										</tr>
										<tr style="width:100%;margin:0px;margin-bottom:10px;border:0px;padding:0px;">
											<td style="width:100%;margin:0px;border:0px;padding:40px 20px;box-sizing:border-box;background-color:#fff;">
												<p style="font-size:14px;font-weight:400;text-align:center;color:#212121;margin:0px;padding:0px;">' . $mail_text . '</p>
												<a style="width:100%;display:block;margin:15px 0px 20px 0px;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#fff;background-color:#201d33;" href="https://' . Configuration::$domain . '">' . $mail_btn . '</a>
											</td>
										</tr>
										<tr style="width:100%;margin:0px;border:0px;padding:0px;">
											<td style="width:100%;margin:0px;border:0px;padding:20px;box-sizing:border-box;background-color:#fff;">
												<a style="width:100%;display:block;padding:20px 0px;box-sizing:border-box;font-size:14px;font-weight:400;text-align:center;text-decoration:none;color:#201d33;" href="https://' . Configuration::$domain . '">' . Configuration::$domain . '</a>
											</td>
										</tr>
									</table>
								</body>
							</html>';
							$mail->AltBody = '';
							$mail->send();
						}
						catch (Exception $e) { }

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
				else
				{
					Functions::environment([
						'status' => 'error',
						'labels' => $labels
					]);
				}
			}

			if ($_POST['action'] == 'deactivate_user')
			{
				$query = $this->model->deactivate_user($_POST['id']);

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

			if ($_POST['action'] == 'activate_user')
			{
				$query = $this->model->activate_user($_POST['id']);

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

			if ($_POST['action'] == 'delete_user')
			{
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
			define('_title', 'GuestVox');

			$template = $this->view->render($this, 'index');

			$tbl_users = '';

			foreach ($this->model->get_users() as $value)
			{
				$tbl_users .=
				'<tr>
					<td align="left">
						<figure>
							<img src="' . (!empty($value['avatar']) ? '{$path.uploads}' . $value['avatar'] : '{$path.images}avatar.png') . '" />
						</figure>
					</td>
					<td align="left">' . $value['firstname'] . ' ' . $value['lastname'] . '</td>
					<td align="left">' . $value['email'] . '</td>
					<td align="left">+' . $value['phone']['lada'] . ' ' . $value['phone']['number'] . '</td>
					<td align="left">' . $value['username'] . '</td>
					<td align="left">
                        ' . (($value['user_permissions']['supervision'] == true) ? '{$lang.supervision}.' : '') . '
                        ' . (($value['user_permissions']['administrative'] == true) ? '{$lang.administrative}.' : '') . '
                        ' . (($value['user_permissions']['operational'] == true) ? '{$lang.operational}.' : '') . '
                    </td>
					<td align="left">' . (($value['status'] == true) ? '{$lang.active}' : '{$lang.deactive}') . '</td>
					' . ((Functions::check_user_access(['{users_delete}']) == true) ? '<td align="right" class="icon">' . (($value['status'] == true) ? '<a data-action="delete_user" data-id="' . $value['id'] . '" class="delete"><i class="fas fa-trash"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_user_access(['{users_deactivate}','{users_activate}']) == true) ? '<td align="right" class="icon">' . (($value['status'] == true) ? '<a data-action="deactivate_user" data-id="' . $value['id'] . '" ><i class="fas fa-ban"></i></a>' : '<a data-action="activate_user" data-id="' . $value['id'] . '"><i class="fas fa-check"></i></a>') . '</td>' : '') . '
					' . ((Functions::check_user_access(['{users_restore_password}']) == true) ? '<td align="right" class="icon">' . (($value['status'] == true) ? '<a data-action="restore_password_user" data-id="' . $value['id'] . '"><i class="fas fa-key"></i></a>' : '') . '</td>' : '') . '
					' . ((Functions::check_user_access(['{users_update}']) == true) ? '<td align="right" class="icon">' . (($value['status'] == true) ? '<a data-action="edit_user" data-id="' . $value['id'] . '" class="edit"><i class="fas fa-pen"></i></a>' : '') . '</td>' : '') . '
				</tr>';
			}

			$opt_ladas = '';

			foreach ($this->model->get_countries() as $value)
				$opt_ladas .= '<option value="' . $value['lada'] . '">' . $value['name'][Session::get_value('account')['language']] . ' (+' . $value['lada'] . ')</option>';

			$opt_user_levels = '';

			foreach ($this->model->get_user_levels() as $value)
				$opt_user_levels .= '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';

            $cbx_user_permissions =
            '<div>
                <h4><i class="fas fa-user-secret"></i>{$lang.supervision}</h4>';

            foreach ($this->model->get_user_permissions('supervision') as $key => $value)
            {
                $cbx_user_permissions .=
    			'<div>
                    <p>{$lang.' . $key . '}</p>';

                foreach ($value as $subvalue)
                {
                    $cbx_user_permissions .=
    				'<div>
    					<input type="' . (($subvalue['unique'] == true) ? 'radio' : 'checkbox') . '" name="user_permissions[]" value="' . $subvalue['id'] . '">
    					<span>' . $subvalue['name'][Session::get_value('account')['language']] . '</span>
    				</div>';
                }

                $cbx_user_permissions .=
                '</div>';
            }

            $cbx_user_permissions .=
            '</div>
            <div>
                <h4><i class="fas fa-user-cog"></i>{$lang.administrative}</h4>';

            foreach ($this->model->get_user_permissions('administrative') as $key => $value)
            {
                $cbx_user_permissions .=
    			'<div>
                    <p>{$lang.' . $key . '}</p>';

                foreach ($value as $subvalue)
                {
                    $cbx_user_permissions .=
    				'<div>
    					<input type="' . (($subvalue['unique'] == true) ? 'radio' : 'checkbox') . '" name="user_permissions[]" value="' . $subvalue['id'] . '">
    					<span>' . $subvalue['name'][Session::get_value('account')['language']] . '</span>
    				</div>';
                }

                $cbx_user_permissions .=
                '</div>';
            }

            $cbx_user_permissions .=
            '</div>
            <div>
                <h4><i class="fas fa-user-tie"></i>{$lang.operational}</h4>';

            foreach ($this->model->get_user_permissions('operational') as $key => $value)
            {
                $cbx_user_permissions .=
    			'<div>
                    <p>{$lang.' . $key . '}</p>';

                foreach ($value as $subvalue)
                {
                    $cbx_user_permissions .=
    				'<div>
    					<input type="' . (($subvalue['unique'] == true) ? 'radio' : 'checkbox') . '" name="user_permissions[]" value="' . $subvalue['id'] . '">
    					<span>' . $subvalue['name'][Session::get_value('account')['language']] . '</span>
    				</div>';
                }

                $cbx_user_permissions .=
                '</div>';
            }

            $cbx_user_permissions .=
            '</div>';

			$cbx_opportunity_areas =
            '<div>
				<div>
					<div>
						<input type="checkbox" name="checked_all">
						<span>{$lang.all}</span>
					</div>';

            foreach ($this->model->get_opportunity_areas() as $key => $value)
            {
                $cbx_opportunity_areas .=
				'<div>
					<input type="checkbox" name="opportunity_areas[]" value="' . $value['id'] . '">
					<span>' . $value['name'][Session::get_value('account')['language']] . '</span>
				</div>';
            }

            $cbx_opportunity_areas .=
            '	</div>
			</div>';

			$replace = [
				'{$tbl_users}' => $tbl_users,
				'{$opt_ladas}' => $opt_ladas,
				'{$opt_user_levels}' => $opt_user_levels,
				'{$cbx_user_permissions}' => $cbx_user_permissions,
				'{$cbx_opportunity_areas}' => $cbx_opportunity_areas,
			];

			$template = $this->format->replace($replace, $template);

			echo $template;
		}
	}
}
