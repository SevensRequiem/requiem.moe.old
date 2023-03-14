<?php

/* If the server is found offline, add downtime to the database */
if(!$server->status) {
    $database->query("UPDATE `servers` SET `downtime` = `downtime` + {$settings->cache_reset_time} WHERE `server_id` = {$server->server_id}");
}
