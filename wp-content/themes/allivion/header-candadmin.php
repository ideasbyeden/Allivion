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
	
	
 	<script>
	 	jQuery(function(){
		 	jQuery('.menu-toggle').click(function(){
			 	jQuery('nav#main').toggleClass('open');
		 	});
	 	});
 	</script>


</head>

<body <?php body_class(); ?>>
	
	<?php require_once(TEMPLATEPATH.'/includes/login_form.php'); ?>
	


		
		<div class="container-fluid" id="navigation">
			<div class="container"
				<div class="row">
					<div class="col-sm-6">
						<nav id="secondary">
							<?php wp_nav_menu('theme_location=secondary'); ?>
						</nav>
					</div>
					<div class="col-sm-6">
						<?php  global $user, $usermeta; if($user) echo '<p class="loginstatus">Logged in as <span class="name">'.$user->display_name.'</span></p>'; ?>
					</div>
					<nav id="main">
						<div id="main-nav">
							<span class="menu-toggle visible-sm visible-xs">Menu</span>
							<?php wp_nav_menu('theme_location=candadmin'); ?>
						</div>
					</nav>
				</div>
			</div>
		</div>
		

			
		