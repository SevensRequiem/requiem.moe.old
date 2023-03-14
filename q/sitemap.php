<?php
header('Content-type: text/xml');

include 'core/init.php';


?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

	<url>
		<loc><?php echo $settings->url . 'index'; ?></loc>
	</url>

	<url>
		<loc><?php echo $settings->url . 'login'; ?></loc>
	</url>

	<url>
		<loc><?php echo $settings->url . 'register'; ?></loc>
	</url>

	<url>
		<loc><?php echo $settings->url . 'lost-password'; ?></loc>
	</url>

	<url>
		<loc><?php echo $settings->url . 'resend-activation'; ?></loc>
	</url>

	<url>
		<loc><?php echo $settings->url . 'servers'; ?></loc>
	</url>

	<?php
	$result = $database->query("SELECT `server_id` FROM `servers` WHERE `active` = '1' AND `private` = '0'");
	while($server = $result->fetch_object()){
	?>
	
	<url>
		<loc><?php echo $settings->url . 'server/' . $server->server_id; ?></loc>
	</url>

	<?php }	?>



</urlset> 