<?php
include '../core/init.php';


/* Check for any errors */
$result = $database->query("SELECT `id` FROM `points` WHERE `type` = 1 AND `server_id` = {$_SESSION['server_id']} AND `ip` = '{$_SERVER['REMOTE_ADDR']}' AND `timestamp` > UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)");

if($result->num_rows) {
	$errors[] = $language['errors']['already_voted'];
}

if(empty($errors)) {

	/* Check for custom fields */
    $server = Database::get('*', 'servers', ['server_id' => $_SESSION['server_id']]);

	/* Update the votes in the database */
	$database->query("INSERT INTO `points` (`type`, `server_id`, `ip`, `timestamp`) VALUES (1, {$_SESSION['server_id']}, '{$_SERVER['REMOTE_ADDR']}', UNIX_TIMESTAMP())");
	$database->query("UPDATE `servers` SET `votes` = `votes` + 1 WHERE `server_id` = {$_SESSION['server_id']}");

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