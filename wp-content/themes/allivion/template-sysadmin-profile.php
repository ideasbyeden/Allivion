<?php

/*
Template Name: Sysadmin recruiter profile
*/

$dircore->canAccess(array('roles' => 'administrator'));
	
get_template_part('header','sysadmin');

$vals = $_REQUEST['i'] ? $recruiter_admin->getVals($_REQUEST['i']) : null;

	
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

$this_user = get_user_by('id',$_REQUEST['i']);
$usercustom = get_user_meta($_REQUEST['i']);
foreach($usercustom as $k=>$v){
	$this_usermeta[$k] = $v[0];
}

//echo '<pre>'; print_r($this_usermeta); echo '</pre>';

?>

<div class="container a2apad">
	<div class="row">
		
		
		<form class="directory <?php echo $recruiter_admin->role; ?> updateuser" id="updateprofile" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" enctype= "multipart/form-data">
			
			<div class="col-md-8">		
				<h1 class="purple"><?php the_title(); ?></h1>
			</div>
			<div class="col-md-4" style="text-align: right">
				<input type="submit" value="Save changes" class="btn btn-default" style="margin-top: 20px;"/>
			</div>
					
			<div class="col-sm-6">
	
					
			<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_update_user_nonce"); ?>" />
				<input type="hidden" name="action" value="directory_update_user" />
<!-- 				<input type="hidden" name="redirect" value="<?php echo DIRECTORY_SYSADMIN; ?>" />
 -->				<input type="hidden" name="role" value="recruiter_admin" />
				<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('ID='.$this_user->ID); ?>" />
	
	
				<div class="qpanel">
					<?php $recruiter_admin->printQuestion('recruiter_name',$vals['recruiter_name']); ?>
					
					<?php if($this_usermeta['logo']) foreach($vals['logo'] as $image_id) echo wp_get_attachment_image($image_id); ?>
				
					<?php $recruiter_admin->printQuestion('logo',$vals['logo']); ?>

					<div id="brand_header"><?php if($vals['brand_header']) foreach(unserialize($vals['brand_header']) as $image_id) echo wp_get_attachment_image($image_id,'brand_header'); ?></div>
						<?php $recruiter_admin->printQuestion('brand_header',$vals['brand_header']); ?>

					<?php $recruiter_admin->printQuestion('boilerplate',$vals['boilerplate']); ?>
						<?php $recruiter_admin->printQuestion('video',$vals['video']); ?>
					<div class="clear"></div>
				</div>

	
				
			
			</div>
		




				<div class="col-md-6">
					<div class="qpanel">
						<?php $recruiter_admin->printQuestion('user_email',$this_user->user_email); ?>
						<?php $recruiter_admin->printQuestion('contact_phone',$vals['contact_phone']); ?>
						<?php $recruiter_admin->printQuestion('job_title',$vals['job_title']); ?>
						<?php $recruiter_admin->printQuestion('department',$vals['department']); ?>
						<?php $recruiter_admin->printQuestion('default_app_email',$vals['default_app_email']); ?>
						<?php $recruiter_admin->printQuestion('website',$vals['website']); ?>
						<?php $recruiter_admin->printQuestion('contactpage',$vals['contactpage']); ?>
						<?php $recruiter_admin->printQuestion('jobspage',$vals['jobspage']); ?>
						<?php $recruiter_admin->printQuestion('main_address',$vals['main_address']); ?>
						<?php $recruiter_admin->printQuestion('invoice_address',$vals['invoice_address']); ?>
						<button type="button" class="btn btn-default" id="copymainaddress">Same as main address</button>
					</div>
				

		
				<?php if($user->roles[0] == 'administrator') { ?>
					<div class="qpanel">
						<?php $recruiter_admin->printQuestion('subscriber',$this_usermeta['subscriber']); ?>							
						<?php $recruiter_admin->printQuestion('recruiter_sector',$this_usermeta['recruiter_sector']); ?>							
					</div>
				<?php } ?>
			</div>
		
		</form>

			

		<div class="col-md-12">
			<?php
				if($_SESSION){ 
					foreach($_SESSION['errors'] as $error) { echo '<p class="formerror">'.$error.'</p>'; }
					session_unset();
				}
			?>
		</div>	
			
		
		
	</div>
</div>

<?php } get_footer(); ?>