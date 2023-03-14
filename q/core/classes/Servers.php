<?php

class Servers {
	private $order_by;
	private $additional_join = null;
	private $where;

	public $pagination;
	public $server_results;
	public $affix;
	public $country_options;
	public $game_options;
	public $no_servers;
	public $result;

	public function __construct() {
		global $database;
		global $settings;
		global $language;

		/* Initiate the affix and start generating it */
		$this->affix = '';

		/* Order by system */
		$order_by_options = array('online_players', 'votes', 'favorites', 'server_id');
		$order_by_column = (isset($_GET['order_by']) && in_array(strtolower($_GET['order_by']), $order_by_options)) ? strtolower($_GET['order_by']) : false;
		$this->order_by = 'ORDER BY `servers`.`highlight` DESC, ';
		$this->order_by .= ($order_by_column !== false) ? '`servers`.`' . $order_by_column . '` DESC' : '`servers`.`votes` DESC';
		$this->affix .= ($order_by_column !== false) ? '&order_by=' . $order_by_column : '';

		/* Filtering system */

		/* Process $_GET filters, build the affix */
		$highlight_options = array(0, 1);
		$highlight_value = (isset($_GET['filter_highlight']) && in_array($_GET['filter_highlight'], $highlight_options)) ? (int) $_GET['filter_highlight'] : false;
		$highlight_where = ($highlight_value !== false) ? 'AND `servers`.`highlight` = ' . $highlight_value : null;
		$this->affix .= ($highlight_value !== false) ? '&filter_highlight=' . $highlight_value : '';

		$status_options = array(0, 1);
		$status_value = (isset($_GET['filter_status']) && in_array($_GET['filter_status'], $status_options)) ? (int) $_GET['filter_status'] : false;
		$status_where = ($status_value !== false) ? 'AND `servers`.`status` = ' . $status_value : null;
		$this->affix .= ($status_value !== false) ? '&filter_status=' . $status_value : '';

		/* The default status filtering ( when there are no status filter active ) */
		$default_status_where = (!$status_value && !$settings->display_offline_servers) ? 'AND `servers` . `status` = \'1\'' : null;

		/* Add the possible countries from the database into an array */
		$result = $database->query("SELECT DISTINCT `country_code` FROM `servers`");
		$this->country_options = array();
		while($country_code = $result->fetch_object()) $this->country_options[] = $country_code->country_code;

		/* Processing again */
		$country_value = (isset($_GET['filter_country']) && in_array($_GET['filter_country'], $this->country_options)) ? $_GET['filter_country'] : false;
		$country_where = ($country_value !== false) ? 'AND `servers`.`country_code` = \'' . $country_value . '\'' : null;
		$this->affix .= ($country_value !== false) ? '&filter_country=' . $country_value : '';

		/* Add the possible server versions into an array */
		$result = $database->query("SELECT DISTINCT `type` FROM `servers` WHERE `type` IS NOT NULL AND `private` = '0' AND `active` = '1'");
		$this->game_options = array();
		while($game = $result->fetch_object()) $this->game_options[] = $game->type;

		/* Processing again */
		$game_value = (isset($_GET['filter_game']) && in_array($_GET['filter_game'], $this->game_options)) ? $_GET['filter_game'] : false;
		$game_where = ($game_value !== false) ? 'AND `servers`.`type` = \'' . $game_value . '\'' : null;
		$this->affix .= ($game_value !== false) ? '&filter_version=' . $game_value : '';

		/* If affix isn't empty prepend the ? sign so it can be processed */
		$this->affix = (!empty($this->affix)) ? '?' . $this->affix : null;

		/* Create the maine $where variable */
		$this->where = "WHERE 1=1 {$default_status_where} {$highlight_where} {$status_where} {$country_where} {$game_where}";

		/* Generate pagination */
		$this->pagination = new Pagination($settings->servers_pagination, $this->where);

		/* Set the default no servers message */
		$this->no_servers = $language['messages']['no_servers'];

	}

	public function additional_where($where) {
		global $settings;

		/* Remake the where with the additional condition */
		$this->where = $this->where . ' ' . $where;

		/* Remake the pagination */
		$this->pagination = new Pagination($settings->servers_pagination, $this->where);

	}

	public function additional_join($join) {
		global $settings;

		/* This is mainly so we can gather the data based on the favorite servers */
		$this->additional_join = $join;

		/* Remake the pagination with the true condition so it counts the servers correctly */
		$this->pagination = new Pagination($settings->servers_pagination, $this->where, true);

	}

	public function remove_pagination() {

		/* Make the pagination null */
		$this->pagination->limit = null;

	}

	public function process() {
		global $database;

		/* Retrieve servers information */
		$this->result = $database->query("SELECT * FROM `servers` {$this->additional_join} {$this->where} {$this->order_by} {$this->pagination->limit}");

		$this->server_results = $this->result->num_rows;
	}

	public function display() {
		global $database;
		global $language;
		global $settings;
		global $account_user_id;

		/* Quickly verify the remaining of highlighted days remaining */
		$database->query("UPDATE `servers` JOIN `payments` ON `servers`.`server_id` = `payments`.`server_id` SET `servers`.`highlight` = '0' WHERE `payments`.`date` + INTERVAL `payments`.`highlighted_days` DAY < CURDATE()");

		if(Plugin::get('bidding-system', 'update-servers.php')) include_once Plugin::get('bidding-system', 'update-servers.php');


		/* Check if there is any result */
		if($this->server_results < 1) $_SESSION['info'][] = $this->no_servers;

		/* Fucking ranking logic. */
		$rank = 1;
		if($this->pagination->current_page > 1)
			$rank = $this->pagination->current_page * $settings->servers_pagination - $settings->servers_pagination + 1;


		?>

		<table class="table table-responsive table-striped">
			<thead>
				<tr>
					<th style="width: 5%;"><i class="fa fa-line-chart" aria-hidden="true"></i></th>
					<th style="width: 5%;"><i class="fa fa-signal" aria-hidden="true"></i></th>
					<th style="width: 35%;"><i class="fa fa-tags" aria-hidden="true"></i> Name</th>
					<th style="width: 35%;"><i class="fa fa-random" aria-hidden="true"></i> Address</th>
					<th style="width: 5%;"><i class="fa fa-users" aria-hidden="true"></i></th>
					<th style="width: 15%;"><i class="fa fa-terminal" aria-hidden="true"></i> Other</th>
				</tr>
			</thead>

			<tbody>
		<?php
		/* Display the servers */
		while($server = $this->result->fetch_object()) {


		/* Store the status into a variable */
		$server->status_text = ($server->status) ? $language['server']['status_online'] : $language['server']['status_offline'];

		/* Percentage */
		$progress_percentage = ($server->online_players > 0) ? ceil(($server->online_players * 100) / $server->maximum_online_players) : 0;
		?>

		<tr>
			<td>
				<?php echo ($server->highlight) ? '<i class="fa fa-star" style="color: #ffc000;" />' : '#<span style="font-style: italic;font-weight: bold;font-size: 16px;">' . $rank . '</span>'; ?>
			</td>
			<td>
				<span class="tag tag-<?php echo ($server->status) ? 'online':'offline' ?>">
					<?php
					echo ($server->status) ?
					'<i class="fa fa-check tooltipz" title="' . $language['server']['status_online'] . '"></i>' :'<i class="fa fa-remove tooltipz" title="' . $language['server']['status_offline'] . '"></i>'
					?>
				</span>
			</td>
			<td>
				<a href="server/<?php echo $server->server_id; ?>">
					<?php echo $server->name; ?>
				</a>
			</td>
			<td>
				<?php echo $server->address . ":" . $server->connection_port; ?>
				<?php if(User::logged_in() && $server->user_id == $account_user_id): ?>
					<a href="edit-server/<?php echo $server->server_id; ?>">
						<span href="#" data-toggle="tooltip" title="<?php echo $language['server']['edit']; ?>" class="tag tooltipz">
							<i class="fa fa-wrench"></i>
						</span>
					</a>
				<?php endif; ?>
			</td>
			<td>
				<?php echo $server->online_players . '/' . $server->maximum_online_players; ?>
				<div class="progress server-progress">
					<div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="<?php echo $server->online_players; ?>" aria-valuemin="0" aria-valuemax="<?php echo $server->maximum_online_players; ?>" style="width: <?php echo $progress_percentage; ?>%">
					</div>
				</div>
			</td>
			<td>
				<span href="#" data-toggle="tooltip" title="<?php echo country_check(2, $server->country_code); ?>" class="tag tooltipz">
					<img src="<?php echo get_country_image($server->country_code); ?>" />
				</span>

				<span href="#" data-toggle="tooltip" title="<?php echo $server->type; ?>" class="tag tooltipz">
					<img src="<?php echo get_game_image($server->type); ?>" />
				</span>
			</td>
		</tr>




		<?php if(!$server->highlight) $rank++; } ?>
		</tbody>
	</table>
	<?php
	}

	public function display_pagination() {

		/* If there are results, display pagination */
		if($this->server_results > 0) {

			/* Display */
			$this->pagination->display($this->affix);
		}
	}

	public function set_current_page_link($current_page) {
		/* Establish the current page link */
		$this->pagination->set_current_page_link($current_page);
	}


	public function filters_display() {
		global $language;
		global $database;

		if($this->server_results > 0) {

			/* Generating the link again for every filter so it doesn't mess the url */
			$order_by_link = (isset($_GET['order_by'])) ? preg_replace('/&order_by=[A-Za-z0-9_]+/', '', $this->affix) : $this->affix;
			$filter_highlight = (isset($_GET['filter_highlight'])) ? preg_replace('/&filter_highlight=[01]+/', '', $this->affix) : $this->affix;
			$filter_status = (isset($_GET['filter_status'])) ? preg_replace('/&filter_status=[01]+/', '', $this->affix) : $this->affix;
			$filter_country = (isset($_GET['filter_country'])) ? preg_replace('/&filter_country=[A-Za-z]+/', '', $this->affix) : $this->affix;
			$filter_game = (isset($_GET['filter_game'])) ? preg_replace('/&filter_game=[A-Za-z]+/', '', $this->affix) : $this->affix;
		?>
            <div class="filters-container">
                <h3><?php echo $language['misc']['filters_header']; ?></h3>
                <h4 class="filter-text">
                    <?php echo $language['misc']['filters_header2']; ?>
                    <span class="dropdown">
                        <a class="dropdown-toggle filter-button" data-toggle="dropdown" href="#"><?php echo $language['misc']['order_by']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $this->pagination->link . $order_by_link . '&order_by=online_players' ?>"><?php echo $language['misc']['order_by_players']; ?></a></li>
                            <li><a href="<?php echo $this->pagination->link . $order_by_link . '&order_by=votes' ?>"><?php echo $language['misc']['order_by_votes']; ?></a></li>
                            <li><a href="<?php echo $this->pagination->link . $order_by_link . '&order_by=favorites' ?>"><?php echo $language['misc']['order_by_favorites']; ?></a></li>
                            <li><a href="<?php echo $this->pagination->link . $order_by_link . '&order_by=server_id' ?>"><?php echo $language['misc']['order_by_latest']; ?></a></li>
                        </ul>
                    </span>
                    <?php echo $language['misc']['filters_header3']; ?>

                    <span class="dropdown">
                        <a class="dropdown-toggle filter-button" data-toggle="dropdown" href="#"><?php echo $language['misc']['filter_status']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?php echo $this->pagination->link . $filter_status . '&filter_status=1' ?>"><?php echo $language['misc']['filter_online']; ?></a></li>
                            <li><a href="<?php echo $this->pagination->link . $filter_status . '&filter_status=0' ?>"><?php echo $language['misc']['filter_offline']; ?></a></li>
                        </ul>
                    </span>
                    <?php echo $language['misc']['filters_header4']; ?>
                    <span class="dropdown">
                        <a class="dropdown-toggle filter-button" data-toggle="dropdown" href="#"><?php echo $language['misc']['filter_country']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php foreach($this->country_options as $country) { echo '<li><a href="' . $this->pagination->link . $filter_country . '&filter_country=' . $country . '">' . country_check(2, $country) . '</a></li>'; } ?>
                        </ul>
                    </span>
                    <?php echo $language['misc']['filters_header4']; ?>
                    <span class="dropdown">
                        <a class="dropdown-toggle filter-button" data-toggle="dropdown" href="#"><?php echo $language['misc']['filter_game']; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php foreach($this->game_options as $game) { echo '<li><a href="' . $this->pagination->link . $filter_game . '&filter_game=' . $game . '">' . $game . '</a></li>'; } ?>
                        </ul>
                    </span>
                </h4>

                <?php if(!empty($this->affix)) { ?>
                    <h5><?php echo sprintf($language['misc']['reset_filters'], $this->pagination->link); ?></a></h5>
                <?php } ?>
            </div>
		<?php
		}
	}

	public static function total_servers($highlighted = true) {
		global $database;

		$highlight_where = ($highlighted) ? 'WHERE `highlight` = 1' : null;
		$stmt = $database->prepare("SELECT COUNT(`user_id`) FROM `servers` {$highlight_where}");
		$stmt->execute();
		$stmt->bind_result($result);
		$stmt->fetch();
		$stmt->close();

		return $result;
	}

}
?>
