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
	$teacher_obj = new Smgt_Teacher;
	$obj_route = new Class_routine();	
	$teacher_data=get_userdata($_REQUEST['teacher_id']);
?>
<div class="panel-body">	
	<div class="box-body">
		<div class="row">
			<div class="col-md-3 col-sm-4 col-xs-12">	
				<?php
				$umetadata=get_user_image($teacher_data->ID);
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
					<h2><?php echo $teacher_data->display_name;?></h2>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-3 col-xs-12">
						<i class="fa fa-envelope"></i>&nbsp;
						<span class="email-span"><?php echo $teacher_data->user_email;?></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<i class="fa fa-phone"></i>&nbsp;
						<span><?php echo $teacher_data->phone;?></span>
					</div>
					<div class="col-md-5 col-sm-3 col-xs-12 no-padding">
						<i class="fa fa-map-marker"></i>&nbsp;
						<span><?php echo $teacher_data->address;?></span>
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
								<p class="user-info">: <?php echo $teacher_data->display_name;?></p>
							</div>
							
						<!--</div>
						<div class="row">-->							
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Birth Date', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo smgt_getdate_in_input_box($teacher_data->birth_date);?></p>
							</div>
							<div class="col-md-2">
									<p class="user-lable"><?php _e( 'Gender', 'school-mgt' ) ;?></p>
								</div>
							<div class="col-md-4">
									<!--<p class="user-info">: <?php echo $teacher_data->gender;?></p>-->
									<p class="user-info">: <?php 
									if($teacher_data->gender=='male') 
										echo __('Male','school-mgt');
									elseif($teacher_data->gender=='female') 
										echo __('Female','school-mgt');
									?></p>
							</div>
						<!--</div>
						<div class="row">-->
														
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Class Name', 'school-mgt' );?></p>
							</div>
							<?php
							$classes="";
							$classes = $teacher_obj->smgt_get_class_by_teacher($teacher_data->ID);
							/*   echo '<pre>';
							 print_r ($classes);
							 echo '</pre>'; */
							$classname = "";
							foreach($classes as $class)
							{
								$classname .= get_class_name($class['class_id']).",";
							}
							$classname = trim($classname,",");
							?>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $classname;?></p> 
							</div>
							
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Subject Name', 'school-mgt' );?></p>
							</div>
							<?php
							$subjectname=get_subject_name_by_teacher($teacher_data->ID); 
							?>
							<div class="col-md-4">
								<p class="user-info">: <?php echo rtrim($subjectname,", ");?></p> 
							</div>
						</div>						
					</div>
					
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
								<p class="user-info">: <?php echo $teacher_data->address;?><br></p>
							</div>
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'City', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $teacher_data->city;?></p>
							</div>
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'State', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $teacher_data->state;?></p>
							</div>
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Zipcode', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $teacher_data->zip_code;?></p>
							</div>
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Phone Number', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $teacher_data->phone;?></p>
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
			<li class="active"><a data-toggle="tab" href="#Section1"><i class="fa fa-calendar "></i><b><?php _e( ' Time Table', 'school-mgt' ); ?></b></a></li>
		</ul>
		<div class="tab-content">
			<div id="Section1" class="tab-pane fade in active">
				<div class="row">
					<div class="col-lg-12">
						<div class="card">
							<div class="card-content">
								<table class="table table-bordered">
									<?php 
									foreach(sgmt_day_list() as $daykey => $dayname)
									{	?>
									<tr>
								   <th width="100"><?php echo $dayname;?></th>
									<td>
										 <?php
											$period = $obj_route->get_periad_by_teacher($teacher_data->ID,$daykey);
											 
											if(!empty($period))
												foreach($period as $period_data)
												{
													echo '<div class="btn-group m-b-sm">';
													echo '<button class="btn btn-primary dropdown-toggle" aria-expanded="false" data-toggle="dropdown"><span class="period_box" id='.$period_data->route_id.'>'.get_single_subject_name($period_data->subject_id);
													
													$start_time_data = explode(":", $period_data->start_time);
													$start_hour=str_pad($start_time_data[0],2,"0",STR_PAD_LEFT);
													$start_min=str_pad($start_time_data[1],2,"0",STR_PAD_LEFT);
													$start_am_pm=$start_time_data[2];
													
													$end_time_data = explode(":", $period_data->end_time);
													$end_hour=str_pad($end_time_data[0],2,"0",STR_PAD_LEFT);
													$end_min=str_pad($end_time_data[1],2,"0",STR_PAD_LEFT);
													$end_am_pm=$end_time_data[2];
													echo '<span class="time"> ('.$start_hour.':'.$start_min.' '.$start_am_pm.' - '.$end_hour.':'.$end_min.' '.$end_am_pm.') </span>';
													
													echo '<span>'.get_class_name($period_data->class_id).'</span>';
													echo '</span></span><span class="caret"></span></button>';
													echo '<ul role="menu" class="dropdown-menu">
															<li><a href="?page=smgt_route&tab=addroute&action=edit&route_id='.$period_data->route_id.'">'.__('Edit','school-mgt').'</a></li>
															<li><a href="?page=smgt_route&tab=route_list&action=delete&route_id='.$period_data->route_id.'">'.__('Delete','school-mgt').'</a></li>
														</ul>';
													echo '</div>';					
												}
											?>
										</td>
									</tr>
									<?php	
									}
									?>
								</table>
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
 
	 
