<?php
include '../../../core/init.php';

$result = $database->query("SELECT * FROM `servers` WHERE `active` = '1' ORDER BY `cachetime` ASC");

$i = 1;

while (($server = $result->fetch_object()) && ($i <= Plugin::$plugins['cron-job-servers']['limit'])) {


	if($server->cachetime < time() - $settings->cache_reset_time){

		/* Establish the vars needed for the library */
		$server->query_address = $server->address;
		$type = $server->type;

		/* SRV Checking if the game is minecraft */
		if($type == 'minecraft') {
			if(Plugin::get('srv-support', 'submit-replacer.php')) include_once Plugin::get('srv-support', 'submit-replacer.php');
		}

		$host = $server->query_address . ':' . $server->connection_port;
		$query = [];

		/* Query with GameQ */
		try {
			$GameQ = new \GameQ\GameQ();
			$GameQ->addServer([
				'type' => $type,
				'host' => $host,
				'options' => [
					'query_port' => $server->query_port
				]
			]);
			$GameQ->setOption('timeout', 2);
			$query = $GameQ->process();

			$server->status = (int) $query['gq_online'];


		} catch(Exception $e) {
			$_SESSION['error'][] = $e->getMessage();
			$server->status = 0;
		}
		if(!empty($query)) {
			$query['gq_numplayers'] = (int) $query['gq_numplayers'];
			$query['gq_maxplayers'] = (int) $query['gq_maxplayers'];
		} else {
			$query['gq_numplayers'] = $query['gq_maxplayers'] = 0;
		}


		/* Update the database with new data */
		if($server->status) {
			$players_json = json_encode($query['players']);
			$details = json_encode(array_diff_key(
				$query,
				[
					'gq_address' => 'xy',
					'gq_dedicated' => 'xy',
					'gq_hostname' => 'xy',
					'gq_gametype' => 'xy',
					'gq_joinlink' => 'xy',
					'gq_mapname' => 'xy',
					'gq_mod' => 'xy',
					'gq_maxplayers' => 'xy',
					'gq_numplayers' => 'xy',
					'gq_name' => 'xy',
					'gq_password' => 'xy',
					'gq_online' => 'xy',
					'gq_port_client' => 'xy',
					'gq_port_query' => 'xy',
					'gq_protocol' => 'xy',
					'gq_transport' => 'xy',
					'gq_type' => 'xy',
					'players' => 'xy',
					'teams' => 'xy'
				]
			));

			$stmt = $database->prepare("
			UPDATE `servers`
			SET
				`status` = ?,
				`online_players` = ?,
				`maximum_online_players` = ?,
				`hostname` = ?,
				`gametype` = ?,
				`joinlink` = ?,
				`map` = ?,
				`password` = ?,
				`players` = ?,
				`details` = ?,
				`cachetime` = unix_timestamp()
			WHERE `server_id` = {$server->server_id}
		");

			$stmt->bind_param(
				'ssssssssss',
				$server->status,
				$query['gq_numplayers'],
				$query['gq_maxplayers'],
				$query['gq_hostname'],
				$query['gq_name'],
				$query['gq_joinlink'],
				$query['gq_mapname'],
				$query['gq_password'],
				$players_json,
				$details
			);
		}
		else {
			$stmt = $database->prepare("
			UPDATE `servers`
			SET
				`status` = ?,
				`online_players` = ?,
				`maximum_online_players` = ?,
				`cachetime` = unix_timestamp()
			WHERE `server_id` = {$server->server_id}
		");
			$stmt->bind_param(
				'sss',
				$server->status,
				$query['gq_numplayers'],
				$query['gq_maxplayers']
			);
		}
		$test = $stmt->execute();

		/* If the Uptime Tracking plugin is activated */
		if(Plugin::get('uptime', 'update.php')) include_once Plugin::get('uptime', 'update.php');

		echo 'Success query for server with id: ' . $server->server_id . '<br />';
	}

	$i++;


}



?>
