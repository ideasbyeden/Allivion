	<div class="cta cta-jobalerts">
		<h3 style="margin-top: 0px !important;">Job alert</h3>
		<hr>
		<form class="directory subscription create" id="jobs_subscribe" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
						
						<input type="hidden" name="type" value="subscription" />
						<input type="hidden" name="subscription_type" value="jobalert" />
						<input type="hidden" name="nonce" value="<?php echo wp_create_nonce("directory_create_nonce"); ?>" />
						<input type="hidden" name="action" value="directory_create" />

						<input type="hidden" name="job_title" value="<?php echo $vals['job_title']; ?>" />
						<?php $subscription->printQuestion('item_type','job'); ?>
						<?php $subscription->printQuestion('status','active'); ?>
						<span class="nolabel">
						<?php $subscription->printQuestion('industry',$vals['industry'][0],'dropdown'); ?>
						</span>
						<?php $subscription->printQuestion('subscription_date',strtotime('now')); ?>
						
						<input type="email" name="subscriber_email" value="<?php echo $user->user_email ? $user->user_email : ''; ?>" style="width: 100%"/>
						<input type="hidden" name="expire" value="7" />
						<div class="clear" style="margin-bottom: 10px;"></div>
						<input type="submit" value="Go" />
						<div class="clear"></div>
						
					</form>
	</div>