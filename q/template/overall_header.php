<!DOCTYPE html>
<html>
	<?php include 'includes/head.php'; ?>
	<body>
		<div class="header-top-container <?php if($_GET['page'] == 'index') echo 'header-top-container-animate'; ?>" style="background: url('https://i.redd.it/x12fpvp9ow8x.jpg') no-repeat;">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<h2><a href="<?php echo $settings->url; ?>" class="no-underline shadow"><?php echo $settings->title; ?></a></h2>
						<span class="muted shadow"><?php echo $settings->description; ?></span>
					</div>

					<div class="col-md-4">
						<span class="navbar-social pull-right hidden-sm">
							<?php
							if(!empty($settings->facebook))
								echo '<a href="http://facebook.com/' . $settings->facebook . '"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-stack-1x fa-inverse"></i></span></a>';

							if(!empty($settings->twitter))
								echo '<a href="http://twitter.com/' . $settings->twitter . '"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-twitter fa-stack-1x fa-inverse"></i></span></a>';

							if(!empty($settings->googleplus))
								echo '<a href="http://plus.google.com/' . $settings->googleplus . '"><span class="fa-stack"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-google-plus fa-stack-1x fa-inverse"></i></span></a>';
							?>
						</span>
					</div>
				</div>



			</div>
		</div>

		<?php include 'includes/menu.php'; ?>

		<div class="container animated fadeIn"><!-- Start Container -->

			<?php display_notifications(); ?>

			<?php include 'includes/widgets/top_ads.php'; ?>
