<!DOCTYPE html>
<?php $t =& peTheme();?>
<?php $class = ""; ?>
<!--[if IE 7 ]><html class="lt-ie9 lt-ie8 ie7 no-js desktop <?php echo $class ?>" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 8 ]><html class="lt-ie9 ie8 no-js desktop <?php echo $class ?>" <?php language_attributes(); ?>><![endif]-->
<!--[if IE 9 ]><html class="ie9 no-js desktop <?php echo $class ?>" <?php language_attributes(); ?>><![endif]--> 
<!--[if (gte IE 9)|!(IE)]><!--><html class="no-js desktop <?php echo $class ?>" <?php language_attributes();?>><!--<![endif]-->
   
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<title><?php $t->header->title(); ?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="format-detection" content="telephone=no">
		<!-- http://remysharp.com/2009/01/07/html5-enabling-script/ -->
		<!--[if lt IE 9]>
			<script type="text/javascript">/*@cc_on'abbr article aside audio canvas details figcaption figure footer header hgroup mark meter nav output progress section summary subline time video'.replace(/\w+/g,function(n){document.createElement(n)})@*/</script>
			<![endif]-->
		<script type="text/javascript">(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
		<script>if(Function('/*@cc_on return document.documentMode===10@*/')()){document.documentElement.className+=' ie10';}</script>
		
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

		<!-- favicon -->
		<link rel="shortcut icon" href="<?php echo $t->options->get("favicon") ?>" />

		<?php $t->font->load(); ?>

		<!-- scripts and wp_head() here -->
		<?php $t->header->wp_head(); ?>
		<?php $t->font->apply(); ?>
		<?php $t->color->apply(); ?>

		<?php if ($customCSS = $t->options->get("customCSS")): ?>
		<style type="text/css"><?php echo stripslashes($customCSS) ?></style>
		<?php endif; ?>
		<?php if ($customJS = $t->options->get("customJS")): ?>
		<script type="text/javascript"><?php echo stripslashes($customJS) ?></script>
		<?php endif; ?>
		

	</head>

	<body <?php $t->content->body_class(); ?>>

		<?php $template = is_page() ? $t->content->pageTemplate() : false; ?>
		<?php if ($template === "page-home.php"): ?>
		<?php get_template_part("headlines"); ?>
		<div id="wrapper">
		<?php else: ?>
		<div>
		<?php endif; ?>
		
			<?php get_template_part("menu"); ?>

