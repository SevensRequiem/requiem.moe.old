<?php
User::logged_in_redirect();

if(!empty($_POST)) {
	/* Clean some posted variables */
	$_POST['name']		= 'Anonymous';
	$_POST['email']		= filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

	/* Define some variables */
	$recaptcha = new \ReCaptcha\ReCaptcha($settings->private_key);
	$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
	$fields = array('username', 'name', 'email' ,'password', 'repeat_password', 'recaptcha_response_field');

	/* Check for any errors */
	foreach($_POST as $key=>$value) {
		if(empty($value) && in_array($key, $fields) == true) {
			$_SESSION['error'][] = $language['errors']['fields_required'];
			break 1;
		}
	}
	if(!$resp->isSuccess()) {
		$_SESSION['error'][] = $language['errors']['captcha_not_valid'];
	}
	if(Database::exists('email', 'users', ['email' => $_POST['email']])) {
		$_SESSION['error'][] = $language['errors']['email_used'];
	}
	if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
		$_SESSION['error'][] = $language['errors']['invalid_email'];
	}
	if(strlen(trim($_POST['password'])) < 6) {
        $_SESSION['error'][] = $language['errors']['password_too_short'];
    }
    if($_POST['password'] !== $_POST['repeat_password']) {
        $_SESSION['error'][] = $language['errors']['passwords_doesnt_match'];
    }


	/* If there are no errors continue the registering process */
	if(empty($_SESSION['error'])) {
		/* Define some needed variables */ 
	    $password 	= User::encrypt_password($_POST['email'], $_POST['password']);
	    $active 	= ($settings->email_confirmation == 0) ? "1" : "0";
	    $email_code = md5($_POST['email'] + microtime());
		$date = new DateTime();
		$date = $date->format('Y-m-d H:i:s');

		/* Add the user to the database */
		$stmt = $database->prepare("INSERT INTO `users` (`password`, `email`, `email_activation_code`, `name`, `active`, `ip`, `date`) VALUES (?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('sssssss', $password, $_POST['email'], $email_code, $_POST['name'], $active, $_SERVER['REMOTE_ADDR'], $date);
		$stmt->execute();
		$stmt->close();

		/* If active = 1 then login the user, else send the user an activation email */
		if($active == '1') {
			$_SESSION['user_id'] = User::login($_POST['email'], $password);
			redirect();
		} else {
			$_SESSION['success'][] = $language['messages']['registered_successfuly'];
			sendmail($_POST['email'], $settings->contact_email, $language['misc']['activate_account'], sprintf($language['misc']['activation_email'], $settings->url, $_POST['email'], $email_code));
			//printf($language['misc']['activation_email'], $settings->url, $_POST['email'], $email_code);
		}
	}

	display_notifications();

}

initiate_html_columns();

?>

<h3><?php echo $language['headers']['register']; ?></h3>

<form action="" method="post" role="form">

	<div class="form-group">
		<label><?php echo $language['forms']['email']; ?></label>
		<input type="text" name="email" class="form-control" placeholder="<?php echo $language['forms']['email']; ?>" />
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['password']; ?></label>
		<input type="password" name="password" class="form-control" placeholder="<?php echo $language['forms']['password']; ?>" />
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['repeat_password']; ?></label>
		<input type="password" name="repeat_password" class="form-control" placeholder="<?php echo $language['forms']['repeat_password']; ?>" />
	</div>

	<div class="form-group">
		<div class="g-recaptcha" data-sitekey="<?php echo $settings->public_key; ?>"></div>
	</div>

	<div class="form-group">
		<button type="submit" name="submit" class="btn btn-default col-lg-4"><?php echo $language['forms']['submit']; ?></button><br /><br />
	</div>

</form>
