<!DOCTYPE html>
<html>
<head>

	<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">	
	
	<?php
	if ( is_tag() ) { echo "<meta name=\"robots\" content=\"noindex,follow\">"; }
	elseif ( is_archive() ) { echo "<meta name=\"robots\" content=\"noindex,follow\">"; }
	elseif ( is_search() ) { echo "<meta name=\"robots\" content=\"noindex,follow\">"; }
	elseif ( is_paged() ) { echo "<meta name=\"robots\" content=\"noindex,follow\">"; }
	else { echo "<meta name=\"robots\" content=\"index,follow\">"; }
	?>
	
	<title></title>
	
	<link rel="shortcut icon" href="<?php bloginfo('template_url') ?>/favicon.ico" />

	<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url') ?>/style.css" />
	<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url') ?>/css/layout.css" />
	<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url') ?>/css/textstyles.css" />
	<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url') ?>/css/nav.css" />
	

	
	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	
	<?php require_once(TEMPLATEPATH.'/includes/login_form.php'); ?>
	

		<div class="section" id="navigation" style="margin-bottom: 40px;">
			<div class="stage">
				<nav id="main">
					<?php wp_nav_menu('theme_location=sysadmin'); ?>
				</nav>
				<?php global $user, $usermeta; if($user) echo '<p class="">Logged in as '.$user->display_name.'</p>'; ?>
					
			</div>
		</div>
		

			
		