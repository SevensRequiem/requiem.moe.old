<?php
User::check_permission(1);

if(isset($_GET['status']) && Plugin::exists($_GET['status'])) {
	$_SESSION['info'][] = 'This feature is not yet implemented, please edit the config file of the plugin manually.';
	redirect('admin/plugins');
}

display_notifications();

initiate_html_columns();
?>
<h3><?php echo $language['headers']['plugins']; ?></h3>

<div class="row">
	<?php foreach(Plugin::$plugins as $plugin_name => $plugin): ?>
	<div class="col-sm-6">
		<h4><?php echo $plugin['title']; ?></h4>
		<p class="no-margin"><strong><?php echo $language['misc']['plugins_author']; ?></strong> <a href="<?php echo $plugin['url']; ?>"><?php echo $plugin['title']; ?></a></p>
		<p class="no-margin"><strong><?php echo $language['misc']['plugins_version']; ?></strong> <?php echo $plugin['version']; ?></p>
		<p class="no-margin"><strong><?php echo $language['misc']['plugins_status']; ?></strong> 
			<a href="admin/plugins/<?php echo $plugin_name; ?>"><?php echo $plugin['active'] ? $language['misc']['plugins_status_active'] : $language['misc']['plugins_status_inactive']; ?></a>
		</p>
	</div>
	<?php endforeach; ?>
</div>
