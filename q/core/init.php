<?php
// VERSION 1.3.1
ob_start();
session_start();

const DEBUG = 0;

if(DEBUG) {
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
} else {
	error_reporting(0);
}


define('ROOT', realpath(__DIR__ . '/..'));

include 'classes/Database.php';
include 'database/connect.php';
include 'functions/language.php';
include 'functions/general.php';
include 'classes/User.php';
include 'classes/Pagination.php';
include 'classes/Server.php';
include 'classes/Servers.php';
include 'classes/Csrf.php';
include 'classes/Plugin.php';
include 'classes/PHPMailer/PHPMailerAutoload.php';
include 'libraries/GameQ/Autoloader.php';
include 'libraries/ReCaptcha/autoload.php';

/* Plugins System */
Plugin::init();
foreach(Plugin::$auto_files as $file) include $file;

/* Initialize variables */
$errors 	= array();
$settings 	= settings_data();
$token 		= new CsrfProtection();
$no_panel_pages = array('my_favorites', 'bid', 'admin_auctions_management', 'my_servers', 'servers', 'server', 'profile', 'admin_categories_management', 'category');


/* Set the default timezone if its not set in the ini file */
$date_timezone = ini_get('date.timezone');
if(empty($date_timezone))
	date_default_timezone_set('UTC');

/* Paging */
$pages = glob('pages/' . '*.php');
$pages = preg_replace('(pages/|.php)', '', $pages);
$_GET['page'] = (isset($_GET['page'])) ? htmlspecialchars($_GET['page'], ENT_QUOTES) : 'index';


/* If user is logged in get his data */
if(User::logged_in()) {
	$account_user_id = (isset($_SESSION['user_id']) == true) ? $_SESSION['user_id'] : $_COOKIE['user_id'];
	$account = Database::get('*', 'users', ['user_id' => $account_user_id]);

	/* Update last activity */
	$database->query("UPDATE `users` SET `last_activity` = unix_timestamp() WHERE `user_id` = {$account_user_id}");
}


/* Get server data if needed */
if(!empty($_GET['server_id']) && ($_GET['page'] == 'server' || $_GET['page'] == 'server_statistics' || $_GET['page'] == 'server_banners' || $_GET['page'] == 'server_details' || $_GET['page'] == 'server_blog')) {
	$server = Server::get($_GET['server_id']);
	if($server->exists) $_SESSION['server_id'] = $server->server_id;

	/* Check if server exists and the GET variables are not empty */
	if(empty($_GET['server_id']) || !$server->exists) {
		$_SESSION['error'][] = $language['errors']['server_not_found'];
	} else {

		/* Check if server is disabled */
		if(!$server->active) {
			$_SESSION['error'][] = $language['errors']['server_not_active'];
		}

		if(
			($server->private && !User::logged_in()) ||
			($server->private && User::logged_in() && $account_user_id != $server->user_id)
		) {
			/* Set error message and redirect */
			$_SESSION['error'][] = $language['errors']['server_private'];
		}

	}


}

/* Get profile data if needed */
if(!empty($_GET['user_id']) && $_GET['page'] == 'profile') {
	/* Fetch the users data & Set a session with the profile id for the form */
	$_SESSION['profile_user_id'] = $profile_user_id = (int) $_GET['user_id'];

	/* Get user data */
	$profile_account = Database::get('*', 'users', ['user_id' => $profile_user_id]);

	/* Check if user exists */
	$user_exists = ($profile_account !== NULL);


}


/* If page is custom page */
if(!empty($_GET['url']) && $_GET['page'] == 'page') {
	/* Get the custom page url parameter */
	$custom_page_url = (isset($_GET['url'])) ? Database::clean_string($_GET['url']) : false;

	/* If the custom page url is set then try to get data from the database */
	$custom_page = ($custom_page_url) ? Database::get('*', 'pages', ['url' => $custom_page_url]) : false;

	/* Redirect if the page does not exist */
	if(!$custom_page) {
		$_SESSION['info'][] = $language['errors']['invalid_page'];
		redirect();
	}
}


include 'functions/titles.php';

?>
