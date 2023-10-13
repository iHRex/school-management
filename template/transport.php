<?php 
//-------- CHECK BROWSER JAVA SCRIPT ----------//
MJ_smgt_browser_javascript_check();
//--------------- ACCESS WISE ROLE -----------//
$user_access=smgt_get_userrole_wise_access_right_array();
if (isset ( $_REQUEST ['page'] ))
{	
	if($user_access['view']=='0')
	{	
		MJ_smgt_access_right_page_not_access_message();
		die;
	}
	if(!empty($_REQUEST['action']))
	{
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='edit'))
		{
			if($user_access['edit']=='0')
			{	
				MJ_smgt_access_right_page_not_access_message();
				die;
			}			
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='delete'))
		{
			if($user_access['delete']=='0')
			{	
				MJ_smgt_access_right_page_not_access_message();
				die;
			}	
		}
		if (isset ( $_REQUEST ['page'] ) && $_REQUEST ['page'] == $user_access['page_link'] && ($_REQUEST['action']=='insert'))
		{
			if($user_access['add']=='0')
			{	
				MJ_smgt_access_right_page_not_access_message();
				die;
			}	
		} 
	}
}
//----------Add-update record---------------------//
	$tablename="transport";
	if(isset($_POST['save_transport']))
	{	
        $nonce = $_POST['_wpnonce'];
		if ( wp_verify_nonce( $nonce, 'save_transpoat_admin_nonce' ) )
		{
			if(isset($_FILES['upload_user_avatar_image']) && !empty($_FILES['upload_user_avatar_image']) && $_FILES['upload_user_avatar_image']['size'] !=0)
			{
				if($_FILES['upload_user_avatar_image']['size'] > 0)
					$member_image=smgt_load_documets($_FILES['upload_user_avatar_image'],'upload_user_avatar_image','pimg');
					$photo=content_url().'/uploads/school_assets/'.$member_image;
			}
			else
			{
				if(isset($_REQUEST['hidden_upload_user_avatar_image']))
				$member_image=$_REQUEST['hidden_upload_user_avatar_image'];
				$photo=$member_image;
			}
			
			$route_data=array(
				'route_name'=>MJ_smgt_address_description_validation($_POST['route_name']),
				'number_of_vehicle'=>MJ_smgt_onlyNumberSp_validation($_POST['number_of_vehicle']),
				'vehicle_reg_num'=>MJ_smgt_address_description_validation($_POST['vehicle_reg_num']),
				'smgt_user_avatar'=>$photo,
				'driver_name'=>MJ_smgt_onlyLetter_specialcharacter_validation($_POST['driver_name']),
				'driver_phone_num'=>MJ_smgt_phone_number_validation($_POST['driver_phone_num']),
				'driver_address'=>MJ_smgt_address_description_validation($_POST['driver_address']),
				'route_description'=>MJ_smgt_address_description_validation($_POST['route_description']),					
				'route_fare'=>MJ_smgt_address_description_validation($_POST['route_fare'])	,				
				'created_by'=>get_current_user_id()	
			);
					
			//table name without prefix
			$tablename="transport";
			if($_REQUEST['action']=='edit')
			{
				$transport_id=	array('transport_id'=>$_REQUEST['transport_id']);
				$result	=	update_record($tablename,$route_data,$transport_id);
				/* if($result)
				{ */
					wp_redirect ( home_url() . '?dashboard=user&page=transport&tab=transport_list&message=2'); 	
				 /* } */
			}
			else
			{		
				$result	=	insert_record($tablename,$route_data);
				
				if($result)
				{	
					$SearchArr['{{route_name}}']	=	$_POST['route_name'];
					$SearchArr['{{vehicle_identifier}}']	=	$_POST['number_of_vehicle'];
					$SearchArr['{{vehicle_registration_number}}']	=	$_POST['vehicle_reg_num'];
					$SearchArr['{{driver_name}}']	=	$_POST['driver_name'];
					$SearchArr['{{driver_phone_number}}']	=	$_POST['driver_phone_num'];
					$SearchArr['{{driver_address}}']	=	$_POST['driver_address'];
					$SearchArr['{{route_fare}}']	=	$_POST['route_fare'];
					$SearchArr['{{school_name}}']	=	 get_option('smgt_school_name');
					$MSG = string_replacement($SearchArr,get_option('school_bus_alocation_mail_content'));
					
					$AllUsr = smgt_get_all_user_in_plugin();
					foreach($AllUsr as $key=>$usr)
					{
						 $to[] = $usr->user_email;
						//$to[] = "meru@dasinfomedia.com";
					}
					smgt_send_mail($to,get_option('school_bus_alocation_mail_subject'),$MSG);
				  wp_redirect ( home_url() . '?dashboard=user&page=transport&tab=transport_list&message=1'); 	
				 }
			}
	    }
	}
	if(isset($_REQUEST['delete_selected']))
	{		
		if(!empty($_REQUEST['id']))
		foreach($_REQUEST['id'] as $id)
			$result=delete_transport($tablename,$id);
		if($result)
			{ 
				wp_redirect ( home_url() . '?dashboard=user&page=transport&tab=transport_list&message=3'); 	
			}
	}
	//----------Delete record---------------------------
		$tablename="transport";
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
	{
		$result=delete_transport($tablename,$_REQUEST['transport_id']);
			if($result)
			{
				wp_redirect ( home_url() . '?dashboard=user&page=transport&tab=transport_list&message=3'); 					
			}
	}
$active_tab = isset($_GET['tab'])?$_GET['tab']:'transport_list';
?>
<script>
$(document).ready(function() {
    $('#transport_list').DataTable({
        responsive: true,
		language:<?php echo smgt_datatable_multi_language();?>	
    });
} );
</script>
<!-- POP up code -->
<div class="popup-bg">
    <div class="overlay-content top_color">
		<div class="modal-content">
			<div class="view_popup"></div>     
		</div>
    </div>    
</div>
<!-- End POP-UP Code -->
<div class="panel-body panel-white">
<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Transport Added successfully','school-mgt');
			break;
		case '2':
			$message_string = __('Transport Updated successfully','school-mgt');
			break;	
		case '3':
			$message_string = __('Transport Delete Successfully','school-mgt');
			break;
	}
	
	if($message)
	{ ?>
		<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<?php echo $message_string;?>
		</div>
<?php } ?>
	<ul class="nav nav-tabs panel_tabs" role="tablist">
		<li class=" <?php echo $active_tab == 'transport_list' ? 'active' : ''; ?>">
			<a href="?dashboard=user&page=transport&tab=transport_list" class="nav-tab2"> <strong>
				<i class="fa fa-align-justify"> </i> <?php _e('Transport List', 'school-mgt'); ?></strong>
			</a>
		</li>
		<li class=" <?php echo $active_tab == 'addtransport' ? 'active' : ''; ?>">
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
			<a href="?dashboard=user&page=transport&tab=addtransport&action=edit&transport_id=<?php echo $_REQUEST['transport_id'];?>" class="nav-tab2 margin_top_10_res <?php echo $active_tab == 'addtransport' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Transport', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{
			if($user_access['add']=='1')
			{?>
				<a href="?dashboard=user&page=transport&tab=addtransport" class="margin_top_10_res"><?php echo '<span class="fa fa-plus-circle "></span>'.__(' Add Transport', 'school-mgt'); ?></a>  
        <?php 
			}
		}?>
		</li>
	</ul>
	<div class="tab-content">
       <?php 
	if($active_tab == 'transport_list')
	{
		$user_id=get_current_user_id();
		//------- Transport DATA FOR STUDENT ---------//
		if($school_obj->role == 'student')
		{
			$retrieve_class = get_all_data('transport');
		}
		//------- Transport DATA FOR TEACHER ---------//
		elseif($school_obj->role == 'teacher')
		{
			$retrieve_class = get_all_data('transport');
		}
		//------- Transport DATA FOR PARENT ---------//
		elseif($school_obj->role == 'parent')
		{
			$retrieve_class = get_all_data('transport');
		}
		//------- Transport DATA FOR SUPPORT STAFF ---------//
		else
		{ 
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$retrieve_class	=get_all_transport_created_by($user_id);
			}
			else
			{
				$retrieve_class = get_all_data('transport');
			}
		} 
		?>
		<div class="panel-body">
			<div class="table-responsive">
				<table id="transport_list" class="display dataTable transport_datatable" cellspacing="0" width="100%">
					<thead>
						<tr>                
							<th><?php _e('Photo','school-mgt');?></th>
							<th><?php _e('Route Name','school-mgt');?></th>
							<th><?php _e('Number Of Vehicle','school-mgt');?></th>
							<th><?php _e('Vehicle Registration Number','school-mgt');?></th>
							<th><?php _e('Driver Name','school-mgt');?></th>
							<th><?php _e('Driver Phone Number','school-mgt');?></th>              
							<th><?php _e('Route Fare','school-mgt');?>(<?php echo get_currency_symbol();?>)</th>
							<th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>              
						</tr>
					</thead>
					<tfoot>
						<tr>
						   <th><?php _e('Photo','school-mgt');?></th>
							<th><?php _e('Route Name','school-mgt');?></th>
							<th><?php _e('Number Of Vehicle','school-mgt');?></th>
							<th><?php _e('Vehicle Registration Number','school-mgt');?></th>
							<th><?php _e('Driver Name','school-mgt');?></th>
							<th><?php _e('Driver Phone Number','school-mgt');?></th>              
							<th><?php _e('Route Fare','school-mgt');?>(<?php echo get_currency_symbol();?>)</th>
							<th><?php echo _e( 'Action', 'school-mgt' ) ;?></th>              
						</tr>
					</tfoot>
					<tbody>
					  <?php 
						foreach ($retrieve_class as $retrieved_data)
						{ 
					 ?>
							<tr>
								<td class="user_image"><?php $tid=$retrieved_data->transport_id;
									$umetadata=get_user_driver_image($tid);
								
									if(empty($umetadata) || $umetadata['smgt_user_avatar'] == "")
									{
										echo '<img src="'.get_option( 'smgt_driver_thumb' ).'" height="50px" width="50px" class="img-circle" />';
									}
									else
									{
										echo '<img src='.$umetadata['smgt_user_avatar'].' height="50px" width="50px" class="img-circle" title="No image" />';
									} ?>				
								</td>
								<td><?php echo $retrieved_data->route_name;?></td>
								<td><?php echo $retrieved_data->number_of_vehicle;?></td>
								<td><?php echo $retrieved_data->vehicle_reg_num;?></td>
								<td><?php echo $retrieved_data->driver_name;?></td>
								<td><?php echo $retrieved_data->driver_phone_num;?></td>
								<td><?php echo $retrieved_data->route_fare;?></td>         
								<td>
									<a href="#" id="<?php echo $retrieved_data->transport_id;?>" type="transport_view" class="view_details_popup btn btn-primary"><?php _e('View','school-mgt');?></a>
									 <?php
									if($user_access['edit']=='1')
									{
									?>
										<a href="?dashboard=user&page=transport&tab=addtransport&action=edit&transport_id=<?php echo $retrieved_data->transport_id;?>" class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
								<?php 
									}
									if($user_access['delete']=='1')
									{ ?>
										<a href="?dashboard=user&page=transport&tab=transport&action=delete&transport_id=<?php echo $retrieved_data->transport_id;?>" class="btn btn-danger" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a>
									<?php
									} ?>
									</td>
							   </td>
							</tr>
						<?php 
						} ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php
	}
	if($active_tab == 'addtransport')
	{ ?>
		<script type="text/javascript">
		$(document).ready(function() {
			 $('#transport_form').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
		} );
		</script>
		<div class="add_transport">		
			<?php  
				$edit=0;
				if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
				{
					$edit=1;
					$transport_data= get_transport_by_id($_REQUEST['transport_id']);
				}
			?>
			
			<div class="panel-body">
			<form name="transport_form" action="" method="post" class="form-horizontal" id="transport_form" enctype="multipart/form-data">
			  <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
			<input type="hidden" name="action" value="<?php echo $action;?>">
			<div class="form-group">
				<label class="col-sm-2 control-label" for="route_name"><?php _e('Route Name','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="route_name" class="form-control validate[required,custom[address_description_validation]]" type="text" maxlength="50" value="<?php if($edit){ echo $transport_data->route_name;}?>" name="route_name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="number_of_vehicle"><?php _e('Vehicle Identifier','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="number_of_vehicle" class="form-control validate[required,custom[onlyNumberSp]]" maxlength="15" type="text" value="<?php if($edit){ echo $transport_data->number_of_vehicle;}?>" name="number_of_vehicle">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="vehicle_reg_num"><?php _e('Vehicle Registration Number','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="vehicle_reg_num" class="form-control validate[required,custom[address_description_validation]]" maxlength="50" type="text" value="<?php if($edit){ echo $transport_data->vehicle_reg_num;}?>" name="vehicle_reg_num">
				</div>
			</div>
			<?php wp_nonce_field( 'save_transpoat_admin_nonce' ); ?>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="driver_name"><?php _e('Driver Name','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="driver_name" class="form-control validate[required,custom[onlyLetter_specialcharacter]]" maxlength="50" type="text" value="<?php if($edit){ echo $transport_data->driver_name;}?>" name="driver_name">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="driver_phone_num"><?php _e('Driver Phone Number','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="driver_phone_num" class="form-control validate[required,custom[phone_number],minSize[6],maxSize[15]]" type="text" value="<?php if($edit){ echo $transport_data->driver_phone_num;}?>" name="driver_phone_num">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="driver_address"><?php _e('Driver Address','school-mgt');?><span class="require-field">*</span></label>
				<div class="col-sm-8">
					<textarea name="driver_address" class="form-control validate[required,custom[address_description_validation]]" maxlength="150" id="driver_address"><?php if($edit){ echo $transport_data->driver_address;}?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="photo"><?php _e('Image','school-mgt');?></label>
				<div class="col-sm-2">
					<input type="text" id="amgt_user_avatar_url" class="form-control" name="smgt_user_avatar"  
					value="<?php if($edit)echo ( $user_info->smgt_user_avatar );elseif(isset($_POST['smgt_user_avatar'])) echo $_POST['smgt_user_avatar']; ?>" />
					<input type="hidden" class="form-control" name="hidden_upload_user_avatar_image"  
					value="<?php if($edit)echo ( $user_info->smgt_user_avatar );elseif(isset($_POST['hidden_upload_user_avatar_image'])) echo $_POST['hidden_upload_user_avatar_image']; ?>" />
				</div>	
					<div class="col-sm-3">
						 <input id="upload_user_avatar" class="btn_top" name="upload_user_avatar_image" onchange="fileCheck(this);" type="file" />
				</div>
				<div class="clearfix"></div>
				
				<div class="col-sm-offset-2 col-sm-8">
					<div id="upload_user_avatar_preview" >
						<?php if($edit) 
						{
							if($user_info->smgt_user_avatar == "")
							{ ?>
								<img class="image_preview_css" src="<?php echo get_option( 'smgt_student_thumb' ); ?>">
						<?php }
						else { ?>
							<img class="image_preview_css" src="<?php if($edit)echo esc_url( $user_info->smgt_user_avatar ); ?>" />
						<?php }
						}
					else { 	?>
							<img class="image_preview_css" src="<?php echo get_option( 'smgt_student_thumb' ); ?>">
				 <?php } ?>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="route_description"><?php _e('Description','school-mgt');?></label>
				<div class="col-sm-8">
					 <textarea name="route_description" class="form-control validate[custom[address_description_validation]]" maxlength="150" id="route_description"><?php if($edit){ echo $transport_data->route_description;}?></textarea>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="route_fare"><?php _e('Route Fare','school-mgt');?>(<?php echo get_currency_symbol();?>)<span class="require-field">*</span></label>
				<div class="col-sm-8">
					<input id="route_fare" class="form-control validate[required,custom[onlyNumberSp],min[0],maxSize[10]]" type="text"value="<?php if($edit){ echo $transport_data->route_fare;}?>" name="route_fare">
				</div>
			</div>
			<div class="col-sm-offset-2 col-sm-8">
				
				<input type="submit" value="<?php if($edit){ _e('Save Transport','school-mgt'); }else{ _e('Add Transport','school-mgt');}?>" name="save_transport" class="btn btn-success"/>
			</div>
			
			</form>
			</div>
		</div>
<?php
	}
	?>
	</div>
</div>  
<?php 
?>