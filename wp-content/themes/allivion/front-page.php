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
			}
		});
	});
</script>

<?php $bg = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_id()), 'full' ); ?>

<div class="container-fluid homesearch-container" style="background-image: url(<?php echo $bg[0]; ?>);">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				
				<div id="homesearch">
					
					<h1 style="color: white !important; margin: -30px 0 0 0; text-align: center; font-size: 4em;">Welcome to Allivion</h1>
					<h2 style="color: white !important; margin: 0 0 30px;text-align: center;">Your academic, professional and research job board</h2>				
	
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

	<?php the_post_thumbnail_caption(); ?>

	<span class="featurelinks"><a href="/career-advice">Tour blog</a> | Do you want us to visit and feature your University? <a href="/host-a-visit">Host a Visit</a>
</div>



	
<div class="container">			
	<div class="row"  id="homefeaturedjobs">
		<div class="col-sm-12">
			<h2 class="purple">Browse jobs by sector</h2>
			<ul class="nav nav-tabs nav-justified" id="sectortabs">
				<li role="presentation" class="active">
					<a data-toggle="tab" href="#academic_cats" class="academic">
						<span class="icon"></span>
						Academic &&nbsp;<br class="hidden-sm hidden-xs"/>Research Jobs
					</a>
				</li>
				<li role="presentation">
					<a data-toggle="tab" href="#professional_cats" class="professional">
						<span class="icon"></span>
						Professional&nbsp;<br class="hidden-sm hidden-xs"/>Jobs
					</a>
				</li>
				<li role="presentation">
					<a data-toggle="tab" href="#studentships_cats" class="studentships">
						<span class="icon"></span>
						Studentships<br class="hidden-sm hidden-xs"/>&nbsp;
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

							if($term->parent == $parent->term_id){

								$params['encrypted'] = $dircore->encrypt('type=job&job_status=published&publish_from=<'.strtotime('now').'&closing_date=>'.strtotime('now'));

								$params['industry'] = $term->slug;
								$items = directory_search($params);
				
						
								echo '<li><a href="/jobs?industry='.$term->slug.'">'.$term->name.' <span class="orange jobcount">('.count($items->posts).')</span></a></li>';
							
							}
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
							
							$params['encrypted'] = $dircore->encrypt('type=job&job_status=published&publish_from=<'.strtotime('now').'&closing_date=>'.strtotime('now'));

								$params['industry'] = $term->slug;
								$items = directory_search($params);

											
							echo '<li><a href="/jobs?industry='.$term->slug.'">'.$term->name.' <span class="orange jobcount">('.count($items->posts).')</span></a></li>';
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
							
							$params['encrypted'] = $dircore->encrypt('type=job&job_status=published&publish_from=<'.strtotime('now').'&closing_date=>'.strtotime('now'));

								$params['industry'] = $term->slug;
								$items = directory_search($params);						
											
							echo '<li><a href="/jobs?industry='.$term->slug.'">'.$term->name.' <span class="orange jobcount">('.count($items->posts).')</span></a></li>';
						}
						
					?>
					</ul>
					</div>
				</div>

			</div>
		</div>
	</div><!-- end row -->
			
			
			<!-- Logo carousel -->
	<div class="hidden-xs">
	<?php require(TEMPLATEPATH.'/includes/logo_carousel.php'); ?>	
	</div>
	
	
	<div class="row boxad_array boxad_array_1" style="padding-top: 60px; padding-bottom: 40px;">
		<div class="col-md-12">
			<h2 class="purple">Featured jobs</h2>
		</div>
		<div class="col-sm-4" style="text-align: center">
			
			<a href="<?php the_field('boxad_1_link'); ?>" target="_blank">
			<img src="<?php the_field('box_ad_1'); ?>" class="mptrack" data-mpitem="boxad" data-mpevent="ad1click" />
			</a>
			
		</div>
		<div class="col-sm-4" style="text-align: center">
		
	
			<?php //include(TEMPLATEPATH.'/revive-zones/boxad_2.html'); ?>
			<a href="<?php the_field('boxad_2_link'); ?>" target="_blank">
			<img src="<?php the_field('box_ad_2'); ?>" class="mptrack" data-mpitem="boxad" data-mpevent="ad2click"  />
			</a>

		</div>
		<div class="col-sm-4" style="text-align: center">


			<?php //include(TEMPLATEPATH.'/revive-zones/boxad_3.html'); ?>
			<a href="<?php the_field('boxad_3_link'); ?>" target="_blank">
			<img src="<?php the_field('box_ad_3'); ?>" class="mptrack" data-mpitem="boxad" data-mpevent="ad3click"  />
			</a>

		</div>
	</div>	
 
				
</div>

<div class="container a2apad">
	<div class="row">
		<div class="col-md-3">
			<?php include('includes/cta-uploadcv.php'); ?>
		</div>
		<div class="col-md-3">
			<?php include('includes/cta-feedback.php'); ?>
		</div>
		<div class="col-md-3">
			<?php include('includes/cta-jobalert.php'); ?>
		</div>
		<div class="col-md-3">
			<?php include('includes/cta-advertise.php'); ?>
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

