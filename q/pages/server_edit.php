<?php
User::check_permission(0);

/* Get $server data from the database */
$server = Database::get('*', 'servers', ['server_id' => $_GET['server_id']]);


/* Check for any errors */
if(!$server) {
	$_SESSION['error'][] = $language['errors']['server_not_found'];
}
if($server->user_id != $account_user_id){
	$_SESSION['error'][] = $language['errors']['command_denied'];
}
if(!empty($_SESSION['error'])) User::get_back('my-servers');


if(isset($_GET['type']) && empty($_POST)) {

	/* Check if the token is valid */
	if(!$token->is_valid()) {
		$_SESSION['error'][] = $language['errors']['invalid_token'];
	}

	/* Check if there are no errors */
	if(empty($_SESSION['error'])) { 
		/* Set a success message */
		$_SESSION['success'][] = $language['messages']['success'];

		/* Check for the type of action */
		if($_GET['type'] == 'private') {
			$server->new_private = ($server->private) ? 0 : 1;
			$database->query("UPDATE `servers` SET `private` = {$server->new_private} WHERE `server_id` = {$server->server_id}");
		}

		if($_GET['type'] == 'delete') {
			Server::delete_server($server->server_id);
			redirect('my-servers');
		}

		/* Refresh the server data */
		$server = Database::get('*', 'servers', ['server_id' => $_GET['server_id']]);

	}

}

if(!empty($_POST)) {
	/* Define some variables */
	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
	$connection_port = (int) $_POST['connection_port'];
	$query_port = (int) $_POST['query_port'];
	$allowed_extensions = array('jpg', 'jpeg', 'gif');
	$country_code = (country_check(0, $_POST['country_code'])) ? $_POST['country_code'] : 'US';
	$youtube_id = youtube_url_to_id(filter_var($_POST['youtube_id'], FILTER_SANITIZE_STRING));
	$website = filter_var($_POST['website'], FILTER_VALIDATE_URL);
	$description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);


	/* Check for any errors */
	if(strlen($description) > 2560) {
		$_SESSION['error'][] = $language['errors']['description_too_long'];
	}
	if(strlen($name) > 64 || strlen($name) < 3) {
		$_SESSION['error'][] = $language['errors']['server_name_length'];
	}


	/* If there are no errors, proceed with the updating */
	if(empty($_SESSION['error'])) {

		$stmt = $database->prepare("UPDATE `servers` SET `name` = ?, `address` = ?, `connection_port` = ?, `query_port` = ?,   `country_code` = ?, `youtube_id` = ?, `website` = ?, `description` = ? WHERE `server_id` = {$server->server_id}");
		$stmt->bind_param('ssssssss', $name, $address, $connection_port, $query_port, $country_code, $youtube_id, $website, $description);
		$stmt->execute();

		/* Set a success message */
		$_SESSION['success'][] = $language['messages']['success'];

		/* Refresh the server data */
		$server = Database::get('*', 'servers', ['server_id' => $_GET['server_id']]);
	}
}

display_notifications();

initiate_html_columns();

?>

<h3><?php echo $language['headers']['edit_server'] . User::generate_go_back_button('my-servers'); ?></h3>

<form action="" method="post" role="form" enctype="multipart/form-data">
	<div class="form-group">
		<label><?php echo $language['forms']['server_status']; ?></label>
		<?php
		if($server->active) 
			echo '<span data-toggle="tooltip" title="' . $language['server']['status_active'] . '" class="glyphicon glyphicon-ok green tooltipz"></span>&nbsp;';
		else
			echo '<span data-toggle="tooltip" title="' . $language['server']['status_disabled'] . '" class="glyphicon glyphicon-remove red tooltipz"></span>&nbsp;';		
		if($server->highlight) echo '<span data-toggle="tooltip" title="' . $language['server']['status_highlighted'] . '" class="glyphicon glyphicon-star tooltipz"></span>&nbsp;';
		if($server->private) echo '<span data-toggle="tooltip" title="' . $language['server']['status_private'] . '" class="glyphicon glyphicon-off tooltipz"></span>';
		?>
	</div>
	<div class="form-group">
		<label><?php echo $language['forms']['server_name']; ?></label>
		<input type="text" name="name" class="form-control" value="<?php echo $server->name; ?>" />
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_address']; ?></label>
		<input type="text" name="address" class="form-control" value="<?php echo $server->address; ?>" />
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_connection_port']; ?></label>
		<input type="text" name="connection_port" class="form-control" value="<?php echo $server->connection_port; ?>" />
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_query_port']; ?></label>
		<input type="text" name="query_port" class="form-control" value="<?php echo $server->query_port; ?>" />
	</div>

	<h3><?php echo $language['headers']['edit_server_details']; ?></h3>



	<div class="form-group">
		<label><?php echo $language['forms']['server_date_added']; ?></label>
		<input type="text" class="form-control" value="<?php echo $server->date_added; ?>" disabled="true" />
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_country']; ?></label>
		<select name="country_code" class="form-control">
			<?php country_check(1, $server->country_code); ?>
		</select>
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_youtube_id']; ?></label>
		<p class="help-block"><?php echo $language['forms']['server_youtube_id_help']; ?></p>
		<input type="text" name="youtube_id" class="form-control" value="<?php echo $server->youtube_id; ?>" />
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_website']; ?></label>
		<input type="text" name="website" class="form-control" value="<?php echo $server->website; ?>" />
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_description']; ?></label>
		<p class="help-block"><?php echo $language['forms']['server_description_help']; ?></p>
		<textarea name="description" class="form-control" rows="6"><?php echo $server->description; ?></textarea>
	</div>


	<div class="form-group">
		<button type="submit" name="submit" class="btn btn-default"><?php echo $language['forms']['submit']; ?></button>

		<a href="edit-server/<?php echo $_GET['server_id']; ?>/private/<?php echo $token->hash; ?>" >
			<button type="button" class="btn btn-warning"><?php echo ($server->private) ? $language['forms']['server_remove_private'] : $language['forms']['server_make_private']; ?></button>
		</a>

		<a href="edit-server/<?php echo $_GET['server_id']; ?>/delete//<?php echo $token->hash; ?>" data-confirm="<?php echo $language['messages']['confirm_delete']; ?>">
			<button type="button" class="btn btn-danger"><?php echo $language['forms']['server_delete']; ?></button>
		</a>

		<br /><br />
	</div>
</form>