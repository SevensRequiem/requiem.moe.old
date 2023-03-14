<?php

class User {

	public static function encrypt_password($username, $password) {
		/* Using $username as salt */
		$username = hash('sha512', $username);
		$hash	  = hash('sha512', $password . $username);

		/* Iterating the hash */
		for($i = 1;$i <= 1000;$i++) {
			$hash = hash('sha512', $hash);
		}

		return $hash;
	}

	public static function login($email, $password) {
		global $database;

		$stmt = $database->prepare("SELECT `user_id` FROM `users` WHERE `email` = ? AND `password` = ?");
		$stmt->bind_param('ss', $email, $password);
		$stmt->execute();
		$stmt->bind_result($result);
		$stmt->fetch();
		$stmt->close();

		return (!is_null($result)) ? $result : false;
	}

	public static function logout() {
		session_destroy();
		setcookie('username', '', time()-30);
		setcookie('password', '', time()-30);
		setcookie('user_id', '', time()-30);
		redirect();
	}

	public static function user_active($email) {
		global $database;

		$stmt = $database->prepare("SELECT `active` FROM `users` WHERE `email` = ?");
		$stmt->bind_param('s', $email);
		$stmt->execute();
		$stmt->bind_result($result);
		$stmt->fetch();
		$stmt->close();

		return ($result) ? true : false;
	}

	public static function logged_in_redirect() {
		global $language;

		if(self::logged_in()) {
			$_SESSION['error'][] = $language['errors']['cant_access'];
			redirect();
		}
	}

	public static function logged_in() {
		if(isset($_COOKIE['email']) && isset($_COOKIE['password']) && User::login($_COOKIE['email'], $_COOKIE['password']) !== false && $_COOKIE['user_id'] == User::login($_COOKIE['email'], $_COOKIE['password'])) {
			return true;
		} elseif(isset($_SESSION['user_id'])) {
			return true;
		} else return false;
	}

	public static function get_back($new_page = 'index') {
		if(isset($_SERVER['HTTP_REFERER']))
			Header('Location: ' . $_SERVER['HTTP_REFERER']);
		else
			redirect($new_page);
		die();
	}

	public static function get_type($user_id) {
		global $database;

		$stmt = $database->prepare("SELECT `type` FROM `users` WHERE `user_id` = ?");
		$stmt->bind_param('s', $user_id);
		$stmt->execute();
		$stmt->bind_result($result);
		$stmt->fetch();
		$stmt->close();

		return $result;
	}

	public static function get_servers($user_id) {
		global $database;

		$stmt = $database->prepare("SELECT COUNT(`user_id`) FROM `servers` WHERE `user_id` = ?");
		$stmt->bind_param('s', $user_id);
		$stmt->execute();
		$stmt->bind_result($result);
		$stmt->fetch();
		$stmt->close();

		return $result;
	}

	public static function get_profile_link($user_id) {
		global $database;

		$stmt = $database->prepare("SELECT `user_id`, `name` FROM `users` WHERE `user_id` = ?");
		$stmt->bind_param('s', $user_id);
		$stmt->execute();
		$stmt->bind_result($user_id, $name);
		$stmt->fetch();
		$stmt->close();

		return (!$user_id) ? 'Anonymous' : '<a href="profile/' . $user_id . '">' . $name . '</a>';
	}


	public static function online_users($seconds) {
		global $database;

		$stmt = $database->prepare("SELECT COUNT(`user_id`) FROM `users` WHERE `last_activity` > UNIX_TIMESTAMP() - ?");
		$stmt->bind_param('i', $seconds);
		$stmt->execute();
		$stmt->bind_result($result);
		$stmt->fetch();
		$stmt->close();

		return $result;
	}


	public static function check_permission($level = 1) {
		global $account_user_id;
		global $language;

		switch($level) {
			case 0 :
				if(!self::logged_in()) {
					$_SESSION['info'][] = $language['info']['need_to_login'];

					redirect('login');
					die();
				}
			break;

			case ($level > 0):
				if(!self::logged_in() || self::get_type($account_user_id) < $level) {
					$_SESSION['error'][] = $language['errors']['cant_access'];

					if(isset($_SERVER['HTTP_REFERER'])) Header('Location: ' . $_SERVER['HTTP_REFERER']); else redirect();
					die();
				}
			break;
		}

	}

	public static function is_admin($user_id) {
		return (self::get_type($user_id) > 0) ? true : false;
	}

	public static function generate_go_back_button($default = 'index') {
		global $language;
		global $settings;

		return '&nbsp; <a href="' . $settings->url . $default . '"><button class="btn btn-primary btn-sm get-back-button"><i class="fa fa-arrow-left"></i> ' . $language['misc']['go_back'] . '</button></a>';
	}
}

?>
