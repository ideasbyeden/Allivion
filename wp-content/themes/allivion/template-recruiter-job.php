<?php 


$dircore->canAccess(array('group_id' => get_post_meta($_REQUEST['i'],'group_id',true)));

/*
Template Name: Recruiter job
*/

$vals = $_REQUEST['i'] ? $job->getVals($_REQUEST['i']) : null;
// 	echo '<pre>'; print_r($vals); echo '</pre>';

$header = 'recadmin';
if($user->roles[0] == 'administrator') $header = 'sysadmin';
if($user->roles[0] == 'recruiter_admin') $header = 'recadmin';

get_template_part('header',$header);
	
while (have_posts()) { 
		the_post();
		the_content();
} 

//echo '<pre>Question'; print_r($job->getQuestion('promote')); echo '</pre>';


?>

<div class="container a2apad">
	<div class="row">
		<div class="col-md-12">
			<h1 class="purple">Create job advertisement</h1>
		</div>
		
			<form class="directory <?php echo $job->type; ?> update" id="jobdetails" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" autosave="true" enctype="multipart/form-data">
				
				<input type="hidden" name="post_id" value="<?php echo $_REQUEST['i']; ?>" />
				<input type="hidden" name="type" value="<?php echo $job->getItemType(); ?>" />
				<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_update_nonce"); ?>" />
				<input type="hidden" name="action" value="directory_update" />
				<input type="hidden" name="role" value="<?php echo $user->roles[0]; ?>" />
				<input type="hidden" name="notify" value="<?php echo SYSADMIN_EMAIL; ?>" disabled="disabled"/>
				<input type="hidden" name="notify_subject" value="New job published" />
				<input type="hidden" name="notify_template" value="new_job" />
				
				
				<div class="col-md-6">

					<div class="qpanel purplegrad">
						<p>Create or edit your ad here, any changes will be automatically saved and shown in the ad preview on the right.<br />When you're ready, publish your ad. If you've selected a 'publish from' date your ad will appear on the site after that date.</p>
						

						<?php $job->printGroup('publishing',$vals); ?>
						
						<input type="button" id="publish_ad" value="Publish" class="btn btn-default purplegrad" style="width: 100%; margin-top: 12px;<?php echo $vals['job_status'][0] == 'published' ? 'display:none;' : ''; ?>"/>
						
					</div>
					<div class="qpanel">
						<?php $job->printGroup('headline',$vals); ?>
					</div>
					<div class="qpanel">
						<?php $job->printGroup('package',$vals); ?>
					</div>
					<div class="qpanel">
						<?php $job->printGroup('industry_location',$vals); ?>
					</div>
					<div class="qpanel">
						<?php $job->printQuestion('full_description_limited',$vals['full_description_limited']); ?>
						<?php $job->printQuestion('full_description',$vals['full_description']); ?>
						<?php $job->printQuestion('spec_upload',$vals['spec_upload']); ?>
						<?php if($vals['spec_upload']) echo '<a href="'.$vals['spec_upload'].'" target="_blank">'.get_post_meta($_REQUEST['i'],'spec_upload_label',true).'</a>'; ?>
					</div>
					<div class="qpanel">
						<?php $job->printGroup('extra',$vals); ?>
					</div>
					<div class="qpanel">
						<?php $job->printGroup('admin',$vals); ?>
					</div>
					<?php if($user->roles[0] == 'administrator') { ?>
						<div class="qpanel">
							<?php $job->printGroup('sysadmin',$vals); ?>							
						</div>
					<?php } ?>
				
				</div>
				
				<div class="col-md-6">
					<div id="adpreview" class="preview">
						<h3>Ad preview</h3>
						<input type="submit" value="Save changes" class="btn btn-default"/>
						<hr>
						<h2 class="purple"><span id="job_title"><?php echo $vals['job_title'] ? $vals['job_title'] : 'Job Title'; ?></span>, <span id="location"><?php echo $vals['location'] ? $vals['location'] : 'Location'; ?></span></h2>
						<h4><span id="employer"><?php echo get_user_meta($vals['group_id'],'recruiter_name',true); ?></span></h4>
						<h4><span id="salary_details"><?php echo $vals['salary_details'] ? $vals['salary_details'] : 'Salary'; ?></span></h4>
						<div class="limited">
							<span id="full_description_limited">
								<?php echo $vals['full_description_limited'] ? $vals['full_description_limited'] : 'Job description'; ?>
							</span>
						</div>
						<div class="unlimited">
							<span id="full_description">
								<?php echo $vals['full_description'] ? $vals['full_description'] : 'Job description'; ?>
							</span>
						</div>
					</div>
				</div>
				
			</form>
		
		<div class="clear"></div>
		
	</div>
</div>

<?php wp_tiny_mce( true, array( "editor_selector" => 'richtext' ) ); ?>


<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/wordlimit.js"></script>

<script>
	// Show / hide limited or unlimited description fields based on ad type
	jQuery(function(){
		if(jQuery('select[name="ad_type"]').val() != 'standard'){
			jQuery('.limited').hide();
			jQuery('.unlimited').show();
		} else {
			jQuery('.unlimited').hide();
			jQuery('.limited').show();				
		}
		jQuery('select[name="ad_type"]').change(function(){
			if(jQuery(this).val() != 'standard'){
				jQuery('.limited').hide();
				jQuery('.unlimited').show();
			} else {
				jQuery('.unlimited').hide();
				jQuery('.limited').show();				
			}
		});
	});
	
	jQuery(function(){
		jQuery('#publish_ad').click(function(){
			var pf = jQuery('input[name="publish_from"]').val();

			jQuery('select[name="job_status"]').val('published');
			if(pf == ''){
				jQuery('input[name="publish_from"]').val(moment().format('D MMM YYYY'));
				var pm = 'Your ad is published'; 
			} else {	
				var pm = 'Your ad will be published on '+pf; 
			}
			jQuery(this).closest('form').find('input[name="notify"]').removeAttr('disabled');
			
			jQuery(this).hide().after('<div class="alert alert-success" style="margin: 12px 0 0 0">'+pm+'</div>').closest('form').submit();
			
			jQuery(this).closest('form').find('input[name="notify"]').attr('disabled','disabled');

		});
	});
	
/*
	jQuery(function(){
		tinyMCE.init({
	        mode : "specific_textareas",
	        theme : "simple", 
	        plugins : "autolink, lists, spellchecker, style, layer, table, advhr, advimage, advlink, emotions, iespell, inlinepopups, insertdatetime, preview, media, searchreplace, print, contextmenu, paste, directionality, fullscreen, noneditable, visualchars, nonbreaking, xhtmlxtras, template",
	        editor_selector :"richtext"
	    });
	});
*/
</script>


<?php get_footer(); ?>