<div class="sticky-footer-top">
	<div class="container">
		<div class="row">
			<div class="col-md-4 col-sm-4">
				<h4><?php echo $language['footer']['pages']; ?></h4>
				<ul class="list-unstyled">
					<?php
					$bottom_menu_result = $database->query("SELECT `url`, `title` FROM `pages`");

					while($bottom_menu = $bottom_menu_result->fetch_object()):
					?>
						<li><a href="page/<?php echo $bottom_menu->url; ?>"><?php echo $bottom_menu->title; ?></a></li>
					<?php endwhile; ?>
				</ul>
			</div>

			<div class="col-md-4 col-sm-4">
				<h4><?php echo $language['footer']['links']; ?></h4>
				<ul class="list-unstyled">
					<li><a href="">Edit</a></li>
					<li><a href="">these</a></li>
					<li><a href="">in the</a></li>
					<li><a href="">template/includes/footertop.php file</a></li>
				</ul>
			</div>

			<div class="col-md-4 col-sm-4">
				<h4><?php echo $language['footer']['new_servers']; ?></h4>
				<?php $result = $database->query("SELECT `server_id`, `name` FROM `servers` ORDER BY `server_id` DESC LIMIT 5"); ?>
				<ul class="list-unstyled">
					<?php while($server = $result->fetch_object()): ?>
						<li><a href="server/<?php echo $server->server_id; ?>" title="<?php echo $server->name; ?>"><?php echo string_resize($server->name, 26); ?></a></li>
					<?php endwhile; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
