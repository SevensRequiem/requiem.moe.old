<?php
include 'core/init.php';
include 'template/overall_header.php';

if(in_array($_GET['page'], $pages)) {
	include 'pages/'.$_GET['page'].'.php';
} else {
	include 'pages/notfound.php';
}

include 'template/overall_footer.php';
include 'core/deinit.php';
?>
