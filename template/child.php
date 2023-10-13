<?php 
$active_tab=isset($_REQUEST['tab'])?$_REQUEST['tab']:'childlist';
$obj_mark = new Marks_Manage();
$access=page_access_rolewise_and_accessright();
if($access)
{
?>
<script>
$(document).ready(function() {
    $('#student_list').DataTable({
        responsive: true
    });
} );
</script>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content">
		<div class="result"></div>
		<div class="view-parent"></div>
		<div class="view-attendance"></div>
    </div> 
</div>
<?php if(isset($_REQUEST['attendance']) && $_REQUEST['attendance'] == 1)
{
	?>
	<script type="text/javascript">
$(document).ready(function() {
	
	$('.sdate').datepicker({dateFormat: "yy-mm-dd"}); 
	$('.edate').datepicker({dateFormat: "yy-mm-dd"}); 

 
} );
</script>
	<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">
      <li class="active">
          <a href="#child" role="tab" data-toggle="tab">
             <i class="fa fa-align-justify"></i> <?php _e('Attendance', 'school-mgt'); ?></a>
          </a>
      </li>
</ul>
   

<div class="tab-content">
      
        	<div class="panel-body">
<form name="wcwm_report" action="" method="post">
<input type="hidden" name="attendance" value=1> 
<input type="hidden" name="user_id" value=<?php echo $_REQUEST['student_id'];?>>       
	<div class="form-group col-md-3">
    	<label for="exam_id"><?php _e('Strat Date','school-mgt');?></label>
       
					
            	<input type="text"  class="form-control sdate" name="sdate" value="<?php if(isset($_REQUEST['sdate'])) echo $_REQUEST['sdate'];else echo date('Y-m-d');?>" readonly>
            	
    </div>
    <div class="form-group col-md-3">
    	<label for="exam_id"><?php _e('End Date','school-mgt');?></label>
			<input type="text"  class="form-control edate" name="edate" value="<?php if(isset($_REQUEST['edate'])) echo $_REQUEST['edate'];else echo date('Y-m-d');?>" readonly>
            	
    </div>
    <div class="form-group col-md-3 button-possition">
    	<label for="subject_id">&nbsp;</label>
      	<input type="submit" name="view_attendance" Value="<?php _e('Go','school-mgt');?>"  class="btn btn-info"/>
    </div>	
</form>
<div class="clearfix"></div>
<?php if(isset($_REQUEST['view_attendance']))
{
	$start_date = $_REQUEST['sdate'];
	$end_date = $_REQUEST['edate'];
	$user_id = $_REQUEST['user_id'];
	$attendance = smgt_view_student_attendance($start_date,$end_date,$user_id);
	
	$curremt_date =$start_date;
	?>
	 <div class="table-responsive">
	<table class="table col-md-12">
	<tr>
	<th width="200px"><?php _e('Date','school-mgt');?></th>
	<th><?php _e('Day','school-mgt');?></th>
	<th><?php _e('Attendance','school-mgt');?></th>
	<th><?php _e('Comment','school-mgt');?></th>
	</tr>
	<?php 
	while ($end_date >= $curremt_date)
	{
		echo '<tr>';
		echo '<td>';
		echo smgt_getdate_in_input_box($curremt_date);
		echo '</td>';
		
		$attendance_status = smgt_get_attendence($user_id,$curremt_date);
		echo '<td>';
		echo date("D", strtotime($curremt_date));
		echo '</td>';
		
		if(!empty($attendance_status))
		{
			echo '<td>';
			echo smgt_get_attendence($user_id,$curremt_date);
			echo '</td>';
		}
		else 
		{
			echo '<td>';
			echo __('Absent','school-mgt');
			echo '</td>';
		}
		echo '<td>';
		echo smgt_get_attendence_comment($user_id,$curremt_date);
		echo '</td>';
		echo '</tr>';
		$curremt_date = strtotime("+1 day", strtotime($curremt_date));
		$curremt_date = date("Y-m-d", $curremt_date);
	}
?>
</table>
</div>
<?php }?>
</div>
</div>
</div>
	<?php 
}
else 
{?>
<div class="panel-body panel-white">
 <ul class="nav nav-tabs panel_tabs" role="tablist">
       <li class="<?php if($active_tab=='childlist'){?>active<?php }?>">
          <a href="?dashboard=user&page=child&tab=childlist" class="nav-tab2">
             <i class="fa fa-align-justify"></i> <?php _e('Child List', 'school-mgt'); ?></a>
          </a>
      </li>
	 <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'view_student')
	   {?>
	  <li class="<?php if($active_tab=='view_student'){?>active<?php }?>">
          <a href="?dashboard=user&page=child&tab=view_student&action=view_student&student_id=<?php echo $_REQUEST['student_id'];?>" class="nav-tab2">
             <i class="fa fa-eye"></i> <?php _e('View Child', 'school-mgt'); ?></a>
          </a>
      </li>
	  <?php
	   } ?>
</ul>
   
  <?php if($active_tab == 'childlist')
     {
     ?>
<div class="tab-content">
      
<div class="panel-body">
<form name="wcwm_report" action="" method="post">
	 <div class="table-responsive">
        <table id="student_list" class="display dataTable child_datatable" cellspacing="0" width="100%">
        	 <thead>
            <tr>
				<th width="75px"><?php  _e( 'Photo', 'school-mgt' ) ;?></th>
				<th><?php echo _e( 'Child Name', 'school-mgt' ) ;?></th>
				<th><?php _e('Roll No.','school-mgt');?></th>
                <th> <?php echo _e( 'Class', 'school-mgt' ) ;?></th>
				<th> <?php echo _e( 'Child Email', 'school-mgt' ) ;?></th>
				<th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
               <th><?php echo _e( 'Photo', 'school-mgt' ) ;?></th>
			   <th><?php echo _e( 'Child Name', 'school-mgt' ) ;?></th>
				<th><?php _e('Roll No.','school-mgt');?></th>
                <th> <?php echo _e( 'Class', 'school-mgt' ) ;?></th>
				<th> <?php echo _e( 'Child Email', 'school-mgt' ) ;?></th>
				
                 <th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>
                
            </tr>
        </tfoot>
 
        <tbody>
         <?php 
			
			if(!empty($school_obj->child_list))
			{
				foreach ($school_obj->child_list as $child_id){ 
				$retrieved_data= get_userdata($child_id);
				if($retrieved_data)
				{
			
		 ?>
            <tr>
				<td class="user_image text-center"><?php $uid=$retrieved_data->ID;
							$umetadata=get_user_image($uid);
							if(empty($umetadata['meta_value']))
								//echo get_avatar($retrieved_data->ID,'46');
								echo '<img src='.get_option( 'smgt_student_thumb' ).' height="50px" width="50px" class="img-circle" />';
							else
							echo '<img src='.$umetadata['meta_value'].' height="50px" width="50px" class="img-circle"/>';
				?></td>
                <td class="name"><?php echo $retrieved_data->display_name;?></td>
				<td><?php echo get_user_meta($retrieved_data->ID, 'roll_id',true);?></td>
				<td class="name"><?php $class_id=get_user_meta($retrieved_data->ID, 'class_name',true);
									echo $classname=	get_class_name($class_id);
				?></td>
                <td class="email"><?php echo $retrieved_data->user_email;?></td>
                
               	<td class="action"> 
					<a href="?dashboard=user&page=child&tab=view_student&action=view_student&student_id=<?php echo $retrieved_data->ID;?>" class="btn btn-success"><?php _e('View','school-mgt');?></a>
					<a href="?dashboard=user&page=student&action=result&student_id=<?php echo $retrieved_data->ID;?>" class="show-popup btn btn-default"  
					idtest="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-bar-chart"></i> <?php _e('View Result','school-mgt');?></a> 
					<a href="?dashboard=user&page=view-attendance&tab=stud_attendance&student_id=<?php echo $retrieved_data->ID;?>" class="btn btn-default"  
					idtest="<?php echo $retrieved_data->ID; ?>"><i class="fa fa-eye"></i> <?php _e('View Attendance','school-mgt');?> </a>
                </td>
               
            </tr>
				<?php  }
				} 
			}
			?>
     
        </tbody>
        
        </table>
       </div>
		
</form>
</div>
</div>
</div>
<?php 
	}
	if($active_tab == 'view_student')
	{	
?>
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
<?php
 $student_data=get_userdata($_REQUEST['student_id']);
 $user_meta =get_user_meta($_REQUEST['student_id'], 'parent_id', true); 
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
					echo '<img class="img-circle img-responsive member-profile" src='.$umetadata['meta_value'].' style="height:150px;width:150px;" />';
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
					<i class="fa fa-angle-down fa-2x view_more_details"></i>
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
									<p class="user-info">: <?php echo $student_data->gender;?></p>
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
										<tbody>
										<?php
										if(!empty($user_meta))
										{
											foreach($user_meta as $parentsdata)
											{
											$parent=get_userdata($parentsdata);?>
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
											 <td><?php echo $parent->user_email;?></td> 
											 <td><?php echo $parent->phone;?></td>
										  <td><?php echo $parent->first_name." ".$parent->last_name;?></td>
										  <td><?php if($parent->relation=='Father'){ echo __('Father','school-mgt'); }elseif($parent->relation=='Mother'){ echo __('Mother','school-mgt');} ?></td>
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
<?php
}
}
}
else
{
	wp_redirect ( admin_url () . 'index.php' );
} 
?>