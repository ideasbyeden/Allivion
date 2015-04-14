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
$returnfields = array('job_title','location','summary','recruiter_name','closing_date');


/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////



?>

<div class="section">
	<div class="stage">
		
		<h1 class="purple">Job advertisements</h1>
		
						
			<div class="thirdcol">
				<div class="qpanel purplegrad" id="job_bullets">				

					<form class="directory <?php echo $job->type; ?> search" id="searchjobs" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post" return="<?php echo implode(',', $returnfields); ?>" targetid="jobslist" clickableurl="/job">
					
						<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_search_nonce"); ?>" />
						<input type="hidden" name="action" value="directory_search" />
						<input type="hidden" name="inc_search_count" value="true" />
						
						<input type="hidden" name="encrypted" value="<?php echo $dircore->encrypt('type=job'); ?>" />
					
	
						<h2>Search jobs</h2>
						<label>Keywords</label><input type="text" name="keywords" value="<?php echo $_REQUEST['keywords']; ?>" />
						<input type="submit" value="Search" class="fr"/>
						<div class="clear"></div>
						
					</form>

				</div>
			</div>
				
			
			
			<?php 
				$params = $_GET ? $_GET : array();
				$params['encrypted'] = $dircore->encrypt('type=job');
				$params['inc_search_count'] = true;
				$items = directory_search($params);
				
			?>
			
			<pre><?php //print_r($items); ?></pre>

			<div class="twothirdscol">
				<table class="searchresults">
					
							
					<tbody id="jobslist">
						
					<tr class="prototype" data-href="/job?i=">
						<td>[logo]</td>
						<td>
							<h4>[job_title], [location]</h4>
							<h5>[recruiter_name]</h5>
							<p>[summary]</p>
						</td>
						<td>[closing_date]</td>
					</tr>
								
					<?php foreach ($items->posts as $item){ ?>
						<tr class="clickable rowitem" data-href="/job?i=<?php echo $item->ID; ?>">
							
							<?php if($item->meta['logo']) { ?><td><?php echo $item->meta['logo']; ?></td><?php } ?>
							<td>
								<h4><?php echo $item->meta['job_title']; ?><?php if($item->meta['location']) echo ', '.$item->meta['location']; ?></h4>
								<h5><?php echo $item->groupmeta['recruiter_name']; ?></h5>
								<p><?php echo $item->meta['summary']; ?></p>
							</td>
							<td>
								<p><?php echo $item->meta['closing_date']; ?></p>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>			
			</div>

		
			<div class="clear"></div>
		</div>
	</div>
</div>

<?php get_footer(); ?>