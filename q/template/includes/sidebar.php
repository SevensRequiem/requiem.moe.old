<?php

if(isset($_GET['page']) && (($_GET['page'] == 'category' && $category_exists) || $_GET['page'] == 'servers')) {
	include 'widgets/servers_filter.php';
	include 'widgets/categories.php';
}

if((isset($_GET['page']) && $_GET['page'] != 'server') && Plugin::get('bump', 'widget.php')) include_once Plugin::get('bump', 'widget.php');

if(User::logged_in() && User::get_servers($account_user_id) && (isset($_GET['page']) && $_GET['page'] != 'server') && Plugin::get('my-servers', 'widget.php')) include_once Plugin::get('my-servers', 'widget.php');

if((isset($_GET['page']) && $_GET['page'] != 'server') && Plugin::get('latest-servers', 'widget.php')) include_once Plugin::get('latest-servers', 'widget.php');

if(!empty($settings->side_ads)) echo $settings->side_ads;
?>
