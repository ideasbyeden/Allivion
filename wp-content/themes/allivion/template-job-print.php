<?php
	


/*
Template Name: Job Print
Post Template: Job Print
*/




if(!$_REQUEST['i'] || !$job->itemExists($_REQUEST['i'])) header("Location: /index.php");

get_template_part('header','print');
	
while (have_posts()) { 
		the_post();
		the_content();
} 

/////////////////////////////////////////////
//
// Page config
//
/////////////////////////////////////////////

// Data for job being displayed
$vals = $_REQUEST['i'] ? $job->getVals($_REQUEST['i']) : null;

// Data for employer
$employer = $_REQUEST['i'] ? $recruiter->getVals(get_post_meta($_REQUEST['i'],'group_id',true)) : null;
//echo '<pre>'; print_r($employer); echo '</pre>';

// Data for logged in user to autopopulate
$uservals['first_name'] = $usermeta['first_name'];
$uservals['last_name'] = $usermeta['last_name'];
$uservals['email'] = $user->user_email;


/////////////////////////////////////////////
//
// End Page config
//
/////////////////////////////////////////////

$adtype = $vals['ad_type'][0] ? $vals['ad_type'][0] : 'standard';

?>
<div class="container-fluid a2apad">
<div class="container">
	<div class="row">
		
		<div class="col-md-12">	

			<div>
				<?php
					if($vals['ad_type'][0] && $vals['ad_type'][0] != 'standard' && $employer['brand_header']){
						foreach($employer['brand_header'] as $image_id) echo '<span id="brand_header">'.wp_get_attachment_image($image_id,'brand_header').'</span>';						
					} else if($employer['logo']) {
						foreach($employer['logo'] as $image_id) echo '<span id="logo">'.wp_get_attachment_image($image_id,'recruiter_icon_small').'</span>';
					} ?>
			</div>					
			<h1 class="purple"><?php echo $vals['job_title']; ?></h1>
			<h4>
				<span id="employer"><strong><?php echo $employer['recruiter_name']; ?></strong></span>
				<span id="department"><?php echo $vals['department'] ? ' - '.$vals['department'] : ''; ?></h6>
				<h5>Posted: <strong><?php echo $vals['publish_from']; ?></strong></h5>
			
			<div class="row jobspec">
			<div class="col-md-4">
				<h5>Salary: <strong><?php echo $vals['salary_details']; ?></strong></h5>
				<h5>Location: <strong><?php echo $vals['location'] ? $vals['location'] : ''; ?></strong></h5>
				<h5>Hours: <strong><?php echo $vals['hours'][0]; ?></strong></h5>
				<h5>Contract: <strong><?php echo $vals['contract'][0]; ?></strong></h5>
				<h5>Job ref: <strong><?php echo $vals['job_ref']; ?></strong></h5>
			</div>

			<div class="col-md-4" style="text-align: center;">
				
				<?php if($vals['closing_date']) {
					$datearr = explode(' ', $vals['closing_date']); ?>
					<h4 class="purple">Applications close</h4>
				<div class="calpanel">
					<div class="day"><?php echo $datearr[0]; ?></div>
					<div class="month"><?php echo $datearr[1]; ?></div>
				</div>
				<?php } ?>
				
			</div>
			</div>
			
			<div>
				<span id="full_description">
					<?php if($vals['ad_type'][0] == 'standard'){
							echo $vals['full_description_limited'] ? $vals['full_description_limited'] : 'Job description'; 
						} else {
							echo $vals['full_description'] ? $vals['full_description'] : 'Job description'; 
						}							
						?>
				</span>
			</div>
			
		</div>
	</div>
</div>
</div>
			

			

			
			
		
<?php get_template_part('footer','print'); ?>

<script>
	jQuery(window).load(function(){
		window.print();
	})
</script>