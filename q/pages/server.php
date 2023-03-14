<?php


/* If its private but the owner is viewing it, display a notice message */
if($server->private) echo output_notice($language['server']['private']);

/* Check if we should add another hit to the server or not */
$result = $database->query("SELECT `id` FROM `points` WHERE `type` = 0 AND `server_id` = {$server->server_id} AND `ip` = '{$_SERVER['REMOTE_ADDR']}' AND `timestamp` > UNIX_TIMESTAMP(NOW() - INTERVAL 1 DAY)");
if(!$result->num_rows) $database->query("INSERT INTO `points` (`type`, `server_id`, `ip`, `timestamp`) VALUES (0, {$server->server_id}, '{$_SERVER['REMOTE_ADDR']}', UNIX_TIMESTAMP())");

/* Check the cache timer, so we don't query the server
everytime we load the page */
if($server->cachetime > time() - $settings->cache_reset_time) {

	// nothing for now

} else {

	/* Establish the vars needed for the library */
	$server->query_address = $server->address;
	$type = $server->type;

	/* SRV Checking if the game is minecraft */
	if($type == 'minecraft') {
		if(Plugin::get('srv-support', 'server-replacer.php')) include_once Plugin::get('srv-support', 'server-replacer.php');
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
	$stmt->execute();


	/* Refresh details */
	$server = Server::get($_GET['server_id']);
}


/* If the Uptime Tracking plugin is activated */
if(Plugin::get('uptime', 'update.php')) include_once Plugin::get('uptime', 'update.php');


$server->players = json_decode($server->players, true);
initiate_html_columns();

?>

<?php include 'template/includes/widgets/server_header.php'; ?>

<div class="server-description">
	<?php
	if(!empty($server->description)) {
		$description = (strlen($server->description) > 300) ? substr_replace(bbcode($server->description), '<span class="spoiler">', 300, 0) . '</span>' : bbcode($server->description);

		echo $description;
	}
	?>
</div>

<div class="panel panel-default">
	<div class="panel-body">

		<table class="table">
			<tbody>
				<tr>
					<td style="width: 50%;"><span class="glyphicon glyphicon-time"></span> <strong><?php echo $language['server']['status']; ?></strong></td>
					<td>
						<?php
						if($server->status)
							echo '<span class="label label-success"><span class="glyphicon glyphicon-ok glyphicon glyphicon-white"></span></span> ' . $language['server']['status_online'];
						else
							echo '<span class="label label-danger"><span class="glyphicon glyphicon-remove glyphicon glyphicon-white"></span></span> ' . $language['server']['status_offline'];
						?>
					</td>
				</tr>
				<tr>
					<td><span class="glyphicon glyphicon-random"></span> <strong><?php echo $language['server']['address']; ?></strong></td>
					<td><?php echo $server->address ?></td>
				</tr>
				<tr>
					<td><span class="glyphicon glyphicon-tasks"></span> <strong><?php echo $language['server']['connection_port']; ?></strong></td>
					<td><?php echo $server->connection_port; ?></td>
				</tr>
				<tr>
					<td><span class="glyphicon glyphicon-bell"></span> <strong><?php echo $language['server']['last_check']; ?></strong></td>
					<td class="timeago" title="<?php if($server->cachetime > time() - $settings->cache_reset_time) echo @date("c", $server->cachetime); else echo date("c", time()); ?>"></td>
				</tr>
				<tr>
					<td><span class="glyphicon glyphicon-bell"></span> <strong><?php echo $language['server']['previous_check']; ?></strong></td>
					<td class="timeago" title="<?php echo @date('c', $server->cachetime); ?>"></td>
				</tr>
				<tr>
					<td><span class="glyphicon glyphicon-tower"></span> <strong><?php echo $language['server']['owner']; ?></strong></td>
					<td><?php echo User::get_profile_link($server->user_id); ?></td>
				</tr>
				<tr>
					<td><span class="glyphicon glyphicon-arrow-up"></span> <strong><?php echo $language['server']['votes']; ?></strong></td>
					<td id="votes_value"><?php echo $server->votes; ?></td>
				</tr>
				<tr>
					<td><span class="glyphicon glyphicon-star"></span> <strong><?php echo $language['server']['favorites']; ?></strong></td>
					<td><?php echo $server->favorites; ?></td>
				</tr>
				<tr>
					<td><span class="glyphicon glyphicon-upload"></span> <strong><?php echo $language['server']['hits']; ?></strong></td>
					<td><?php echo $server->hits; ?></td>
				</tr>
				<tr>
					<td><span class="glyphicon glyphicon-globe"></span> <strong><?php echo $language['server']['country']; ?></strong></td>
					<td><?php echo country_check(2, $server->country_code); ?> <img src="template/images/locations/<?php echo $server->country_code; ?>.png" alt="<?php echo $server->country_code; ?>" /></td>
				</tr>
				<?php if(!empty($server->website)): ?>
				<tr>
					<td><span class="glyphicon glyphicon-link"></span> <strong><?php echo $language['forms']['server_website']; ?></strong></td>
					<td><a href="<?php echo $server->website; ?>"><?php echo $server->website; ?></a></td>
				</tr>
				<?php endif; ?>

				<tr>
					<td><i class="fa fa-users"></i> <strong><?php echo $language['server']['online_players']; ?></strong></td>
					<td><?php echo ($server->status) ? $server->online_players . '/' . $server->maximum_online_players : $language['server']['online_players_na']; ?></td>
				</tr>

				<?php if(!empty($server->hostname)): ?>
				<tr>
					<td><i class="fa fa-cloud"></i> <strong><?php echo $language['server']['hostname']; ?></strong></td>
					<td><?php echo $server->hostname; ?></td>
				</tr>
				<?php endif; ?>

				<?php if(!empty($server->map)): ?>
				<tr>
					<td><i class="fa fa-photo"></i> <strong><?php echo $language['server']['map']; ?></strong></td>
					<td><?php echo $server->map; ?></td>
				</tr>
				<?php endif; ?>

				<?php if(!empty($server->gametype)): ?>
				<tr>
					<td><i class="fa fa-gamepad"></i> <strong><?php echo $language['server']['gametype']; ?></strong></td>
					<td><?php echo $server->gametype; ?></td>
				</tr>
				<?php endif; ?>

				<?php if(!empty($server->password)): ?>
				<tr>
					<td><strong><?php echo $language['server']['password']; ?></strong></td>
					<td><?php echo ($server->password) ? '<i class="fa fa-lock"></i>' : '<i class="fa fa-unlock"></i>'; ?></td>
				</tr>
				<?php endif; ?>

				<?php if(!empty($server->joinlink)): ?>
				<tr>
					<td><i class="fa fa-users"></i> <strong><?php echo $language['server']['joinlink']; ?></strong></td>
					<td><i class="fa fa-steam-square" aria-hidden="true"></i> <a href="<?php echo $server->joinlink; ?>"><?php echo $server->name; ?></a></td>
				</tr>
				<?php endif; ?>


				<?php if(Plugin::get('uptime', 'display-on-server.php')) include_once Plugin::get('uptime', 'display-on-server.php'); ?>
			</tbody>
		</table>

	</div>
</div>

<?php if(!empty($settings->server_ads)) { ?>
	<div class="center">
		<?php echo $settings->server_ads; ?>
	</div>
<?php } ?>

<?php if($server->status && !empty($server->players)): ?>
<hr class="custom-one" />

<div class="panel panel-default">
	<div class="panel-heading">
		<i class="fa fa-users"></i> <?php echo $language['server']['players_list']; ?>
	</div>
	<div class="panel-body">
		<table id="players" class="table table-condensed">
			<thead>
				<th><?php echo $language['server']['players_name']; ?></th>
				<th><?php echo $language['server']['players_score']; ?></th>
			</thead>
			<tbody>
			<?php foreach($server->players as $player): ?>
				<tr>
					<td><?php echo $player['gq_name']; ?></td>
					<td><?php echo $player['gq_score']; ?></td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<?php endif; ?>

<hr class="custom-one" />

<!-- Video -->
<?php if(!empty($server->youtube_id)) { ?>

	<div class="panel panel-default">
		<div class="panel-body">
			<div class="video-container">
				<?php echo youtube_convert($server->youtube_id); ?>
			</div>
		</div>
	</div>

	<hr class="custom-one" />
<?php } ?>

<h3><?php echo $language['misc']['share_server_header']; ?></h3>
<p><?php echo $language['misc']['share_server_text']; ?></p>
<div>
	<span class='st_sharethis_large' displayText='ShareThis'></span>
	<span class='st_facebook_large' displayText='Facebook'></span>
	<span class='st_twitter_large' displayText='Tweet'></span>
	<span class='st_googleplus_large' displayText='Google +'></span>
	<span class='st_tumblr_large' displayText='Tumblr'></span>
	<span class='st_pinterest_large' displayText='Pinterest'></span>
	<span class='st_email_large' displayText='Email'></span>
</div>
<br />

<hr class="custom-one" />


<h3><?php echo $language['misc']['banners_header']; ?></h3>
<p><?php echo $language['misc']['banners_text']; ?></p>
<img id="live_banner" src="banner/<?php echo $server->server_id; ?>/default/ffffff/ffffff/medium" class="img-responsive" />





<!-- Comments -->
<hr class="custom-one" />

<h3>
	<i class="fa fa-users"></i> <?php echo $language['server']['comments']; ?>

	<span class="pull-right">
		<a data-toggle="modal" data-target="#comment">
			<button type="button" class="btn btn-info btn-sm btn-smsm"><span class="glyphicon glyphicon-plus"></span> <?php echo $language['server']['comment']; ?></button>
		</a>
	</span>
</h3>

<div id="comments"></div>


<hr class="custom-one" />

<?php
include 'template/includes/widgets/server_options.php';

?>
<script>

$(document).ready(function() {

	/* Spoiler handling */
	var $revealPlaceHolder = $('<span class="revealPlaceHolder"> Reveal <i class="fa fa-eye" aria-hidden="true"></i> <span>');

	$('.spoiler').addClass('hidden').before($revealPlaceHolder);

	$('.revealPlaceHolder').click(function(){
		$(this).hide();
		$(this).next('.spoiler').removeClass('hidden');
	});

	/* Load the first comments results */
	showMore(0, 'processing/comments_show_more.php', '#comments', '#showMoreComments');

	/* Vote button */
	$('#vote').on('click', function() {
        if(!$(this).find('button').attr('disabled')) {

            /* Post and get response */
            $.post('processing/process_votes.php', function (data) {
                $('html, body').animate({scrollTop: 0}, 'slow');
                var result = JSON.parse(data);

                /* Display success message */
                $('#response').html(result.message).fadeIn('slow');

                if (result.status) {

                    /* Increment the vote number */
                    $('#votes_value').text(parseInt($('#votes_value').text()) + 1);

                }

                setTimeout(function () {
                    $('#response').fadeOut('slow');
                }, 5000);

            });

            $(this).find('button').attr('disabled', 'true');

        }
	});

	$('#players').DataTable();

});
</script>
