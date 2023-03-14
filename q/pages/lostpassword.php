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
	}
	if(!$resp->isSuccess()) {
		$_SESSION['error'][] = $language['errors']['captcha_not_valid'];
	}

	/* If there are no errors, resend the activation link */
	if(empty($_SESSION['error'])) {
		/* Define some variables */

		$user_id 			= Database::simple_get('user_id', 'users', ['email' => $_POST['email']]);
		$lost_password_code = md5($_POST['email'] + microtime());

		/* Update the current activation email */
		$database->query("UPDATE `users` SET `lost_password_code` = '{$lost_password_code}' WHERE `user_id` = {$user_id}");

		/* Send the email */
		sendmail($_POST['email'],  $settings->contact_email, $language['misc']['lost_password'], sprintf($language['misc']['lost_password_email'], $settings->url, $_POST['email'], $lost_password_code));
		//printf($language['misc']['lost_password_email'], $settings->url, $_POST['email'], $lost_password_code);

		/* Set success message */
		$_SESSION['success'][] = $language['messages']['lostpassword'];
	}

	display_notifications();

}

initiate_html_columns();

?>

<h3><?php echo $language['headers']['lostpassword']; ?></h3>

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