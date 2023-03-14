<div class="navbar navbar-default navbar-static-top <?php echo (true === false) ? 'navbar-no-margin':null; ?>" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="servers"><i class="fa fa-feed" aria-hidden="true"></i> <?php echo $language['menu']['home']; ?></a></li>
				<li><a href="purchase-highlight"><i class="fa fa-star" aria-hidden="true"></i> <?php echo $language['menu']['purchase_highlight']; ?></a></li>

				<?php if(Plugin::active('bidding-system')): ?>
					<li><a href="bid"><?php echo $language['menu']['bid']; ?></a></li>
				<?php endif; ?>
				<li><a href="submit"><i class="fa fa-plus" aria-hidden="true"></i> <?php echo $language['menu']['submit']; ?></a></li>



				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $language['menu']['account']; ?> <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<?php if(User::logged_in() == false): ?>
							<li><a href="login"><?php echo $language['menu']['login']; ?></a></li>
							<li><a href="register"><?php echo $language['menu']['register']; ?></a></li>
						<?php else: ?>
							<li><a href="my-servers"><?php echo $language['menu']['my_servers']; ?></a></li>
							<li><a href="my-favorites"><?php echo $language['menu']['my_favorites']; ?></a></li>
							<li><a href="profile/<?php echo $account_user_id; ?>"><?php echo $language['menu']['my_profile']; ?></a></li>
							<li role="separator" class="divider"></li>
							<li><a href="settings/profile"><?php echo $language['menu']['profile_settings']; ?></a></li>
							<li><a href="settings/design"><?php echo $language['menu']['design_settings']; ?></a></li>
							<li><a href="settings/password"><?php echo $language['menu']['change_password']; ?></a></li>
							<li role="separator" class="divider"></li>
							<li><a href="logout"><?php echo $language['menu']['logout']; ?></a></li>
						<?php endif; ?>
					</ul>
				</li>


				<?php if(User::logged_in() && User::is_admin($account_user_id)) { ?>
				<li class="dropdown">
					<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-unlock" aria-hidden="true"></i> <?php echo $language['menu']['admin']; ?> <span class="caret"></span>
					</a>
					<ul class="dropdown-menu">
						<li><a href="admin/users-management"><?php echo $language['menu']['users_management']; ?></a></li>
						<li><a href="admin/servers-management"><?php echo $language['menu']['servers_management']; ?></a></li>
						<li><a href="admin/reports-management"><?php echo $language['menu']['reports_management']; ?></a></li>
						<li><a href="admin/pages-management"><?php echo $language['menu']['pages_management']; ?></a></li>
						<?php if(User::get_type($account_user_id) > 1) { ?>
						<li><a href="admin/website-settings"><?php echo $language['menu']['website_settings']; ?></a></li>
						<li><a data-confirm="<?php echo $language['messages']['reset_votes']; ?>" href="admin/reset"><?php echo $language['menu']['reset_votes']; ?></a></li>
						<li><a href="admin/payments-management"><?php echo $language['menu']['payments_management']; ?></a></li>
						<li><a href="admin/plugins"><?php echo $language['menu']['plugins']; ?></a></li>
						<?php } ?>
						<li><a href="admin/website-statistics"><?php echo $language['menu']['website_statistics']; ?></a></li>

						<?php if(Plugin::active('bidding-system')): ?>
							<li><a href="admin/auctions-management"><?php echo $language['menu']['auctions_management']; ?></a></li>
						<?php endif; ?>
					</ul>
				</li>
				<?php } ?>

			</ul>

		</div>
	</div>
</div>
