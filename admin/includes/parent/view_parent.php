<script>
$(document).ready(function(){
	$(".view_more_details_div").on("click", ".view_more_details", function(event)
	{
		$('.view_more_details_div').css("display", "none");
		$('.view_more_details_less_div').css("display", "block");
		$('.user_more_details').css("display", "block");
	});		
	$(".view_more_details_less_div").on("click", ".view_more_details_less", function(event)
	{
		$('.view_more_details_div').css("display", "block");
		$('.view_more_details_less_div').css("display", "none");
		$('.user_more_details').css("display", "none");
	});
});

</script>
<style>
.bounce {
  -moz-animation: bounce 2s infinite;
  -webkit-animation: bounce 2s infinite;
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 20%, 50%, 80%, 100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-15px);
  }
  60% {
    transform: translateY(-5px);
  }
}
</style>
<?php
 $parent_data=get_userdata($_REQUEST['parent_id']);
 $user_meta =get_user_meta($_REQUEST['parent_id'], 'child', true); 
?>
<div class="panel-body">	
	<div class="box-body">
		<div class="row">
			<div class="col-md-3 col-sm-4 col-xs-12">	
				<?php
				$umetadata=get_user_image($parent_data->ID);
				if(empty($umetadata['meta_value']))
				{
					echo '<img class="img-circle img-responsive member-profile" src='.get_option( 'smgt_student_thumb' ).' style="height:150px;width:150px;"/>';
				}
				else
					echo '<img class="img-circle img-responsive member-profile user_height_width" src='.$umetadata['meta_value'].'>';
				?>
			</div>
			
			<div class="col-md-9 col-sm-8 col-xs-12 ">
				<div class="row">
					<h2><?php echo $parent_data->display_name;?></h2>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-3 col-xs-12">
						<i class="fa fa-envelope"></i>&nbsp;
						<span class="email-span"><?php echo $parent_data->user_email;?></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<i class="fa fa-phone"></i>&nbsp;
						<span><?php echo $parent_data->phone;?></span>
					</div>
					<div class="col-md-5 col-sm-3 col-xs-12 no-padding">
						<i class="fa fa-map-marker"></i>&nbsp;
						<span><?php echo $parent_data->address;?></span>
					</div>
				</div>					
			</div>
		</div>
			
		<div class="row">
			<div class="view-more view_more_details_div" style="display:block;">
				<h4><?php _e( 'View More', 'school-mgt' ) ;?></h4>
					<i class="fa fa-angle-down fa-2x bounce view_more_details"></i>
			</div>
			<div class="view-more view_more_details_less_div " style="display:none;">
				<h4><?php _e( 'View Less', 'school-mgt' ) ;?></h4>
					<i class="fa fa-angle-up fa-2x view_more_details_less"></i>
			</div>
		</div>
		<hr>
			<div class="user_more_details" style="display: none;">
				<div class="card">
					<div class="card-head">
						<i class="fa fa-user"></i>
						<span><b><?php _e( 'Personal Information', 'school-mgt' ) ;?></b></span>
					</div>
					<div class="card-body">
						<div class="row">							
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Name', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $parent_data->display_name;?></p>
							</div>
							
						<!--</div>
						<div class="row">-->							
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Birth Date', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo smgt_getdate_in_input_box($parent_data->birth_date);?></p>
							</div>
							<div class="col-md-2">
									<p class="user-lable"><?php _e( 'Gender', 'school-mgt' ) ;?></p>
								</div>
							<div class="col-md-4">
									<p class="user-info">: <?php echo $parent_data->gender;?></p>
							</div>
						<!--</div>
						<div class="row">-->
														
							 <div class="col-md-2">
									<p class="user-lable"><?php _e( 'Relation', 'school-mgt' ) ;?></p>
								</div>
							<div class="col-md-4">
									<p class="user-info">: <?php echo $parent_data->relation;?></p>
							</div>
							
							 
						 
							</div>
						</div>						
					</div>
				<div class="card">
					<div class="card-head">
						<i class="fa fa-map-marker"></i>
						<span> <b><?php _e( 'Contact Information', 'school-mgt' ) ;?> </b></span>
					</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Address', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $parent_data->address;?><br></p>
							</div>
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'City', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $parent_data->city;?></p>
							</div>
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'State', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $parent_data->state;?></p>
							</div>
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Zipcode', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $parent_data->zip_code;?></p>
							</div>
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Phone Number', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $parent_data->phone;?></p>
							</div>
						</div>											
					</div>
					 
				</div>
			</div>
		</div>
</div>
   
<div class="panel-body">
	<div class="row">	
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#Section1"><i class="fa fa-user"></i><b><?php _e( ' Child', 'school-mgt' ); ?></b></a></li>
		</ul>
	<script>
	jQuery(document).ready(function() {
		var table =  jQuery('#child_list').DataTable({
			responsive: true,
			"order": [[ 0, "asc" ]],
			"aoColumns":[	                  
			{"bSortable": false},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true},
			{"bSortable": true}],
			language:<?php echo smgt_datatable_multi_language();?>				
		});
	});
	</script>
		<div class="tab-content">
			<div id="Section1" class="tab-pane fade in active">
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-content">
								 <div class="table-responsive">
									  <table id="child_list" class="display table" cellspacing="0" width="100%">
									  <thead>
											<tr>
											  <th><?php _e('Photo','school-mgt');?></th>
											  <th><?php _e('Child Name','school-mgt');?></th>
											  <th><?php _e('Roll No','school-mgt');?></th>
											  <th><?php _e('Class','school-mgt');?></th>
											  <th><?php _e('Child Email','school-mgt');?></th>
											</tr>
										</thead>
										<tfoot>
											<tr>
											  <th><?php _e('Photo','school-mgt');?></th>
											  <th><?php _e('Child Name','school-mgt');?></th>
											  <th><?php _e('Roll No','school-mgt');?></th>
											  <th><?php _e('Class','school-mgt');?></th>
											  <th><?php _e('Child Email','school-mgt');?></th>
											</tr>
										</tfoot>
										<tbody>
										<?php
										if(!empty($user_meta))
										{
											foreach($user_meta as $childsdata)
											{
											$child=get_userdata($childsdata);?>
										<tr>
										  <td><?php 
											if($childsdata)
											{
												$umetadata=get_user_image($childsdata);
											}
											if(empty($umetadata['meta_value']))
											{
												echo '<img src='.get_option( 'smgt_student_thumb' ).' height="50px" width="50px" class="img-circle" />';
											}
											else
												echo '<img src='.$umetadata['meta_value'].' height="50px" width="50px" class="img-circle"/>';?></td>
										  <td><?php echo $child->first_name." ".$child->last_name;?></td>
										  <td><?php echo get_user_meta($child->ID, 'roll_id',true);?></td>
										  <td>
											<?php  $class_id=get_user_meta($child->ID, 'class_name',true);
											echo $classname=get_class_name($class_id);?>
										  </td> 
										  <td><?php echo $child->user_email;?></td> 
										</tr>
										<?php
											}
										}
										?>
									</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		<div id="Section2" class="tab-pane fade">
					 
		</div>
		 
		</div>
	</div>
</div>
 
	 
