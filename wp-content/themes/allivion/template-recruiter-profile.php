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

//echo '<pre>'; print_r($usermeta); echo '</pre>';

?>

<div class="container">
	<div class="row">
			<form class="directory <?php echo $recruiter_admin->role; ?>" id="updateprofile" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" enctype="multipart/form-data">
		
		<div class="col-md-8">
			<h1 class="purple"><?php the_title(); ?></h1>
		</div>
		<div class="col-md-4" style="text-align: right">
			<input type="submit" value="Save changes" class="btn btn-default" style="margin-top: 20px;"/>
		</div>
			
				<div class="col-md-6">

				
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_update_user_nonce"); ?>" />
 					<input type="hidden" name="action" value="directory_update_user" />
 					<input type="hidden" name="redirect" value="<?php echo DIRECTORY_RECADMIN; ?>" />
 					<input type="hidden" name="role" value="<?php echo $user->roles[0]; ?>" />
 					<input type="hidden" name="origin" value="updateprofile" />
 		

					<div class="qpanel">
						<?php $recruiter_admin->printQuestion('recruiter_name',$usermeta['recruiter_name']); ?>
						
						<?php if($usermeta['logo']) foreach(unserialize($usermeta['logo']) as $image_id) echo wp_get_attachment_image($image_id,'recruiter_icon_small'); ?>
						<?php $recruiter_admin->printQuestion('logo',$usermeta['logo']); ?>

						<div id="brand_header"><?php if($usermeta['brand_header']) foreach(unserialize($usermeta['brand_header']) as $image_id) echo wp_get_attachment_image($image_id,'brand_header'); ?></div>
						<?php $recruiter_admin->printQuestion('brand_header',$usermeta['brand_header']); ?>

						<?php $recruiter_admin->printQuestion('boilerplate',$usermeta['boilerplate']); ?>
						<div class="clear"></div>
					</div>
					
				
				</div>
				
				<div class="col-md-6">
					<div class="qpanel">
						<?php $recruiter_admin->printQuestion('user_email',$user->user_email); ?>
						<?php $recruiter_admin->printQuestion('contact_phone',$usermeta['contact_phone']); ?>
						<?php $recruiter_admin->printQuestion('default_app_email',$usermeta['default_app_email']); ?>
						<?php $recruiter_admin->printQuestion('website',$usermeta['website']); ?>
					</div>
				</div>
				
				<?php if($user->roles[0] == 'administrator') { ?>
					<div class="qpanel">
						<?php $recruiter_admin->printQuestion('subscriber',$usermeta['subscriber']); ?>							
					</div>
				<?php } ?>

				
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