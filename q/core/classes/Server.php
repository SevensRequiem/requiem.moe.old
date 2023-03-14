<?php

class Server {

	public static function get($server_id = false) {
		global $database; 

		/* Get all the server information from the database */
        $stmt = $database->prepare("SELECT * FROM `servers` WHERE `server_id` = ?");
        $stmt->bind_param('s', $server_id);
		$stmt->execute();
		bind_object($stmt, $server);
		$stmt->fetch();
		$stmt->close();

		/* Determine if the server exists */
		$server->exists = ($server !== NULL) ? true : false;


		/* If server exists gather the category information */
		if($server->exists) {

			/* Get this month hits */
			$result = $database->query("
				SELECT 
					COUNT(`id`) FROM `points` as `count`
				WHERE 
					`type` = 0 AND
					`server_id` = {$server_id} AND
					MONTH(FROM_UNIXTIME(`timestamp`)) = MONTH(CURDATE()) AND
					YEAR(FROM_UNIXTIME(`timestamp`)) = YEAR(CURDATE())
			");

			$server->hits = $result->fetch_row();
			$server->hits = $server->hits[0];


			/* Process the custom field */				
			if(!empty($server->custom)) {
				$server->custom = json_decode($server->custom);
			} else {
				$server->custom = new StdClass;
				$server->custom->votifier_public_key = $server->custom->votifier_ip = $server->custom->votifier_port = null;
			}
			
            return $server;
		}
	}

	public static function delete_server($server_id) {
		global $database;

		/* We need to make sure to delete all the data of the specific server */
		$database->query("DELETE FROM `servers` WHERE `server_id` = {$server_id}");
		$database->query("DELETE FROM `points` WHERE `server_id` = {$server_id}");
		$database->query("DELETE FROM `reports` WHERE `type` = 2 AND `reported_id` = {$server_id}");
		$database->query("DELETE FROM `favorites` WHERE `server_id` = {$server_id}");
		$database->query("DELETE FROM `comments` WHERE `server_id` = {$server_id}");

	}



}



?>