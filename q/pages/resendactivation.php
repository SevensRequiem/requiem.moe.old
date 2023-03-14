<?php
User::logged_in_redirect();

if(!empty($_POST)) {
	/* Clean the posted variable */
	$_POST['email'] = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

	/* Define the captcha variable */
	$recaptcha = new \ReCaptcha\ReCaptcha($settings->private_key);
	$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

	/* Check for any errors */
	if(!Database::exists('email', 'users', ['email' => $_POST['email']])) {
		$_SESSION['error'][] = $language['errors']['email_doesnt_exist'];
	} else 
	if(User::user_active($_POST['email'])) {
		$_SESSION['error'][] = $language['errors']['user_already_active'];
	}
	if(!$resp->isSuccess()) {
		$_SESSION['error'][] = $language['errors']['captcha_not_valid'];
	}

	/* If there are no errors, resend the activation link */
	if(empty($_SESSION['error'])) {
		/* Define some variables */
		$user_id 	= Database::simple_get('user_id', 'users', ['email' => $_POST['email']]);
		$email_code = md5($_POST['email'] + microtime());

		/* Update the current activation email */
		$database->query("UPDATE `users` SET `email_activation_code` = '{$email_code}' WHERE `user_id` = {$user_id}");

		/* Send the email */
		sendmail($_POST['email'], $settings->contact_email, $language['misc']['activate_account'], sprintf($language['misc']['activation_email'], $settings->url, $_POST['email'], $email_code));
		//printf($language['misc']['activation_email'], $settings->url, $_POST['email'], $email_code);

		/* Store success message */
		$_SESSION['success'][] = $language['messages']['resendactivation'];
	}

	display_notifications();
	
}

initiate_html_columns();

?>

<h3><?php echo $language['headers']['resendactivation']; ?></h3>

<form action="" method="post" role="form">
	<div class="form-group">
		<label><?php echo $language['forms']['email']; ?></label>
		<input type="text" name="email" class="form-control" />
	</div>

	<div class="form-group">
		<div class="g-recaptcha" data-sitekey="<?php echo $settings->public_key; ?>"></div>
	</div>

	<div class="form-group">
		<button type="submit" name="submit" class="btn btn-default col-lg-4"><?php echo $language['forms']['submit']; ?></button><br /><br />
	</div>

</form>