<?php
include '../core/init.php';

/* Process variables */
@$_POST['comment'] = filter_var($_POST['comment'], FILTER_SANITIZE_STRING);
$type = (isset($_POST['type'])) ? (int) $_POST['type'] : '0';

/* Check for errors */
if(!isset($_POST['delete'])) {

	if(isset($_POST['type']) && $account_user_id != Database::simple_get('user_id', 'servers', ['server_id' => $_SESSION['server_id']])) {
		$errors[] = $language['errors']['command_denied'];
	}
	if(!$token->is_valid()) {
	$errors[] = $language['errors']['invalid_token'];
	}
	if(strlen($_POST['comment']) > 512) {
		$errors[] = $language['errors']['message_too_long'];
	}
	if(strlen($_POST['comment']) < 5) {
		$errors[] = $language['errors']['message_too_short'];
	}

} else {
	if(!User::is_admin($account_user_id)) {
		$errors[] = $language['errors']['command_denied'];
	}
}


if(empty($errors)) {
	$date = new DateTime();
	$date = $date->format('Y-m-d H:i:s');

	if(!isset($_POST['delete'])) {
		$stmt = $database->prepare("INSERT INTO `comments` (`server_id`, `user_id`, `type`, `comment`, `date_added`) VALUES (?, ?, ?, ?, ?)");
		$stmt->bind_param('sssss',  $_SESSION['server_id'], $account_user_id, $type, $_POST['comment'], $date);
		$stmt->execute();
		$stmt->close();
	} else {
		$stmt = $database->prepare("DELETE FROM `comments` WHERE `type` = ? AND `id` = ?");
		$stmt->bind_param('ss', $type, $_POST['reported_id']);
		$stmt->execute();
		$stmt->close();
	}

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