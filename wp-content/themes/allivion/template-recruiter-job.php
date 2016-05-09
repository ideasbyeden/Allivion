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

<?php $args = array('taxonomy' => 'sector'); 
	
//	$sector->asjad($args);


		
		//echo '<pre>'; print_r($sector->taxTreeRecursive()); echo '</pre>';



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
						<p>You can create or edit your ad here. Any changes you make are automatically saved and displayed in the ad preview on the right. When you’re happy with your ad, simply press ‘publish’. </p>
						
						



						<?php $job->printGroup('publishing',$vals); ?>
						
						<input type="button" id="publish_ad" value="Publish" class="btn btn-default purplegrad" style="width: 100%; margin-top: 12px;<?php echo $vals['job_status'][0] == 'published' ? 'display:none;' : ''; ?>"/>

						<div class="invalidmsg" style="padding-top: 8px"></div>

						<p style="margin-top: 16px"><strong>Please note:</strong>
							All adverts are published immediately – to delay publication, please select an alternative date using the ‘publish from’ box above.
						</p>	
						
						
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
						<div class="limited">
						<span id="wordcount"></span> words&nbsp;<span id="wordalert" class="alert"></span>
						</div>
						
						<?php $job->printQuestion('full_description_limited',$vals['full_description_limited']); ?>
						<?php $job->printQuestion('full_description',$vals['full_description']); ?>

						<?php $job->printQuestion('doc_upload',$vals['doc_upload']); ?>
						<?php if($vals['doc_upload']) echo '<a href="'.$vals['doc_upload'].'" target="_blank">'.get_post_meta($_REQUEST['i'],'doc_upload_label',true).'</a>'; ?>
						<?php $job->printQuestion('doc_download_label',$vals['doc_download_label']); ?>
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
						<button type="submit" class="btn btn-default" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Saving">Save changes</button>



						<hr>
						<h2 class="purple"><span id="job_title"><?php echo $vals['job_title'] ? $vals['job_title'] : 'Job Title'; ?></span></h2>
						<h4><span id="employer"><?php echo get_user_meta($vals['group_id'],'recruiter_name',true); ?></span> - <span id="department"><?php echo $vals['department'] ? $vals['department'] : 'Department'; ?></span></h4>
						<h4>
							<span id="salary_details"><?php echo $vals['salary_details'] ? $vals['salary_details'] : 'Salary'; ?></span>, <span id="location"><?php echo $vals['location'] ? $vals['location'] : 'Location'; ?></span>	
						</h4>
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
		
<div class="totop" <?php echo $vals['job_status'][0] == 'published' ? 'style="display:none"' : '' ?>>
<h2 class="fl purple" style="margin-right: 8px;"><i class="fa fa-arrow-up"></i></h2>

<h3 class="purple" style="margin-bottom: 0px !important;">Completed?</h3>
<p style="margin-top: 0px;">If you are done, please scroll up to the top of the page and select 'Publish' to advertise your role</p>
</div>

	</div>
</div>




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

	// Show / hide promotion options based on ad type
/*
	jQuery(function(){
		jQuery('select[name="ad_type"]').change(function(){
			if(jQuery(this).val() == 'sponsored'){
				jQuery('#qg-admin').show();
			} else {
				jQuery('#qg-admin').hide();
			}
		});
	});
*/
	
	// Show / hide application web address field
/*
	jQuery(function(){
		jQuery('select[name="application_method"]').change(function(){
			if(jQuery(this).val() == 'sponsored'){
				jQuery('#qg-admin').show();
			} else {
				jQuery('#qg-admin').hide();
			}
		});
	});
*/

	

	jQuery(function(){
		jQuery('#publish_ad').click(function(){
				jQuery('select[name="job_status"]').val('published');

			// temporarily enable notify
			var form = jQuery(this).closest('form');
			form.find('input[name="notify"]').removeAttr('disabled');
			
			
			tinyMCE.triggerSave();
			var validates = dirvalidates(form);
			if(validates == 'true'){
				jQuery('.invalidmsg').html('');
				form.submit();
				

				var pf = jQuery('input[name="publish_from"]').val();	

				if(pf == ''){
					jQuery('input[name="publish_from"]').val(moment().format('D MMM YYYY'));
					var pm = 'Thank you for placing an ad - it is now live on our site'; 
				} else {	
					var pm = 'Thank you for placing an ad. It will be live on our site on '+pf+'. '; 
					pm += 'Your reference number for this ad is ALR<?php echo $_REQUEST['i']; ?>';
				}
				
				jQuery(this).hide().after('<div class="alert alert-success" style="margin: 12px 0 0 0">'+pm+'</div>');
				
			}  else {
				jQuery('.invalidmsg').html('<div class="alert alert-danger">You did not complete some required fields - please check the form below and try again.</div>');
			}
			
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

<script type="text/javascript">
jQuery(document).ready(function(){
    // visual mode
    // the iframe id
    //jQuery("#description_ifr").ready(function () {
        setInterval(function(){
            var tinymceval = stripHTML(jQuery('#full_description_limited_ifr').contents().find('body').text());
            var wordscount = tinymceval.split(" ");
            var wordlimit = parseInt(jQuery('#full_description_limited_ifr').closest('span.limited').data('limit'));
            
            jQuery("#wordcount").text(wordscount.length+'/'+wordlimit);
            if(wordscount.length > wordlimit){
				jQuery('#full_description_limited_ifr').addClass('invalid');
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


<?php get_footer(); ?>