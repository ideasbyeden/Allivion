<?php
	
	$users = $recruiter_admin->getUsers(array('orderby' => 'recruiter_name'));
	//echo '<pre>'; print_r($users); echo '</pre>';

	if(is_array($users->results)) foreach($users->results as $user){
		if(get_user_meta($user->ID,'subscriber',true) == 'annual' || get_user_meta($user->ID,'logo',true) != ''){
			
			$logo = get_user_meta($user->ID,'logo',true);
			$logourl = wp_get_attachment_image($logo[0],'medium');
			
			$params['encrypted'] = $dircore->encrypt('type=job');
			$params['group_id'] = $user->ID;
			$items = directory_search($params);

			$recruiters[] = array('logourl' => $logourl,
									'job_count' => count($items->posts)
									);
		}
	}
	
	?>
   
   
   <div class="col-md-12">

        <div class="well">
            <div id="myCarousel" class="carousel slide">
                
                <!-- Carousel items -->
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="row">
	                        
	                        <?php for($i=0; $i<count($recruiters); $i++){ ?>
	                        <div class="col-sm-3" style="text-align: center;">
		                        <a href="#x">
			                        <?php echo $recruiters[$i]['logourl']; ?>
			                        <p><?php echo $recruiters[$i]['job_count']; ?> role<?php echo $recruiters[$i]['job_count'] > 1 ? 's' : ''; ?></p>
			                    </a>
			                </div>
		                        
		                    <?php if($i+1 %4 == 0 && $i+1 < count($recruiters)) { ?></div><div class="row"><?php } ?>
		                        
	                        <?php } ?>
	                        

                        </div>
                        <!--/row-->
                    </div>
                    <!--/item-->
                    
                    
                </div>
                <!--/carousel-inner-->
            </div>
            <!--/myCarousel-->
        </div>
        <!--/well-->
    </div>