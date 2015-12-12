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
$returnfields = array('job_title','location','summary','recruiter_name','publish_from','salary_details','closing_date','logo','logo_image');


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
			jQuery('#job_bullets table').html('');
			jQuery(this).find('select').each(function(){
				if(jQuery(this).val() != ''){
					var label = jQuery(this).attr('label');
					var opval = jQuery(this).find('option:selected').text().replace(/^- /,'');
					
	 			jQuery('#job_bullets table').append('<tr><td style="width:50%">'+label+'</td><td><strong>'+opval+'</strong></td></tr>').hide().fadeIn(100);
	 			}
			});
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

<!-- <pre><?php print_r($job->getVars()); ?></pre> -->

<div class="container">
	<div class="stage" style="margin: 0">
		
		<div class="col-md-12">
			<div class="row">
				<h1 class="purple">Job advertisements</h1>
			</div>
		</div>
						
			<div class="qtrcol sticky">
				<div class="qpanel darkpurplegrad" id="job_bullets" style="padding: 12px;">
					<table style="width: 90%; margin-bottom: 30px;">
					<?php
						foreach($_GET as $k=>$v){
							if($v) $job->printDetail($k,$_GET);
/*
							if($v){
								if($q = $job->getQuestion($k)){
									$v = ($q['value']) ? array_pop(array_keys($q['value'],$v)) : $v;
								echo '<tr><td>'.$q['label'].'</td><td><strong>'.$v.'</strong></td></tr>';
								}
							}
*/
						}
					?>
					</table>				
					<span id="togglesearchform">Refine search</span>

					<div class="qpanel purplegrad popoutform">
						<form class="directory <?php echo $job->type; ?> search" id="searchjobs" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" return="<?php echo implode(',', $returnfields); ?>" targetid="jobslist" clickableurl="/job">
						
							<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_search_nonce"); ?>" />
							<input type="hidden" name="action" value="directory_search" />
							<input type="hidden" name="inc_search_count" value="true" />
							
							<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('type=job&job_status=published'); ?>" />
						
		
							<div class="question">
								<label>Keywords</label>
								<input type="text" name="keywords" value="<?php echo $_GET['keywords']; ?>" />
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
			</div>
				
			
			
			<?php 
				$params = $_REQUEST ? $_REQUEST : array();
				$params['encrypted'] = $dircore->encrypt('type=job&job_status=published&publish_from=<'.strtotime('now'));
				$params['inc_search_count'] = true;
				$items = directory_search($params);
				
			?>
			
<!-- 			<pre><?php print_r($items); ?></pre> -->

			<div class="threeqtrscol" style="padding-right: 0px;">
				<table class="searchresults">
					
					<thead>
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
						<td style="width: 60px;">[logo_image]</td>
						<td>
							<h4>[job_title], [location]</h4>
							<p>[department]</p>
							<p><strong>[recruiter_name]</strong></p>
							<p><strong>Salary </strong>[salary_details]</p>
						</td>
						<td>[publish_from]</td>
						<td>[closing_date]</td>
					</tr>
								
					<?php if(count($items->posts) > 0) foreach ($items->posts as $item){ ?>
					
						<?php // Promoted (Sponsored) or Premium logic
							$class = '';
							if($item->meta['ad_type'][0] == 'premium') $class = 'premium';
							if($item->meta['ad_type'][0] == 'sponsored') {
								if($item->meta['promote'][0] == $_REQUEST['industry'] && $item->meta['promote_enabled'][0] == 'enabled') {
									$class = 'promoted';
								}
							}
							
							?>
					
						<tr class="clickable rowitem <?php echo $class ?>" data-href="/job?i=<?php echo $item->ID; ?>">
							<td style="width: 60px;">
								<?php if($item->groupmeta['logo']) { ?>
										<?php foreach($item->groupmeta['logo'] as $image_id) echo wp_get_attachment_image($image_id,'tinythumb'); ?>
								<?php } ?>
							</td>
							<td>
								<h4><?php echo $item->meta['job_title']; ?><?php if($item->meta['location']) echo ', '.$item->meta['location']; ?></h4>
								<p><?php echo $item->meta['department'] ? $item->meta['department'].'<br />' : ''?>
								<p><strong><?php echo $item->groupmeta['recruiter_name']; ?></strong></p>
								<p><strong>Salary </strong><?php echo $item->meta['salary_details']; ?></p>
							</td>
							<td>
								<?php echo $item->meta['publish_from']; ?>
							</td>

							<td>
								<?php echo $item->meta['closing_date'];  ?>
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

<?php get_footer(); ?>