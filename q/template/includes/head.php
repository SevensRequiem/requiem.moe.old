<head>
	<title><?php echo $page_title; ?></title>
	<base href="<?php echo $settings->url; ?>">
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	if(!empty($settings->meta_description) && (!isset($_GET['page']) || (isset($_GET['page']) && $_GET['page'] != 'category')))
		echo '<meta name="description" content="' . $settings->meta_description . '" />';
	?>

	<?php if($_GET['page'] == 'servers'): ?>
	<link rel="canonical" href="<?php echo $settings->url; ?>" />
	<?php endif; ?>

	<link href="template/css/bootstrap.min.css" rel="stylesheet" media="screen">
	<link href="template/css/custom.css" rel="stylesheet" media="screen">
	<link href="template/css/font-awesome.min.css" rel="stylesheet" media="screen">
	<link href="template/css/datatables.css" rel="stylesheet" media="screen">
	<link href="template/css/animate.css" rel="stylesheet" media="screen">

	<script src="template/js/jquery.js"></script>
	<script src="template/js/bootstrap.min.js"></script>
	<script src="template/js/timeago.js"></script>
	<script src="template/js/functions.js"></script>
	<script src="template/js/cookieconsent.min.js"></script>
	<?php if($_GET['page'] == 'servers' || $_GET['page'] == 'index'): ?>
	<script src="template/js/waypoints.min.js"></script>
	<script src="template/js/counterup.min.js"></script>
	<?php endif; ?>
	<?php if($_GET['page'] == 'server'): ?><script src="template/js/datatables.js"></script><?php endif; ?>
	<script src='https://www.google.com/recaptcha/api.js'></script>

	<link href="template/images/favicon.ico" rel="shortcut icon" />
	<?php if(!empty($settings->analytics_code)): ?>
	<script>
	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	ga('create', '<?php echo $settings->analytics_code; ?>', 'auto');
	ga('send', 'pageview');

	</script>
	<?php endif; ?>

	<?php if(!empty($settings->sharethis_pub_id)): ?>
	<script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" id="st_insights_js" src="http://w.sharethis.com/button/buttons.js?publisher=<?php echo $settings->sharethis_pub_id; ?>"></script>
	<script type="text/javascript">stLight.options({publisher: "<?php echo $settings->sharethis_pub_id; ?>", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
	<?php endif; ?>

	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@<?php echo $settings->twitter; ?>">
	<meta name="twitter:creator" content="@grohsfabian">
	<meta name="twitter:title" content="<?php echo $settings->title; ?>">
	<meta name="twitter:description" content="<?php echo $settings->meta_description; ?>">
	<meta name="twitter:image" content="<?php echo $settings->url . 'template/images/social-twitter.jpg'; ?>">
	<meta property="og:url" content="https://minecraft-server.net"/>
	<meta property="og:type" content="website"/>
	<meta property="og:title" content="<?php echo $settings->title; ?>"/>
	<meta property="og:description" content="<?php echo $settings->meta_description; ?>"/>
	<meta property="og:image" content="<?php echo $settings->url . 'template/images/social-facebook.jpg'; ?>"/>

	<script type="text/javascript">
		window.cookieconsent_options = {"message":"This website uses cookies to ensure you get the best experience on our website","dismiss":"Got it!","learnMore":"More info","link":null,"theme":"dark-bottom"};
	</script>
</head>
