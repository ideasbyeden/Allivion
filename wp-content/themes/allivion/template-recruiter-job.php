<!--
	<pre>
		<?php
//Generate an array of custom taxonomy
  $arr = wp_list_categories_array("sector");//Feed your taxonomy to generate array
  
  print_r($sector->taxTree());
?>
	</pre>
-->


<?php 

/*
	echo '<h3>';
//	$taxterms = get_terms('sector',array( 'hide_empty' => 0));
	echo '<pre>'; print_r($sector->taxTree()); echo '</pre>';
	echo '</h3>';

	//echo '<h4>'; print_r(get_term_children(406,'sector')); echo '</h4>';
	//echo '<h5>'; print_r(get_term(409,'sector')); echo '</h5>';
*/
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

<div class="container">
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
				
				
				<div class="col-md-6">

					<div class="qpanel">
						<?php $job->printQuestion('ad_type',$vals['ad_type']); ?>
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
						<?php $job->printGroup('details',$vals); ?>
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
						<h4><span id="job_title"><?php echo $vals['job_title'] ? $vals['job_title'] : 'Job Title'; ?></span>, <span id="location"><?php echo $vals['location'] ? $vals['location'] : 'Location'; ?></span></h4>
						<h6><span id="employer"><?php echo get_user_meta($vals['group_id'],'recruiter_name',true); ?></span></h6>
						<h6><span id="salary_details"><?php echo $vals['salary_details'] ? $vals['salary_details'] : 'Salary'; ?></span></h6>
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

<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/wordlimit.js"></script>

<script>
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
</script>


<?php get_footer(); ?>