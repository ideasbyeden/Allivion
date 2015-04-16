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
					<p id="searchform_toggle">Use advanced search</p>

				<form class="directory <?php echo $job->type; ?> homesearch" id="searchjobs" action="/jobs" method="get">
				
					<div class="fields" style="width: 100%;">
					<input type="text" name="keywords" value="<?php echo $_REQUEST['keywords']; ?>" placeholder="I'm looking for..." class="fl" />
					<div class="clear"></div>
					
					<?php $region = $job->getQuestion('region'); ?>
					<select name="region">
						<option value="">Region</option>
						<?php foreach($region['value'] as $k=>$v){ ?>
							<option value="<?php echo $v; ?>"><?php echo $k; ?></option>
						<?php } ?>
					</select>
					
					<?php $salary_range = $job->getQuestion('salary_range'); ?>
					<select name="salary_range">
						<option value="">Salary</option>
						<?php foreach($salary_range['value'] as $k=>$v){ ?>
							<option value="<?php echo $v; ?>"><?php echo $k; ?></option>
						<?php } ?>
					</select>
					
					<?php $contract = $job->getQuestion('contract'); ?>
					<select name="contract">
						<option value="">Contract</option>
						<?php foreach($contract['value'] as $k=>$v){ ?>
							<option value="<?php echo $v; ?>"><?php echo $k; ?></option>
						<?php } ?>
					</select>
					</div>
					
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