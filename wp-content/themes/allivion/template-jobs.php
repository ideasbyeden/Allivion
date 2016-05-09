<?php

/*
Template Name: Jobs search results
*/
	
get_template_part('header');
	
while (have_posts()) { 
		the_post();
		the_content();
} 


/////////////////////////////////////////////
//
// Page config
//
/////////////////////////////////////////////

// Fields to be shown in search results
$returnfields = array('job_title','location','summary','recruiter_name','department','publish_from','salary_details','closing_date','closing_date_day','closing_date_month','closing_date_year','logo','logo_image');


/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////

?>

<script>
	// Updates purple panel with search params
/*
	jQuery(document).ajaxSuccess(function( event, xhr, settings ) {
		var data = queryStringToJSON(settings.data)
		if(data.action == 'directory_search'){
			var form = jQuery('input[name="action"][value="'+data.action+'"]').closest('form');
			var userfields = [];
			form.find('select').each(function(i){
				userfields.push(jQuery(this).attr('name'));
			});

			var searchval;
			jQuery('#job_bullets table').html('');

			jQuery.each(data, function(k,v){
				if(jQuery.inArray(k,userfields)!==-1 && v != ''){					

					jQuery.ajax({
				    	type: 'POST',
				    	url:  '<?php echo admin_url('admin-ajax.php'); ?>',
				    	data: 'action=jsapi&type=job&method=getquestion&name='+k+'&value='+v,
				    	dataType: 'json',
								
						success: function(result){
							var label = '';
							var value = '';
							if(typeof result.question.label != 'undefined'){
								label = result.question.label;
							} 
							if(typeof result.value != 'undefined'){
								value = result.value;
							} else {
								value = v;
							}
							jQuery('#job_bullets table').append('<tr><td style="width:50%">'+label+'</td><td><strong>'+value+'</strong></td></tr>').hide().fadeIn(100);
						}
					});

					
				}
			});


		}
	});
*/

	jQuery(function(){
		jQuery('form.directory.search').submit(function(e){
			
			var querystring = '?';
			jQuery('#job_bullets table').html('');
			jQuery(this).find('select, input[type="text"]').each(function(){
				if(jQuery(this).val() != ''){
					var label = jQuery(this).attr('label');
					if(jQuery(this).is('input')){
						var opval = jQuery(this).val();						
					} else {
						var opval = jQuery(this).find('option:selected').text().replace(/^- /,'');
					}
					
					querystring += jQuery(this).attr('name') + '=' + jQuery(this).val() + '&';
										
	 			jQuery('#job_bullets table').append('<tr><td style="width:50%">'+label+'</td><td><strong>'+opval+'</strong></td></tr>').hide().fadeIn(100);
	 			}
			});
			var newurl = document.location.protocol + '//' + document.location.hostname  + document.location.pathname + querystring;
			//document.location = newurl;
			history.pushState('', document.title, newurl);

		});
	});	
	
	jQuery(function(){
		jQuery('#togglesearchform').click(function(){
			if(jQuery(this).hasClass('open')){
				jQuery(this).removeClass('open').html('Refine search');
				jQuery('.popoutform').hide();
			} else {
				jQuery(this).addClass('open').html('Close');			
				jQuery('.popoutform').show();
			}
		});
		
	
	
	
	});
	
	function formclose(c){
		jQuery('.'+c).hide();
		jQuery('#togglesearchform').removeClass('open').html('Refine search');
	}
	

	

	

</script>

<?php $recruiter = $recruiter_admin->getUsers(array('id'=>$_REQUEST['group_id']))->results[0]; ?>

<div class="container-fluid a2apad <?php if($_REQUEST['group_id'] && $recruiter->meta['subscriber'] == 'annual') echo 'single-job-standard'; ?>">
<div class="container">
	<div class="stage" style="margin: 0">
		
		<div class="col-md-12">
			<div class="row">
				<h1 class="purple">Job advertisements</h1>
			</div>
		</div>
						
			<div class="qtrcol sticky">
				<?php if(!isset($_REQUEST['group_id'])) { ?>
				<div class="qpanel darkpurplegrad" id="job_bullets" style="padding: 12px;">
					<table style="width: 90%; margin-bottom: 30px;" class="hidden-xs">
					<?php
						foreach($_GET as $k=>$v){
							if($v && $k != 'group_id') $job->printDetail($k,$_GET);
						}
					?>
					</table>				
					<span id="togglesearchform" class="hidden-sm hidden-xs">Refine search</span>

					<div class="qpanel purplegrad popoutform">
						<form class="directory <?php echo $job->type; ?> search" id="searchjobs" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" return="<?php echo implode(',', $returnfields); ?>" targetid="jobslist" clickableurl="/job">
						
							<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_search_nonce"); ?>" />
							<input type="hidden" name="action" value="directory_search" />
							<input type="hidden" name="inc_search_count" value="true" />
							
							<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('type=job&job_status=published&publish_from=<'.strtotime('now').'&closing_date=>'.strtotime('tomorrow')); ?>" />
						
		
							<div class="question">
								<label>Keywords</label>
								<input type="text" name="keywords" label="Keywords" value="<?php echo $_GET['keywords']; ?>" />
							</div>
							<?php
								$job->printQuestion('industry',$_GET['industry'],'dropdown',true);
								$job->printQuestion('region',$_GET['region'],'dropdown',true);
								$job->printQuestion('salary_range',$_GET['salary_range'],'dropdown',true);
								$job->printQuestion('contract',$_GET['contract'],'dropdown',true);
						
								
								
								
							?>
							<input type="submit" value="Go" onClick="formclose('popoutform');"/>
							<div class="clear"></div>
							
						</form>
					</div>
				</div>
				<?php } ?>

				<div class="qpanel" style="padding: 12px;">
					<h3 class="purple">Job alerts</h3>
					<p>Sign up for our job alerts and receive new opportunities straight to your inbox</p>
					<form class="directory subscription create" id="jobs_subscribe" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
						
						<input type="hidden" name="type" value="subscription" />
						<input type="hidden" name="subscription_type" value="jobalert" />
						<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_create_nonce"); ?>" />
						<input type="hidden" name="action" value="directory_create" />

						<input type="hidden" name="job_title" value="<?php echo $vals['job_title']; ?>" />
						<?php $subscription->printQuestion('item_type','job'); ?>
						<?php $subscription->printQuestion('status','active'); ?>
						<?php $subscription->printQuestion('industry',$vals['industry'][0],'dropdown'); ?>
						<?php $subscription->printQuestion('subscription_date',strtotime('now')); ?>
						
						<input type="email" name="subscriber_email" value="<?php echo $user->user_email ? $user->user_email : ''; ?>" />
						<input type="hidden" name="expire" value="7" />
						<input type="submit" value="Submit" class="btn btn-default" />
						
					</form>
				</div>
			</div>
				
			
			
			<?php 
				$params = $_REQUEST ? $_REQUEST : array();
				$params['encrypted'] = $dircore->encrypt('type=job&job_status=published&publish_from=<'.strtotime('now').'&closing_date=>'.strtotime('yesterday'));
				$params['inc_search_count'] = true;
				$items = directory_search($params);
				
			?>
			

			<div class="threeqtrscol" style="padding-right: 0px;">

			<?php if($_REQUEST['group_id'] && $recruiter->meta['subscriber'] == 'annual') {
						require(TEMPLATEPATH.'/includes/employer_profile.php');
					} ?>

				<table class="searchresults">
					
					<thead style="display: none;">
						<tr>
							<td></td>
							<td>
								<form class="directory <?php echo $job->type; ?> search sortform" id="searchjobs" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" return="<?php echo implode(',', $returnfields); ?>" targetid="jobslist" clickableurl="/job">
									<?php foreach($_GET as $k=>$v) { ?>
										<input type="hidden" name="<?php echo $k ; ?>" value="<?php echo $v; ?>" />
									<?php } ?>
									<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_search_nonce"); ?>" />
									<input type="hidden" name="action" value="directory_search" />
									<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('type=job'); ?>" />
									<input type="hidden" name="inc_search_count" value="false" />
									<input type="hidden" name="orderby" value="job_title" />
									<input type="hidden" name="order" value="ASC" />
									<input type="submit" value="Job title" />
								</form>
							</td>
							<td>
								<form class="directory <?php echo $job->type; ?> search sortform" id="searchjobs" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" return="<?php echo implode(',', $returnfields); ?>" targetid="jobslist" clickableurl="/job">
									<?php foreach($_GET as $k=>$v) { ?>
										<input type="hidden" name="<?php echo $k ; ?>" value="<?php echo $v; ?>" />
									<?php } ?>
									<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_search_nonce"); ?>" />
									<input type="hidden" name="action" value="directory_search" />
									<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('type=job'); ?>" />
									<input type="hidden" name="inc_search_count" value="false" />
									<input type="hidden" name="orderby" value="publish_from" />
									<input type="submit" value="Published" />
								</form>
							</td>
							
							<td><form class="directory <?php echo $job->type; ?> search sortform" id="searchjobs" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" return="<?php echo implode(',', $returnfields); ?>" targetid="jobslist" clickableurl="/job">
									<?php foreach($_GET as $k=>$v) { ?>
										<input type="hidden" name="<?php echo $k ; ?>" value="<?php echo $v; ?>" />
									<?php } ?>
									<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_search_nonce"); ?>" />
									<input type="hidden" name="action" value="directory_search" />
									<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('type=job'); ?>" />
									<input type="hidden" name="inc_search_count" value="false" />
									<input type="hidden" name="orderby" value="closing_date" />
									<input type="submit" value="Closes" />
								</form>
							</td>

						</tr>
					</thead>
							
					<tbody id="jobslist">
						
					<tr class="prototype" data-href="/job?i=">
						<td style="width: 90px;">[logo_image]</td>
						<td>
							<h4>
								<span class="job_title">[job_title]</span>
							</h4>
							<p class="recruiter_name"><strong>[recruiter_name]</strong></p>
							<p class="department">[department]</p>
							<p>
								<span class="salary_details"><strong>[salary_details]</strong></span>
								<span class="location"><strong>, [location]</strong></span>
							</p>
							<p class="publish_from">Placed on <strong>[publish_from]</strong></p>
						</td>
						<td></td>
						<td style="text-align: center">
							<span class="closing_date">
								<p>Closes</p>
								<div class="calpanel">
									<div class="day">[closing_date_day]</div>
									<div class="month">[closing_date_month]</div>
								</div>
							</span>
						</td>
					</tr>
								
					<?php if(count($items->posts) > 0) foreach ($items->posts as $item){ ?>
					
						<?php // Promoted (Sponsored) or Premium logic
							$class = '';
							if($item->meta['ad_type'][0] == 'premium') $class = 'premium';
							if($item->meta['ad_type'][0] == 'sponsored') {
								if($item->meta['promote'][0] == $_REQUEST['industry'] && $item->meta['promote_enabled'][0] == 'enabled' && $item->meta['ad_type'][0] == 'sponsored') {
									$class = 'promoted';
								}
							}
							
							?>
					
						<tr class="clickable rowitem <?php echo $class ?>" data-href="/job?i=<?php echo $item->ID; ?>">

							<td style="width: 150px;">
								<?php if($item->groupmeta['logo']) { ?>
										<?php foreach($item->groupmeta['logo'] as $image_id) echo wp_get_attachment_image($image_id,'recruiter_icon_small'); ?>
								<?php } ?>
							</td>
							<td>
								<h4><?php echo $item->meta['job_title']; ?></h4>
								<p><strong><?php echo $item->groupmeta['recruiter_name']; ?></strong></p>
								<p><?php echo $item->meta['department'] ? $item->meta['department'].'<br />' : ''?>
								<?php if($item->meta['salary_details'] != ''){ ?>
									<p>
										<span><strong><?php echo $item->meta['salary_details']; ?></strong></span><span><strong><?php if($item->meta['location']) echo ', '.$item->meta['location']; ?></strong></span>	
									</p>
								<?php } ?>
								<?php if($item->meta['publish_from'] != '') { ?>
									<p>Placed on <strong><?php echo $item->meta['publish_from']; ?></strong></p>
								<?php } ?>
							</td>
							<td>
								<?php //echo $item->meta['publish_from']; ?>
							</td>

							<td style="text-align: center">
								
								<?php if($item->meta['closing_date']) {
									$datearr = explode(' ', $item->meta['closing_date']); ?>
									<p>Closes</p>
									<div class="calpanel">
										<div class="day"><?php echo $datearr[0]; ?></div>
										<div class="month"><?php echo $datearr[1]; ?></div>
									</div>
								<?php } ?>
								
							</td>
							
						</tr>
					<?php } 
						if(count($items->posts) == 0) echo '<tr class="rowitem"><td colspan=99><h3>No results were found</h3><p>Please broaden your search and try again</p></td></tr>';
						
						
					?>
					</tbody>
				</table>
				
							
			</div>

		
			<div class="clear"></div>
			
		</div>
	</div>
</div>
</div>

<?php $studentships = get_term_by( 'slug', 'academic', 'sector' );
	$children = get_term_children($studentships->term_id, 'sector'); ?>
<script>
	
	jQuery(function(){
		var showids = [<?php echo implode(',', $children); ?>];
		jQuery('#jobs_subscribe select[name="industry"]').find('option').each(function(){
			var termid = parseInt(jQuery(this).attr('termid'));
			if(jQuery(this).val() != ''){
				if(showids.indexOf(termid) !== -1){
					jQuery(this).hide();
				}
			}
		});
	});

</script>



<?php get_footer(); ?>