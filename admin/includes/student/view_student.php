<script>
jQuery(document).ready(function($){
	jQuery(".view_more_details_div").on("click", ".view_more_details", function(event)
	{
		$('.view_more_details_div').css("display", "none");
		$('.view_more_details_less_div').css("display", "block");
		$('.user_more_details').css("display", "block");
	});		
	jQuery(".view_more_details_less_div").on("click", ".view_more_details_less", function(event)
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
 $student_data=get_userdata($_REQUEST['student_id']);
$user_meta =get_user_meta($_REQUEST['student_id'], 'parent_id', true);
 $parent_list 	= 	smgt_get_student_parent_id($_REQUEST['student_id']);	
 $custom_field_obj = new Smgt_custome_field;								
 $module='student';	
 $user_custom_field=$custom_field_obj->Smgt_getCustomFieldByModule($module);
?>
<div class="panel-body">	
	<div class="box-body">
		<div class="row">
			<div class="col-md-3 col-sm-4 col-xs-12">	
				<?php
				$umetadata=get_user_image($student_data->ID);
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
					<h2><?php echo $student_data->display_name;?></h2>
				</div>
				<div class="row">
					<div class="col-md-4 col-sm-3 col-xs-12">
						<i class="fa fa-envelope"></i>&nbsp;
						<span class="email-span"><?php echo $student_data->user_email;?></span>
					</div>
					<div class="col-md-3 col-sm-3 col-xs-12">
						<i class="fa fa-phone"></i>&nbsp;
						<span><?php echo $student_data->phone;?></span>
					</div>
					<div class="col-md-5 col-sm-3 col-xs-12 no-padding">
						<i class="fa fa-map-marker"></i>&nbsp;
						<span><?php echo $student_data->address;?></span>
					</div>
				</div>					
			</div>
		</div>
			
		<div class="row">
			<div class="view-more view_more_details_div" style="display:block;">
				<h4><?php _e( 'View More', 'school-mgt' ) ;?></h4>
					<i class="fa fa-angle-down bounce fa-2x view_more_details"></i>
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
								<p class="user-info">: <?php echo $student_data->display_name;?></p>
							</div>
							
						<!--</div>
						<div class="row">-->							
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Birth Date', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo smgt_getdate_in_input_box($student_data->birth_date);?></p>
							</div>
							<div class="col-md-2">
									<p class="user-lable"><?php _e( 'Gender', 'school-mgt' ) ;?></p>
								</div>
							<div class="col-md-4">
									<p class="user-info">: <?php 
									if($student_data->gender=='male') 
										echo __('Male','school-mgt');
									elseif($student_data->gender=='female') 
										echo __('Female','school-mgt');
									?></p>
							</div>
						<!--</div>
						<div class="row">-->
														
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Roll No', 'school-mgt' );?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $student_data->roll_id;?></p> 
							</div>
							
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Class Name', 'school-mgt' );?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo get_class_name($student_data->class_name);?></p> 
							</div>
							
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Section Name', 'school-mgt' );?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php 
									if(($student_data->class_section)!="")
									{
										echo smgt_get_section_name($student_data->class_section); 
									}
									else
									{
										_e('No Section','school-mgt');;
									}?>
								</p> 
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
								<p class="user-info">: <?php echo $student_data->address;?><br></p>
							</div>
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'City', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $student_data->city;?></p>
							</div>
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'State', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $student_data->state;?></p>
							</div>
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Zipcode', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $student_data->zip_code;?></p>
							</div>
							<div class="col-md-2">
								<p class="user-lable"><?php _e( 'Phone Number', 'school-mgt' ) ;?></p>
							</div>
							<div class="col-md-4">
								<p class="user-info">: <?php echo $student_data->phone;?></p>
							</div>
						</div>											
					</div>
					<?php
					if(!empty($user_custom_field))
					{	?>
					<div class="card-head">
						<i class="fa fa-bars"></i>
						<span> <b><?php _e( 'Other Information', 'school-mgt' ) ;?> </b></span>
					</div>
					<div class="card-body">
						<div class="row">
							 <?php
									foreach($user_custom_field as $custom_field)
									{
										$custom_field_id=$custom_field->id;
									 
										$module_record_id=$_REQUEST['student_id'];
										 
										$custom_field_value=$custom_field_obj->Smgt_get_single_custom_field_meta_value($module,$module_record_id,$custom_field_id);
										?>
										<div class="col-xl-2 col-lg-2">
										<p class="user-lable"><?php _e(''.$custom_field->field_label.'','school-mgt'); ?></p>
										</div>	
										<?php
										if($custom_field->field_type =='date')
										{	
											?>
											<div class="col-xl-4 col-lg-4">
											<p class="user-info">: <?php if(!empty($custom_field_value)){ echo smgt_getdate_in_input_box($custom_field_value); }else{ echo '-'; } ?>
											</p></div>	
											<?php
										}
										elseif($custom_field->field_type =='file')
										{
											if(!empty($custom_field_value))
											{
											?>
											<div class="col-xl-4 col-lg-4"><p class="user-info">
											<a target="blank" href="<?php echo content_url().'/uploads/school_assets/'.$custom_field_value;?>"><button class="btn btn-default view_document" type="button">
													<i class="fa fa-eye"></i> <?php _e('View','school-mgt');?></button></a>
														
													<a target="" href="<?php echo content_url().'/uploads/school_assets/'.$custom_field_value;?>" download="CustomFieldfile"><button class="btn btn-default view_document" type="button">
													<i class="fa fa-download"></i> <?php _e('Download','school-mgt');?></button></a></p>
											</div>		
											<?php 
											}
											else
											{
												echo '-';
											}
										}
										else
										{
											?>
											<div class="col-xl-4 col-lg-4">
										<p class="user-info"><?php if(!empty($custom_field_value)){ echo $custom_field_value; }else{ echo '-'; } ?></p>
											</div>	
											<?php		
										}									
									}
									?>	
						</div>											
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
</div>
   
<div class="panel-body">
	<div class="row">	
		<ul class="nav nav-tabs">
			<li class="active"><a data-toggle="tab" href="#Section1"><i class="fa fa-user"></i><b><?php _e( ' Parents', 'school-mgt' ); ?></b></a></li>
		</ul>
	<script>
	jQuery(document).ready(function() {
		var table =  jQuery('#parents_list').DataTable({
			responsive: true,
			"order": [[ 0, "asc" ]],
			"aoColumns":[	                  
			{"bSortable": true},
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
									  <table id="parents_list" class="display table" cellspacing="0" width="100%">
										<thead>
											<tr>
											  <th><?php _e('Photo','school-mgt');?></th>
											  <th><?php _e('Name','school-mgt');?></th>
											  <th><?php _e('Email','school-mgt');?></th>
											  <th><?php _e('Phone number','school-mgt');?></th>
											  <th> <?php _e('Relation','school-mgt');?></th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th><?php _e('Photo','school-mgt');?></th>
												<th><?php _e('Name','school-mgt');?></th>
												<th><?php _e('Email','school-mgt');?></th>
												<th><?php _e('Phone number','school-mgt');?></th>
												<th> <?php _e('Relation','school-mgt');?></th>
											</tr>
										</tfoot>
										<tbody>
										<?php
										if(!empty($user_meta))
										{
											foreach($user_meta as $parentsdata)
											{
												if(!empty($parentsdata->errors))
												{
													$parent = "";
												}
												else
												{
													$parent=get_userdata($parentsdata);
												}

												if (!empty($parent)) 
												{

												?>
												
										<tr>
										  <td><?php 
											if($parentsdata)
											{
												$umetadata=get_user_image($parentsdata);
											}
											if(empty($umetadata['meta_value']))
											{
												echo '<img src='.get_option( 'smgt_parent_thumb' ).' height="50px" width="50px" class="img-circle" />';
											}
											else
												echo '<img src='.$umetadata['meta_value'].' height="50px" width="50px" class="img-circle"/>';?></td>
											 <td><?php echo $parent->first_name." ".$parent->last_name;?></td>
											 <td><?php echo $parent->user_email;?></td> 
											 <td><?php echo $parent->phone;?></td>
										  <td><?php if($parent->relation=='Father'){ echo __('Father','school-mgt'); }elseif($parent->relation=='Mother'){ echo __('Mother','school-mgt');} ?></td>
										</tr>
										<?php
									}
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
 
	 
