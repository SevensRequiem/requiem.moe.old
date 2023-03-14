<?php
User::check_permission(1);

initiate_html_columns();

?>

<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
				<th>Type</th>
				<th>Email</th>
				<th>Reported Id</th>
				<th>Date</th>
				<th>View report</th>
			</tr>
		</thead>
		<tbody id="results">
			
		</tbody>
	</table>
</div>

<script>
$(document).ready(function() {
	/* Load first answers */
	showMore(0, 'processing/admin_reports_show_more.php', '#results', '#showMoreReports');
});
</script>