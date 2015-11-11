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

<div class="container">
	<div class="row">
		
		<div class="col-sm-12" id="homesearch">				
				<h2>Find your job</h2>
				<p id="searchform_toggle">Use advanced search</p>

			<form class="directory <?php echo $job->type; ?> homesearch" id="searchjobs" action="/jobs" method="get">
			
				<div class="fields" style="width: 100%;">
				<input type="text" name="keywords" value="<?php echo $_REQUEST['keywords']; ?>" placeholder="I'm looking for..." class="fl" />
				<div class="clear"></div>
				
				<?php $job->printQuestion('industry',null,'dropdown',true); ?>
				<?php $job->printQuestion('region',null,'dropdown',true); ?>
				<?php $job->printQuestion('salary_range',null,'dropdown',true); ?>
				<?php $job->printQuestion('contract',null,'dropdown',true); ?>
<!--
				<select name="industry">
					<option value="">Industry</option>
					<?php foreach($industry['value'] as $k=>$v){ ?>
						<option value="<?php echo $v; ?>"><?php echo $k; ?></option>
					<?php } ?>
				</select>
-->
				
				</div>
				
				<input type="submit" value="Go" class="fr"/>
				<div class="clear"></div>
				
			</form>

		</div>
	</div>
			
	<div class="row"  id="homefeaturedjobs">
		<div class="col-sm-12">
			<ul class="nav nav-tabs nav-justified">
				<li role="presentation" class="active"><a data-toggle="tab" href="#academic_cats">Academic &<br />Research Careers</a></li>
				<li role="presentation"><a data-toggle="tab" href="#professional_cats">Professional<br />Careers</a></li>
				<li role="presentation"><a data-toggle="tab" href="#studentships_cats">Studentships<br />&nbsp;</a></li>
			</ul>
			<div class="tab-content">
				<div id="academic_cats" class="tab-pane fade in active">
					<ul class="cc3">
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

				<div id="professional_cats" class="tab-pane fade">
					<ul class="cc3">
					<?php
						$parent = get_term_by('name','Professional','sector');					
						$terms = get_term_children( intval($parent->term_id), 'sector' );
						foreach($terms as $term){
							$term = get_term_by('id',$term,'sector');					
							echo '<li><a href="/jobs?industry='.$term->slug.'">'.$term->name.' ('.$term->count.')</a></li>';
						}
						
					?>
					</ul>
				</div>

				<div id="studentships_cats" class="tab-pane fade">
					<ul class="cc1">
					<?php
						$parent = get_term_by('name','Studentships','sector');					
						$terms = get_term_children( intval($parent->term_id), 'sector' );
						foreach($terms as $term){
							$term = get_term_by('id',$term,'sector');					
							echo '<li><a href="/jobs?industry='.$term->slug.'">'.$term->name.' ('.$term->count.')</a></li>';
						}
						
					?>
					</ul>
				</div>

			</div>
		</div>
	</div><!-- end row -->
			
			
			<!-- Logo carousel -->
	<?php require(TEMPLATEPATH.'/includes/logo_carousel.php'); ?>		
 
				
</div>

<?php get_footer(); ?>

<script>
	jQuery(function() {
	jQuery('#myCarousel').carousel({
	interval: 4000
	})
    
    $('#myCarousel').on('slid.bs.carousel', function() {
    	//alert("slid");
	});
    
    
});
</script>

