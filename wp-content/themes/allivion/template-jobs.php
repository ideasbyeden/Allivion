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
$returnfields = array('logo','logo_image','job_title','location','summary','recruiter_name','closing_date','publish_from');


/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////

?>

<script>
	// Updates purple panel with search params
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
				    	data: 'action=jsapi&type=job&method=getquestion&name='+k,
				    	dataType: 'json',
								
						success: function(question){
							console.log(question.label);
							if(typeof question.value != 'undefined'){
								jQuery.each(question.value, function(qk,qv) {
									if(qv == v) searchval = qk;
								});
							} else {
								searchval = v;
							}
							jQuery('#job_bullets table').append('<tr><td>'+question.label+'</td><td><strong>'+searchval+'</strong></td></tr>').hide().fadeIn(100);
						}
					});

					
				}
			});


		}
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

<div class="section">
	<div class="stage" >
		
		<h1 class="purple">Job advertisements</h1>
		
						
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
							
							<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('type=job'); ?>" />
						
		
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
							<input type="submit" value="Search" class="fr" onClick="formclose('popoutform');"/>
							<div class="clear"></div>
							
						</form>
					</div>
				</div>
			</div>
				
			
			
			<?php 
				$params = $_REQUEST ? $_REQUEST : array();
				$params['encrypted'] = $dircore->encrypt('type=job');
				$params['inc_search_count'] = true;
				$items = directory_search($params);
				
			?>
			
<!-- 			<pre><?php print_r($items); ?></pre> -->

			<div class="threeqtrscol">
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
								</form></td>
						</tr>
					</thead>
							
					<tbody id="jobslist">
						
					<tr class="prototype" data-href="/job?i=">
						<td>[logo_image]</td>
						<td>
							<h4>[job_title], [location]</h4>
							<h5>[recruiter_name]</h5>
							<p>[summary]</p>
						</td>
						<td>[publish_from]</td>
						<td>[closing_date]</td>
					</tr>
								
					<?php if(count($items->posts) > 0) foreach ($items->posts as $item){ ?>
<!-- 					<pre><?php print_r($item->meta); ?></pre> -->
						<tr class="clickable rowitem <?php if(in_array($item->meta['promote'], $item->meta['industry']) || $item->meta['promote_enabled'] != '') echo 'promoted'; ?>" data-href="/job?i=<?php echo $item->ID; ?>">
							<td style="width: 60px;">
								<?php if($item->groupmeta['logo']) { ?>
										<?php foreach($item->groupmeta['logo'] as $image_id) echo wp_get_attachment_image($image_id,'tinythumb'); ?>
								<?php } ?>
							</td>
							<td>
								<h4><?php echo $item->meta['job_title']; ?><?php if($item->meta['location']) echo ', '.$item->meta['location']; ?></h4>
								<h5><?php echo $item->groupmeta['recruiter_name']; ?></h5>
								<p><?php echo $item->meta['summary']; ?></p>
							</td>
							<td>
								<?php echo $item->meta['publish_from'] ? time2str($item->meta['publish_from']) : ''; ?>
							</td>
							<td>
								<?php echo $item->meta['closing_date'] ? date('jS M Y',strtotime($item->meta['closing_date'])) : ''; ?>
							</td>
						</tr>
					<?php } 
						if(count($items->posts) == 0) echo '<tr class="rowitem"><td colspan=99><h3>No results were found</h3><p>Please broaden your search and try again</p></td></tr>';
						
						
					?>
					</tbody>
				</table>
				
							
			</div>

		
			<div class="clear"></div>
			
			<pre><?php //print_r($items->posts); ?></pre>
		</div>
	</div>
</div>

<?php get_footer(); ?>