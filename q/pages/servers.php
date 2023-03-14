<?php  initiate_html_columns();

/* Get servers stats */
$stats = $database->query("SELECT SUM(`online_players`) AS `total_online_players`, COUNT(`server_id`) AS `total_servers` FROM `servers` WHERE `status` = 1 AND `private` = 0 AND `active` = 1")->fetch_object();


echo '<div class="servers-stats-container">';
echo sprintf($language['headers']['servers_stats'], $stats->total_online_players, $stats->total_servers);
echo $language['headers']['servers_stats_help'];
echo '</div>';

/* Initiate the servers list class */
$servers = new Servers;

/* Make it so it will display only the active and the servers which are not private */
$servers->additional_where("AND `private` = '0' AND `active` = '1' AND `highlight` = '1'");

/* Remove pagination */
$servers->remove_pagination();

/* Custom message */
$servers->no_servers = $language['messages']['no_premium_servers'];

/* Process the results */
$servers->process();

/* Try and display the server list */
$servers->display();

/* Display any notification if there are any ( no servers ) */
display_notifications();





/* Initiate the servers list class */
$servers = new Servers;

/* Make it so it will display only the active and the servers which are not private */
$servers->additional_where("AND `private` = '0' AND `active` = '1' AND `highlight` = '0'");

/* Set the current page */
$servers->set_current_page_link('servers');

/* Process the results */
$servers->process();

/* Display header and filters */
$servers->filters_display();


/* Try and display the server list */
$servers->display();


/* Display any notification if there are any ( no servers ) */
display_notifications();

/* Display the pagination if there are servers */
$servers->display_pagination();


?>

<script>
$(document).ready(function() {
    $('.counterUp').counterUp({
        delay: 10,
        time: 1000
    });
});
</script>
