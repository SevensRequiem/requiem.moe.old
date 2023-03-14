<?php

initiate_html_columns();

$details = json_decode($server->details, true);
?>

<?php include 'template/includes/widgets/server_header.php'; ?>


<div class="panel panel-default">
    <div class="panel-body">

        <h5><span class="glyphicon glyphicon-bell"></span> <?php echo $language['server']['last_check']; ?>
            <span class="timeago" title="<?php echo @date('c', $server->cachetime); ?>"></span>
        </h5>

        <table class="table">
            <tbody>

            <?php
            foreach($details as $key => $value):
            $key = ucwords(str_replace('_', ' ', $key));
            ?>
            <tr>
                <td><strong><?php echo $key; ?></strong></td>
                <td><?php echo $value ?></td>
            </tr>
            <?php endforeach; ?>

            </tbody>
        </table>

    </div>
</div>


<hr class="custom-one" />

<?php include 'template/includes/widgets/server_options.php'; ?>
