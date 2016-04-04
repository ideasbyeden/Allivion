<div class="whitepanel" style="margin-top: 0px;">

<?php $employer = (array)$recruiter->data->meta;
//echo '<pre>'; print_r($recruiter->data->meta); echo '</pre>';


if($employer['logo']) echo wp_get_attachment_image($employer['logo'],'recruiter_icon_small',false,array( 'class' => 'fl','style' => 'margin: 0 20px 20px 0' )); ?>

<div class="clear"></div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

	<h1 style="margin-top: 0px !important;"><?php echo $employer['recruiter_name']; ?></h1>
</div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	<?php if($employer['website']) { ?>
		<a href="<?php echo $employer['website']; ?>" target="_blank">
			<input type="button" value="Visit our website" class="btn btn-purple"/>
		</a>
	<?php } ?>

	<?php if($employer['contactpage']) { ?>
		<a href="<?php echo $employer['contactpage']; ?>" target="_blank">
			<input type="button" value="Contact us" class="btn btn-purple"/>
		</a>
	<?php } ?>

	<?php if($employer['jobspage']) { ?>
		<a href="<?php echo $employer['jobspage']; ?>" target="_blank">
			<input type="button" value="Our jobs" class="btn btn-purple"/>
		</a>
	<?php } ?>


</div>
<div class="clear"></div>
<hr>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	<p><?php echo $employer['boilerplate']; ?></p>	
</div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="height: 250px">


	

	<?php include(TEMPLATEPATH.'/includes/recruiter_video.php'); ?>
	
</div>
<div class="clear" style="margin-bottom: 20px"></div>
</div>
<h3>Current jobs and studentships at <?php echo $recruiter->data->meta['recruiter_name']; ?></h2>
