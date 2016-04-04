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

<div class="container a2apad">
	<div class="row">
			<form class="directory <?php echo $recruiter_admin->role; ?>" id="updateprofile" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" enctype="multipart/form-data">
		
		<div class="col-md-8">
			<h1 class="purple"><?php the_title(); ?></h1>

		</div>
		<div class="col-md-4" style="text-align: right">
			<input type="submit" value="Save changes" class="btn btn-default" style="margin-top: 20px;"/>
		</div>
			
			<div class="col-md-12 alert alert-warning">
			<strong>Need help?</strong> To ask a question, simply get in touch with our support team on 0208 310 3131 or email us at <a href="mailto:info@allivion.com">info@allivion.com</a> 
		</div> 
				<div class="col-md-6">

				
					<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_update_user_nonce"); ?>" />
 					<input type="hidden" name="action" value="directory_update_user" />
<!--  					<input type="hidden" name="redirect" value="<?php echo DIRECTORY_RECADMIN; ?>" />
 --> 					<input type="hidden" name="role" value="<?php echo $user->roles[0]; ?>" />
 					<input type="hidden" name="origin" value="updateprofile" />
 		

					<div class="qpanel">
						<?php $recruiter_admin->printQuestion('recruiter_name',$usermeta['recruiter_name']); ?>
						
						<?php if($usermeta['logo']) foreach(unserialize($usermeta['logo']) as $image_id) echo wp_get_attachment_image($image_id,'recruiter_icon_small'); ?>
						<?php $recruiter_admin->printQuestion('logo',$usermeta['logo']); ?>

						<div id="brand_header"><?php if($usermeta['brand_header']) foreach(unserialize($usermeta['brand_header']) as $image_id) echo wp_get_attachment_image($image_id,'brand_header'); ?></div>
						<?php $recruiter_admin->printQuestion('brand_header',$usermeta['brand_header']); ?>

						<span id="wordcount"></span> words&nbsp;<span id="wordalert" class="alert"></span>


						<?php $recruiter_admin->printQuestion('boilerplate',$usermeta['boilerplate']); ?>
						<?php $recruiter_admin->printQuestion('video',$usermeta['video']); ?>
						<div class="clear"></div>
					</div>
					
				
				</div>
				
				<div class="col-md-6">
					<div class="qpanel">
						<?php $recruiter_admin->printQuestion('user_email',$user->user_email); ?>
						<?php $recruiter_admin->printQuestion('contact_phone',$usermeta['contact_phone']); ?>
						<?php $recruiter_admin->printQuestion('job_title',$usermeta['job_title']); ?>
						<?php $recruiter_admin->printQuestion('department',$usermeta['department']); ?>
						<?php $recruiter_admin->printQuestion('default_app_email',$usermeta['default_app_email']); ?>
						<?php $recruiter_admin->printQuestion('website',$usermeta['website']); ?>
						<?php $recruiter_admin->printQuestion('contactpage',$usermeta['contactpage']); ?>
						<?php $recruiter_admin->printQuestion('jobspage',$usermeta['jobspage']); ?>
						<?php $recruiter_admin->printQuestion('main_address',$usermeta['main_address']); ?>
						<?php $recruiter_admin->printQuestion('invoice_address',$usermeta['invoice_address']); ?>
						<button type="button" class="btn btn-default" id="copymainaddress">Same as main address</button>
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
			
			<script>
				jQuery(function(){
					jQuery('#copymainaddress').click(function(){
						var mainaddress = jQuery('[name="main_address"]').val();
						jQuery('[name="invoice_address"]').val(mainaddress);
					})
				});
			</script>
		
		<div class="clear"></div>
		
	</div>
</div>


<script type="text/javascript">
jQuery(document).ready(function(){
    // visual mode
    // the iframe id
    //jQuery("#description_ifr").ready(function () {
        setInterval(function(){
            var tinymceval = stripHTML(jQuery('#boilerplate_ifr').contents().find('body').text());
            var wordscount = tinymceval.split(" ");
            var wordlimit = parseInt(jQuery('#boilerplate_ifr').closest('span.limited').data('limit'));
            
            jQuery("#wordcount").text(wordscount.length+'/'+wordlimit);
            if(wordscount.length > wordlimit){
				jQuery('#boilerplate_ifr').addClass('invalid');
				jQuery("#wordalert").text('Your text is too long');
	        } else {
				jQuery('#full_description_limited_ifr').removeClass('invalid');
				jQuery("#wordalert").text('');
	        }
        }, 300)
    //});

/*
jQuery('#full_description_limited_ifr').contents().find('body').keydown(function(e) {
    if(e.keyCode !== 8) {
        e.preventDefault();
    }
});
*/

				
// automatically trims content back to word limit, but moves cursor to start of text
//jQuery('#full_description_limited_ifr').contents().find('body').text(wordscount.slice(0, wordlimit).join(' '));

function stripHTML(dirtyString) {
  var container = document.createElement('div');
  var text = document.createTextNode(dirtyString);
  container.appendChild(text);
  return container.innerHTML; // innerHTML will be a xss safe string
}

}); 
</script>


<?php } get_footer(); ?>