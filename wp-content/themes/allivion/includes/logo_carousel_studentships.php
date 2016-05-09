<?php  // Source: http://www.bootply.com/J0NcrdSwY6#
	
	$users = $recruiter_admin->getUsers(array('orderby' => 'recruiter_name'));
	//echo '<pre>'; print_r($users); echo '</pre>';

	if(is_array($users->results)) foreach($users->results as $user){
		
		$params = array();
		if(is_array($extraparams)) $params = array_merge($params,$extraparams);
		if(get_user_meta($user->ID,'subscriber',true) == 'annual' && get_user_meta($user->ID,'logo',true) != ''){
			
			$logo = get_user_meta($user->ID,'logo',true);
			$logourl = wp_get_attachment_image($logo[0],'recruiter_icon');
			$logourl = preg_replace( '/(width|height)="\d*"\s/', "", $logourl );
			
			$params['encrypted'] = $dircore->encrypt('type=job&job_status=published&industry=academic&publish_from=<'.strtotime('now').'&closing_date=>'.strtotime('yesterday'));
			$params['group_id'] = $user->ID;
			$items = directory_search($params);
			
			//echo '<pre>Params:<br />'; print_r($params); echo '</pre>';

			$recruiters[] = array('logourl' => $logourl,
									'job_count' => count($items->posts),
									'ID' => $user->ID
									);
		}
	}
	
	?>
   
   
			<h2 class="purple">Studentship recruiters</h2>
            <div id="recruiters_carousel" class="carousel slide">
                
                <!-- Carousel items -->
                <div class="carousel-inner">
                    <div class="item active">
                        <div class="row">
	                        
	                        <?php for($i=0; $i<count($recruiters); $i++){ ?>
	                        <div class="col-sm-2 recruiter_icon_panel" style="text-align: center;">
		                        
		                        <?php $extendquery = $extraparams ? '&'.http_build_query($extraparams) : ''; ?>
		                        
		                        <a href="jobs/?group_id=<?php echo $recruiters[$i]['ID'].$extendquery; ?>">
	            <div class="iconframe">
		            <div class="inner">
	                <?php echo $recruiters[$i]['logourl']; ?>
		            </div>
	            </div>
	            <p class="orange"><?php echo $recruiters[$i]['job_count']; ?> studentship<?php echo $recruiters[$i]['job_count'] != 1 ? 's' : ''; ?></p>
            </a>
			                </div>
		                        
		                    <?php if(($i+1) %6 == 0 && ($i+1) < count($recruiters)) echo '</div></div><div class="item"><div class="row">'; ?>
		                        
	                        <?php } // end for loop ?>
	                        

                        </div>
                        <!--/row-->
                    </div>
                    <!--/item-->
                    
                    
                </div>
                <!--/carousel-inner-->
                
                <a class="left carousel-control" href="#recruiters_carousel" data-slide="prev"></a>

                <a class="right carousel-control" href="#recruiters_carousel" data-slide="next"></a>
            </div>
            <!--/myCarousel-->
    
    <div class="col-md-12" style="text-align: center; margin-bottom: 20px;">
	    <a href="/recruiters"><button type="button" class="btn btn-default">See all recruiters</button></a>
    </div>