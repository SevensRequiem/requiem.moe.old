<?php

return [
	/* This is a secure key that only you should know, an added layer of security for the image upload */
    'secure_key' => 'dzWZ5SuTDa',

    /* This is the url your output will be, usually http://www.domain.com/u/, also going to this url will be the gallery page */
    'output_url' => 'http://i.sevens.gq/u/',

    /* This is a redirect url if the script is accessed directly */
    'redirect_url' => 'https://sevens.gq',

    /* This is a list of IPs that can access the gallery page (Leave empty for universal access) */
    'allowed_ips' => [''],

    /* Page title of the gallery page */
    'page_title' => 'sevensGallery',

    /* Heading text at the top of the gallery page */
    'heading_text' => 'sevensUploading',

    /* Delete file option (true to enable, disabled by default) */
    'enable_delete' => true,

    /* Show image in tooltip  (true to enable, disabled by default) */
    'enable_tooltip' => true,

    /* Generate random name (true to enable, disabled by default) */
    'enable_random_name' => true,

    /* Select lenght of random name (10 symbols by default) */
    'random_name_length' => 10,

];
