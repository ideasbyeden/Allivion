<?php
	
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

<script>
	jQuery(function(){
		var form = jQuery('form.homesearch');
		var natheight = form.height();
		jQuery('#searchform_toggle').click(function(){
			var d = 0;
			if(jQuery(this).hasClass('open')){
				jQuery(this).removeClass('open').html('Use advanced search');
				form.animate({
					height: '155'
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
					height: '317'
				},500);		}
		})
	});
</script>

<div class="container-fluid homesearch-container">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				
				<div id="homesearch">				
	
					<form class="directory <?php echo $job->type; ?> homesearch" id="searchjobs" action="/jobs" method="get">
					<h2 style="color: white;">Find your job</h2>
					<p id="searchform_toggle">Use advanced search</p>

						<div class="fields" style="width: 100%;">
							
							
							
							<input type="text" name="keywords" value="<?php echo $_REQUEST['keywords']; ?>" placeholder="I'm looking for..." class="fl" />
							<div class="clear"></div>
							
							<?php $job->printQuestion('industry',null,'dropdown',true); ?>
							<?php $job->printQuestion('region',null,'dropdown',true); ?>
							<?php $job->printQuestion('salary_range',null,'dropdown',true); ?>
							<?php $job->printQuestion('contract',null,'dropdown',true); ?>
						</div>
						
						<input type="submit" value="Go" class="fr"/>
						<div class="clear"></div>
						
					</form>
				</div>
	
			</div>
		</div>
	</div>
</div>
	
<div class="container">			
	<div class="row"  id="homefeaturedjobs">
		<div class="col-sm-12">
			<h2 class="purple">Browse jobs by sector</h2>
			<ul class="nav nav-tabs nav-justified">
				<li role="presentation" class="active">
					<a data-toggle="tab" href="#academic_cats" class="academic">
						<span class="icon"></span>
						Academic &<br />Research Careers
					</a>
				</li>
				<li role="presentation">
					<a data-toggle="tab" href="#professional_cats" class="professional">
						<span class="icon"></span>
						Professional<br />Careers
					</a>
				</li>
				<li role="presentation">
					<a data-toggle="tab" href="#studentships_cats" class="studentships">
						<span class="icon"></span>
						Studentships<br />&nbsp;
					</a>
				</li>
			</ul>
			<div class="tab-content">
				<div id="academic_cats" class="tab-pane fade in active">
					<ul class="cc3">
					<?php
						$parent = get_term_by('name','Academic','sector');					
						$terms = get_term_children( intval($parent->term_id), 'sector' );
						foreach($terms as $term){
							$term = get_term_by('id',$term,'sector');					
							echo '<li><a href="/jobs?industry='.$term->slug.'">'.$term->name.' <span class="orange jobcount">('.$term->count.')</span></a></li>';
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
							echo '<li><a href="/jobs?industry='.$term->slug.'">'.$term->name.' <span class="orange jobcount">('.$term->count.')</span></a></li>';
						}
						
					?>
					</ul>
				</div>

				<div id="studentships_cats" class="tab-pane fade">
					<div class="col-xs-4" style="padding: 0px">
					<ul class="cc1">
					<?php
						$parent = get_term_by('name','Studentships','sector');					
						$terms = get_term_children( intval($parent->term_id), 'sector' );
						foreach($terms as $term){
							$term = get_term_by('id',$term,'sector');					
							echo '<li><a href="/jobs?industry='.$term->slug.'">'.$term->name.' <span class="orange jobcount">('.$term->count.')</span></a></li>';
						}
						
					?>
					</ul>
					</div>
				</div>

			</div>
		</div>
	</div><!-- end row -->
			
			
			<!-- Logo carousel -->
	<?php require(TEMPLATEPATH.'/includes/logo_carousel.php'); ?>	
	
	
	<div class="row boxad_array boxad_array_1" style="padding-top: 60px; padding-bottom: 40px;">
		<div class="col-sm-4" style="text-align: center">
			
			<?php //include(TEMPLATEPATH.'/revive-zones/boxad_1.html'); ?>
			<img src="<?php bloginfo('template_url'); ?>/img/box_ad_1.jpg" />

			
		</div>
		<div class="col-sm-4" style="text-align: center">
		
	
			<?php //include(TEMPLATEPATH.'/revive-zones/boxad_2.html'); ?>
			<img src="<?php bloginfo('template_url'); ?>/img/box_ad_2.jpg" />

		</div>
		<div class="col-sm-4" style="text-align: center">


			<?php //include(TEMPLATEPATH.'/revive-zones/boxad_3.html'); ?>
			<img src="<?php bloginfo('template_url'); ?>/img/box_ad_3.jpg" />

		</div>
	</div>	
 
				
</div>

<?php get_footer(); ?>

<script>
	jQuery(function() {
		jQuery('#recruiters_carousel').carousel({ interval: 4000 });
    });
</script>

<script>
	jQuery(function(){
		jQuery('.tab-content')
	})
</script>

