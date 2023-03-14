<?php
User::check_permission(1);

initiate_html_columns();

?>

<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Status</th>
				<th>IP Address</th>
				<th>Connection Port</th>
				<th>Query Port</th>
				<th>Game</th>
				<th>Date Added</th>
				<th>Edit Server</th>
			</tr>
		</thead>
		<tbody id="results">
			
		</tbody>
	</table>
</div>

<script>
$(document).ready(function() {
	/* Load first answers */
	showMore(0, 'processing/admin_servers_show_more.php', '#results', '#showMoreServers');
});
</script>