<?php
/* Calculating the uptime */
$server_time_online = time() - $server->uptime_timestamp;
$server_uptime = $server_time_online - $server->downtime;
$server_uptime_percent = intval(($server_uptime * 100) / $server_time_online);

/* Additional checks */
if($server_uptime_percent > 100) $server_uptime_percent = 100;
if($server_uptime_percent < 0) $server_uptime_percent = 0;

/* Color of the label */
$server_uptime_color = 'success';

if($server_uptime_percent < 55) {
	$server_uptime_color = 'warning';
}
if($server_uptime_percent < 30) {
	$server_uptime_color = 'danger';
}
?>

<tr>
	<td><span class="glyphicon glyphicon-signal"></span> <strong><?php echo $language['server']['uptime']; ?></strong></td>
	<td>
		<span class="label label-<?php echo $server_uptime_color; ?>"><?php echo $server_uptime_percent; ?>%</span>
	</td>
</tr>
