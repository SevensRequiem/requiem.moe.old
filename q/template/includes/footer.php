<div class="sticky-footer">
	<div class="container">
		<p>
			<?php
			echo $language['misc']['language'];

			foreach($languages as $language_name) {
				echo ' <a href="index.php?language=' . $language_name . '">' . $language_name . '</a> &nbsp;&nbsp; ';
			}

			?>

			<br />

			<?php echo 'Copyright &copy; ' . date('Y') . ' ' . $settings->title . '. All rights reserved. Powered by <a href="http://phpserverslist.com">phpServersList</a> ¨¨C¨O¨D¨E¨L¨I¨S¨T¨.¨C¨C¨¨'; ?>
		</p>
	</div>
</div>
