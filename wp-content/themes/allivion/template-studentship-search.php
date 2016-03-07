<?php
	


/*
Template Name: Studentship search
Post Template: Studentship search
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

<div class="container-fluid studentshipsearch-container">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				
				<div id="homesearch">				
	
					<form class="directory <?php echo $job->type; ?> homesearch" id="searchjobs" action="/jobs" method="get">
					<h2 style="color: white;">Find your studentship</h2>
					<p id="searchform_toggle">Use advanced search</p>

						<div class="fields" style="width: 100%;">
							
							
							
							<input type="text" name="keywords" value="<?php echo $_REQUEST['keywords']; ?>" placeholder="I'm looking for..." class="fl" />
							<div class="clear"></div>
							
							<input type="hidden" name="industry" value="studentships" />
							<?php $job->printQuestion('region',null,'dropdown',true,false); ?>
							<?php $job->printQuestion('salary_range',null,'dropdown',true,false); ?>
							<?php $job->printQuestion('studentship_funding',null,'dropdown',true,false); ?>
							<?php $job->printQuestion('qualification',null,'dropdown',true,false); ?>
							<?php $job->printQuestion('industry',null,'dropdown',true,false); ?>
						</div>
						
						<input type="submit" value="Go" class="fr"/>
						<div class="clear"></div>
						
					</form>
				</div>
	
			</div>
			
			
		</div><!-- end row -->
	</div>
</div>

<div class="container-fluid">
	<div class="container">
		<div class="row">

			<!-- Logo carousel -->
			<div class="hidden-xs">
			<?php $extraparams['industry'] = 'studentships'; require(TEMPLATEPATH.'/includes/logo_carousel.php'); ?>	
			</div>
			
		</div>
	</div>
</div>

	
<div class="container">			
	
	<div class="row boxad_array boxad_array_1" style="padding-top: 60px; padding-bottom: 40px;">
		<div class="col-md-12">
			<h2 class="purple">Featured jobs</h2>
		</div>
		<?php $home = get_page_by_title('Home'); ?>
		<div class="col-sm-4" style="text-align: center">
			
			<a href="<?php the_field('boxad_1_link',$home->ID); ?>" target="_blank">
			<img src="<?php the_field('box_ad_1',$home->ID); ?>" class="mptrack" data-mpitem="boxad" data-mpevent="ad1click" />
			</a>
			
		</div>
		<div class="col-sm-4" style="text-align: center">
		
	
			<?php //include(TEMPLATEPATH.'/revive-zones/boxad_2.html'); ?>
			<a href="<?php the_field('boxad_2_link',$home->ID); ?>" target="_blank">
			<img src="<?php the_field('box_ad_2',$home->ID); ?>" class="mptrack" data-mpitem="boxad" data-mpevent="ad2click"  />
			</a>

		</div>
		<div class="col-sm-4" style="text-align: center">


			<?php //include(TEMPLATEPATH.'/revive-zones/boxad_3.html'); ?>
			<a href="<?php the_field('boxad_3_link',$home->ID); ?>" target="_blank">
			<img src="<?php the_field('box_ad_3',$home->ID); ?>" class="mptrack" data-mpitem="boxad" data-mpevent="ad3click"  />
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

<?php $studentships = get_term_by( 'slug', 'academic', 'sector' );
	$children = get_term_children($studentships->term_id, 'sector'); ?>
<script>
	
	jQuery(function(){
		var showids = [<?php echo implode(',', $children); ?>];
		jQuery('select[name="industry"]').find('option').each(function(){
			var termid = parseInt(jQuery(this).attr('termid'));
			if(showids.indexOf(termid) == -1){
				jQuery(this).hide();
			}
		});
	});
	
</script>



<?php get_footer(); ?>
