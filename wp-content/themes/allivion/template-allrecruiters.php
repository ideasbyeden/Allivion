<?php
	


/*
Template Name: All recruiters
*/

$users = $recruiter_admin->getUsers(array('orderby' => 'recruiter_name'));
	//echo '<pre>'; print_r($users); echo '</pre>';

	if(is_array($users->results)) foreach($users->results as $user){
		if(get_user_meta($user->ID,'subscriber',true) == 'annual' && get_user_meta($user->ID,'logo',true) != ''){
			
			$logo = get_user_meta($user->ID,'logo',true);
			$logourl = wp_get_attachment_image($logo[0],'recruiter_icon');
			$logourl = preg_replace( '/(width|height)="\d*"\s/', "", $logourl );
			
			$params['encrypted'] = $dircore->encrypt('type=job');
			$params['group_id'] = $user->ID;
			$items = directory_search($params);

			$recruiters[] = array('logourl' => $logourl,
									'job_count' => count($items->posts),
									'ID' => $user->ID
									);
		}
	}

	
get_header();
	
while (have_posts()) { 
		the_post();
 


?>

<div class="container">
	<div class="row">
		<div class="col-md-12">
		
		<h1 class="purple"><?php the_title(); ?></h1>
		<?php the_content(); ?>
		</div>
		
		<?php for($i=0; $i<count($recruiters); $i++){ ?>
        <div class="col-md-2 col-sm-3 col-xs-4 recruiter_icon_panel">
            <a href="jobs/?group_id=<?php echo $recruiters[$i]['ID']; ?>">
	            <div class="iconframe">
		            <div class="inner">
	                <?php echo $recruiters[$i]['logourl']; ?>
		            </div>
	            </div>
	            <p><?php echo $recruiters[$i]['job_count']; ?> role<?php echo $recruiters[$i]['job_count'] > 1 ? 's' : ''; ?></p>
            </a>
        </div>
        <?php } ?>
		
	</div>
</div>

<?php } get_footer(); ?>