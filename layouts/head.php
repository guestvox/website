<?php defined('_EXEC') or die; ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="{$vkye_lang}">
	<head>
		<base href="{$vkye_base}">
		<title>{$vkye_title}</title>
		<meta charset="UTF-8" />
		<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
		<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
		<meta name="author" content="GuestVox" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="google-site-verification" content="nt4G0mNfZWU_U4U8bMwlnOi2P-bwTyTjoY0HmhaZs2M" />
		{$dependencies.meta}
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico" />
		<link rel="stylesheet" href="{$path.css}valkyrie.min.css" type="text/css" media="all" />
		<link rel="stylesheet" href="{$path.css}styles.css" type="text/css" media="all" />
                <!--Inician dependencias de PWA-->
                <link rel="manifest" href="manifest.json">
                <meta name="theme-color" content="#00A5AB"/>
                <link rel="apple-touch-icon" href="images/apple-touch-icon.png">
                <!--Inician dependencias de pwa para ios-->
                <link rel="apple-touch-startup-image" media="screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) and (orientation: landscape)" href="images/apple-touch-icon.png"/>
                <meta name="apple-mobile-web-app-capable" content="yes">
                <meta name="mobile-web-app-capable" content="yes" />
                <meta name="apple-touch-fullscreen" content="yes" />
                <meta name="apple-mobile-web-app-title" content="GuestVox"/>
                <meta name="apple-mobile-web-app-status-bar-style" content="default" />
                <!--Terminan dependencias de pwa para ios-->
                <!--Terminan dependencias de PWA-->
		{$dependencies.css}
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-153525856-1"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());
			gtag('config', 'UA-153525856-1');
		</script>
		<!--  -->
	</head>
	<body>
