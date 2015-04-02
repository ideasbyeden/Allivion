<?php

/*
Template Name: Recruiter profile
*/

$dircore->canAccess(array('roles' => 'recruiter_admin'));
	
get_template_part('header','recadmin');

$vals = $usermeta;
//echo '<pre>'; print_r($usermeta); echo '</pre>';

	
while (have_posts()) { 
		the_post();
		the_content();


/////////////////////////////////////////////
//
// Page config
//
/////////////////////////////////////////////

// Fields to be shown in search results



/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////

//echo '<pre>'; print_r($user); echo '</pre>';

?>

<div class="section">
	<div class="stage">
		
		<h1 class="purple"><?php the_title(); ?></h1>
		
			<form class="directory <?php echo $recruiter_admin->role; ?>" id="updateprofile" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
		<input type="submit" value="Save changes" />
			
				<div class="halfcol">

				
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_update_user_nonce"); ?>" />
 					<input type="hidden" name="action" value="directory_update_user" />
 					<input type="hidden" name="redirect" value="<?php echo DIRECTORY_RECADMIN; ?>" />
 					<input type="hidden" name="role" value="<?php echo $user->roles[0]; ?>" />
 					<input type="hidden" name="origin" value="updateprofile" />
 		

					<div class="qpanel">
						<?php $recruiter_admin->printQuestion('recruiter_name',$usermeta['recruiter_name']); ?>
						<?php $recruiter_admin->printQuestion('logo',$usermeta['logo']); ?>
						<?php $recruiter_admin->printQuestion('boilerplate',$usermeta['boilerplate']); ?>
						<div class="clear"></div>
					</div>
					
				
				</div>
				
				<div class="halfcol">
					<div class="qpanel">
						<?php $recruiter_admin->printQuestion('user_email',$user->user_email); ?>
						<?php $recruiter_admin->printQuestion('contact_phone',$usermeta['contact_phone']); ?>
						<?php $recruiter_admin->printQuestion('default_app_email',$usermeta['default_app_email']); ?>
					</div>
				</div>
				
			</form>

			
			<div class="clear"></div>

			<?php
							if($_SESSION){ 
								foreach($_SESSION['errors'] as $error) { echo '<p class="formerror">'.$error.'</p>'; }
								session_unset();
							}
						?>
			
			
		
		<div class="clear"></div>
		
	</div>
</div>

<?php } get_footer(); ?>