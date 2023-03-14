<?php
include '../core/init.php';

$_POST['limit'] = (int) $_POST['limit'];
$results_limit = 10;

$result = $database->query("SELECT * FROM `comments` WHERE `server_id` = {$_SESSION['server_id']} AND `type` = 0 ORDER BY `id` DESC LIMIT {$_POST['limit']}, {$results_limit}");
if(!$result->num_rows && $_POST['limit'] == '0') output_notice($language['server']['no_comments']);

while($comment = $result->fetch_object()) {
	/* Get user data */
	$user_data = Database::get(['user_id', 'name', 'avatar', 'email'], 'users', ['user_id' => $comment->user_id]);
	$avatar = (empty($user_data->avatar)) ? get_gravatar($user_data->email, 64) : 'user_data/avatars/thumbs/' . $user_data->avatar;
	?>
<div class="media">
	<span class="pull-left">
		<img class="media-object" style="width:64px;height:64px;" src="<?php echo $avatar; ?>" alt="Avatar">
	</span>

	<div class="media-body">
		<h4 class="media-heading">
			<a href="profile/<?php echo $user_data->user_id; ?>"><?php echo $user_data->name; ?></a>

			<?php if(User::logged_in() && User::is_admin($account_user_id)) { ?>
			<span class="glyphicon glyphicon-remove pull-right clickable media-span-opacity delete" data-id="<?php echo $comment->id; ?>" data-type="<?php echo $comment->type; ?>"></span>
			<?php } ?>

			<span class="glyphicon glyphicon-exclamation-sign pull-right clickable media-span-opacity" onclick="report(<?php echo $comment->id; ?>, <?php echo $comment->type; ?>);"></span>
		</h4>

		<?php echo filter_banned_words($comment->comment); ?>

		<br />
		<span class="text-muted"><?php echo $comment->date_added; ?></span>

	</div>
</div>
<?php } ?>

<?php if($result->num_rows == $results_limit) { ?>
<div id="showMoreComments" class="center">
	<button id="showMore" class="btn btn-default" onClick="showMore(<?php echo $_POST['limit'] + $results_limit; ?>, 'processing/comments_show_more.php', '#comments', '#showMoreComments');"><?php echo $language['misc']['show_more']; ?></button>
</div>
<?php } ?>