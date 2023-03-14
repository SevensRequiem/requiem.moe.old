				</div><!-- END main col-->

			</div><!-- END ROW -->

			<?php include 'includes/widgets/bottom_ads.php'; ?>

		</div><!-- END Container -->

		<div class="sticky-footer-container">
			<?php include 'includes/footer-advertise.php'; ?>
			<?php include 'includes/footertop.php'; ?>
			<?php include 'includes/footer.php'; ?>
		</div>


		<?php
		if(!empty($_GET['server_id']) && ($_GET['page'] == 'server' || $_GET['page'] == 'server_statistics' || $_GET['page'] == 'server_banners' || $_GET['page'] == 'server_details' || $_GET['page'] == 'server_blog')) {
			include 'template/includes/modals/comment.php';
			include 'template/includes/modals/blog.php';
			include 'template/includes/modals/report.php';
		}

		if($_GET['page'] == 'purchase_highlight') include 'template/includes/modals/purchase_highlight.php';
		?>
	</body>
</html>
