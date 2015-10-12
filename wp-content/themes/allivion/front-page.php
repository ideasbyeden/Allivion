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

<script>
	jQuery(function(){
		var form = jQuery('form.homesearch');
		var natheight = form.height();
		jQuery('#searchform_toggle').click(function(){
			var d = 0;
			if(jQuery(this).hasClass('open')){
				jQuery(this).removeClass('open').html('Use advanced search');
				form.animate({
					height: natheight
				},500);
				jQuery(jQuery('div.selector').get().reverse()).each(function() {
				    jQuery(this).delay(d).fadeOut(400);
				    d += 100;
				});
			} else {
				jQuery(this).addClass('open').html('Use basic search');			
				jQuery('div.selector').each(function() {
				    jQuery(this).delay(d).fadeIn(400);
				    d += 100;
				});
				form.animate({
					height: '207'
				},500);		}
		})
	});
</script>

<div class="section">
	<div class="stage">
		
			<div id="homesearch">				
					<h2>Find your job</h2>
					<p id="searchform_toggle">Use advanced search</p>

				<form class="directory <?php echo $job->type; ?> homesearch" id="searchjobs" action="/jobs" method="get">
				
					<div class="fields" style="width: 100%;">
					<input type="text" name="keywords" value="<?php echo $_REQUEST['keywords']; ?>" placeholder="I'm looking for..." class="fl" />
					<div class="clear"></div>
					
					<?php $industry = $job->getQuestion('industry'); ?>
					<select name="industry">
						<option value="">Industry</option>
						<?php foreach($industry['value'] as $k=>$v){ ?>
							<option value="<?php echo $v; ?>"><?php echo $k; ?></option>
						<?php } ?>
					</select>
					
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
			
			<div id="homefeaturedjobs">
				<div class="thirdcol">
					<h3>Academic</h3>
					<ul>
					<?php
						$parent = get_term_by('name','Academic','sector');					
						$terms = get_term_children( intval($parent->term_id), 'sector' );
						foreach($terms as $term){
							$term = get_term_by('id',$term,'sector');					
							echo '<li><a href="/jobs?industry='.$term->slug.'">'.$term->name.' ('.$term->count.')</a></li>';
						}
						
					?>
					</ul>
				</div>
				
				<div class="thirdcol">
					<h3>Featured Jobs</h3>
				</div>
				
				<div class="thirdcol">
					<h3>Professional</h3>
					<ul>
					<?php
						$parent = get_term_by('name','Professional','sector');					
						$terms = get_term_children( intval($parent->term_id), 'sector' );
						foreach($terms as $term){
							$term = get_term_by('id',$term,'sector');					
							echo '<li><a href="/jobs?industry='.$term->slug.'">'.$term->name.'</a></li>';
						}
						
					?>
					</ul>
					
					<h3>Studentships</h3>
					<ul>
					<?php
						$parent = get_term_by('name','Studentships','sector');					
						$terms = get_term_children( intval($parent->term_id), 'sector' );
						foreach($terms as $term){
							$term = get_term_by('id',$term,'sector');					
							echo '<li><a href="/jobs?industry='.$term->slug.'">'.$term->name.'</a></li>';
						}
						
					?>
					</ul>
				</div>
			<div class="clear"></div>
			</div>
				
	</div>
</div>

<?php get_footer(); ?>