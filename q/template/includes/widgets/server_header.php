<div id="response" style="display:none;"></div>

<h3 class="no-margin">
    <?php if($server->status)
        echo '<span class="glyphicon glyphicon-ok green tooltipz" title="'.$language['server']['status_online'].'" style="font-size: 20px;"></span> ';
    else
        echo '<span class="glyphicon glyphicon-remove red tooltipz" title="'.$language['server']['status_offline'].'"" style="font-size: 20px;"></span> ';
    ?>

    <?php echo $server->name; ?>
    <span class="pull-right">
		<a <?php if($_GET['page'] != 'server') echo 'href="server/' . $server->server_id . '"'; else echo 'id="vote"'; ?>>
			<button type="button" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-stats"></span> <?php echo $language['server']['vote']; ?></button>
		</a>
	</span>
</h3>
<h5><?php echo $language['server']['connect'] . ' ' . $server->address . ":" . $server->connection_port; ?></h5>

<div class="btn-group btn-group-justified server-options">

    <?php if($_GET['page'] != 'server'): ?>
        <div class="btn-group btn-group-xs">
            <a href="server/<?php echo $server->server_id; ?>" class="btn btn-default">
                <i class="fa fa-server"></i> <?php echo $language['server']['server']; ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="btn-group btn-group-xs">
        <a href="server/<?php echo $server->server_id; ?>/blog" class="btn btn-default">
            <i class="fa fa-commenting"></i> <?php echo $language['server']['blog']; ?>
        </a>
    </div>

    <div class="btn-group btn-group-xs">
        <a href="server/<?php echo $server->server_id; ?>/statistics" class="btn btn-default btn-info">
            <i class="fa fa-line-chart"></i> <?php echo $language['server']['statistics']; ?>
        </a>
    </div>

    <div class="btn-group btn-group-xs">
        <a href="server/<?php echo $server->server_id; ?>/banners" class="btn btn-default btn-warning">
            <i class="fa fa-bookmark-o"></i> <?php echo $language['server']['banners']; ?>
        </a>
    </div>

    <div class="btn-group btn-group-xs">
        <a href="server/<?php echo $server->server_id; ?>/details" class="btn btn-default btn-success">
            <i class="fa fa-bar-chart"></i> <?php echo $language['server']['more_details']; ?>
        </a>
    </div>

</div>
