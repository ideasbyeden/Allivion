<?php

/*
Template Name: Candidate profile
*/

$dircore->canAccess(array('roles' => 'candidate'));
	
get_template_part('header','candadmin');

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

<div class="container a2apad">
	
<!-- 			<pre><?php print_r($usermeta); ?></pre> -->

			<form class="directory <?php echo $candidate->role; ?> updateuser" id="updateprofile" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" enctype= "multipart/form-data">
	<div class="row">
		<div class="col-md-8">
			<h1 class="purple"><?php the_title(); ?></h1>
		</div>
		<div class="col-md-4" style="text-align: right;">
			<input type="submit" class="btn btn-default" value="Save changes" style="margin-top: 20px;"/>
		</div>
			</div>
			<div class="row">
				<div class="col-md-6">

				
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_update_user_nonce"); ?>" />
 					<input type="hidden" name="action" value="directory_update_user" />
 					<input type="hidden" name="redirect" value="<?php //echo DIRECTORY_CANDADMIN; ?>" />
 					<input type="hidden" name="role" value="<?php echo $user->roles[0]; ?>" />
 					<input type="hidden" name="origin" value="updateprofile" />
 		

					<div class="qpanel">
						<?php $candidate->printQuestion('first_name',$usermeta['first_name']); ?>
						<?php $candidate->printQuestion('last_name',$usermeta['last_name']); ?>
						<?php $candidate->printQuestion('user_email',$user->user_email); ?>
						<?php $candidate->printQuestion('contact_phone',$usermeta['contact_phone']); ?>

						<div class="clear"></div>
					</div>
					
				
				</div>
				
				<div class="col-md-6">
					<div class="qpanel">
						<?php //wp_editor( $usermeta['intro'], 'intro', $settings = array('media_buttons' => false,'textarea_name' => 'cv','tinymce' => true,'teeny' => false,'quicktags' => true,'textarea_rows' => 50) ); ?>
						<?php $candidate->printQuestion('cv_upload',$usermeta['cv_intro']); ?>
						<?php if($usermeta['cv_upload']) echo '<a href="'.$usermeta['cv_upload'].'" target="_blank">'.get_user_meta($user->ID,'cv_upload_label',true).'</a><p></p>'; ?>

						
						<?php $candidate->printQuestion('cv_intro',$usermeta['cv_intro']); ?>
						<?php $candidate->printQuestion('cv_positions',$usermeta['cv_positions']); ?>
						<?php $candidate->printQuestion('cv_education',$usermeta['cv_education']); ?>
						<?php $candidate->printQuestion('cv_interests',$usermeta['cv_interests']); ?>
						<?php $candidate->printQuestion('cv_summary',$usermeta['cv_summary']); ?>

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