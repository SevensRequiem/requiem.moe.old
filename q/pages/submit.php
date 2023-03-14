<?php
if(!$settings->guest_submit) User::check_permission(0);

$address = $query_address = $name = $country_code = $youtube_link = $website = $description = null;
$connection_port = $query_port = '';

if(!empty($_POST)) {

	/* Define some variables */
	$address = filter_var($_POST['address'], FILTER_SANITIZE_STRING);
	$query_address = $address;
	$connection_port = (int) $_POST['connection_port'];
	$query_port = (!empty($_POST['query_port'])) ? $_POST['query_port'] : 0;
	$date = new DateTime();
	$date = $date->format('Y-m-d H:i:s');

	if(User::logged_in()) {
		$private = ($settings->new_servers_visibility) ? '0' : '1';
		$active = $status = '1';
	} else {
		$account_user_id = 0;
		$private = 0;
		$status = '1';
		$active = ($settings->new_guest_servers_status) ? '1' : '0';
	}

	$name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
	$country_code = (country_check(0, $_POST['country_code'])) ? $_POST['country_code'] : 'US';
	$youtube_link = filter_var($_POST['youtube_id'], FILTER_SANITIZE_STRING);
	$youtube_id = youtube_url_to_id($youtube_link);
	$website = filter_var($_POST['website'], FILTER_VALIDATE_URL);
	$description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);

	$recaptcha = new \ReCaptcha\ReCaptcha($settings->private_key);
	$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
	$required_fields = array('address', 'connection_port', 'name');



	/* Establish the vars needed for the library */
	$type = (isset($_POST['type'])) ? filter_var($_POST['type'], FILTER_SANITIZE_STRING) : false;

	/* SRV Checking if the game is minecraft */
	if($type == 'minecraft') {
		if(Plugin::get('srv-support', 'submit-replacer.php')) include_once Plugin::get('srv-support', 'submit-replacer.php');
	}

	$host = $query_address . ':' . $connection_port;


	/* Query with GameQ */
	try {
		$GameQ = new \GameQ\GameQ();
		$GameQ->addServer([
			'type' => $type,
			'host' => $host,
			'options' => [
				'query_port' => $query_port
			]
		]);
		$GameQ->setOption('timeout', 3);
		$query = $GameQ->process();

		if(!isset($query['gq_online']) || !$query['gq_online']) {
			$_SESSION['error'][] = $language['errors']['server_offline'];
		}

	} catch(Exception $e) {
		$_SESSION['error'][] = $e->getMessage();
	}


	/* Check for the required fields */
	foreach($_POST as $key=>$value) {
		if(empty($value) && in_array($key, $required_fields) == true) {
			$_SESSION['error'][] = $language['errors']['marked_fields_empty'];
			break 1;
		}
	}


	/* More checks */
	if(!$resp->isSuccess()) {
		$_SESSION['error'][] = $language['errors']['captcha_not_valid'];
	}
	if(strlen($name) > 64 || strlen($name) < 3) {
		$_SESSION['error'][] = $language['errors']['server_name_length'];
	}
	if(strlen($description) > 2560) {
		$_SESSION['error'][] = $language['errors']['description_too_long'];
	}
	if(Database::exists('server_id', 'servers', ['address' => $address, 'connection_port' => $connection_port])) {
		$_SESSION['error'][] = $language['errors']['server_already_exists'];
	}


	/* If there are no errors, add the server to the database */
	if(empty($_SESSION['error'])) {


		/* Add the server to the database as private */
		$stmt = $database->prepare("INSERT INTO `servers` (`user_id`, `type`, `address`, `connection_port`, `query_port`, `private`, `active`, `status`, `date_added`, `name`, `country_code`, `youtube_id`, `website`, `description`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$stmt->bind_param('ssssssssssssss',  $account_user_id, $type, $address, $connection_port, $query_port, $private, $active, $status, $date, $name, $country_code, $youtube_id, $website, $description);
		$stmt->execute();
		echo $database->error . $stmt->error;
		$stmt->close();

		/* Set the success message and redirect */
		if($active == '1') {
			$_SESSION['success'][] = $language['messages']['server_added'];
		} else {
			$_SESSION['success'][] = $language['messages']['server_added_inactive'];
		}

		if(!$settings->guest_submit)
			redirect('my-servers');
		else
			redirect('servers');
	}

display_notifications();

}


initiate_html_columns();

?>


<h3><?php echo $language['headers']['submit']; ?></h3>



<form action="" method="post" role="form" enctype="multipart/form-data">

	<div class="form-group">
		<label><?php echo $language['forms']['type']; ?> *</label>
		<select name="type" class="form-control" id="type" required="required">
			<option value="" selected="true" disabled="">--</option>
			<option value="arkse" data-port="21000">ARK: Survival Evolved</option>
			<option value="cs16" data-port="27015">Counter-Strike 1.6</option>
			<option value="czero" data-port="27015">Counter-Strike: Condition Zero</option>
			<option value="csgo" data-port="27015">Counter-Strike: Global Offensive</option>
			<option value="css" data-port="27015">Counter-Strike: Source</option>
			<option value="minecraft" data-port="25565">Minecraft</option>
			<option value="rust" data-port="27015">Rust</option>
			<option value="samp" data-port="7777">San Andreas Multiplayer</option>
			<option value="spaceengineers" data-port="27015">Space Engineers</option>
			<option value="teamspeak2" data-port="9987">TeamSpeak 2</option>
			<option value="teamspeak3" data-port="9987">TeamSpeak 3</option>
			<option value="terraria" data-port="7777">Terraria</option>
			<option value="starbound" data-port="21025">Starbound</option>
			<option value="starmade" data-port="4242">Starmade</option>
			<option value="unturned" data-port="27015">Unturned</option>
			<option value="dayz" data-port="2302">DayZ</option>
			<option value="dayzmod" data-port="2302">DayZ Mod</option>
			<option value="tf2" data-port="27015">Team Fortress 2</option>
			<option value="arma2" data-port="2302">ARMA 2</option>
			<option value="arma3" data-port="2302">ARMA 3</option>
			<option value="bf2" data-port="19567">Battlefield 2</option>
			<option value="bf3" data-port="19567">Battlefield 3</option>
			<option value="bf4" data-port="30000">Battlefield 4</option>
			<option value="bfh" data-port="19567">Battlefield Hardline</option>
			<option value="bf1942" data-port="">Battlefield 1942</option>
			<option value="bfbc2" data-port="">Battlefield Bad Company 2</option>

			<option value="cod2" data-port="28960">Call Of Duty 2</option>
			<option value="cod4" data-port="28960">Call Of Duty 4</option>
			<option value="codmw3" data-port="27015">Call Of Duty: Modern Warfare 3</option>
			<option value="gmod" data-port="27015">Garry's Mod</option>

			<option value="conanexiles" data-port="">Conan Exiles</option>
			<option value="dod" data-port="">Day of Defeat</option>
			<option value="dods" data-port="">Day of Defeat: Source</option>
			<option value="ffow" data-port="">Frontlines Fuel of War</option>
			<option value="ffe" data-port="">Fortress Forever</option>
			<option value="grav" data-port="">GRAV Online</option>
			<option value="hl2dm" data-port="">Half Life 2: Deathmatch</option>
			<option value="insurgency" data-port="">Insurgency</option>
			<option value="l4d" data-port="">Left 4 Dead</option>
			<option value="l4d2" data-port="">Left 4 Dead2 </option>
			<option value="lhmp" data-port="">Lost Heaven</option>
			<option value="mta" data-port="">Multi Theft Auto</option>
			<option value="mumble" data-port="">Mumble Server</option>
			<option value="ns2" data-port="">Natural Selection 2</option>
			<option value="quake2" data-port="">Quake 2</option>
			<option value="quake3" data-port="">Quake 3</option>
			<option value="quakelive" data-port="">Quake Live</option>
			<option value="redorchestra2" data-port="">Red orchestra 2</option>
			<option value="sevendaystodie" data-port="">Seven Days to Die</option>
			<option value="ship" data-port="">The Ship</option>
			<option value="squad" data-port="">Squad</option>
			<option value="teeworlds" data-port="">Teeworlds Server</option>
			<option value="ventrilio" data-port="">Ventrilio</option>
			<option value="warsow" data-port="">Warsow</option>
			<option value="won" data-port="">World Opponent Network</option>
			<option value="wurm" data-port="">Wurm Unlimited</option>

			<option value="medievalengineers" data-port="27015">Medieval Engineers</option>
		</select>
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_address']; ?> *</label>
		<input type="text" name="address" class="form-control" value="<?php echo $address; ?>" required="required" />
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_connection_port']; ?> *</label>
		<p class="help-block"><?php echo $language['forms']['server_connection_port_help']; ?></p>
		<input type="text" name="connection_port" id="connection_port" class="form-control" value="<?php echo $connection_port; ?>" required="required" />
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_query_port']; ?></label>
		<p class="help-block"><?php echo $language['forms']['server_query_port_help']; ?></p>
		<input type="text" name="query_port" class="form-control" value="<?php echo $query_port; ?>" />
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_name']; ?> *</label>
		<input type="text" name="name" class="form-control" value="<?php echo $name; ?>" required="required" />
	</div>

	<hr class="custom-one" />

	<div class="form-group">
		<label><?php echo $language['forms']['server_country']; ?></label>
		<select name="country_code" class="form-control">
			<?php country_check(1, $country_code); ?>
		</select>
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_youtube_id']; ?></label>
		<p class="help-block"><?php echo $language['forms']['server_youtube_id_help']; ?></p>
		<input type="text" name="youtube_id" class="form-control" value="<?php echo $youtube_link; ?>" />
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_website']; ?></label>
		<input type="text" name="website" class="form-control" value="<?php echo $website; ?>"/>
	</div>

	<div class="form-group">
		<label><?php echo $language['forms']['server_description']; ?></label>
		<p class="help-block"><?php echo $language['forms']['server_description_help']; ?></p>
		<textarea name="description" class="form-control" rows="6"><?php echo $description; ?></textarea>
	</div>

	<div class="form-group">
		<div class="g-recaptcha" data-sitekey="<?php echo $settings->public_key; ?>"></div>
	</div>

	<div class="form-group">
		<button type="submit" name="submit" class="btn btn-default col-lg-4"><?php echo $language['forms']['submit']; ?></button><br /><br />
	</div>

</form>

<script>
	$(document).ready(function() {
		$('#type').on('change', function() {
			var port = $(this).find(":selected").data('port');
			console.log(port);
			$('#connection_port').attr('value', port);
		});
	});
</script>