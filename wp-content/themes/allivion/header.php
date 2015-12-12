<!DOCTYPE html>
<html>
<head>

	<meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">	
	
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
	<link rel="stylesheet" media="screen" href="<?php bloginfo('template_url') ?>/css/uniform.default.css" />
	

	
	<?php wp_head(); ?>
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<script type="text/javascript">stLight.options({publisher: "5c9feb5b-d9eb-44fb-95ef-a54292286d69", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>


	<script src="<?php bloginfo('template_url'); ?>/js/jquery.uniform.min.js"></script>
	<script>
		jQuery(function() {
	 		jQuery('select, input[type=checkbox]').uniform();
 		});
 	</script>
 	
 	<script src="<?php bloginfo('template_url'); ?>/js/QueryToJSON.js"></script>
 	<script src="<?php bloginfo('template_url'); ?>/js/jquery.sticky-kit.min.js"></script>
 	
 	<script>
	 	jQuery(function(){
			jQuery(".sticky").stick_in_parent({
				offset_top: 20
			})
			.on('sticky_kit:stick', function(e){
				jQuery(this).parent().css('z-index', '999');
			})
			.on('sticky_kit:bottom', function(e) {
			    jQuery(this).parent().css('position', 'static');
			})
			.on('sticky_kit:unbottom', function(e) {
			    jQuery(this).parent().css('position', 'relative');
			})
		});
 	</script>
 	
 	<style>#sharethis{display:block}</style>
 	


 		
	<?php global $user, $usermeta, $type; 
		if($user) { ?>
			<style>
				.loggedinshow{display:inherit;}
				.loggedinhide{display:none;}
			</style>
		<?php } else { ?>
			<style>
				.loggedinshow{display:none;}
				.loggedinhide{display:inherit;}
			</style>
		<?php } ?> 

</head>

<body <?php body_class(); ?>>

	
	<?php require_once(TEMPLATEPATH.'/includes/login_form.php'); ?>
	
		<?php if(is_front_page()){ ?>
		<div class="container" id="header">
			<div class="row">
				<div class="col-sm-12">
					<a href="/">
						<img src="<?php bloginfo('template_url'); ?>/img/logo_strap.png" id="logo" />
					</a>
					
					<div class="leaderboard">
						<?php //include(TEMPLATEPATH.'/revive-zones/leaderboard_iframe.html'); ?>
						<img src="<?php bloginfo('template_url'); ?>/img/banner_ad.jpg" />
					</div>
				</div>
			</div>
		</div>
		<?php } ?>

		<div class="container-fluid" id="navigation">
			<div class="container"
				<div class="row">
					<div class="col-sm-6">
						<nav id="secondary">
							<?php wp_nav_menu('theme_location=secondary'); ?>
						</nav>
					</div>
					<div class="col-sm-6">
						<?php if($user) echo '<p class="loginstatus">Logged in as <span class="name">'.$user->display_name.'</span></p>'; ?>
					</div>
					<nav id="main">
						<?php wp_nav_menu('theme_location=main'); ?>
					</nav>
				</div>
			</div>
		</div>
		

		