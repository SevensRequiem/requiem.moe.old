<?php
ini_set('log_errors', true);
ini_set('error_log', dirname(__FILE__).'/ipn.log');

include '../core/init.php';
include '../core/classes/IpnListener.php';

$listener = new IpnListener();

$listener->use_sandbox = false;

try {
	$listener->requirePostMethod();
	$verified = $listener->processIpn();
} catch (Exception $e) {
	error_log($e->getMessage());
	exit(0);
}



if ($verified) {
	/* Process the custom variable */
	$custom = explode('|', $_POST['custom']);
	$server_id = $custom[0];
	$highlighted_days = $custom[1];
	$date = new DateTime();
	$date = $date->format('Y-m-d H:i:s');
	$user_id = Database::simple_get('user_id', 'servers', ['server_id' => $server_id]);
	$_POST['mc_gross'] = (float) $_POST['mc_gross'];
	$should_be = (float) ($settings->per_day_cost * $highlighted_days);

	/* Check for any errors in the small details of the payment */
	if($_POST['payment_status'] != 'Completed') {
		$errors[] = "Payment not completed";
	}

	if($_POST['receiver_email'] != $settings->paypal_email) {
		$errors[] = "Receiver email is not the same: " . $_POST['receiver_email'];
	}

	if(($_POST['mc_gross'] - $should_be) > 0.0001) {
		$errors[] = "Not enough paid:" . $_POST['mc_gross'];
	}

	if($_POST['mc_currency'] != $settings->payment_currency) {
		$errors[] = "Currency is not the same: " . $_POST['mc_currency'];
	}

	/* If there are errors, log them */
	if(!empty($errors)) {
		$error_log = '';

		foreach($errors as $error) $error_log += ' - ' . $error;

		error_log($error_log);
	}

	/* If there are no errors, make the server highlighted and add a log in the database */
	else {

		$database->query("UPDATE `servers` SET `highlight` = '1' WHERE `server_id` = {$server_id}");
		$database->query("INSERT INTO `payments` (`user_id`, `server_id`, `highlighted_days`, `date`, `revenue`, `email`) VALUES ({$user_id}, {$server_id}, {$highlighted_days}, '{$date}', '{$_POST['mc_gross']}', '{$_POST['payer_email']}')");

	}

	error_log($listener->getTextReport());

} else {

	error_log($listener->getTextReport());

}

?>
