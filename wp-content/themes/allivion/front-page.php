<?php
	
get_template_part('header');
	
while (have_posts()) { 
		the_post();
		echo '<div class="section"><div class="stage">';
		the_content();
		echo '</div></div>';
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
		
			<div id="homesearch">				
					<h2>Find your job</h2>

				<form class="directory <?php echo $job->type; ?> homesearch" id="searchjobs" action="/jobs" method="get">
				
					<input type="text" name="keywords" value="<?php echo $_REQUEST['keywords']; ?>" placeholder="I'm looking for..." class="fl" />
					<input type="submit" value="Go" class="fr"/>
					<div class="clear"></div>
					
				</form>

			</div>
			
			<div id="homecats">
				
			</div>
				
			<div class="clear"></div>
	</div>
</div>

<?php get_footer(); ?>