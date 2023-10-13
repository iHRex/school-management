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
	$tablename="holiday";
	//--------------------- DELETE HOLIDAY --------------//
	if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')
	{
		$result=delete_holiday($tablename,$_REQUEST['holiday_id']);
		if($result){ 
			wp_redirect ( home_url() . '?dashboard=user&page=holiday&tab=holidaylist&message=3'); 	
		}
	}
	if(isset($_REQUEST['delete_selected']))
	{		
		if(!empty($_REQUEST['id']))
		foreach($_REQUEST['id'] as $id)
			$result=delete_holiday($tablename,$id);
		if($result)
		{
			wp_redirect ( home_url() . '?dashboard=user&page=holiday&tab=holidaylist&message=3'); 	
		}
	}
	//------------------- SAVE HOLIDAYS --------------------/
	if(isset($_POST['save_holiday']))
	{
		$nonce = $_POST['_wpnonce'];
	    if ( wp_verify_nonce( $nonce, 'save_holiday_admin_nonce' ) )
		{
			$start_date = date('Y-m-d',strtotime($_REQUEST['date']));
			$end_date = date('Y-m-d',strtotime($_REQUEST['end_date']));
			if($start_date > $end_date )
			{
				echo '<script type="text/javascript">alert("'.__('End Date should be greater than the Start Date','school-mgt').'");</script>';
			}
			else
			{
				$haliday_data=array(
					'holiday_title'=>MJ_smgt_popup_category_validation($_POST['holiday_title']),
					'description'=>MJ_smgt_address_description_validation($_POST['description']),
					'date'=>date('Y-m-d', strtotime($_POST['date'])),
					'end_date'=>date('Y-m-d', strtotime($_POST['end_date'])),
					'created_by'=>get_current_user_id(),
					'created_date'=>date('Y-m-d H:i:s')
				);
				//table name without prefix
				$tablename="holiday";		
				if($_REQUEST['action']=='edit')
				{
					$holiday_id=array('holiday_id'=>$_REQUEST['holiday_id']);			
					$result=update_record($tablename,$haliday_data,$holiday_id);
					if($result)
					{ 
						wp_redirect ( home_url() . '?dashboard=user&page=holiday&tab=holidaylist&message=2'); 	
					}
				}
				else
				{
					$startdate = strtotime($_POST['date']);
					$enddate = strtotime($_POST['end_date']);
					if($startdate==$enddate)
					{
						$date = $_POST['date'];
					}
					else
					{
						$date = $_POST['date'] ." To ".$_POST['end_date'];
					}
					$AllUsr = smgt_get_all_user_in_plugin();
					foreach($AllUsr as $key=>$usr)
					{
						$to[] = $usr->user_email;
						//$to[] = "meru@dasinfomedia.com";
					}
					
					
					$result=insert_record($tablename,$haliday_data);
					if($result)
					{
						$Search['{{holiday_title}}'] 	= 	smgt_strip_tags_and_stripslashes($_POST['holiday_title']);
						$Search['{{holiday_date}}'] 	= 	$date;
						$Search['{{school_name}}'] 		= 	get_option('smgt_school_name');
					
						$message 	=	 string_replacement($Search,get_option('holiday_mailcontent'));
						smgt_send_mail($to,get_option('holiday_mailsubject'),$message);
						wp_redirect ( home_url() . '?dashboard=user&page=holiday&tab=holidaylist&message=1'); 	
					}
				}
			}
		}
	}
$active_tab = isset($_GET['tab'])?$_GET['tab']:'holidaylist';
?>
<script>
$(document).ready(function() {
    $('#holiday_list').DataTable({
        responsive: true,
		"order": [[ 1, "asc" ]],
				"aoColumns":[          
							  {"bSortable": true},
							  {"bSortable": true},
							  {"bSortable": true},
							  {"bSortable": true}
							  <?php
								if($user_access['edit']=='1' || $user_access['delete']=='1')
								{
								?>
									,{"bSortable": false}
							  <?php
								}
								?>],
		language:<?php echo smgt_datatable_multi_language();?>	
    });
});
</script>
<div class="panel-body panel-white">
	<?php
	$message = isset($_REQUEST['message'])?$_REQUEST['message']:'0';
	switch($message)
	{
		case '1':
			$message_string = __('Holiday Added Successfully.','school-mgt');
			break;
		case '2':
			$message_string = __('Holiday Updated Successfully.','school-mgt');
			break;	
		case '3':
			$message_string = __('Holiday Deleted Successfully.','school-mgt');
			break;
	}
	
	if($message)
	{ ?>
		<div class="alert_msg alert alert-success alert-dismissible fade in" role="alert">
			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
			</button>
			<?php echo $message_string;?>
		</div>
<?php 
	} ?>
	<ul class="nav nav-tabs panel_tabs" role="tablist">
		<li class=" <?php echo $active_tab == 'holidaylist' ? 'active' : ''; ?>">
			<a href="?dashboard=user&page=holiday&tab=holidaylist" class="nav-tab2"> <strong>
				<i class="fa fa-align-justify"> </i> <?php _e('Holiday List', 'school-mgt'); ?></strong>
			</a>
		</li>
		<li class=" <?php echo $active_tab == 'addholiday' ? 'active' : ''; ?>">
		<?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
		{?>
			<a href="?dashboard=user&page=holiday&tab=addholiday&action=edit&notice_id=<?php echo $_REQUEST['holiday_id'];?>" class="nav-tab2 <?php echo $active_tab == 'addholiday' ? 'nav-tab-active' : ''; ?>">
		<?php _e('Edit Holiday', 'school-mgt'); ?></a>  
		<?php 
		}
		else
		{
			if($user_access['add']=='1')
			{ ?>
				<a href="?dashboard=user&page=holiday&tab=addholiday" class="nav-tab2  <?php echo $active_tab == 'addholiday' ? 'nav-tab-active' : ''; ?>"><?php echo '<span class="fa fa-plus-circle"></span>'.__(' Add Holiday', 'school-mgt'); ?></a>  
        <?php 
			}
		}?>
		</li>
	</ul>
	<?php 
	if($active_tab=='holidaylist')
	{
		
		$user_id=get_current_user_id();
		if($school_obj->role == 'supportstaff')
		{
			$own_data=$user_access['own_data'];
			if($own_data == '1')
			{ 
				$retrieve_class = get_all_holiday_created_by($user_id);
			}
			else
			{
				$retrieve_class = get_all_data ( 'holiday' );
			}
		}
		else
		{
			$retrieve_class = get_all_data ( 'holiday' );
		}
		?>
			<div class="panel-body">
				<div class="table-responsive">
					<table id="holiday_list" class="display dataTable" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th><?php _e('Holiday Title','school-mgt');?></th>
								<th><?php _e('Description','school-mgt');?></th>
								<th><?php _e('Start Date','school-mgt');?></th>
								<th><?php _e('End Date','school-mgt');?></th>
								  <?php
								if($user_access['edit']=='1' || $user_access['delete']=='1')
								{
								?>
								 <th><?php _e('Action','school-mgt');?></th> 
								  <?php
								}
								?>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th><?php _e('Holiday Title','school-mgt');?></th>
								<th><?php _e('Description','school-mgt');?></th>
								<th><?php _e('Start Date','school-mgt');?></th>
								<th><?php _e('End Date','school-mgt');?></th>
								  <?php
								if($user_access['edit']=='1' || $user_access['delete']=='1')
								{
								?>
								 <th><?php _e('Action','school-mgt');?></th> 
								  <?php
								}
								?>
							</tr>
						</tfoot>

						<tbody>
						  <?php
							foreach ( $retrieve_class as $retrieved_data ) 
							{
							?>
							<tr>
								<td><?php echo $retrieved_data->holiday_title;?></td>
								<td><?php echo $retrieved_data->description;?></td>
								<td><?php echo smgt_getdate_in_input_box($retrieved_data->date);?></td>
								<td><?php echo smgt_getdate_in_input_box($retrieved_data->end_date);?></td>
								<?php
								if($user_access['edit']=='1' || $user_access['delete']=='1')
								{
									?>
									<td>
									<?php
									if($user_access['edit']=='1')
									{
									?>
										<a href="?dashboard=user&page=holiday&tab=addholiday&action=edit&holiday_id=<?php echo $retrieved_data->holiday_id;?>"class="btn btn-info"><?php _e('Edit','school-mgt');?></a>
									<?php
									}
									if($user_access['delete']=='1')
									{ ?>
										<a href="?dashboard=user&page=holiday&tab=holidaylist&action=delete&holiday_id=<?php echo $retrieved_data->holiday_id;?>" class="btn btn-danger" onclick="return confirm('<?php _e('Are you sure you want to delete this record?','school-mgt');?>');"> <?php _e('Delete','school-mgt');?></a>
									<?php
									}
									?>
									</td>
									<?php
								}
								?>
							</tr>
						<?php 
							} ?>
					   </tbody>
					</table>
				</div>
			</div>
		<?php
	}
	if($active_tab=='addholiday')
	{   ?>
		<script type="text/javascript">
			$(document).ready(function() {
				 $('#holiday_form_template').validationEngine({promptPosition : "bottomRight",maxErrorsPerField: 1});
				  
				  $('#start_date').datepicker({		
					dateFormat: "yy-mm-dd",
					minDate:0,
					onSelect: function (selected) {
						var dt = new Date(selected);
						dt.setDate(dt.getDate() + 0);
						$("#end_date").datepicker("option", "minDate", dt);
					}
				}); 
				$('#end_date').datepicker({		
					dateFormat: "yy-mm-dd",
					minDate:0,
					onSelect: function (selected) {
						var dt = new Date(selected);
						dt.setDate(dt.getDate() - 0);
						$("#start_date").datepicker("option", "maxDate", dt);
					}
				}); 	 
			} );
		</script>
		<?php  
			$edit=0;
			if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'edit')
			{
				$edit=1;
				$holiday_data= get_holiday_by_id($_REQUEST['holiday_id']);
			}
		?>
		<div class="panel-body">
			<form name="holiday_form" action="" method="post" class="form-horizontal" id="holiday_form_template">
			   <?php $action = isset($_REQUEST['action'])?$_REQUEST['action']:'insert';?>
				<input type="hidden" name="action" value="<?php echo $action;?>">
				<div class="form-group">
					<label class="col-sm-2 control-label" for="holiday_title"><?php _e('Holiday Title','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="holiday_title" class="form-control validate[required,custom[popup_category_validation]] text-input" maxlength="50" type="text" value="<?php if($edit){ echo $holiday_data->holiday_title;}?>" name="holiday_title">
						<input type="hidden" name="holiday_id"   value="<?php if($edit){ echo $holiday_data->holiday_id;}?>"/> 
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="description"><?php _e('Description','school-mgt');?></label>
					<div class="col-sm-8">
						<input id="holiday_title" class="form-control validate[custom[address_description_validation]]" maxlength="150" type="text" value="<?php if($edit){ echo $holiday_data->description;}?>" name="description">				
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="date"><?php _e('Start Date','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="start_date" class="datepicker form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime($holiday_data->date)); }?>" name="date" readonly>				
					</div>
				</div>
				<?php wp_nonce_field( 'save_holiday_admin_nonce' ); ?>
				<div class="form-group">
					<label class="col-sm-2 control-label" for="date"><?php _e('End Date','school-mgt');?><span class="require-field">*</span></label>
					<div class="col-sm-8">
						<input id="end_date" class="datepicker form-control validate[required] text-input" type="text" value="<?php if($edit){ echo date("Y-m-d",strtotime($holiday_data->end_date));}?>" name="end_date" readonly>				
					</div>
				</div>
				<div class="col-sm-offset-2 col-sm-8">        	
					<input type="submit" value="<?php if($edit){ _e('Save Holiday','school-mgt'); }else{ _e('Add Holiday','school-mgt');}?>" name="save_holiday" class="btn btn-success" />
				</div>        
			</form>
		</div>
	<?php
	}
	?>
</div>
<?php ?> 