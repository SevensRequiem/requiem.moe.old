<?php
include '../core/init.php';

/* Process variables */
$_POST['email']		    = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$_POST['message']		= filter_var($_POST['message'], FILTER_SANITIZE_STRING);
$_POST['type']			= (int) $_POST['type'];
$_POST['reported_id']	= (int) $_POST['reported_id'];


/* Check for errors */
$report_exists = Database::exists(['id'], 'reports', ['type' => $_POST['type'], 'reported_id' => $_POST['reported_id']]);


if($report_exists) {
	$errors[] = $language['errors']['already_reported'];
}
if(!$token->is_valid()) {
	$errors[] = $language['errors']['invalid_token'];
}
if(strlen($_POST['message']) > 512) {
	$errors[] = $language['errors']['message_too_long'];
}
if(strlen($_POST['message']) < 5) {
	$errors[] = $language['errors']['message_too_short'];
}
if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false) {
    $_SESSION['error'][] = $language['errors']['invalid_email'];
}

if(empty($errors)) {
	$date = new DateTime();
	$date = $date->format('Y-m-d H:i:s');
	$stmt = $database->prepare("INSERT INTO `reports` (`email`, `type`, `reported_id`, `message`, `date`) VALUES (?, ?, ?, ?, ?)");
	$stmt->bind_param('sssss', $_POST['email'], $_POST['type'], $_POST['reported_id'], $_POST['message'], $date);
	$stmt->execute();
	$stmt->close();

    echo json_encode([
        'status' => true,
        'message' => trim(output_success($language['messages']['success'], true))
    ]);
} else
    echo json_encode([
        'status' => false,
        'message' => trim(output_errors($errors, true))
    ]);
?>